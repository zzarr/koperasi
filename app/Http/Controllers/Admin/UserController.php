<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    private $isSuccess;
    private $exception;

    public function __construct()
    {
        $this->isSuccess = false;
        $this->exception = null;
    }

    public function exportPDF()
    {
    $users = User::with('roles')->get(); // Ambil data pengguna dengan relasi roles

    // Load view dan kirim data ke PDF
    $pdf = Pdf::loadView('eksport.users-pdf', compact('users'));

    // Unduh file PDF
    return $pdf->download('users.pdf');
    }   

    // Menampilkan view utama untuk manajemen user
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all(); // Menambahkan pengambilan semua roles
        return view('admin.manage-user.index', compact('users', 'roles')); // Mengirimkan roles ke view
    }

    // Mengambil data untuk DataTables (jika digunakan)
    public function data()
    {
        $users = User::with('roles')->get();
        return DataTables::of($users)->make();
    }

    // Menampilkan data user untuk edit
    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);
        return response()->json(['user' => $user]);
    }

    // Menyimpan atau memperbarui data user
    public function store(Request $request)
{
    $request->validate([
        'email' => 'required|email|unique:users,email,' . $request->id,
        'username' => 'required|string|max:255|unique:users,username,' . $request->id,
        'password' => 'sometimes|nullable|string|min:6',
        'role_id' => 'required|exists:roles,id', // Validasi role_id
    ]);

    try {
        // Siapkan data user
        $data = [
            'email' => $request->email,
            'username' => $request->username,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'registered_at' => $request->registered_at ?? now()->toDateString(), // Menambahkan logika default
        ];

        // Jika password diisi, hash password sebelum menyimpan
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        // Mulai transaksi database
        DB::beginTransaction();

        // Buat atau update user
        $user = User::updateOrCreate(
            ['id' => $request->id ?? null], // Jika id ada, akan mengupdate, jika tidak akan membuat user baru
            $data
        );

        // Assign roles menggunakan Spatie
        if ($request->role_id) {
            $role = Role::findById($request->role_id);
            $user->syncRoles([$role]);
        }

        // Commit transaksi
        DB::commit();

        return redirect()->route('manage-user.index')->with('success', 'User saved successfully!');
    } catch (\Exception $e) {
        DB::rollBack();

        return redirect()->back()->with('error', 'Failed to save user: ' . $e->getMessage());
    }
}


    // Menghapus user
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $user->delete();
            DB::commit();
            $this->isSuccess = true;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->exception = $e->getMessage();
        }

        return response()->json([
            "status"    => $this->isSuccess ?? false,
            "code"      => $this->isSuccess ? 200 : 600,
            "message"   => $this->isSuccess ? "Success!" : ($this->exception ?? "Unknown error"),
            "data"      => $this->isSuccess ? $user : [],
        ], 201);
    }
}
