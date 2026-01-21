<?php

namespace App\Http\Controllers\CheckOut;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\VendorOrder;
use App\Models\OrderItem;
use App\Models\VendorProduct;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;

class CheckOutController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'first_name'     => 'required',
            'last_name'      => 'required',
            'email'          => 'required|email',
            'phone'          => 'required',
            'address'        => 'required',
            'city'           => 'required',
            'country'        => 'required',
            'total_bill'     => 'required',
            'payment_method' => 'required',
            'order_items'    => 'required|array',
            'payment_intent_id' => 'required_if:payment_method,stripe|nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $maxOrderNumber = Order::max('order_number');
            $nextNumber = $maxOrderNumber ? (int)$maxOrderNumber + 1 : 1;
            $orderNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // Create Order
            $order = Order::create([
                'user_id'        => auth()->id(),
                'first_name'     => $request->first_name,
                'last_name'      => $request->last_name,
                'email'          => $request->email,
                'phone'          => $request->phone,
                'address'        => $request->address,
                'zipcode'        => $request->zipcode,
                'city'           => $request->city,
                'country'        => $request->country,
                'order_number'   => $orderNumber,
                'tax'            => 0,
                'discount'       => 0,
                'shipping'       => 0,
                'total_bill'     => $request->total_bill,
                'payment_method' => $request->payment_method,
                'payment_intent_id' => $request->payment_method === 'stripe'
                ? $request->payment_intent_id
                : null,

                'payment_status' => $request->payment_method === 'stripe'
                                ? 'paid'
                                : 'cod',
            ]);

            $commission = \App\Models\Comission::first();
            $commissionPercent = $commission ? $commission->comission : 0;

            // Group items by vendor
            $groupedByVendor = collect($request->order_items)->groupBy('vendor_id');

            foreach ($groupedByVendor as $vendorId => $items) {
                $vendorSubtotal = 0;
                $totalCommission = 0;

                // Create VendorOrder
                $vendorOrder = VendorOrder::create([
                    'order_id'        => $order->id,
                    'vendor_id'       => $vendorId,
                    'vendor_subtotal' => 0,
                    'vendor_tax'      => 0,
                    'vendor_discount' => 0,
                    'vendor_shipping' => 0,
                    'vendor_total'    => 0,
                    'status'          => "pending",
                ]);

                foreach ($items as $item) {
                    $product = VendorProduct::findOrFail($item['product_id']);
                    $itemTotal = $product->final_price * $item['quantity'];

                    $imagePath = str_replace(config('app.url').'/', '', $item['image']);

                    // Calculate commission
                    $commissionAmount = ($itemTotal * $commissionPercent) / 100;
                    $vendorAmount = $itemTotal - $commissionAmount;
                    $totalCommission += $commissionAmount;

                    // Save OrderItem with commission
                    OrderItem::create([
                        'order_id'          => $order->id,
                        'vendor_order_id'   => $vendorOrder->id,
                        'product_id'        => $product->id,
                        'product_name'      => $product->name,
                        'quantity'          => $item['quantity'],
                        'price'             => $item['price'],
                        'tax'               => 0,
                        'discount'          => 0,
                        'total'             => $itemTotal,
                        'color'             => $item['color'] ?? null,
                        'size'              => $item['size'] ?? null,
                        'image'             => $imagePath,
                        'commission_percent'=> $commissionPercent,
                        'commission_amount' => $commissionAmount,
                        'vendor_amount'     => $vendorAmount,
                    ]);

                    // Update product stock
                    $product->update([
                        'stock' => $product->stock - $item['quantity']
                    ]);

                    $vendorSubtotal += $itemTotal;
                }

                // Update VendorOrder totals
                $vendorOrder->update([
                    'vendor_subtotal' => $vendorSubtotal,
                    'vendor_total'    => $vendorSubtotal - $totalCommission
                ]);
            }

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Order placed successfully',
                'order'   => $order
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function allOrder(){
        $userId=auth()->id();
        $vendor=Vendor::where('user_id',$userId)->first();
        $order=VendorOrder::with('order')->where('vendor_id',$vendor->id)->latest()->get();
        return response()->json([
            'message'=>'Orders',
            'orders'=>$order
        ]);
    }
    public function detailOrder($id){
        $userId=auth()->id();
        $vendor=Vendor::where('user_id',$userId)->first();
        $order=VendorOrder::with('order','items')->where('vendor_id',$vendor->id)->find($id);
        return response()->json([
            'message'=>'Detail',
            'data'=>$order
        ]);
    }
    public function customerOrder()
    {
        $userId = auth()->id();

        $orders = Order::where('user_id', $userId)
                        ->with('items','vendorOrders')->latest()
                        ->get();

        foreach ($orders as $order) {
            foreach ($order->vendorOrders as $item) {
                if ($item->status == 'delivered') {
                    $order->status = 'Delivered';
                    $order->save();
                }
            }
        }

        return response()->json([
            'message' => 'customer orders',
            'data' => $orders
        ]);
    }
    function customerDetail($id){
        $userId = auth()->id();

        $orders = Order::where('user_id', $userId)
                        ->with('items','vendorOrders')
                        ->find($id);
        $orders->created_at_format = $orders->created_at->format('d-m-Y');
        // foreach ($orders as $order) {
        //     foreach ($order->vendorOrders as $item) {
        //         if ($item->status == 'delivered') {
        //             $order->status = 'Delivered';
        //             $order->save();
        //         }
        //     }
        // }

        return response()->json([
            'message' => 'customer orders',
            'data' => $orders
        ]);
    }
    public function editOrder(Request $request,$id){
        $user_id=auth()->id();
        $vendor=Vendor::where('id',$user_id)->first();
        $orderVendor=VendorOrder::find($id);
        return response()->json([
            'data'=>$orderVendor
        ]);
    }
    public function updateOrder(Request $request,$id){
        $user_id=auth()->id();
        $vendor=Vendor::where('id',$user_id)->first();
        $orderVendor=VendorOrder::find($id);
        $orderVendor->status=$request->status;
        $orderVendor->save();
        return response()->json([
            'message'=>'updated'
        ]);
    }




}


