<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Withdraw;
use App\Models\Wallet;
use App\Models\ConfigPayment;
use App\Models\MonthlyPayment;
use App\Models\OtherPayment;
use Barryvdh\DomPDF\Facade\Pdf;




class WithdrawController extends Controller
{

    private $isSuccess;
    private $exception;
    public function index(Request $request)
    {
        $data['user'] = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        })->orderBy('name', 'ASC')->get();

        return view('admin.withdraw-request.index', $data);
    }

    public function datatables(Request $request)
    {
        $data = Withdraw::with('user')->get();

        return DataTables::of($data)->make();
    }

    public function show($id)
    {
        return $id;
    }

    public function userWallet($id)
    {
        return User::with('wallet')->find($id);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $monthly = ConfigPayment::where('name', 'monthly_payment')->first();
            $wallet = Wallet::where('user_id', $request->user_id)->first();

            if ($request->type == 'all') {
                // Penarikan keseluruhan tabungan
                $amount = $wallet->total;
                $wallet->update([
                    'main'      => 0,
                    'monthly'   => 0,
                    'other'     => 0,
                    'total'     => 0,
                ]);
            } elseif ($request->type == 'other-cash') {
                // Penarikan dana Hari Raya (dari saldo 'other')
                if ($wallet->other - filterNumber($request->amount) >= 0) {
                    $amount = $wallet->other;
                    $wallet->update([
                        'other' => 0,
                        // $wallet->other - filterNumber($request->amount)
                    ]);
                } else {
                    $amount = 0; // Default untuk tipe lainnya
                }
            }

            // Buat histori penarikan
            Withdraw::create([
                'user_id'       => $request->user_id,
                'name'          => $request->type,
                'description'   => $request->note,
                'value'         => $request->value ?: 0,
                'amount'        => filterNumber($amount),
                'withdrawn_at'  => now(),
                'status'        => 1,
            ]);

            // Update saldo total wallet
            $wallet = Wallet::where('user_id', $request->user_id)->first();
            $wallet->update([
                'total' => $wallet->main + $wallet->monthly + ($wallet->other ?? 0)
            ]);

            DB::commit();
            $this->isSuccess = true;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->exception = $e->getMessage();

            Log::error('Error in Store Method', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return response()->json([
            "status"    => $this->isSuccess ?? false,
            "code"      => $this->isSuccess ? 200 : 600,
            "message"   => $this->isSuccess ? "Success!" : ($this->exception ?? "Unknown error(?)"),
        ], 201);
    }

    public function previewInvoice($id)
    {
        // Ambil data withdraw berdasarkan ID
        $withdraw = Withdraw::findOrFail($id);

        // Validasi data
        if (!$withdraw) {
            return redirect()->back()->withErrors(['error' => 'Data withdraw tidak ditemukan.']);
        }

        // Generate PDF
        $pdf = Pdf::loadView('admin.withdraw-request.invoices', compact('withdraw'))
            ->setPaper('a4', 'landscape');

        // Stream PDF ke browser untuk preview
        return $pdf->stream('Invoice_Withdraw_' . $withdraw->id . '.pdf');
    }
}
