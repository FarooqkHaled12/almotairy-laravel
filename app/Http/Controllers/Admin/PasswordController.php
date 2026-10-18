<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('admin.password.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:3|confirmed',
        ], [
            'current_password.required' => 'كلمة المرور الحالية مطلوبة',
            'new_password.required' => 'كلمة المرور الجديدة مطلوبة',
            'new_password.min' => 'كلمة المرور الجديدة يجب أن تكون 3 أحرف على الأقل',
            'new_password.confirmed' => 'كلمة المرور الجديدة غير متطابقة',
        ]);

        $admin = Auth::guard('admin')->user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
        }

        // Update password
        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return redirect()->route('admin.password.edit')->with('success', 'تم تغيير كلمة المرور بنجاح');
    }
}
