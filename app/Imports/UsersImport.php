<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
     * Map each row from the file to the User model.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name' => $row[0],
            'email' => $row[1],
            'username' => $row[2],
            'password' => Hash::make($row[3]), // Hash the password
            'phone_number' => $row[4],
            'address' => $row[5],
        ]);
    }
}