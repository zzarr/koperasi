<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\MonthlyPayment;
use App\Models\Wallet;
use App\Models\YearlyLog;
use App\Models\ConfigPayment;
use Barryvdh\DomPDF\Facade\Pdf;

class MonthlyPaymentController extends Controller
{
    private $isSuccess;
    private $exception;

    public function index(Request $request)
    {
        return view('admin.payment.monthly.index');
    }
    public function datatables(Request $request)
    {
        $year = date('Y');

        $users = User::with([
            'monthlyPayment' => function ($query) use ($year) {
                $query->where('payment_year', $year)
                    ->orderBy('payment_month', 'ASC');
            },
            'monthlyPayment.configPayment'
        ])
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'admin'); // Exclude admin roles
            })
            ->get();

        return DataTables::of($users)
            ->addColumn('monthly_total', function ($user) use ($year) {
                return $user->monthlyPayment->where('payment_year', $year)->sum('amount') ?? 0;
            })
            ->addColumn('last_year_1', function ($user) {
                return MonthlyPayment::where('payment_year', (date('Y') - 1))->where('user_id', $user->id)->sum('amount') ?? 0;
            })
            ->addColumn('last_year_2', function ($user) {
                return MonthlyPayment::where('payment_year', (date('Y') - 2))->where('user_id', $user->id)->sum('amount') ?? 0;
            })
            ->addColumn('last_year_3', function ($user) {
                return MonthlyPayment::where('payment_year', '<=', (date('Y') - 3))->where('user_id', $user->id)->sum('amount') ?? 0;
            })
            ->addColumn('total_all', function ($user) {
                return $user->monthlyPayment->sum('amount') ?? 0;
            })
            ->make();
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $configPayment['monthly'] = ConfigPayment::where(['is_active' => 1, 'name' => 'monthly_payment'])->first();
            $request->amount = $configPayment['monthly']->paid_off_amount;

            $isCreated = MonthlyPayment::where([
                'user_id' => $request->user_id,
                'payment_year' => $request->payment_year,
                'payment_month' => 1,
                'payment_month' => 2,
                'payment_month' => 3,
                'payment_month' => 4,
                'payment_month' => 5,
                'payment_month' => 6,
                'payment_month' => 7,
                'payment_month' => 8,
                'payment_month' => 9,
                'payment_month' => 10,
                'payment_month' => 11,
                'payment_month' => 12,
            ])->count();

            if ($isCreated == 0) {
                for ($i = 0; $i < 12; $i++) {
                    MonthlyPayment::updateOrCreate(
                        [
                            'user_id'           => $request->user_id,
                            'payment_month'     => ($i + 1),
                            'payment_year'      => $request->payment_year,
                        ],
                        [
                            'config_payment_id' => $configPayment['monthly']->id,
                            'amount'            => 0,
                        ]
                    );
                }
            }

            $monthlyPayment = MonthlyPayment::updateOrCreate(
                [
                    'user_id'           => $request->user_id,
                    'payment_month'     => $request->payment_month,
                    'payment_year'     => $request->payment_year,
                ],
                [
                    'config_payment_id' => $configPayment['monthly']->id,
                    'amount'            => $request->amount,
                    'paid_at'           => $request->paid_at,
                ]
            );

            $monthlyTotal = MonthlyPayment::where('user_id', $request->user_id)->sum('amount');

            $logYear = YearlyLog::where(['user_id'   => $request->user_id, 'year'   => $request->payment_year])->first();
            YearlyLog::updateOrCreate(
                [
                    'user_id'   => $request->user_id,
                    'year'      => $request->payment_year
                ],
                [
                    'total_monthly'    => ($logYear->total_monthly ?? 0) + $request->amount,
                ]
            );

            $wallet = Wallet::where('user_id', $request->user_id)->first();
            Wallet::updateOrCreate(
                [
                    'user_id'   => $request->user_id,
                ],
                [
                    'monthly'      => $monthlyTotal,
                    'total'     => $wallet ? ($monthlyTotal + $wallet->main + $wallet->other) : $monthlyTotal
                ]
            );

            DB::commit();
            $this->isSuccess = true;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->exception = $e;
        }

        return response()->json([
            "status"    => $this->isSuccess ?? false,
            "code"      => $this->isSuccess ? 200 : 600,
            "message"   => $this->isSuccess ? "Success!" : ($this->exception ?? "Unknown error(?)"),
            "pdf_url"   => $this->isSuccess ? route('admin.payment.monthly.download', ['id' => $monthlyPayment->id]) : null,
        ], 201);
    }

    public function dataTanggal($id)
    {
        $data = MonthlyPayment::where('user_id', $id)->where('payment_year', date('Y'))->orderBy('payment_month', 'ASC')->get();

        return response()->json($data);
    }

    public function exportInvoice(Request $request)
    {
        $data = MonthlyPayment::with('user')->where('payment_month', $request->month)->first();

        if (!$data) {
            return back()->with('error', 'Data tidak ditemukan untuk tanggal yang dipilih.');
        }

        $pdf = Pdf::loadView('admin.payment.monthly.invoices', compact('data'))
            ->setPaper('a4', 'landscape');


        return $pdf->stream('Invoice_' . $data->id . '.pdf');
    }
}
