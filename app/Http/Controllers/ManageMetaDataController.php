<?php

namespace App\Http\Controllers;

use App\Models\MetaData;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ManageMetaDataController extends Controller
{
    public function index()
    {
        return view('admin.managemetadata');
    }

    public function datatable(Request $request)
    {
        $data = MetaData::query();
        return DataTables::of($data)->make(true);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_alat' => 'string|max:255',
            'alamat' => 'string|max:255',

        ]);

        $hubhtb = MetaData::find($id);
        $hubhtb->update($validatedData);

        return response()->json(['success' => 'Data berhasil diupdate']);
    }


}
