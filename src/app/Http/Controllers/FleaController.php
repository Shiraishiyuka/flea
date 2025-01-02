<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FleaController extends Controller
{
    
    



        public function setupProfile(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'post_code' => 'nullable|string|max:10',
        'address' => 'nullable|string|max:255',
        'building' => 'nullable|string|max:255',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $profileImagePath = null;
    if ($request->hasFile('profile_image')) {
        $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
    }

    UserProfile::create([
        'user_id' => auth()->id(),
        'name' => $validated['name'],
        'post_code' => $validated['post_code'],
        'address' => $validated['address'],
        'building' => $validated['building'],
        'profile_image_path' => $profileImagePath,
    ]);

    return redirect()->route('home'); // ホームページへ
}

    public function address()
    {
        return view('address');
    }

    
}
