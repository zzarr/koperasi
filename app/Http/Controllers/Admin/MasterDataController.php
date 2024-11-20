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
        $data['main'] = ConfigPayment::where('name', 'main_payment')->first();
        $data['monthly'] = ConfigPayment::where('name', 'monthly_payment')->first();
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
                ['name' => 'monthly_payment'],
                [
                    'paid_off_amount'   => preg_replace('/[^0-9]/', '', $request->monthly_payment),
                    'is_active'         => 1
                ]
            );

            // Ambil konfigurasi pembayaran utama
            $configPayment = ConfigPayment::where(['is_active' => 1, 'name' => 'main_payment'])->first();

            // Ambil semua pengguna dari tabel MainPayment secara unik berdasarkan user_id
            $users = MainPayment::select('user_id')->distinct()->get();

            foreach ($users as $user) {
                // Hitung total pembayaran utama untuk setiap user
                $mainTotal = MainPayment::where('user_id', $user->user_id)->sum('amount');

                // Periksa apakah pembayaran sudah mencapai jumlah lunas
                if ($mainTotal >= $configPayment->paid_off_amount) {
                    // Update status pembayaran untuk user terkait
                    User::where('id', $user->user_id)->update([
                        'main_payment_status' => 1
                    ]);
                } else {
                    // Optional: Update jika status belum lunas
                    User::where('id', $user->user_id)->update([
                        'main_payment_status' => 0
                    ]);
                }
            }

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
}
