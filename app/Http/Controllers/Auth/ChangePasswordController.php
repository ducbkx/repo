<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ChangePasswordController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show form change password
     * 
     * @return view
     */
    public function showForm()
    {
        return view('auth.passwords.change');
    }

    /**
     * Change password
     * 
     * @param Request $request
     * @return view
     */
    public function postChange(Request $request)
    {
        $rules = [
            'current_password' => 'required|min:8|old_password:' . Auth::user()->password,
            'password' => 'required|min:8|different:current_password|confirmed',
        ];
        $messages = [
            'min' => 'Mật khẩu phải dài hơn :min ký tự',
            'old_password' => 'Mật khẩu hiện tại không chính xác',
            'confirmed' => 'Mật khẩu nhập lại không khớp',
            'different' => 'Mật khẩu mới phải khác mật khẩu cũ',
        ];
        
        $request->validate($rules, $messages);

        
        $user = Auth::user();
        $user->password = bcrypt($request->get('password'));
        $user->active = true;
        if ($user->save()) {
            return redirect()->route('home');
        }
    }
}
