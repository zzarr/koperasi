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
        $data = Piutang::with('user'); // Mengambil data user terkait
        return DataTables::of($data)
            ->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '-'; // Ambil nama user atau tampilkan "-"
            })
            ->make(true);
    }

    public function getUsers()
    {
        $users = User::all(['id', 'name']); // Ambil hanya kolom id dan name
        return response()->json($users); // Kembalikan data dalam format JSON
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
        $validatedData = $request->validate([
            'nama' => 'required|exists:users,id', // Validasi harus sesuai ID user
            'jenis_hutang' => 'required|string',
            'jumlah_bulan' => 'required|integer|min:1|max:12',
            'jumlah_hutang' => 'required|numeric|min:0',
        ]);
    
        try {
            // Simpan data ke database
            Piutang::create([
                'user_id' => $validatedData['nama'],
                'jenis_hutang' => $validatedData['jenis_hutang'],
                'jumlah_bulan' => $validatedData['jumlah_bulan'],
                'jumlah_hutang' => $validatedData['jumlah_hutang'],
                'sisa' => $validatedData['jumlah_hutang'], // Misalnya, sisa sama dengan jumlah awal
                'is_lunas' => 0, // Default belum lunas
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
