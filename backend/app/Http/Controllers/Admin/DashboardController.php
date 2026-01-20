<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductLimit;

class DashboardController extends Controller
{
    public function editProfile(){
        $user=Auth::user();
        return view('admin.profile',[
            'user'=>$user
        ]);
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
        return redirect()->back()->with('success','Profile Updated Successfully!');
    }
    public function dashboard()
    {
        /* =============================
           COUNTS (For Stat Cards)
        ==============================*/
        // $categoriesCount     = Category::count();
        // $subCategoriesCount  = SubCategory::count();
        // $vendorsCount        = Vendor::count();
        // $privateSellersCount = PrivateSeller::count();
        // $productsCount       = VendorProduct::count();
        // $storesCount         = VendorStore::count();

        $commissionPercent = Comission::first()?->comission ?? 0;

        /* =============================
           LATEST ORDERS
        ==============================*/
        $order = Order::latest()->limit(5)->get();

        /* =============================
           COMMISSION DATA (DATE WISE)
        ==============================*/
        $commissionData = OrderItem::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(commission_amount) as admin_commission'),
                DB::raw('SUM(vendor_amount) as vendor_earning')
            )
            ->whereNotNull('commission_amount')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        /* =============================
           CHART DATA
        ==============================*/

        // Labels (Dates)
        $salesLabels = $commissionData->pluck('date');

        // Sales = Admin + Vendor
        $salesData = $commissionData->map(function ($item) {
            return $item->admin_commission + $item->vendor_earning;
        });

        // Line Chart Series
        $adminCommissionSeries  = $commissionData->pluck('admin_commission');
        $vendorCommissionSeries = $commissionData->pluck('vendor_earning');

        // Doughnut Totals
        $adminCommission = $adminCommissionSeries->sum();
        $vendorAmount    = $vendorCommissionSeries->sum();

        /* =============================
           RETURN VIEW
        ==============================*/
        return view('admin.dashboard', compact(

            'order',
            'salesLabels',
            'salesData',
            'adminCommissionSeries',
            'vendorCommissionSeries',
            'adminCommission',
            'vendorAmount'
        ));
    }
    public function editComission(){
        $comission=Comission::first();
        return view('admin.comission.comission',compact('comission'));
    }
    public function updateCommission(Request $request)
    {
        $request->validate([
            'comission' => 'required|numeric|min:0|max:100'
        ]);

        $setting = Comission::first();
        $setting->update([
            'comission' => $request->comission
        ]);

        return back()->with('success', 'Commission updated successfully');
    }
    public function editLimit(){
        $limit=ProductLimit::first();
        return view('admin.limit.updateLimit',compact('limit'));
    }

    public function updateLimit(Request $request){
        $request->validate([
            'limit'=>'required'
        ]);
        $limit=ProductLimit::first();
        $limit->limit=$request->limit;
        $limit->save();
        return redirect()->back()->with('success','Product Limit Updated Successfully!');
    }


}
