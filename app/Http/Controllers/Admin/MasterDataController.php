<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\ConfigPayment;
use App\Models\MainPayment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MasterDataController extends Controller
{
    private $isSuccess;
    private $exception;

    public function __construct()
    {
        $this->isSuccess = false;
        $this->exception = null;
    }

    public function index()
    {
        $data['app'] = ConfigPayment::where('name', 'LIKE', '%app_%')->get();
        $data['main'] = ConfigPayment::where('name', 'main_payment')->first();
        $data['monthlyAsn'] = ConfigPayment::where('name', 'monthly_payment_asn')->first();
        $data['monthlyTu'] = ConfigPayment::where('name', 'monthly_payment_tu')->first();
        $data['monthly'] = ConfigPayment::where('name', 'monthly_payment')->first();
        $data['routine'] = ConfigPayment::where('name', 'dept_routine')->first();
        $data['special'] = ConfigPayment::where('name', 'dept_special')->first();
        return view('admin.meta.managemetadata', $data);
    }

    public function getData()
    {
        return response()->json(ConfigPayment::where('name', 'monthly_payment')->first());
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            ConfigPayment::updateOrCreate(
                ['name' => 'main_payment'],
                [
                    'paid_off_amount'   => preg_replace('/[^0-9]/', '', $request->main_payment),
                    'is_active'         => 1
                ]
            );

            ConfigPayment::updateOrCreate(
                ['name' => 'monthly_payment_asn'],
                [
                    'paid_off_amount'   => preg_replace('/[^0-9]/', '', $request->monthly_payment_asn),
                    'is_active'         => 1
                ]
            );
            
            ConfigPayment::updateOrCreate(
                ['name' => 'monthly_payment_tu'],
                [
                    'paid_off_amount'   => preg_replace('/[^0-9]/', '', $request->monthly_payment_tu),
                    'is_active'         => 1
                ]
            );
            
            ConfigPayment::updateOrCreate(
                ['name' => 'monthly_payment'],
                [
                    'paid_off_amount'   => preg_replace('/[^0-9]/', '', $request->monthly_payment),
                    'is_active'         => 1
                ]
            );

            ConfigPayment::updateOrCreate(
                ['name' => 'dept_routine'],
                [
                    'paid_off_amount'   => $request->dept_routine,
                    'is_active'         => 1
                ]
            );

            ConfigPayment::updateOrCreate(
                ['name' => 'dept_special'],
                [
                    'paid_off_amount'   => $request->dept_special,
                    'is_active'         => 1
                ]
            );

            // ======================================================
            ConfigPayment::updateOrCreate(
                ['name' => 'app_app_name'],
                [
                    'paid_off_amount'   => $request->app_name,
                    'is_active'         => 1
                ]
            );
            ConfigPayment::updateOrCreate(
                ['name' => 'app_instansi'],
                [
                    'paid_off_amount'   => $request->instansi,
                    'is_active'         => 1
                ]
            );
            ConfigPayment::updateOrCreate(
                ['name' => 'app_location'],
                [
                    'paid_off_amount'   => $request->location,
                    'is_active'         => 1
                ]
            );
            ConfigPayment::updateOrCreate(
                ['name' => 'app_ketua'],
                [
                    'paid_off_amount'   => $request->ketua,
                    'is_active'         => 1
                ]
            );
            ConfigPayment::updateOrCreate(
                ['name' => 'app_bendahara'],
                [
                    'paid_off_amount'   => $request->bendahara,
                    'is_active'         => 1
                ]
            );



            DB::commit();
            $this->isSuccess = true;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->exception = $e;
            dd($e->getMessage());
        }
        return redirect()->back();
        return response()->json([
            "status"    => $this->isSuccess ?? false,
            "code"      => $this->isSuccess ? 200 : 600,
            "message"   => $this->isSuccess ? "Success!" : ($this->exception ?? "Unknown error(?)"),
        ], 201);
    }
}
