<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:120'], 'email' => ['required', 'email', 'unique:users,email'], 'phone' => ['nullable', 'string', 'max:32'], 'password' => ['required', 'string', 'min:8', 'confirmed']]);
        $user = User::create([...$data, 'role' => 'customer']);
        return response()->json($this->tokenResponse($user, 'customer-web'), 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate(['email' => ['required', 'email'], 'password' => ['required', 'string'], 'device_name' => ['nullable', 'string', 'max:80']]);
        $user = User::where('email', $data['email'])->first();
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages(['email' => ['Email atau kata sandi tidak sesuai.']]);
        }
        $user->update(['last_login_at' => now()]);
        return response()->json($this->tokenResponse($user, $data['device_name'] ?? 'laundry-desk'));
    }

    public function me(Request $request) { return $request->user()->load('store'); }
    public function logout(Request $request) { $request->user()->currentAccessToken()?->delete(); return response()->noContent(); }

    private function tokenResponse(User $user, string $device): array
    {
        $abilities = match ($user->role) { 'platform_admin' => ['admin:*'], 'store_admin' => ['store:*'], default => ['customer:*'] };
        return ['token' => $user->createToken($device, $abilities)->plainTextToken, 'user' => $user->load('store')];
    }
}
