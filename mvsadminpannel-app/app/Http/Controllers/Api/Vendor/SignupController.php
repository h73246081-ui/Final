<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Storage;


class SignupController extends Controller
{
    //

    public function vendorSignup(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'store_name' => 'required|string|max:255',
        'password' => 'required|min:6|confirmed',
    ], [
        'name.required' => 'Name is required',
        'email.required' => 'Email is required',
        'email.email' => 'Email must be valid',
        'email.unique' => 'Email already exists',
        'store_name.required' => 'Store name is required',
        'password.required' => 'Password is required',
        'password.confirmed' => 'Password confirmation does not match',
        'password.min' => 'Password must be at least 6 characters',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation error',
            'errors' => $validator->errors(),
        ], 422);
    }

    $role = Role::where('name', 'Vendor')->first();

    if (!$role) {
        return response()->json([
            'status' => false,
            'message' => 'Vendor role not found',
        ], 404);
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role_id' => $role->id,
    ]);

    Vendor::create([
        'user_id' => $user->id,
        'store_name' => $request->store_name,
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'status' => true,
        'message' => 'Vendor registered successfully',
        'token' => $token,
        'role' => 'vendor',
    ], 201);
}


}
