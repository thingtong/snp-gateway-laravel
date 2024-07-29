<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Rules\ThaiEnglishPersonName;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get(Request $request)
    {
        $user = Auth::user()->load('profile');

        return $this->ok(data: $user);
    }

    public function updateProfile(Request $request)
    {
        $req = $request->validate([
            'name' => ['required', new ThaiEnglishPersonName()],
            'surname' => ['required', new ThaiEnglishPersonName()],
        ]);

        $user = Auth::user();
        $profile = $user->profile;

        $profile->update($req);

        return $this->ok(data: $profile);
    }
}
