<?php

namespace App\Http\Controllers;

use App\Models\MainPayment;
use App\Models\MonthlyPayment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ManageMetaDataController extends Controller
{
    public function index()
    {
        // Mengambil data untuk 'main_payment' dan 'monthly_payment'
        $main = MainPayment::first(); // Ambil data pertama dari tabel main_payment
        $monthly = MonthlyPayment::first(); // Ambil data pertama dari tabel monthly_payment

        // Kirim data ke view
        return view('admin.managemetadata', compact('main', 'monthly'));
    }

    public function datatable(Request $request)
    {
        $data = MetaData::query(); // Ini tetap menggunakan model MetaData untuk DataTables
        return DataTables::of($data)->make(true);
    }

    public function update(Request $request, $id)
    {
        \Log::info('Data Received:', $request->all());

        // Update data untuk main_payment atau monthly_payment berdasarkan id
        if ($request->has('main_payment')) {
            $mainPayment = MainPayment::findOrFail($id);
            $request->validate([
                'main_payment' => 'required|numeric',
            ]);
            $mainPayment->paid_off_amount = $request->main_payment;
            $mainPayment->save();
        }

        if ($request->has('monthly_payment')) {
            $monthlyPayment = MonthlyPayment::findOrFail($id);
            $request->validate([
                'monthly_payment' => 'required|numeric',
            ]);
            $monthlyPayment->paid_off_amount = $request->monthly_payment;
            $monthlyPayment->save();
        }

        return response()->json([
            'message' => 'Data updated successfully',
            'code' => 200
        ]);
    }
}
