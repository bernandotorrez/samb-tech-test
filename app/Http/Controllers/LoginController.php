<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\MySQL\FailedLoginService;
use App\Services\MySQL\UserService;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    protected UserService $model;
    protected FailedLoginService $failedLogin;
    protected $maxTry = 3;
    protected $resctrictionTime = 5; // in minutes

    public function __construct(
        UserService $user,
        FailedLoginService $failedLogin
    ) {
        $this->model = $user;
        $this->failedLogin = $failedLogin;
    }

    public function index()
    {
        return view('pages.login');
    }

    public function checkLoginBlock(Request $request) {
        $ip = $request->ip();

        $checkBlockIP = Cache::get("block:$ip") ?? false;

        if($checkBlockIP) {
            $cacheLastLoginDate = $checkBlockIP['lastLoginDate'];
            $cacheCurrentDate = date('Y-m-d H:i:s');
            $cacheDiff = $cacheLastLoginDate->diff(new DateTime($cacheCurrentDate));
            $cacheDiffMinutes = $this->resctrictionTime - $cacheDiff->i;

            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => "Anda memasukkan username dan password yang salah dalam 3 kali, silahkan tunggu $cacheDiffMinutes menit lagi",
                'data' => [
                    'chance' => 0,
                    'last_login_date' => $cacheLastLoginDate->modify('+'.$this->resctrictionTime.' minutes'),
                ]
            ], 200);
        } else {
            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => "Success mendapatkan Block IP",
                'data' => [
                    'chance' => 0,
                    'last_login_date' => 0,
                ]
            ], 200);
        }
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $username = $validated['username'];
        $password = $validated['password'];
        $ip = $request->ip();

        $checkBlockIP = Cache::get("block:$ip") ?? false;

        if($checkBlockIP) {
            // $cacheDiffMinutes = $checkBlockIP['diffMinutes'];
            $cacheLastLoginDate = $checkBlockIP['lastLoginDate'];
            $cacheCurrentDate = date('Y-m-d H:i:s');
            $cacheDiff = $cacheLastLoginDate->diff(new DateTime($cacheCurrentDate));
            $cacheDiffMinutes = $this->resctrictionTime - $cacheDiff->i;

            return response()->json([
                'code' => 200,
                'success' => false,
                'message' => "Anda memasukkan username dan password yang salah dalam 3 kali, silahkan tunggu $cacheDiffMinutes menit lagi",
                'data' => [
                    'chance' => 0,
                    'last_login_date' => $cacheLastLoginDate->modify('+'.$this->resctrictionTime.' minutes'),
                ]
            ], 200);
        } else {
            $checkLogin = Auth::attempt(['username' => $username, 'password' => $password, 'status' => '1']);

            if($checkLogin) {
                $this->failedLogin->deleteByIP($ip);
                return response()->json([
                    'code' => 200,
                    'success' => true,
                    'message' => 'success',
                    'data' => [
                        'chance' => 3,
                        'last_login_date' => 0,
                    ]
                ], 200);
            } else {

                // if failed insert into failed_login and count 3
                // if count more than 3 then user muse waiting 1 hour to login

                $dataFailedLoginByIP = $this->failedLogin->getByIP($ip);
                $currentDate = date('Y-m-d H:i:s');

                if(count($dataFailedLoginByIP) >= $this->maxTry) {
                    $lastLoginDate = new DateTime($dataFailedLoginByIP[0]->created_at);
                    $diff = $lastLoginDate->diff(new DateTime($currentDate));
                    $diffMinutes = $this->resctrictionTime - $diff->i;
                } else {
                    $diffMinutes = 0;
                }

                if(count($dataFailedLoginByIP) >= $this->maxTry && $diffMinutes <= 0) {
                    $this->failedLogin->deleteByIP($ip);
                }

                if(count($dataFailedLoginByIP) >= $this->maxTry && $diffMinutes > 0) {
                    Cache::remember("block:$ip", 60*$this->resctrictionTime, function() use ($diffMinutes, $lastLoginDate, $currentDate, $diff) {
                        return [
                            'block' => true,
                            'diffMinutes' => $diffMinutes,
                            'lastLoginDate' => $lastLoginDate,
                            'diff' => $diff->i,
                        ];
                    });

                    $checkBlockIP = Cache::get("block:$ip") ?? false;
                    $cacheLastLoginDate = $checkBlockIP['lastLoginDate'];
                    $cacheCurrentDate = date('Y-m-d H:i:s');
                    $cacheDiff = $cacheLastLoginDate->diff(new DateTime($cacheCurrentDate));
                    $cacheDiffMinutes = $this->resctrictionTime - $cacheDiff->i;

                    return response()->json([
                        'code' => 200,
                        'success' => false,
                        'message' => "Anda memasukkan username dan password yang salah dalam 3 kali, silahkan tunggu $cacheDiffMinutes menit lagi",
                        'data' => [
                            'chance' => 0,
                            'last_login_date' => $cacheLastLoginDate->modify('+'.$this->resctrictionTime.' minutes'),
                        ]
                    ], 200);

                } else {
                    $this->failedLogin->create(
                        [
                            'username' => $username,
                            'ip_address' => $request->ip()
                        ]
                    );

                    return response()->json([
                        'code' => 200,
                        'success' => false,
                        'message' => 'Username atau Password salah!',
                        'data' => [
                            'chance' => $this->maxTry - count($dataFailedLoginByIP),
                            'last_login_date' => 0,
                        ]
                    ], 200);
                }
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('index'));
    }

}
