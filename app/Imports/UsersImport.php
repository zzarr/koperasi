<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UsersImport implements ToCollection, WithStartRow
{
    /**
     * Map each row from the file to the User model.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            User::create([
                'name' => $row[0],
                'email' => $row[1],
                'username' => $row[2],
                'password' => Hash::make($row[3]), // Hash the password
                'phone_number' => $row[4],
                'address' => $row[5],
                'registered_at' => now(),
            ])->assignRole('user');
        }
    }
}
