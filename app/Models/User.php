<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function getUserById($id)
    {
        return $this->find($id);
    }

    public function checkUserLogin(Request $request)
    {
        $user = $this->getUserByEmail($request->email);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return [
                'errors' => ['The provided credentials are incorrect.'],
                'status' => 401
            ];
        }

        if (Auth::attempt($request->all())) {
            $checkUser = Auth::getLastAttempted();
            Auth::login($checkUser);
            $token = Auth::user()->createToken('LaravelAuthApp')->accessToken;
            // $expiration = Auth::user()->createToken('LaravelAuthApp')->token->expires_at->diffForHumans();
            return [
                'token' => $token,
                'user' => new UserResource(Auth::user()),
                'message' => 'User Logged In successfully',
                'status' => 200
            ];
        }

        return ['errors' => 'Invalid email/password.', 'status' => 401];

    }

    public function changeUserPassword(Request $request, $userId){
        $user = $this->getUserById($userId);
        $user->password = Hash::make($request->password);
        $user->update();

        return response()->json([ 'message' => 'Password changed successfully', 'status' => 200 ]);
    }
}
