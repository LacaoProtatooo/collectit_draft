<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Cart\Collectible;
use App\Models\Order;
use App\Models\User;
use App\Models\Courier;
use Illuminate\Http\Request;
use App\Mail\TransacComplete;
use Mail;
use Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy("id", "desc")->paginate(10);
        return view("user.myorders", compact('orders'));
    }

    public function summary(Request $request)
    {
        // dd($request);
        $orderID = $request->id;
        $order = Order::find($orderID);
        // dd($request->id);
        $courier = Courier::where('id', $order->courier_id)->first();
        if ($order) {
            $collectibles = $order->collectibles()->withPivot('quantity', 'reviewStat')->orderBy('id', 'desc')->paginate(10);
        }
        // dd($courier);



       return view('user.orderSummary', compact('collectibles', 'order','courier'));
    }

    public function migrate(Request $request)
    {
        // dd($request);
        $cartID = $request->cartID;
        $courierID = $request->courier;

        $cart = Cart::with('collectibles')->findOrFail($cartID);
        $shipType = Courier::where('id', $courierID)->value('type');
        // Access the collectibles related to the cart
        // $collectibles = $cart->collectibles;
        // $quantity = $collectibles->pivot->quantity;
        // dd($cart->collectibles->pivot->quantity);

        $order = new order();
        $order->user_id = Auth::user()->id;
        $order->courier_id = $courierID;
        $order->ship_type = $shipType;
        $order->status = 'toShip';
        $order->date = now();
        $order->save();

        foreach ($cart->collectibles as $collectible) {
            $quantity = $collectible->pivot->quantity;
            $collectibleId = $collectible->id;
            $order->collectibles()->attach($collectibleId, ['quantity' => $quantity, 'reviewStat'=> 'toRate']);
        }
            $collectibles = $order->collectibles()->withPivot('quantity', 'reviewStat')->orderBy('id', 'desc')->paginate(10);
            // dd($collectibles)  ;
            foreach ($collectibles as $collectible) {
                $pivot = $collectible->pivot;
                $quantity = $pivot->quantity;
                $status = $order->status;

                // dd($status);
                if ($status === 'toShip') {
                    $newStock = $collectible->stock - $quantity;
                    $collectible->update(['stock' => $newStock]);
                }

                if($collectible->stock < 1)
                {
                    $collectible->update(['status' => 'sold']);
                }
            }
            $user = Auth::user();
            $orders = Order::with('user', 'courier', 'collectibles')->get();
            Mail::to($user->email)->send(new TransacComplete($orders, $user));


        $cart = Cart::destroy($cartID);
        return redirect()->route('order.index');
    }

    public function shipping($id){
        $order = Order::findOrFail($id);
        $order->status = 'shipping';
        $order->date = now();
        $order->save();

        return redirect()->route('order.show');
    }

    public function shipped($id){
        $order = Order::findOrFail($id);
        $order->status = 'shipped';
        $order->date = now();
        $order->save();

        return redirect()->route('order.show');
    }

    public function show()
    {
        $orders = Order::with('user', 'courier')->get();
        return view('admin.order', compact('orders'));
    }


}
