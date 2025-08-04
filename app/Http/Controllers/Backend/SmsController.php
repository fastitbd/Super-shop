<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apiKey = env('SMS_API_KEY');
        $url = env('SMS_BALANCE_URL') . '/' . $apiKey . '/getBalance';

        // Fetch the balance using an HTTP GET request
        $response = Http::get($url);

        if ($response->successful()) {
            $balance = $response->body(); // Adjust based on API response format
            // dd($balance);
        } else {
            $balance = 'Error fetching balance';
        }
        $customer = Customer::orderBy('id', 'asc')->get();
        return view('backend.pages.sms.index', compact('customer', 'balance'));
    }
    public function create() {}
    public function store(Request $request)
    {
        // dd($request->customer_name);
        if (env('APP_MODE') == 'demo') {
            notify()->error('This Feature is not available in Demo');
            return back();
        } else {
            foreach ($request->customer_name as $customer) {
                $phone = Customer::find($customer);
                $contacts = $phone->phone;
                // $message = 'আসসালামু আলাইকুম, প্রিয় গ্রাহক, আপনার নিকট মেসার্স মেধা এন্টার প্রাইজ এর ০০০০ টাকা বাকি আছে  অনুগ্রহ করে পরিশোধ করুন, ধন্যবাদ';

                $response = sendPromotionalSMS($contacts, $request->message);

                if ($response == null) {
                    notify()->success('Sms Send successfully');
                    return back();
                } else if ($response == 1002) {
                    notify()->error('Sender Id/Masking Not Found');
                    return back();
                } else if ($response == 1003) {
                    notify()->error('API Not Found');
                    return back();
                } else if ($response == 1004) {
                    notify()->error('SPAM Detected');
                    return back();
                } else if ($response == 1005) {
                    notify()->error('Internal Error');
                    return back();
                } else if ($response == 1006) {
                    notify()->error('Internal Error');
                    return back();
                } else if ($response == 1007) {
                    notify()->error('Balance Insufficient');
                    return back();
                } else if ($response == 1008) {
                    notify()->error('Message is empty');
                    return back();
                } else if ($response == 1009) {
                    notify()->error('Message Type Not Set (text/unicode)');
                    return back();
                } else if ($response == 1010) {
                    notify()->error('Invalid User & Password');
                    return back();
                } else if ($response == 1011) {
                    notify()->error('Invalid User Id');
                    return back();
                } else if ($response == 1012) {
                    notify()->error('Invalid Number');
                    return back();
                } else if ($response == 1013) {
                    notify()->error('	API limit error');
                    return back();
                } else if ($response == 1014) {
                    notify()->error('No matching template');
                    return back();
                } else if ($response == 1015) {
                    notify()->error('	SMS Content Validation Fails');
                    return back();
                } else if ($response == 1016) {
                    notify()->error('IP address not allowed!!');
                    return back();
                } else if ($response == 1019) {
                    notify()->error('Sms Purpose Missing');
                    return back();
                }
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
