<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $user;
    function __construct(User $user){
        $this->user = $user;
    }
    
    public function login(LoginRequest $request){
        try {
            $data = $this->user->checkUserLogin($request);
            return response()->json($data);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }
}
