<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FleaController extends Controller
{
    public function home() 
    {
        return view('home');
    }

    



        public function mypage(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'post_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        $user->update([
            'name' => $request->name,
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building' => $request->building,
            'profile_complete' => true, // プロフィール完了フラグを更新
        ]);


        return redirect('/home')->with('status', 'プロフィールが更新されました！');
    }

    public function address()
    {
        return view('address');
    }

    public function sell()
    {
        return view('sell');
    }
}
