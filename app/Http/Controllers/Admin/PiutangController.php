<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PembayaranPiutang;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Piutang;
use App\Models\User;
use Illuminate\Http\Request;

class PiutangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.piutang.index');
    }

    public function datatables(Request $request)
    {
        $data = Piutang::with('user');
        return DataTables::of($data)
            ->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '-';
            })
            ->make(true);
    }

    public function getUsers()
    {
        $users = User::all(['id', 'name']);
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $cleanedJumlahHutang = str_replace(['Rp', '.', ' '], '', $request->jumlah_hutang);
        $request->merge(['jumlah_hutang' => $cleanedJumlahHutang]);

        $validatedData = $request->validate([
            'nama' => 'required|exists:users,id',
            'jenis_hutang' => 'required|string',
            'source' => 'required|string',
            'jumlah_bulan' => 'required|integer',
            'jumlah_hutang' => 'required|numeric|min:0',
        ]);

        try {
            if($validatedData['jenis_hutang'] == 'rutin' || $validatedData['jenis_hutang'] == 'rutin_2' || $validatedData['jenis_hutang'] == 'ob')
                $paymentType = 'dept_routine';
            else
                $paymentType = 'dept_special';

            $configPayment = \App\Models\ConfigPayment::where('name', $paymentType)->first();
            if (!$configPayment) {
                return response()->json(['message' => 'Jenis hutang tidak ditemukan dalam konfigurasi pembayaran'], 400);
            }


            // if($isAnyHutangAvailable){
            if($validatedData['jenis_hutang'] == 'ob'){
                $isAnyHutangAvailable = Piutang::where('user_id', $validatedData['nama'])->where('jenis_hutang', 'rutin')->where('is_lunas', 0)->first();

                $sisaPokok = $isAnyHutangAvailable->jumlah_hutang - PembayaranPiutang::where('hutang_id', $isAnyHutangAvailable->id)->sum('jumlah_bayar_pokok');
                $sisa = ($validatedData['jumlah_hutang'] + $sisaPokok)  * ($configPayment->paid_off_amount / 100) * $validatedData['jumlah_bulan'] + ($validatedData['jumlah_hutang'] + $sisaPokok);

                $isAnyHutangAvailable->update([
                    'jumlah_hutang' => $validatedData['jumlah_hutang'] + $sisaPokok,
                    'jumlah_bulan' => $validatedData['jumlah_bulan'],
                    'jenis_hutang' => $validatedData['jenis_hutang'],
                    'sisa' => $sisa,
                    'source' => $request->source,
                ]);
                
                PembayaranPiutang::where('hutang_id', $isAnyHutangAvailable->id)->delete();
            }else{
                $sisa = $validatedData['jumlah_hutang']  * ($configPayment->paid_off_amount / 100) * $validatedData['jumlah_bulan'] + $validatedData['jumlah_hutang'];

                Piutang::create([
                    'user_id' => $validatedData['nama'],
                    'jenis_hutang' => $validatedData['jenis_hutang'],
                    'jumlah_bulan' => $validatedData['jumlah_bulan'],
                    'jumlah_hutang' => $validatedData['jumlah_hutang'],
                    'sisa' => $sisa,
                    'is_lunas' => 0,
                    'source' => $request->source,
                ]);
            }

            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error' => $e->getMessage().' : '.$validatedData['jumlah_hutang']
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $antena = Piutang::find($id);
        $antena->delete();
        return response()->json(['success', 'Data berhasil dihapus!']);
    }
}
