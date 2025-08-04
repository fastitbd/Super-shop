<?php

use App\Models\Invoice;
use App\Models\Product;
use App\Models\BankAccount;
use App\Models\InvoiceItem;
use App\Models\PurchaseItem;
use App\Models\BankTransaction;
use App\Models\BusinessSetting;
use App\Models\Damage;
use App\Models\DamageItem;
use App\Models\ReturnItem;
use App\Models\ReturnPurchaseItem;
use App\Models\UsedItem;
use App\Models\UsedPurchaseItem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

function slugify($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'utf-8//IGNORE', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

//get all route list
function get_route_list()
{
    //get all routes
    $routes = Route::getRoutes();
    $routeList = [];
    foreach ($routes as $route) {
        $routeName = explode('.', $route->getName());
        if (isset($routeName[1])) {
            $routeList[$routeName[0]][] = $routeName[1];
        }
    }
    //remove duplicate routes
    foreach ($routeList as $key => $value) {
        $routeList[$key] = array_unique($value);
    }
    // return response()->json($routeList);

    //remove unnecessary routes
    unset($routeList['login']);
    unset($routeList['logout']);
    unset($routeList['register']);
    unset($routeList['password']);
    unset($routeList['verification']);
    unset($routeList['password']);
    unset($routeList['user-profile-information']);
    unset($routeList['user-password']);
    unset($routeList['two-factor']);
    unset($routeList['profile']);
    unset($routeList['sanctum']);
    unset($routeList['livewire']);
    unset($routeList['ignition']);
    unset($routeList['store']);
    unset($routeList['get']);
    unset($routeList['expense-category']);
    unset($routeList['user-role']);

    //sort ascending
    ksort($routeList);


    //set all routes to false
    foreach ($routeList as $key => $value) {
        $routeList[$key] = array_fill_keys($value, false);
    }

    return $routeList;
}

function check_permission($routeName)
{
    if (auth()->user()->user_role == 1)
        return true;

    $routeName = explode('.', $routeName);
    if (!isset($routeName[1])) return true;
    $authUserPermissions = auth()->user()->role->permission;
    $authUserPermissions = json_decode($authUserPermissions, true);
    if (isset($authUserPermissions[$routeName[0]][$routeName[1]])) {
        if ($authUserPermissions[$routeName[0]][$routeName[1]] == true) {
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}

function main_menu_permission($menuName)
{
    if (auth()->user()->user_role == 1)
        return true;

    $authUserPermissions = auth()->user()->role->permission;
    $authUserPermissions = json_decode($authUserPermissions, true);
    if (isset($authUserPermissions[$menuName])) {
        foreach ($authUserPermissions[$menuName] as $key => $value) {
            if ($value == true) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('get_setting')) 
{
    function get_setting($key)
    {
        $settings = Cache::remember('business_settings', 86400, function () {
            return BusinessSetting::all();
        });

        $setting = $settings->where('type', $key)->first();

        return $setting?->value;
    }
}

//invoiced_qty
if (!function_exists('invoiced_qty')) 
{
    function invoiced_qty($product)
    {
        if ($product->is_service == 0) {
            if ($product->unit->related_unit  == null) {
                $inv_stock = InvoiceItem::with('invoice')
                    ->where('product_id', $product->id)
                    ->sum('main_qty');
                $total_stock = $inv_stock;
                $data['stock_qty'] = $total_stock . ' ' . $product->unit->name;
            } else {
                //invoice
                $inv_stock_main = InvoiceItem::with('invoice')
                    ->where('product_id', $product->id)
                    ->sum('main_qty');
                $inv_total_main = (float)($inv_stock_main * $product->unit->related_value);
                $inv_total_sub = InvoiceItem::with('invoice')
                    ->where('product_id', $product->id)
                    ->sum('sub_qty');
                $inv_total_stock = (float)($inv_total_main + $inv_total_sub);
                $total_stock = $inv_total_stock;
                $check = $total_stock / $product->unit->related_value;
                if (is_integer($check)) {
                    $data['stock_qty'] = $check . ' ' . $product->unit->name . ' 0 ' . $product->unit->related_unit->name;
                } else {
                    $main_value = floor($check) * $product->unit->related_value;
                    $sub_value = $total_stock - $main_value;
                    $data['stock_qty'] = floor($check) . ' ' . $product->unit->name . ' ' . $sub_value . ' ' . $product->unit->related_unit->name;
                }
            }
            return $data['stock_qty'];
        }
    }
}
//used product qty
if (!function_exists('used_qty')) 
{
    function used_qty($product)
    {
        if ($product->unit->related_unit  == null) {
            $inv_stock = UsedItem::where('product_id', $product->id)
                ->sum('main_qty');
            $total_stock = $inv_stock;
            $data['stock_qty'] = $total_stock . ' ' . $product->unit->name;
        } else {
            //invoice
            $inv_stock_main = UsedItem::with('invoice')
                ->where('product_id', $product->id)
                ->sum('main_qty');
            $inv_total_main = (float)($inv_stock_main * $product->unit->related_value);
            $inv_total_sub = UsedItem::with('invoice')
                ->where('product_id', $product->id)
                ->sum('sub_qty');
            $inv_total_stock = (float)($inv_total_main + $inv_total_sub);
            $total_stock = $inv_total_stock;
            $check = $total_stock / $product->unit->related_value;
            if (is_integer($check)) {
                $data['stock_qty'] = $check . ' ' . $product->unit->name . ' 0 ' . $product->unit->related_unit->name;
            } else {
                $main_value = floor($check) * $product->unit->related_value;
                $sub_value = $total_stock - $main_value;
                $data['stock_qty'] = floor($check) . ' ' . $product->unit->name . ' ' . $sub_value . ' ' . $product->unit->related_unit->name;
            }
        }
        return $data['stock_qty'];
    }
}

//returned_qty
if (!function_exists('returned_qty')) 
{
    function returned_qty($product)
    {
        if ($product->is_service == 0) {
            if ($product->unit->related_unit  == null) {
                $inv_stock = ReturnItem::with('return')
                    ->where('product_id', $product->id)
                    ->sum('main_qty');
                $total_stock = $inv_stock;
                $data['stock_qty'] = $total_stock . ' ' . $product->unit->name;
            } else {
                //return
                $inv_stock_main = ReturnItem::with('return')
                    ->where('product_id', $product->id)
                    ->sum('main_qty');
                $inv_total_main = (float)($inv_stock_main * $product->unit->related_value);
                $inv_total_sub = ReturnItem::with('return')
                    ->where('product_id', $product->id)
                    ->sum('sub_qty');
                $inv_total_stock = (float)($inv_total_main + $inv_total_sub);
                $total_stock = $inv_total_stock;
                $check = $total_stock / $product->unit->related_value;
                if (is_integer($check)) {
                    $data['stock_qty'] = $check . ' ' . $product->unit->name . ' 0 ' . $product->unit->related_unit->name;
                } else {
                    $main_value = floor($check) * $product->unit->related_value;
                    $sub_value = $total_stock - $main_value;
                    $data['stock_qty'] = floor($check) . ' ' . $product->unit->name . ' ' . $sub_value . ' ' . $product->unit->related_unit->name;
                }
            }
            return $data['stock_qty'];
        }
    }
}
if (!function_exists('return_pur_qty')) 
{
    function return_pur_qty($product)
    {
        if ($product->is_service == 0) {
            if ($product->unit->related_unit  == null) {
                $pur_stock = ReturnPurchaseItem::where('product_id', $product->id)
                    ->sum('main_qty');
                $total_stock = $pur_stock;
                $data['stock_qty'] = $total_stock . ' ' . $product->unit->name;
            } else {
                //return
                $inv_stock_main = ReturnPurchaseItem::where('product_id', $product->id)
                    ->sum('main_qty');
                $inv_total_main = (float)($inv_stock_main * $product->unit->related_value);
                $inv_total_sub = ReturnPurchaseItem::where('product_id', $product->id)
                    ->sum('sub_qty');
                $inv_total_stock = (float)($inv_total_main + $inv_total_sub);
                $total_stock = $inv_total_stock;
                $check = $total_stock / $product->unit->related_value;
                if (is_integer($check)) {
                    $data['stock_qty'] = $check . ' ' . $product->unit->name . ' 0 ' . $product->unit->related_unit->name;
                } else {
                    $main_value = floor($check) * $product->unit->related_value;
                    $sub_value = $total_stock - $main_value;
                    $data['stock_qty'] = floor($check) . ' ' . $product->unit->name . ' ' . $sub_value . ' ' . $product->unit->related_unit->name;
                }
            }
            return $data['stock_qty'];
        }
    }
}
//damaged_qty
if (!function_exists('damaged_qty')) 
{
    function damaged_qty($product)
    {
        if ($product->is_service == 0) {
            if ($product->unit->related_unit  == null) {
                $damage_stock = DamageItem::where('product_id', $product->id)
                    ->sum('main_qty');
                $total_stock = $damage_stock;
                $data['stock_qty'] = $total_stock . ' ' . $product->unit->name;
            } else {
                //return
                $damage_stock_main = DamageItem::where('product_id', $product->id)
                    ->sum('main_qty');
                $inv_total_main = (float)($damage_stock_main * $product->unit->related_value);

                $inv_total_sub = DamageItem::where('product_id', $product->id)
                    ->sum('sub_qty');

                $inv_total_stock = (float)($inv_total_main + $inv_total_sub);
                $total_stock = $inv_total_stock;
                $check = $total_stock / $product->unit->related_value;
                if (is_integer($check)) {
                    $data['stock_qty'] = $check . ' ' . $product->unit->name . ' 0 ' . $product->unit->related_unit->name;
                } else {
                    $main_value = floor($check) * $product->unit->related_value;
                    $sub_value = $total_stock - $main_value;
                    $data['stock_qty'] = floor($check) . ' ' . $product->unit->name . ' ' . $sub_value . ' ' . $product->unit->related_unit->name;
                }
            }
            return $data['stock_qty'];
        }
    }
}
//purchased_qty
if (!function_exists('purchased_qty')) 
{
    function purchased_qty($product)
    {
        if ($product->is_service == 0) {
            if ($product->unit->related_unit  == null) {
                $pur_stock = PurchaseItem::with('purchase')
                    ->where('product_id', $product->id)
                    ->sum('main_qty');
                // $open_pro_stock = Product::where('id', $product->id)->first()->main_qty;
                $total_stock = $pur_stock;
                $data['stock_qty'] = $total_stock . ' ' . $product->unit->name;
            } else {
                //purchase
                $pur_stock_main = PurchaseItem::with('purchase')
                    ->where('product_id', $product->id)
                    ->sum('main_qty');
                // $open_main_pro_stock = Product::where('id', $product->id)->first()->main_qty;
                $main_pro =  $pur_stock_main;
                $pur_total_main = (float)($main_pro * $product->unit->related_value);
                $pur_stock_sub = PurchaseItem::with('purchase')
                    ->where('product_id', $product->id)
                    ->sum('sub_qty');
                // $open_main_pro_stock = Product::where('id', $product->id)->first()->sub_qty;
                $pur_total_stock = (float)($pur_total_main  + $pur_stock_sub);
                $total_stock = $pur_total_stock;
                $check = $total_stock / $product->unit->related_value;
                if (is_integer($check)) {
                    $data['stock_qty'] = $check . ' ' . $product->unit->name . ' 0 ' . $product->unit->related_unit->name;
                } else {
                    $main_value = floor($check) * $product->unit->related_value;
                    $sub_value = $total_stock - $main_value;
                    $data['stock_qty'] = floor($check) . ' ' . $product->unit->name . ' ' . $sub_value . ' ' . $product->unit->related_unit->name;
                }
            }
            return $data['stock_qty'];
        }
    }
}

//used product purchased_qty
if (!function_exists('used_purchased_qty')) {
    function used_purchased_qty($product)
    {
        if ($product->unit->related_unit  == null) {
            $pur_stock = UsedPurchaseItem::where('product_id', $product->id)
                ->sum('main_qty');
            $total_stock = $pur_stock;
            $data['stock_qty'] = $total_stock . ' ' . $product->unit->name;
        } else {
            $pur_stock_main = UsedPurchaseItem::where('product_id', $product->id)
                ->sum('main_qty');
            $main_pro =  $pur_stock_main;
            $pur_total_main = (float)($main_pro * $product->unit->related_value);
            $pur_stock_sub = UsedPurchaseItem::where('product_id', $product->id)
                ->sum('sub_qty');
            $pur_total_stock = (float)($pur_total_main  + $pur_stock_sub);
            $total_stock = $pur_total_stock;
            $check = $total_stock / $product->unit->related_value;
            if (is_integer($check)) {
                $data['stock_qty'] = $check . ' ' . $product->unit->name . ' 0 ' . $product->unit->related_unit->name;
            } else {
                $main_value = floor($check) * $product->unit->related_value;
                $sub_value = $total_stock - $main_value;
                $data['stock_qty'] = floor($check) . ' ' . $product->unit->name . ' ' . $sub_value . ' ' . $product->unit->related_unit->name;
            }
        }
        return $data['stock_qty'];
    }
}


//gets stock
if (!function_exists('product_stock')) 
{
    function product_stock($product)
    {
        if ($product->is_service == 0) {
            if ($product->unit->related_unit  == null) {
                $pur_stock = PurchaseItem::with('purchase')
                    ->where('product_id', $product->id)
                    ->sum('stock_qty');
                // $open_pro_stock = Product::where('id', $product->id)->first()->main_qty;
                $total_stock = (float)($pur_stock);
                $data['stock_qty'] = $total_stock . ' ' . $product->unit->name;
            } else {
            
                //purchase
                $pur_stock_main = PurchaseItem::with('purchase')
                    ->where('product_id', $product->id)
                    ->sum('stock_qty');

                $pur_total_stock = (float)($pur_stock_main);
                $total_stock = $pur_total_stock;

                $check = $total_stock / $product->unit->related_value;
                if (is_integer($check)) {
                    $data['stock_qty'] = $check . ' ' . $product->unit->name . ' 0 ' . $product->unit->related_unit->name;
                } else {
                    $main_value = floor($check) * $product->unit->related_value;
                    $sub_value = $total_stock - $main_value;
                    $data['stock_qty'] = floor($check) . ' ' . $product->unit->name . ' ' . $sub_value . ' ' . $product->unit->related_unit->name;
                }
            }
            return $data['stock_qty'];
        }
    }
}
//gets stock check
if (!function_exists('product_stock_check')) 
{
    function product_stock_check($product)
    {
        if ($product->is_service == 0) {
            if ($product->unit->related_unit  == null) {
                $pur_stock = App\Models\PurchaseItem::with('purchase')
                    ->where('product_id', $product->id)
                    ->sum('stock_qty');
                $total_stock =
                    (float) ($pur_stock);
                $data['stock_qty'] = $total_stock;
            } else {
                $pur_stock_main = App\Models\PurchaseItem::with('purchase')
                    ->where('product_id', $product->id)
                    ->sum('stock_qty');
                $pur_total_stock =
                    (float) ($pur_stock_main);
                $total_stock = $pur_total_stock;
                $data['stock_qty'] = (float)($total_stock);
            }
            return $data['stock_qty'];
        }
    }
}
//gets stock check
if (!function_exists('used_product_stock_check')) 
{
    function used_product_stock_check($product)
    {
        if ($product->unit->related_unit  == null) {
            $use_stock = App\Models\UsedItem::where('product_id', $product->id)
                ->sum('main_qty');
            $buy_stock = App\Models\UsedPurchaseItem::where('product_id', $product->id)
                ->sum('main_qty');
            $total_stock = (float) ($buy_stock) - ($use_stock);
            $data['stock_qty'] = $total_stock;
        } else {
            //invoice
            $inv_stock_main = App\Models\InvoiceItem::with('invoice')
                ->where('product_id', $product->id)
                ->sum('main_qty');
            $inv_total_main = (float) ($inv_stock_main * $product->unit->related_value);
            $inv_total_sub = App\Models\InvoiceItem::with('invoice')
                ->where('product_id', $product->id)
                ->sum('sub_qty');
            $inv_total_stock = (float) ($inv_total_main + $inv_total_sub);
            //return
            $rtn_stock_main = App\Models\ReturnItem::with('return')
                ->where('product_id', $product->id)
                ->sum('main_qty');
            $rtn_total_main = (float) ($rtn_stock_main * $product->unit->related_value);
            $rtn_total_sub = App\Models\ReturnItem::with('return')
                ->where('product_id', $product->id)
                ->sum('sub_qty');
            $rtn_total_stock = (float) ($rtn_total_main + $rtn_total_sub);
            //purchase
            $pur_stock_main = App\Models\PurchaseItem::with('purchase')
                ->where('product_id', $product->id)
                ->sum('main_qty');
            // $open_main_pro_stock = App\Models\Product::where('id', $product->id)->first()
            //     ->main_qty;
            $main_pro =  $pur_stock_main;
            $pur_total_main = (float) ($main_pro * $product->unit->related_value);
            $pur_stock_sub = App\Models\PurchaseItem::with('purchase')
                ->where('product_id', $product->id)
                ->sum('sub_qty');
            // $open_main_pro_stock = App\Models\Product::where('id', $product->id)->first()
            //     ->o_sub_qty;
            $pur_total_stock =
                (float) ($pur_total_main +  $pur_stock_sub);
            $total_stock = $pur_total_stock + $rtn_total_stock - $inv_total_stock;
            $p_value = $product->purchase_price / $product->unit->related_value;
            $s_value = $product->selling_price / $product->unit->related_value;
            $purchase_price = $total_stock * $p_value;
            $selling_price = $total_stock * $s_value;
            $data['stock_qty'] = (float)($total_stock);
        }
        return $data['stock_qty'];
    }
}

// stock amount
if (!function_exists('product_stock_balance')) 
{
    function product_stock_balance($product)
    {
        if ($product->is_service == 0) {
            if ($product->unit->related_unit  == null) {
                $pur_stock = App\Models\PurchaseItem::with('purchase')
                    ->where('product_id', $product->id)
                    ->sum('stock_qty');
                $total_stock =
                    (float) ($pur_stock );
                $data['stock_qty'] = $total_stock;
            } else {
                $pur_stock_main = App\Models\PurchaseItem::with('purchase')
                    ->where('product_id', $product->id)
                    ->sum('stock_qty');
                $pur_total_stock =
                    (float) ($pur_stock_main);
                $total_stock = $pur_total_stock;
                $total_stock = $total_stock / $product->unit->related_value;
                $data['stock_qty'] = (float)($total_stock);
            }
            return $data['stock_qty'];
        }
    }
}

//gets current_balance
if (!function_exists('current_balance')) 
{
    function current_balance($bank_id)
    {
        $open_balance = BankAccount::where('id', $bank_id)->first()->opening_balance;
        $deposit = BankTransaction::where('trans_type', 'deposit')->where('bank_id', $bank_id)->sum('amount');
        $withdraw = BankTransaction::where('trans_type', 'withdraw')->where('bank_id', $bank_id)->sum('amount');
        $from_transfer = BankTransaction::where('trans_type', 'transfer')->where('from_bank_id', $bank_id)->sum('amount');
        $to_transfer = BankTransaction::where('trans_type', 'transfer')->where('to_bank_id', $bank_id)->sum('amount');
        $current_balance = (float)($open_balance + $to_transfer + $deposit) - (float)($withdraw + $from_transfer);
        return $current_balance;
    }
}

if (!function_exists('date_current_balance')) 
{
    function date_current_balance($bank_id, $date)
    {
        $open_balance = BankAccount::where('id', $bank_id)->first()->opening_balance;
        $deposit = BankTransaction::where('trans_type', 'deposit')->where('bank_id', $bank_id)->where('date', '=', $date)->sum('amount');
        $withdraw = BankTransaction::where('trans_type', 'withdraw')->where('bank_id', $bank_id)->where('date', '=', $date)->sum('amount');
        $from_transfer = BankTransaction::where('trans_type', 'transfer')->where('from_bank_id', $bank_id)->where('date', '=', $date)->sum('amount');
        $to_transfer = BankTransaction::where('trans_type', 'transfer')->where('to_bank_id', $bank_id)->where('date', '=', $date)->sum('amount');
        $date_current_balance = (float)($open_balance + $to_transfer + $deposit) - (float)($withdraw + $from_transfer);
        return $date_current_balance;
    }
}


if (!function_exists('previous_balance')) 
{
    function previous_balance($bank_id, $date)
    {
        $open_balance = 0;
        $open_balance = BankAccount::where('id', $bank_id)->first()->opening_balance ?? 0;
        $deposit = BankTransaction::where('trans_type', 'deposit')->where('bank_id', $bank_id)->where('date', '<', $date)->sum('amount');
        $withdraw = BankTransaction::where('trans_type', 'withdraw')->where('bank_id', $bank_id)->where('date', '<', $date)->sum('amount');
        $from_transfer = BankTransaction::where('trans_type', 'transfer')->where('from_bank_id', $bank_id)->where('date', '<', $date)->sum('amount');
        $to_transfer = BankTransaction::where('trans_type', 'transfer')->where('to_bank_id', $bank_id)->where('date', '<', $date)->sum('amount');
        $previous_balance = (float)($open_balance + $to_transfer + $deposit) - (float)($withdraw + $from_transfer);
        return $previous_balance;
    }
}


//gets open_balance_customer
if (!function_exists('open_balance_customer')) 
{
    function open_balance_customer($id, $open_receivable, $open_payable)
    {
        $received = App\Models\ActualPayment::with('transaction')
            ->where('account_type', 'Customer')
            ->where('wallet_type', 'Balance Adjust')
            ->where('pay_type', 'Money Received')
            ->whereHas('transaction', function ($query) use ($id) {
                $query->where('customer_id', $id);
            })
            ->sum('amount');
        $payable = App\Models\ActualPayment::with('transaction')
            ->where('account_type', 'Customer')
            ->where('wallet_type', 'Balance Adjust')
            ->where('pay_type', 'Money Payment')
            ->whereHas('transaction', function ($query) use ($id) {
                $query->where('customer_id', $id);
            })
            ->sum('amount');
        $open_balance = (float)($open_receivable + $received) - (float)($open_payable + $payable);
        return $open_balance;
    }
}

//gets current_balance_supplier
if (!function_exists('open_balance_supplier')) 
{
    function open_balance_supplier($id, $open_receivable, $open_payable)
    {
        $received = App\Models\ActualPayment::with('transaction')
            ->where('account_type', 'Supplier')
            ->where('wallet_type', 'Balance Adjust')
            ->where('pay_type', 'Money Received')
            ->whereHas('transaction', function ($query) use ($id) {
                $query->where('supplier_id', $id);
            })
            ->sum('amount');
        // dd($received);    
        $payable = App\Models\ActualPayment::with('transaction')
            ->where('account_type', 'Supplier')
            ->where('wallet_type', 'Balance Adjust')
            ->where('pay_type', 'Money Payment')
            ->whereHas('transaction', function ($query) use ($id) {
                $query->where('supplier_id', $id);
            })
            ->sum('amount');
        $open_balance = (float)($open_receivable + $received) - (float)($open_payable + $payable);
        return $open_balance;
    }
}

function rtn_profit($returns)
{
    $sum = 0;
    foreach ($returns as $key => $returnItem) {
        $product = Product::with('unit.related_unit')
            ->where('id', $returnItem->product_id)
            ->first();
        $purchase = PurchaseItem::where('product_id', $product->id)->first();

        if ($product->unit->related_unit == null) {
            $inv_stock = $returnItem->main_qty;
            $purchase_price = $inv_stock * $purchase?->rate;
            $selling_price = $inv_stock * $returnItem->rate;
            $profits = $selling_price - $purchase_price;
        } else {
            //return
            $inv_stock_main = $returnItem->main_qty;
            $inv_total_main = (float) ($inv_stock_main * $product->unit->related_value);
            $inv_total_sub = $returnItem->sub_qty;
            $inv_total_stock = (float) ($inv_total_main + $inv_total_sub);
            $total_stock = $inv_total_stock;
            $p_value = $purchase?->rate / $product->unit->related_value;
            $s_value = $returnItem->rate / $product->unit->related_value;
            $purchase_price = $total_stock * $p_value;
            $selling_price = $total_stock * $s_value;

            $profits = $selling_price - $purchase_price;
        }
        $sum += $profits;
    }

    return $sum;
}

function sendPromotionalSMS($contacts, $message)
{
    $url = env('SMS_API_URL');
    $apiKey = env('SMS_API_KEY');
    $senderId = env('SMS_SENDER_ID');

    $response = Http::post($url, [
        'api_key' => $apiKey,
        'type' => 'text',  // specify your content type
        'contacts' => $contacts,  // e.g., '88017xxxxxxxx+88018xxxxxxxx'
        'senderid' => $senderId,
        'purpose' => 'promotional',
        'msg' => $message,
    ]);

    return $response->json();
}
function calculateUnitPriceUsingFIFO($productId, $requiredQty)
{
    $product = Product::where('id', $productId)->first();
    if ($product->is_service == 0) {
        if ($product->unit->related_unit == null) {
            $purchaseItems = PurchaseItem::where('product_id', $productId)
                ->where('stock_qty', '>', 0)
                ->orderBy('id', 'asc')
                ->get();
            $remainingQty = $requiredQty;
            $totalCost = 0;
            $totalQtyConsidered = 0;
            foreach ($purchaseItems as $item) {
                if ($remainingQty <= 0) {
                    break;
                }
                $availableQty = $item->stock_qty;
                $usedQty = min($remainingQty, $availableQty);
                $quantity = $availableQty - $usedQty;
                $item->update(['stock_qty' => $quantity]);
                $totalCost += $usedQty * $item->rate;
                $totalQtyConsidered += $usedQty;
                $remainingQty -= $usedQty;
            }
        } else {
            $purchaseItems = PurchaseItem::where('product_id', $productId)
                ->where('stock_qty', '>', 0)
                ->orderBy('id', 'asc')
                ->get();
            $remainingQty = $requiredQty;
            $totalCost = 0;
            $totalQtyConsidered = 0;
            foreach ($purchaseItems as $item) {
                if ($remainingQty <= 0) {
                    break;
                }
                $availableQty = $item->stock_qty;
                $usedQty = min($remainingQty, $availableQty);
                $quantity = $availableQty - $usedQty;
                $item->update(['stock_qty' => $quantity]);
                $totalCost += ($usedQty / $product->unit->related_value) * $item->rate;
                $totalQtyConsidered += $usedQty;
                $remainingQty -= $usedQty;
            }
        }
    } else {
        $totalCost = 0;
    }

    return $totalCost;
}
function profit($invoice_id)
{
    $invoiceItems = InvoiceItem::where('invoice_id', $invoice_id)->get();
    // Calculate total profit for the invoice
    $totalProfit = $invoiceItems->sum(function ($item) {
        return $item->inv_subtotal - $item->pur_subtotal;
    });
    return $totalProfit;
}

function productStockUpdate($productId, $requiredQty)
{
    $product = Product::where('id', $productId)->first();
    if ($product && $product->is_service == 0) {
        $purchaseItems = PurchaseItem::where('product_id', $productId)
            ->latest()
            ->first();

        if ($purchaseItems) {
            $availableQty = $purchaseItems->stock_qty ?? 0;
            $quantity = $availableQty + $requiredQty;
            $purchaseItems->update(['stock_qty' => $quantity]);
        } else {
            // যদি কোনো purchase item না থাকে তাহলে নতুনভাবে যুক্ত করার চিন্তা করুন
            PurchaseItem::create([
                'product_id' => $productId,
                'stock_qty' => $requiredQty,
                // অন্যান্য প্রয়োজনীয় ফিল্ড এখানে যুক্ত করুন
            ]);
        }
    }
}

function variation_stock($variation)
{
    $inv = InvoiceItem::where('product_variation_id', $variation)->sum('main_qty');
    $pur = PurchaseItem::where('product_variation_id', $variation)->sum('main_qty');
    $dam = DamageItem::where('product_variation_id', $variation)->sum('main_qty');
    $rtn = ReturnItem::where('product_variation_id', $variation)->sum('main_qty');
    $rtn_pur = ReturnPurchaseItem::where('product_variation_id', $variation)->sum('main_qty');
    $stock = ($pur - $inv + $rtn -$dam - $rtn_pur);
    // dd($stock);
    return (string) $stock;
}
