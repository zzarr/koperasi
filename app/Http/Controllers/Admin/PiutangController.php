<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
            'jumlah_bulan' => 'required|integer|min:1|max:12',
            'jumlah_hutang' => 'required|numeric|min:0',
        ]);
    
        try {
            $paymentType = $validatedData['jenis_hutang'] == 'rutin' ? 'dept_routine' : 'dept_special';
    
            $configPayment = \App\Models\ConfigPayment::where('name', $paymentType)->first();
            if (!$configPayment) {
                return response()->json(['message' => 'Jenis hutang tidak ditemukan dalam konfigurasi pembayaran'], 400);
            }
            $sisa = $validatedData['jumlah_hutang'] * ($configPayment->paid_off_amount / 100) + $validatedData['jumlah_hutang'];
    
            Piutang::create([
                'user_id' => $validatedData['nama'], 
                'jenis_hutang' => $validatedData['jenis_hutang'],
                'jumlah_bulan' => $validatedData['jumlah_bulan'],
                'jumlah_hutang' => $validatedData['jumlah_hutang'],
                'sisa' => $sisa,
                'is_lunas' => 0,
            ]);
    
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data'], 500);
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
