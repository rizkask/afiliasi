<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\cart;
use App\Models\product;
use App\Models\Transaction;
use App\Models\TransactionDetail;

use Exception;

use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use DB;
use Cookie;

class CheckoutController extends Controller
{
    public function index(Request $request, $id)
    {
        $data = Crypt::decrypt($id);
    }

    private function getCarts()
    {
        $carts = json_decode(request()->cookie('dw-carts'), true);
        $carts = $carts != '' ? $carts:[];
        return $carts;
    }

    public function add(Request $request, $id)
    {
        $cek = Crypt::decrypt($id);
        $cekproduct = cart::where('products_id',$cek)->where('users_id',Auth::user()->id)->first();

        if($cekproduct==null){
            $data = [
                'products_id' => $cek,
                'users_id' => Auth::user()->id,
                'quantity' => $request->quantity,
            ];

            cart::create($data);
        }
        else{
            $cekproduct->update([
                'quantity' => $request->quantity,
            ]);
        }

        $carts = $this->getCarts();

        $cookie = cookie('dw-carts', json_encode($carts), 2880);
        return redirect()->route('cart')->cookie($cookie);
    }

    public function process(Request $request)
    {

        $code = 'STORE-' . mt_rand(000000,999999);

        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        $midtrans = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => (int) $request->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'enabled_payments' => [
                'permata_va','bank_transfer'
            ],
            'vtweb' => [],
        ];

        DB::beginTransaction();
        try {

            $carts = cart::with(['product','user'])->where('users_id', Auth::user()->id)->get(); 

            $transaction = Transaction::create([
                'users_id' => Auth::user()->id,
                'insurance_price' => 0,
                'shipping_price' => $request->shipping_price,
                'total_price' => $request->total_price,
                'transaction_status' => 'PENDING',
                'code' => $code,
            ]);

            foreach($carts as $cart){
                $affiliate = json_decode(request()->cookie('dw-afiliasi'), true);
                $explodeAffiliate = explode('-', $affiliate);
                
                $trx = 'TRX-' . mt_rand(000000,999999);

                if($affiliate){
                    TransactionDetail::create([
                        'transactions_id' => $transaction->id,
                        'products_id' => $cart->product->id,
                        'quantity' => $cart->quantity,
                        'price' => $cart->product->price*$cart->quantity,
                        'shipping_status' => 'PENDING',
                        'resi' => '',
                        'code' => $trx,
                        'ref' => $explodeAffiliate[1] == $cart->product->id && $affiliate != '' && $explodeAffiliate[0] != Auth::user()->id ? $affiliate:NULL,
                        'komisi' => $cart->product->komisi
                    ]);
                }
                else{
                    TransactionDetail::create([
                        'transactions_id' => $transaction->id,
                        'products_id' => $cart->product->id,
                        'quantity' => $cart->quantity,
                        'price' => $cart->product->price*$cart->quantity,
                        'shipping_status' => 'PENDING',
                        'resi' => '',
                        'code' => $trx,
                        'ref' => NULL
                    ]);
                }
                
                
                product::where('id', $cart->product->id)->increment('sold',1);
            }
            
            foreach($carts as $x){
                $x->delete();
            }
            
            
            $carts = $this->getCarts();

            DB::commit();

            $carts = [];
            $cookie = cookie('dw-carts', json_encode($carts), 2880);
            Cookie::queue(Cookie::forget('dw-afiliasi'));

            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtrans);

            Transaction::where('id',$transaction->id)->update([
                'payment_url' => $paymentUrl->token,
            ]);
            
            // Redirect to Snap Payment Page
            return redirect($paymentUrl->redirect_url)->cookie($cookie);
        }
        catch (Exception $e) {
            DB::rollback();
            echo $e->getMessage();
        }
    }

    public function post(Request $request)
    {
        try {
            $notification_body = json_decode($request->getContent(), true);
            $invoice = $notification_body['order_id'];
            $transaction_id = $notification_body['transaction_id'];
            $status_code = $notification_body['status_code'];
            $order = Transaction::where('code', $invoice)->first();
            if (!$order)
                return ['code' => 0, 'messgae' => 'Terjadi kesalahan | Pembayaran tidak valid'];
                switch ($status_code) {
                    case '200':
                        $order->transaction_status = "SUCCESS";
                        break;
                    case '201':
                        $order->transaction_status = "PENDING";
                        break;
                    case '202':
                        $order->transaction_status = "CANCEL";
                        break;
                }
                $order->save();
                return response('Ok', 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return response('Error', 404)->header('Content-Type', 'text/plain');
        }
    }

    public function callback(Request $request)
    {

        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');
        
        try {
            $notification_body = json_decode($request->getContent(), true);
            $invoice = $notification_body['order_id'];
            $type = $notification_body['payment_type'];
            $fraud = $notification_body['fraud_status'];
            $status = $notification_body['transaction_status'];

            $order = Transaction::where('code', $invoice)->first();
            $items = $order->details->first();
            if (!$order)
                return ['code' => 0, 'messgae' => 'Terjadi kesalahan | Pembayaran tidak valid'];
            switch ($status) {
                case 'settlement':
                    $order->transaction_status = 'SUCCESS';
                    $items->update([
                        'shipping_status' => 'DIKEMAS',
                    ]);
                    break;
                case 'pending':
                    $order->transaction_status = "PENDING";
                    break;
                case 'deny':
                    $order->transaction_status = "CANCELLED";
                    break;
                case 'cancel':
                    $order->transaction_status = "CANCELLED";
                    break;
                case 'expire':
                    $order->transaction_status = "CANCELLED";
                    break;
            }
            $order->save();
            return response('Ok', 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return response('Error', 404)->header('Content-Type', 'text/plain');
        }
        
    }

    public function success(Request $request)
    {
        $response = Http::get('https://api.sandbox.midtrans.com/v2/STORE-784147/status');
        $data = $response->json();
        dd($data);
    }

    public function beli(Request $request, $id)
    {
        $cek = cart::where('id',$id)->get();
        $carts = cart::with(['product','user'])->where('users_id', Auth::user()->id)->get();

        $carts = $this->getCarts();

        $cookie = cookie('dw-carts', json_encode($carts), 2880);
        return redirect()->route('indexbeli',$id)->cookie($cookie);
    }

    public function indexbeli()
    {
        $cart = cart::with(['product.galleries','user'])->where('users_id', Auth::user()->id)->get();
        $totalPrice = 0;
        return view('pages.beli',[
            'carts' => $cart,
            'totalPrice' => $totalPrice,
        ]);
    }
}
