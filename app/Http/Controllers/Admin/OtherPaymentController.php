<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Role;
use App\Models\Wallet;
use App\Models\YearlyLog;
use App\Models\OtherPayment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Imports\OtherPaymentImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class OtherPaymentController extends Controller
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
        return view('admin.payment.other.index');
    }

    public function datatables()
    {
        $year = date('Y');

        // Memfilter user yang bukan admin berdasarkan role
        $users = User::whereHas('roles', function ($query) {
                $query->where('name', '!=', 'admin');
            })
            ->with(['otherPayment' => function ($query) use ($year) {
                $query->where('payment_year', $year);
            }])
            ->get();

        return DataTables::of($users)
            ->addColumn('other_total', function ($user) use ($year) {
                return OtherPayment::where('payment_year', $year)
                    ->where('user_id', $user->id)
                    ->sum('amount') ?? 0;
            })
            ->addColumn('last_year_1', function ($user) {
                return OtherPayment::where('payment_year', '<=', date('Y') - 1)
                    ->where('user_id', $user->id)
                    ->sum('amount') ?? 0;
            })
            ->addColumn('total_all', function ($user) {
                return OtherPayment::where('user_id', $user->id)
                    ->sum('amount') ?? 0;
            })
            ->make();
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->merge([
                'amount' => preg_replace('/[^0-9]/', '', $request->amount),
            ]);

            // Inisialisasi bulan (jika belum dibuat)
//            for ($i = 1; $i <= 12; $i++) {
//                OtherPayment::updateOrCreate(
//                    [
//                        'user_id' => $request->user_id,
//                        'payment_month' => $i,
//                        'payment_year' => $request->payment_year,
//                    ],
//                    [
//                        'amount' => 0,
//                    ]
//                );
//            }

            // Simpan atau perbarui pembayaran
            $otherPayment = OtherPayment::updateOrCreate(
                [
                    'user_id' => $request->user_id,
                    'payment_month' => $request->payment_month,
                    'payment_year' => $request->payment_year,
                ],
                [
                    'amount' => $request->amount,
                    'paid_at' => $request->paid_at,
                ]
            );

            // Hitung total pembayaran untuk wallet dan yearly log
            $otherTotal = OtherPayment::where('user_id', $request->user_id)->sum('amount');

            YearlyLog::updateOrCreate(
                [
                    'user_id' => $request->user_id,
                    'year' => $request->payment_year,
                ],
                [
                    'total_other' => $otherTotal,
                ]
            );

            $wallet = Wallet::where('user_id', $request->user_id)->first();
            Wallet::updateOrCreate(
                [
                    'user_id' => $request->user_id,
                ],
                [
                    'other' => $otherTotal,
                    'total' => $wallet ? ($otherTotal + $wallet->main + $wallet->monthly) : $otherTotal,
                ]
            );

            DB::commit();
            $this->isSuccess = true;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->exception = $e->getMessage();
        }

        return response()->json([
            "status" => $this->isSuccess ?? false,
            "code" => $this->isSuccess ? 200 : 600,
            "message" => $this->isSuccess ? "Success!" : ($this->exception ?? "Unknown error."),
        ], 201);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx',
        ]);

        // Upload file
        $file = $request->file('file');
        $nama_file = rand() . $file->getClientOriginalName();
        $file->move('import/other', $nama_file);

        // Import data
        Excel::import(new OtherPaymentImport($request->year), public_path('/import/other/' . $nama_file));

        return redirect()->back()->with('success', 'Import Success!');
    }

    public function dataTanggal($id){
        $data = OtherPayment::where('user_id', $id)->where('payment_year', date('Y'))->orderBy('payment_month', 'ASC')->get();
        return response()->json($data);

    }

    public function exportInvoice(Request $request)
    {
        $data = OtherPayment::with('user')
            ->where('payment_month', $request->month)
            ->where('user_id', $request->user_id)
            ->first();

        if (!$data) {
            return back()->with('error', 'Data tidak ditemukan untuk tanggal yang dipilih.');
        }

        // Generate PDF
        $pdf = Pdf::loadView('admin.payment.other.invoiceOther', compact('data'))
            ->setPaper('a4', 'landscape');

        // Stream PDF ke browser
        return $pdf->stream('Invoice_' . $data->id . '.pdf');
    }

}
