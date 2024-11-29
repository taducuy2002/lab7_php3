<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('Auth.login');
    }
    public function postLogin(Request $request)
    {
        $data = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required']
            ]
        );

        if (Auth::attempt($data)) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.users');
            }
            return redirect()->route('profile.show');
        }

        return back()->withErrors(['invalid_login' => 'Thông tin đăng nhập không chính xác'])->withInput();
    }

    public function register()
    {
        return view('Auth.register');
    }

    public function postRegister(Request $request)
    {
        $data = $request->except('avatar');

        $data = $request->validate(
            [
                'fullname' => ['required'],
                'username' => ['required', 'min:5', 'unique:users,username'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'min:6'],
                'password_confirm' => ['required', 'same:password']
            ],
            [
                'fullname.required' => 'fullname là trường bắt buộc.',
                
                'username.required' => 'username là trường bắt buộc.',
                'username.min' => 'username phải có ít nhất :min ký tự.',
                'username.unique' => 'username đã tồn tại trong hệ thống.',
                
                'email.required' => 'email là trường bắt buộc.',
                'email.email' => 'email phải là một địa chỉ email hợp lệ.',
                'email.unique' => 'email đã tồn tại trong hệ thống.',
                
                'password.required' => 'password là trường bắt buộc.',
                'password.min' => 'password phải có ít nhất :min ký tự.',
                
                'password_confirm.required' => 'password_confirm là trường bắt buộc.',
                'password_confirm.same' => 'password_confirm phải trùng khớp với password.',
            ]
        );

        // upload ảnh
        if ($request->hasFile('avatar')) {
            $path_image = $request->file('avatar')->store('images');
            $data['avatar'] = $path_image;
        }

        User::query()->create($data);

        return redirect()->route('login')->with('message', 'Đăng ký thành công!');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

    public function showProfile()
    {
        $user = Auth::user();
        return view('showProfile', compact('user'));
    }

    public function editProfile($id)
    {
        $user = Auth::user();
        return view('editProfile', compact('user'));
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::query()->find($id);

        $data = $request->except('image');

        $data = $request->validate(
            [
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image',
            ],
            [
                'fullname.required' => 'fullname là trường bắt buộc.',
                'fullname.string' => 'fullname phải là một chuỗi ký tự.',
                'fullname.max' => 'fullname không được vượt quá :max ký tự.',
                'email.email' => 'email phải là một địa chỉ email hợp lệ.',
                'email.unique' => 'email đã tồn tại trong hệ thống.',
                'image.image' => 'image phải là một tệp hình ảnh.',
            ]
    );

        // upload ảnh
        if ($request->hasFile('avatar')) {
            $path_image = $request->file('avatar')->store('images');
            $data['avatar'] = $path_image;
        }

        $user->update($data);

        return back()->with('message', 'Cập nhật thông tin thành công!.');
    }

    public function showChangePasswordForm()
    {
        return view('auth.passwords.changePassword');
    }

    /**
     * Xử lý yêu cầu đổi mật khẩu.
     */
    public function changePassword(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:6'],
            'confirm_password' => ['required', 'same:new_password'],
        ], 
        [
            'current_password.required' => 'Bạn cần nhập mật khẩu hiện tại.',
            'new_password.required' => 'Mật khẩu mới không được để trống.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'confirm_password.required' => 'Vui lòng xác nhận mật khẩu mới.',
            'confirm_password.same' => 'Mật khẩu xác nhận không khớp.',
        ]);

        $user = Auth::user();

        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        // Cập nhật mật khẩu mới
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('password.change')->with('success', 'Đổi mật khẩu thành công!');
    }
}
