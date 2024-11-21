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
use Carbon\Carbon;




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
                $wallet->update([
                    'main'      => 0,
                    'monthly'   => 0,
                    'other'     => 0,
                    'total'     => 0,
                ]);
            } elseif ($request->type == 'other-cash') {
                // Penarikan dana Hari Raya (dari saldo 'other')
                if ($wallet->other - filterNumber($request->amount) >= 0) {
                    $wallet->update([
                        'other' => 0,
                        // $wallet->other - filterNumber($request->amount)
                    ]);
                }

                // Update untuk pembayaran bulanan yang belum dibayar (tidak diubah, tetap menggunakan 'monthly')
                // $monthlyUnpaid = MonthlyPayment::where('user_id', $request->user_id)
                //     ->where('payment_year', date('Y'))
                //     ->where('amount', 0)
                //     ->orderBy('payment_month', 'ASC')
                //     ->limit($request->value)
                //     ->pluck('id');

                // foreach ($monthlyUnpaid as $item) {
                //     MonthlyPayment::find($item)->update([
                //         'amount'    => $monthly->paid_off_amount,
                //         'paid_at'   => date('Y-m-d')
                //     ]);
                // }
            }

            // Buat histori penarikan
            Withdraw::create([
                'user_id'       => $request->user_id,
                'name'          => $request->type,
                'description'   => $request->note,
                'value'         => $request->value ?: 0,
                'amount'        => $request->value ? 0 : filterNumber($request->amount),
                'withdrawn_at'  => Carbon::now(),
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

    public function destroy($id)
    {
        DB::beginTransaction();
        try {


            DB::commit();
            $this->isSuccess = true;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->exception = $e->getMessage();
        }

        return response()->json([
            "status"    => $this->isSuccess ?? false,
            "code"      => $this->isSuccess ? 200 : 600,
            "message"   => $this->isSuccess ? "Success!" : ($this->exception ?? "Unknown error(?)"),
            // "data"      => $this->isSuccess ? $data : [],
        ], 201);
    }
}
