<?php

namespace App\Http\Controllers\API\v1;

use App\Enums\UserTokenPermissions;
use App\Enums\UserTokenTypes;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use App\Rules\ThaiEnglishPersonName;
use DB;
use Illuminate\Http\Request;
use Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->attempt($credentials)) {
            return $this->error('Unauthorized', 'Unauthorized', 401);
        }

        /**
         * @var User $user
         **/
        $user = auth()->user();
        $token = $user->createToken(
            UserTokenTypes::Auth->value,
            UserTokenPermissions::everything(),
            now()->addDay()
        )->plainTextToken;

        return $this->ok(data: [
            'id' => auth()->user()->hash_id,
            'email' => auth()->user()->email,
            'token' => $token,
        ]);
    }

    public function register(Request $request)
    {
        $req = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'name' => ['required', new ThaiEnglishPersonName()],
            'surname' => ['required', new ThaiEnglishPersonName()],

        ]);

        try {
            DB::beginTransaction();

            $user = User::forceCreate([
                'email' => $req['email'],
                'password' => bcrypt($req['password']),
                'remember_token' => Str::random(10),
            ]);

            $userProfile = UserProfile::forceCreate([
                'user_id' => $user->id,
                'name' => $req['name'],
                'surname' => $req['surname'],
            ]);

            DB::commit();

            return $this->ok(
                message: 'User created successfully',
                data: [
                    'id' => $user->hash_id,
                    'email' => $user->email,
                ],
            );
        } catch (\Exception $e) {
            return $this->rollBack('Failed to register', $e);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->ok('Logged out successfully');
    }
}
