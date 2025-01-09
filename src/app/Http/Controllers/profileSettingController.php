<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\UserProfile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class profileSettingController extends BaseController
{
    public function profile_setting()
    {
        return view('profile_setting');
    }

    public function saveProfile(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'post_code' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $userProfile = $user->userProfile;

        if (!$userProfile) {
            // プロファイルが存在しない場合、新規作成
            $userProfile = new UserProfile();
            $userProfile->user_id = $user->id;
        }

        // プロフィール画像の処理
        if ($request->hasFile('profile_image')) {
        // 古い画像を削除
        if ($userProfile->profile_image_path && Storage::disk('public')->exists($userProfile->profile_image_path)) {
        Storage::disk('public')->delete($userProfile->profile_image_path);
        }

        $uploadedFile = $request->file('profile_image');
        $path = $uploadedFile->store('profile_images', 'public');

        // Intervention Imageを使用してトリミングとリサイズ処理
        $image = Image::make(Storage::disk('public')->path($path));
        $size = min($image->width(), $image->height());
        $image->crop($size, $size); // 正方形に切り抜き
        $image->resize(120, 120);   // 適切なサイズにリサイズ
        $image->save();

        $userProfile->profile_image_path = $path;

}
        // フォームから受け取ったデータを保存
        $userProfile->name = $request->name;
        $userProfile->post_code = $request->post_code;
        $userProfile->address = $request->address;
        $userProfile->building = $request->building;

        $userProfile->save();

        $redirect = $this->handleRedirects($request);
        if ($redirect) {
            return $redirect;
        }

        return redirect()->route('home_route')->with('status', 'プロフィールが保存されました。');
        }
}
