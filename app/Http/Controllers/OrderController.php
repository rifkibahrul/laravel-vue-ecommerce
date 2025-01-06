<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Fungsi mendapatkan data user, customer, dan customeraddress
    private function getUserData(Request $request)
    {
        $user = $request->user();
        $customer = $user->customer;
        $customerAddress = $customer->customerAddress;
        return [
            'user' => $user,
            'customer' => $customer,
            'customerAddress' => $customerAddress
        ];
    }

    public function index(Request $request)
    {
        // Mengambil data diri user yang sedang login
        $userData = $this->getUserData($request);

        $orders = Order::query()->where(['created_by' => $userData['user']->id])->orderby('created_at', 'desc')->paginate(10);

        return view('order.index', compact('orders'));
    }

    public function view(Request $request, $id)
    {
        // Mengambil data diri user yang sedang login
        $userData = $this->getUserData($request);

        $order = Order::find($id);
        $payment = $order->payment;
        $orderItems = $order->items;
        $detail = $this->detailOrder($order);

        return view('order.view', compact('order', 'payment', 'orderItems', 'detail', 'userData'));
    }

    // Notifikasi Midtrans
    public function notification()
    {
        \Midtrans\Config::$serverKey    = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;

        try {
            $notif = new \Midtrans\Notification();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challange') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    $payment = Payment::where('serial_number', $order_id)->first();
                    if ($payment) {
                        $payment->update(['transaction_status' => 'Challenge by FDS']);
                        $payment->order->update(['status' => 'Challenge by FDS']);
                    }
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    $payment = Payment::where('serial_number', $order_id)->first();
                    if ($payment) {
                        $payment->update(['transaction_status' => 'Success']);
                        $payment->order->update(['status' => 'Success']);
                    }
                }
            }
        } else if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            $payment = Payment::where('serial_number', $order_id)->first();
            if ($payment) {
                $payment->update(['transaction_status' => 'Settlement']);
                $payment->order->update(['status' => 'Settlement']);
            }
        } else if ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            $payment = Payment::where('serial_number', $order_id)->first();
            if ($payment) {
                $payment->update(['transaction_status' => 'Pending']);
                $payment->order->update(['status' => 'Pending']);
            }
        } else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            $payment = Payment::where('serial_number', $order_id)->first();
            if ($payment) {
                $payment->update(['transaction_status' => 'Denied']);
                $payment->order->update(['status' => 'Denied']);
            }
        } else if ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            $payment = Payment::where('serial_number', $order_id)->first();
            if ($payment) {
                $payment->update(['transaction_status' => 'Expire']);
                $payment->order->update(['status' => 'Expire']);
            }
        } else if ($transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
            $payment = Payment::where('serial_number', $order_id)->first();
            if ($payment) {
                $payment->update(['transaction_status' => 'Denied']);   // Upd table payment
                $payment->order->update(['status' => 'Denied']);        // Upd table order
            }
        }

        return response()->json(['order_id' => $order_id, 'transaction_status' => $transaction]);
    }

    protected function detailOrder($order)
    {
        $payment = $order->payment;

        switch ($order->status) {
            case 'Challenge by FDS':
                return [
                    'message' => 'The order has challenge by FDS, please try to reorder, or call the customer service',
                    'pdf_url' => '',
                    'bill' => ''
                ];
                break;
            case 'Success':
                return [
                    'message' => 'The order is on processing',
                    'pdf_url' => $payment->pdf_url,
                    'bill' => ''
                ];
                break;
            case 'Settlement':
                return [
                    'message' => 'The order has been paid for and will be processed soon. We have sent the detail to your email, please check your email',
                    'pdf_url' => '',
                    'bill' => ''
                ];
                break;
            case 'Pending':
                return [
                    'message' => 'The order is waiting to be paid, please pay immediately using the payment method you choose',
                    'pdf_url' => $payment->pdf_url,
                    'bill' => ''
                ];
                break;
            case 'Denied':
                return [
                    'message' => 'The order has been denied, please try to reorder',
                    'pdf_url' => '',
                    'bill' => ''
                ];
                break;
                break;
            case 'Expire':
                return [
                    'message' => 'The order has expired because it has passed the payment deadline',
                    'pdf_url' => '',
                    'bill' => ''
                ];
                break;
            default:
                return [
                    'message' => 'The order is waiting to be paid, please pay immediately using the payment method you choose',
                    'pdf_url' => $payment->pdf_url ?? '',
                    'bill' => '',
                ];
                break;
        }
    }
}
