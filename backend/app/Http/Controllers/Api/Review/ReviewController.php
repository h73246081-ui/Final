<?php

namespace App\Http\Controllers\Api\Review;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\VendorReview;
use App\Models\Vendor;

class ReviewController extends Controller
{
    public function storeReview(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string',
        ]);
        $review=new VendorReview;
        $user_id = auth()->id();
        $review->user_id=$user_id;
        $review->product_id = $request->product_id;
        if($request->title){
            $review->title = $request->title;
        }
        $review->comment = $request->comment;
        if($request->rating){
            $review->rating = $request->rating;
        }
        $review->status='approved';
        $review->save();
        return response()->json([
            'message'=>'Store'
        ]);
    }
    public function allReviewVendor(){
        $vendor = Vendor::where('user_id', auth()->id())->first();

        if (!$vendor) {
            return response()->json([
                'error' => 'Vendor does not exist'
            ], 404);
        }

        $reviews = VendorReview::with(['user', 'vendorProduct'])
                    ->whereHas('vendorProduct', function($q) use ($vendor) {
                        $q->where('vendor_id', $vendor->id);
                    })
                    ->latest()
                    ->get();

        return response()->json([
            'data' => $reviews
        ]);
    }
    public function deleteReview($id){
        $review=VendorReview::find($id);
        if(!$review){
            return response()->json([
                'error' => 'Does not exist'
            ], 404);
        }
        $review->delete();
        return response()->json([
            'message'=>'Delete Successfully'
        ]);
    }
    // customer reviews
    public function allCustomerReview(){
        $customerId=auth()->id();
        $review=VendorReview::with('user','vendorProduct')->where('user_id',$customerId)->get();
        return response()->json([
            'data'=>$review
        ]);
    }
    public function editReview($id){
        $userId=auth()->id();
        $review = VendorReview::where('id', $id)
        ->where('user_id', $userId)
        ->first();
        return response()->json([
            'data'=>$review
        ]);
    }
    public function updateReview(Request $request,$id)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string',
        ]);
        $review=VendorReview::find($id);
        // $user_id = auth()->id();
        // $review->user_id=$user_id;
        // $review->product_id = $request->product_id;
        if($request->title){
            $review->title = $request->title;
        }
        $review->comment = $request->comment;
        if($request->rating){
            $review->rating = $request->rating;
        }
        if($request->status){
            $review->status=$request->status;
        }

        $review->save();
        return response()->json([
            'message'=>'Update Successfully'
        ]);
    }




}
