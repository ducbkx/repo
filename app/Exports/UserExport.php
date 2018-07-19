<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserExport implements FromCollection
{

    public function collection()
    {
        //Create header
        $header = [['Số thứ tự', 'Tên', 'Email', 'Giới tính', 'Mã nhân viên', 'Bộ phận', 'Chức vụ']];
        $collection = collect($header);
        
        //Get data
        $select = ['users.name', 'email', 'gender', 'code', 'divisions.name as division_name', 'role'];
        if (Auth::user()->is_admin) {
            $users = User::select($select)
                    ->join('divisions', 'users.division_id', 'divisions.id')
                    ->whereNull('is_admin')
                    ->get();
        } else {
            $users = User::select($select)
                    ->join('divisions', 'users.division_id', 'divisions.id')
                    ->where('division_id', Auth::user()->division_id)
                    ->get();
        }
        
        //Edit data
        $key = 1;
        $genders = User::getGenders();
        $roles = User::getRoles();
        foreach ($users as $user) {
            $data = [
                'no' => $key,
                'name' => $user->name,
                'email' => $user->email,
                'gender' => $genders[$user->gender],
                'code' => $user->code,
                'division_name' => $user->division_name,
                'role' => $roles[$user->role],
            ];
            $collection->push($data);
            $key ++;
        }
        
        return $collection;
    }

}
