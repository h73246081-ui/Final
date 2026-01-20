<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ForgotPasswordOtpMail;
use Illuminate\Support\Facades\Storage;
use App\Models\PrivateSeller;


class RegisterController extends Controller
{
    //



// public function customerSignup(Request $request)
// {
//     $validator = Validator::make($request->all(), [
//         'name' => 'required|string|max:255',
//         'email' => 'required|email|unique:users,email',
//         'phone' => 'required|string|max:20',
//         'password' => 'required|min:6|confirmed'
//     ], [
//         'name.required' => 'Name is required',
//         'email.required' => 'Email is required',
//         'email.email' => 'Email must be valid',
//         'email.unique' => 'Email already exists',
//         'phone.required' => 'Phone number is required',
//         'password.required' => 'Password is required',
//         'password.confirmed' => 'Password confirmation does not match',
//         'password.min' => 'Password must be at least 6 characters'
//     ]);

//     if ($validator->fails()) {
//         return response()->json([
//             'status' => false,
//             'message' => 'Validation error',
//             'errors' => $validator->errors()
//         ], 422);
//     }

//     $role = Role::where('name','customer')->first();

//     if (!$role) {
//         return response()->json([
//             'status' => false,
//             'message' => 'Customer role not found'
//         ], 404);
//     }

//     $user = User::create([
//         'name' => $request->name,
//         'email' => $request->email,
//         'phone' => $request->phone,
//         'password' => bcrypt($request->password),
//         'role_id' => $role->id
//     ]);

//     $token = $user->createToken('auth_token')->plainTextToken;

//     return response()->json([
//         'status' => true,
//         'message' => 'Customer registered successfully',
//         'token' => $token,
//         'role' => 'customer'
//     ], 201);
// }



public function customerSignup(Request $request)
{
    try {

        $isVendor = $request->has('store_name') && !empty($request->store_name);
        $roleType = $isVendor ? 'Vendor' : 'Customer';
        // if($request->role=='private'){
        //     $roleType='Private Seller';
        //     $isVendor=false;
        // }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'store_name' => $isVendor ? 'required|string|max:255' : 'nullable',
            'phone' => $isVendor ? 'nullable' : 'required|string|max:20',
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be valid',
            'email.unique' => 'Email already exists',
            'password.required' => 'Password is required',
            'password.confirmed' => 'Password confirmation does not match',
            'password.min' => 'Password must be at least 6 characters',
            'store_name.required' => 'Store name is required for vendors',
            'phone.required' => 'Phone number is required for customers',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Fetch role
        $role = Role::where('name', $roleType)->first();
        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => $roleType . ' role not found',
            ], 404);
        }

        // Create user
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
        ];

        if ($isVendor) {
            // Vendor doesn't need phone
        } else {
            $userData['phone'] = $request->phone;
        }

        $user = User::create($userData);

        // Vendor table insert
        if ($isVendor) {
            Vendor::create([
                'user_id' => $user->id
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => $roleType . ' registered successfully',
            'token' => $token,
            'role' => strtolower($roleType),
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Server Error',
            'error' => $e->getMessage()
        ], 500);
    }
}

    // otp forgotten password
    public function storeOtp(Request $request){
        $request->validate([
            'email'=>'required'
        ]);
        $user=User::where('email',$request->email)->first();
        if(!$user){
            return response()->json([
                'message'=>'Email does not exist'
            ]);
        }
        $opt=rand(100000, 999999);
        $user->update([
            'password_reset_otp'=>$opt,
            'otp_expires_at'=>now()->addMinutes(1),
        ]);
        Mail::to($user->email)->send(new ForgotPasswordOtpMail($opt));


        return response()->json([
            'message'=>'Opt Send to email'
        ]);
    }
    public function verifyOtp(Request $request){
        $request->validate([
            'email'=>'required',
            'otp'=>'required'
        ]);
        $user=User::where('email',$request->email)->where('password_reset_otp',$request->otp)->first();
        if(!$user){
            return response()->json([
                'message'=>'Invalid Otp'
            ]);
        }
        return response()->json([
            'message'=>'Otp Varified'
        ]);
    }
    public function updatePassword(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
        $user=user::where('email',$request->email)->first();
        if(!$user){
            return response()->json([
                'message'=>'Process failed'
            ]);
        }
        $user->update([
            'password'=>Hash::make($request->password),
            'password_reset_otp'=>null,
            'otp_expires_at'=>null
        ]);
        return response()->json([
            'message'=>'Password Updated Successfully'
        ]);
    }





//---- Vendor & Customer ----- //

public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required'
    ], [
        'email.required' => 'Email is required',
        'email.email' => 'Email must be valid',
        'password.required' => 'Password is required'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation error',
            'errors' => $validator->errors()
        ], 422);
    }

    $user = User::where('email', $request->email)->with('role')->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'status' => true,
        'message' => 'Login successful',
        'token' => $token,
        'role' => $user->role->name
    ], 200);
}


        // 🔹 Logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully'
        ]);
    }



}
