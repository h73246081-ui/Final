<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\VendorOrder;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Vendor;

class ReportController extends Controller
{
    public function allOrder(){
        $order=Order::latest()->get();
        return view('admin.orders.allOrders',compact('order'));
    }
    public function detailOrder($id){
        $order=Order::with('vendorOrders.vendor.user',   // vendor
        'vendorOrders.items','user')->find($id);
        return view('admin.orders.detailOrder',[
            'order'=>$order
        ]);
    }
}
