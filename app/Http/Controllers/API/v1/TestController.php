<?php

namespace App\Http\Controllers\API\v1;

use App\Exceptions\ErrorException;
use App\Http\Controllers\Controller;
use App\Jobs\SendNameJob;
use App\Models\User;
use App\Utils\FileUtil;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TestController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('static_token_auth', only: ['tryStaticToken']),
        ];
    }

    public function index(Request $request)
    {
        $test = ['name' => 'John Doe'];

        return $this->ok($test);
    }

    public function testError(Request $request)
    {
        return $this->error(message: 'Send error response');
    }

    public function validationError(Request $request)
    {
        $req = $request->validate([
            'name' => 'required',
        ]);
    }

    public function queryNotFound(Request $request)
    {
        $user = User::findOrFail(999);
    }

    public function manualThrow(Request $request)
    {
        throw new ErrorException('This is my custom error message');
    }

    public function codeError(Request $request)
    {
        $a = ['a' => 1];

        return $this->ok($a['b']);
    }

    public function ramdomNameByUserId(Request $request)
    {
        $user = User::find(1);
        $user->name = bin2hex(random_bytes(5));
        $user->save();

        SendNameJob::dispatch($user);

        return $this->ok(['name' => $user->name]);
    }

    public function uploadFile(Request $request)
    {
        $req = $request->validate([
            'image' => 'required|sometimes|image|file',
            'file' => 'required|sometimes|file',
        ]);

        // $file = FileUtil::upload()->image(file: $req['image']);
        $file = FileUtil::upload()->file(file: $req['file']);

        return $this->ok(['file' => $file]);
    }

    /**
     * ตัวอย่าง command การ gen token ไว้ใช้ใน header
     * php artisan api:regen-token --key=snp-gateway
     */
    public function tryStaticToken(Request $request)
    {
        return $this->ok(['message' => 'You have access to this route']);
    }
}
