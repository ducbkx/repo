<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
     public function showEmployee(User $user)
    {

        $users = User::where([['role', 0], ['division_id', Auth::user()->division_id]])->paginate(5);
        return view('auth.listEmployee', ['users' => $users]);
    }
    /**
     * 
     * @return type
     */
    public function information()
    {
        $users = User::where('email', Auth::user()->email)->paginate(5);
        return view('auth.information', ['users' => $users]);
    }
    public function editInformation($userId)
    {
        $user = $this->User->getById($userId);
        return view('auth.editInformation', compact('user'));
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function updateInformation(Request $request, $userId)
    {
        $divisions = Division::getList();
        $user = $this->User->getById($userId);
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'code' => 'required|unique:users',
        ];
        $messages = [
            'required' => 'Trường không được bỏ trống',
            'name.string' => 'Dữ liệu phải là chuỗi',
            'email.email' => 'Dữ liệu phải có định dạng email',
            'email.unique' => 'Email đã tồn tại',
            'code.unique' => 'Code đã tồn tại'
        ];
        if ($user->email != $request->get('email')) {
            $rules['email'] = 'required|email|unique:users';
        }
        $request->validate($rules, $messages);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->code = $request->code;
        $user->division_id = $request->division_id;

        if ($user->save()) {
            return redirect()->route('information');
        }
    }
}
