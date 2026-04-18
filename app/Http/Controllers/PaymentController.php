<?php
namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
class PaymentController extends Controller
{
public function pay(Order $order)
{

// Make sure the order belongs to the logged in user
if ($order->user_id !== Auth::id()) {
abort(403);
}
// Call the Xendit API using Laravel HTTP client
$response = Http::withBasicAuth(
config('services.xendit.secret_key'), ''
)->post('https://api.xendit.co/v2/invoices', [
'external_id' => 'order-' . $order->id,
'amount' => $order->total_amount,
'payer_email' => $order->email,
'description' => 'Order #' . $order->id . ' - Simple Store',
'success_redirect_url' => route('payment.success', $order),
'failure_redirect_url' => route('payment.failure', $order),
'currency' => 'PHP',
]);
if ($response->failed()) {
return redirect()->route('orders.show', $order)
->with('error', 'Could not initiate payment. Please try again.');
}
$invoice = $response->json();
// Save the invoice URL to the order
$order->update(['invoice_url' => $invoice['invoice_url']]);
// Redirect the customer to Xendit's payment page
return redirect($invoice['invoice_url']);
}
public function success(Order $order)
{
$order->update(['status' => 'processing']);
return redirect()->route('checkout.success', $order)
->with('success', 'Payment successful! Your order is being processed.');
}
public function failure(Order $order)
{
return redirect()->route('orders.show', $order)
->with('error', 'Payment failed. Please try again.');
}
}