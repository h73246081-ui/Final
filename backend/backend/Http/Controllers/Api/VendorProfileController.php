<?php

namespace App\Http\Controllers\Api;

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

class VendorProfileController extends Controller
{
    public function editProfile(){
        $user=Auth::user();
        return response()->json($user);
    }
    public function updateProfile(Request $request){
        $user=Auth::user();
        $user->name=$request->name;
        $user->last_name=$request->last_name;
        $user->email=$request->email;
        $user->phone=$request->phone;
        if($request->password){
            $user->password=Hash::make($request->password);
        }
        if($request->file('image')){
            if($user->image){
                $path=public_path($user->image);
                if(file_exists($path)){
                    unlink($path);
                }
            }
            $image=$request->file('image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/user'), $imageName);
            $user->image = 'upload/user/' . $imageName;
        }
        $user->save();
        return response()->json([
            $user
        ]);
    }
    //saif
    // old
    public function show()
{
    $user = auth()->user();

    if ($user->role->name !== 'Vendor') {
        return response()->json(['status'=>false,'message'=>'Only vendor allowed'],403);
    }

    $vendor = Vendor::where('user_id',$user->id)->first();

    $phone = $vendor?->phone ?? $user?->phone ?? null;

    return response()->json([
        'status'=>true,
        'data'=>[
            'store_name' => $vendor?->store_name,
            'phone' =>  $phone,
            'address' => $vendor?->address,
            'image' => $vendor?->image ? asset('storage/'.$vendor->image) : null,
            'email' => $user->email,
        ]
    ]);
}




//    public function show(Request $request)
//     {
//         $user = auth()->user();

//         // Role check
//         if ($user->role->name !== 'Vendor') {
//             return response()->json(['status'=>false,'message'=>'Only vendor allowed'], 403);
//         }

//         // Optional email parameter
//         $email = $request->query('email');

//         if ($email) {
//             // Find user by email
//             $userByEmail = User::where('email', $email)->first();

//             if (!$userByEmail) {
//                 return response()->json(['status'=>false,'message'=>'User not found'], 404);
//             }

//             $vendor = Vendor::where('user_id', $userByEmail->id)->first();
//             $phone = $vendor?->phone ?? $userByEmail->phone ?? null;
//             $emailToReturn = $userByEmail->email;

//         } else {
//             // Default: logged-in user
//             $vendor = Vendor::where('user_id', $user->id)->first();
//             $phone = $vendor?->phone ?? $user->phone ?? null;
//             $emailToReturn = $user->email;
//         }

//         // JSON response
//         return response()->json([
//             'status' => true,
//             'data' => [
//                 'store_name' => $vendor?->store_name,
//                 'phone' => $phone,
//                 'address' => $vendor?->address,
//                 'image' => $vendor?->image ? asset('storage/'.$vendor->image) : null,
//                 'email' => $emailToReturn,
//             ]
//         ]);
//     }





// old
public function store(Request $request)
{
    $user = auth()->user();

    if ($user->role->name !== 'Vendor') {
        return response()->json(['status'=>false,'message'=>'Only vendor allowed'],403);
    }

    $request->validate([
        'store_name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'image' => 'nullable|image|max:2048',
    ]);

    $vendor = Vendor::updateOrCreate(
        ['user_id' => $user->id],
        [
            'store_name' => $request->store_name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]
    );

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('vendors','public');
        $vendor->image = $path;
        $vendor->save();
    }

    return response()->json(['status'=>true,'message'=>'Profile updated']);
}



// public function store(Request $request)
// {
//     $user = auth()->user();

//     // Role check
//     if ($user->role->name !== 'Vendor') {
//         return response()->json(['status'=>false,'message'=>'Only vendor allowed'], 403);
//     }

//     // Validation
//     $request->validate([
//         'email' => 'nullable|email', // optional email
//         'store_name' => 'required|string|max:255',
//         'phone' => 'nullable|string|max:20',
//         'address' => 'nullable|string|max:255',
//         'image' => 'nullable|image|max:2048',
//     ]);

//     // Determine which user to update
//     if ($request->has('email') && $request->email !== $user->email) {
//         // Fetch user by email
//         $userToUpdate = User::where('email', $request->email)->first();
//         if (!$userToUpdate) {
//             return response()->json(['status'=>false,'message'=>'User not found'], 404);
//         }
//     } else {
//         // Default: logged-in user
//         $userToUpdate = $user;
//     }

//     // Update or create vendor profile
//     $vendor = Vendor::updateOrCreate(
//         ['user_id' => $userToUpdate->id],
//         [
//             'store_name' => $request->store_name,
//             'phone' => $request->phone,
//             'address' => $request->address,
//         ]
//     );

//     // Update image if provided
//     if ($request->hasFile('image')) {
//         $path = $request->file('image')->store('vendors', 'public');
//         $vendor->image = $path;
//         $vendor->save();
//     }

//     return response()->json([
//         'status' => true,
//         'message' => 'Profile updated',
//         'data' => [
//             'store_name' => $vendor->store_name,
//             'phone' => $vendor->phone,
//             'address' => $vendor->address,
//             'email' => $userToUpdate->email,
//             'image' => $vendor->image ? asset('storage/'.$vendor->image) : null,
//         ]
//     ]);
// }




}
