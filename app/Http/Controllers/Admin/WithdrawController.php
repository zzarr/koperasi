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
        $amount = $request->input('amount') ? preg_replace('/[^0-9]/', '', $request->input('amount')) : 0;
        $value = $request->input('value') ? preg_replace('/[^0-9]/', '', $request->input('value')) : 0;

        // dd($request, Carbon::now());
        try {
            DB::beginTransaction();
            $monthly = ConfigPayment::where('name', 'monthly_payment')->first();
            $wallet = Wallet::where('user_id', $request->user_id)->first();

            if ($request->type == 'all') {
                $wallet->update([
                    'main'      => 0,
                    'monthly'   => 0,
                    'other'     => 0,
                    'shu'       => 0,
                    'total'     => 0,
                ]);
            } elseif ($request->type == 'shu-cash') {
                if ($wallet->shu - filterNumber($request->amount) >= 0) {
                    $wallet->update([
                        'shu'       => $wallet->shu - filterNumber($request->amount),
                    ]);
                }
            } elseif ($request->type == 'other-cash') {
                if ($wallet->other - filterNumber($request->amount) >= 0) {
                    $wallet->update([
                        'other'       => $wallet->other - filterNumber($request->amount),
                    ]);
                }
            } elseif ($request->type == 'shu-monthly' || $request->type == 'other-monthly') {
                // Speciaaaaalll
                $monthlyData = MonthlyPayment::where('user_id', $request->user_id)->where('payment_year', date('Y'))->get();
                if (count($monthlyData) == 0) {
                    for ($i = 0; $i < 12; $i++) {
                        MonthlyPayment::create(
                            [
                                'user_id'           => $request->user_id,
                                'payment_month'     => ($i + 1),
                                'payment_year'      => date('Y'),
                                'config_payment_id' => $monthly->id,
                                'amount'            => 0,
                            ]
                        );
                    }
                }

                $monthlyUnpaid = MonthlyPayment::where('user_id', $request->user_id)
                    ->where('payment_year', date('Y'))
                    ->where('amount', 0)
                    ->orderBy('payment_month', 'ASC')
                    ->limit($request->value)
                    ->pluck('id');

                foreach ($monthlyUnpaid as $item) {
                    MonthlyPayment::find($item)->update([
                        'amount'    => $monthly->paid_off_amount,
                        'paid_at'   => date('Y-m-d')
                    ]);
                }

                if ($request->type == 'shu-monthly') {
                    $wallet->update([
                        'shu'       => $wallet->shu - ($monthly->paid_off_amount * $request->value),
                    ]);
                } else {
                    $wallet->update([
                        'other'       => $wallet->other - ($monthly->paid_off_amount * $request->value),
                    ]);
                }
            } elseif ($request->type == 'shu-other') {
                if ($wallet->shu - filterNumber($request->amount) >= 0) {

                    $otherData = OtherPayment::where('user_id', $request->user_id)->where('payment_year', date('Y'))->get();
                    if (count($otherData) == 0) {
                        for ($i = 0; $i < 12; $i++) {
                            OtherPayment::create(
                                [
                                    'user_id'           => $request->user_id,
                                    'payment_month'     => ($i + 1),
                                    'payment_year'      => date('Y'),
                                    'amount'            => 0,
                                ]
                            );
                        }
                    }

                    OtherPayment::where('user_id', $request->user_id)
                        ->where('payment_year', date('Y'))
                        ->where('payment_month', (int)date('m'))
                        ->update([
                            'amount'    => filterNumber($request->amount),
                            'paid_at'   => date('Y-m-d')
                        ]);

                    $wallet->update([
                        'shu'       => $wallet->shu - filterNumber($request->amount),
                        'other'     => $wallet->other + filterNumber($request->amount),
                    ]);
                }
            }

            Withdraw::create([
                'user_id'       => $request->user_id,
                'name'          => $request->type,
                'description'   => $request->note,
                'value'         => $request->value ?: 0,
                'amount'        => $request->value ? 0 : filterNumber($request->amount),
                'withdrawn_at'  => Carbon::now(),
                'status'        => 1,
            ]);

            $wallet = Wallet::where('user_id', $request->user_id)->first();
            $wallet->update([
                'total' => $wallet->main + $wallet->monthly + ($wallet->other ?? 0) + ($wallet->shu ?? 0)
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
