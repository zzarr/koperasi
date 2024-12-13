<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Roles;
use App\Models\Wallet;
use App\Models\YearlyLog;
use App\Models\MainPayment;
use Illuminate\Http\Request;
use App\Models\ConfigPayment;
use Yajra\DataTables\Facades\DataTables;
use App\Imports\MainPaymentImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class MainPaymentController extends Controller
{
    private $isSuccess;
    private $exception;

    public function __construct()
    {
        $this->isSuccess = false;
        $this->exception = null;
    }
    public function index(Request $request)
    {
        return view('admin.payment.main.index');
    }

    public function datatables()
    {
        // Ambil semua user yang memiliki role 'user'
            $user = User::with(['mainPayment.configPayment', 'roles'])
                ->role('user') // Filter user dengan role 'user' (fitur dari Spatie)
                ->get();
        return DataTables::of($user)->make();
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->amount = preg_replace('/[^0-9]/', '', $request->amount);

            $configPayment['main'] = ConfigPayment::where(['is_active' => 1, 'name' => 'main_payment'])->first();
            $mainPayment = MainPayment::updateOrCreate(
                ['id' => $request->id,

                    'user_id'   => $request->user_id,
                    'config_payment_id' => $configPayment['main']->id,
                    'amount'    => $request->amount,
                    'paid_at'   => $request->paid_at,
                ]
            );

            $mainTotal = MainPayment::where('user_id', $request->user_id)->sum('amount');
            if ($mainTotal >= $configPayment['main']->paid_off_amount) {
                User::where('id', $request->user_id)->update([
                    'main_payment_status' => 1
                ]);
            }

            $logYear = YearlyLog::where(['user_id'   => $request->user_id, 'year'   => date('Y', strtotime($request->paid_at))])->first();
            YearlyLog::updateOrCreate(
                [
                    'user_id'   => $request->user_id,
                    'year'   => date('Y', strtotime($request->paid_at))
                ],
                [
                    'total_main'    => ($logYear->total_main ?? 0) + $request->amount,
                ]
            );

            $wallet = Wallet::where('user_id', $request->user_id)->first();
            Wallet::updateOrCreate(
                [
                    'user_id'   => $request->user_id,
                ],
                [
                    'main'      => $mainTotal,
                    'total'     => $wallet ? ($mainTotal + $wallet->monthly + $wallet->other) : $mainTotal
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
        ], 201);
    }

    public function dataTanggal($id){
        $data = MainPayment::where('user_id', $id)->orderBy('created_at', 'ASC')->get();

        return response()->json($data);

    }

    public function exportInvoice(Request $request)
    {
        $data = MainPayment::with('user')->where('paid_at', $request->tanggal)->first();

        if (!$data) {
            return back()->with('error', 'Data tidak ditemukan untuk tanggal yang dipilih.');
        }

        // Generate PDF
        $pdf = Pdf::loadView('admin.payment.main.invoice', compact('data'))
            ->setPaper('a4', 'landscape');

        // Stream PDF ke browser untuk preview
        return $pdf->stream('Invoice_' . $data->id . '.pdf');
    }


}
