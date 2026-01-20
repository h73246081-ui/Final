<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Webhook;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\Package;
use App\Models\VendorPackage;


class StripeController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $intent = PaymentIntent::create([
            'amount' => $request->amount * 100,
            'currency' => 'usd',
            'metadata' => [
                'user_id' => auth()->id(),
            ],
        ]);

        return response()->json([
            'client_secret' => $intent->client_secret,
            'payment_intent_id' => $intent->id,
        ]);
    }

public function webhook(Request $request)
{
    $payload   = $request->getContent();
    $sigHeader = $request->header('Stripe-Signature');
    $secret    = config('services.stripe.webhook_secret');

    try {
        $event = Webhook::constructEvent($payload, $sigHeader, $secret);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Invalid webhook'], 400);
    }
    if ($event->type === 'payment_intent.succeeded') {

        $pi = $event->data->object;
        if (($pi->metadata->type ?? null) === 'vendor_package') {

            if (!VendorPackage::where('payment_intent_id', $pi->id)->exists()) {

                $package = Package::find($pi->metadata->package_id);
                $vendor  = Vendor::where('user_id', $pi->metadata->user_id)->first();

                if ($package && $vendor) {
                    VendorPackage::create([
                        'vendor_id'         => $vendor->id,
                        'package_id'        => $package->id,
                        'start_date'        => now(),
                        'end_date'          => now()->addDays($package->duration),
                        'payment_method'    => 'stripe',
                        'amount'            => $pi->amount / 100,
                        'payment_status'    => 'paid',
                        'status'            => 'active',
                        'payment_intent_id' => $pi->id,
                    ]);
                }
            }

            return response()->json(['status' => 'vendor_package_paid']);
        }

        Order::where('payment_intent_id', $pi->id)
            ->where('payment_status', '!=', 'paid')
            ->update(['payment_status' => 'paid']);

        return response()->json(['status' => 'order_paid']);
    }
    if (in_array($event->type, ['charge.succeeded', 'charge.updated'])) {

        $charge = $event->data->object;

        if (!$charge->payment_intent) {
            return response()->json(['status' => 'no_payment_intent']);
        }

        if ($charge->paid) {
            Order::where('payment_intent_id', $charge->payment_intent)
                ->where('payment_status', '!=', 'paid')
                ->update(['payment_status' => 'paid']);

            return response()->json(['status' => 'order_paid_from_charge']);
        }
    }

    if ($event->type === 'payment_intent.payment_failed') {

        $pi = $event->data->object;

        Order::where('payment_intent_id', $pi->id)
            ->update(['payment_status' => 'failed']);

        VendorPackage::where('payment_intent_id', $pi->id)
            ->update([
                'payment_status' => 'failed',
                'status' => 'inactive'
            ]);

        return response()->json(['status' => 'payment_failed']);
    }

    return response()->json(['status' => 'ignored']);
}






    public function createVendorPackageIntent(Request $request, $packageId)
    {
        $vendorId = auth()->id();
        $vendor = Vendor::where('user_id', $vendorId)->firstOrFail();
        $package = Package::findOrFail($packageId);

        Stripe::setApiKey(config('services.stripe.secret'));

        $intent = PaymentIntent::create([
            'amount' => $package->price * 100,
            'currency' => 'usd',
            'metadata' => [
                'type' => 'vendor_package',
                'package_id' => $package->id,
                'user_id' => $vendorId,
            ],
        ]);

        return response()->json([
            'client_secret' => $intent->client_secret,
        ]);
    }



}
