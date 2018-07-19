<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\{
    User,
    Division
};
use Illuminate\Support\Facades\Mail;
use App\Mail\sendEmail;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function __construct(User $user)
    {
        $this->User = $user;
        $divisions = Division::getList();

        $genders = User::getGenders();
        $roles = User::getRoles();
        //?????
        view()->share(compact('genders', 'divisions', 'roles'));
    }

    /**
     * 
     * @return type
     */
    public function create()
    {
        return view('auth.create');
    }

    /**
     * 
     * @param Request $request
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'avatar' => 'mimes:jpeg,jpg,png|dimensions:width=100,height=100',
            'code' => 'required|unique:users',
        ];
        $messages = [
            'required' => 'Trường không được bỏ trống',
            'name.string' => 'Dữ liệu phải là chuỗi',
            'email.email' => 'Dữ liệu phải có định dạng email',
            'email.unique' => 'Email đã tồn tại',
            'avatar.mimes' => 'Ảnh không đúng định dạng',
            'avatar.dimensions' => 'Ảnh không đúng kích thước',
            'code.unique' => 'Mã nhân viên đã tồn tại'];
        $request->validate($rules, $messages);


        $user = $request->all();
        $user['avatar'] =  $request->file('avatar')->store('avatars');
        $password = $this->User->createRandomPass();
        $user['password'] = bcrypt($password);
        if ($this->User->fill($user)->save()) {
            $user['password'] = $password;
            Mail::to($request->email)->send(new \App\Mail\sendMail($user));
            return redirect()->route('user.index');
        }
    }

    /**
     * 
     * @return type
     */
    public function index()
    {

        $users = User::whereNull('is_admin')->paginate(5);
        return view('auth.listUser', ['users' => $users]);
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function edit($userId)
    {
        $user = $this->User->getById($userId);
        return view('auth.editUser', compact('user'));
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function update(Request $request, $userId)
    {
        $user = $this->User->getById($userId);
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email',
            'avatar' => 'mimes:jpeg,jpg,png|dimensions:width=100,height=100',
            'code' => 'required',
        ];
        $messages = [
            'required' => 'Trường không được bỏ trống',
            'name.string' => 'Dữ liệu phải là chuỗi',
            'email.email' => 'Dữ liệu phải có định dạng email',
            'email.unique' => 'Email đã tồn tại',
            'avatar.mimes' => 'Ảnh không đúng định dạng',
            'avatar.dimensions' => 'Ảnh không đúng kích thước',
            'code.unique' => 'Mã nhân viên đã tồn tại'];
        if ($user->email != $request->get('email')) {
            $rules['email'] = 'required|email|unique:users';
        }
        if ($user->code != $request->get('code')) {
            $rules['code'] = 'required|unique:users';
        }
        $request->validate($rules, $messages);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->avatar =  $request->file('avatar')->store('avatars');
        $user->gender = $request->gender;
        $user->code = $request->code;
        $user->division_id = $request->division_id;

        if ($user->save()) {
            return redirect()->route('user.index');
        }
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('user.index');
    }

    /**
     * 
     * @param Request $request
     * @param type $userId
     * @return type
     */
    public function resetPassword(Request $request, $userId)
    {
        $user = $this->User->getById($userId);
        $password = $this->User->createRandomPass();
        $user->password = bcrypt($password);
        $user->active = false;
        if ($user->save()) {
            $user->password = $password;
            Mail::to($user->email)->send(new \App\Mail\sendMail($user));
            return redirect()->route('user.index');
        }
    }

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
            'email' => 'required|email',
            'code' => 'required',
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

    /**
     * 
     */
    public function excel()
    {
        return Excel::download(new UserExport, 'export.xls');
    }

}
