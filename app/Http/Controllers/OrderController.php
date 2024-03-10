<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Menu;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all() ;
        $orders = Order::with('menus')->get();

        return view('admin.orders.index', ['orders' => $orders , 'users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Ensure user is authenticated
        $user = Auth::user();

        $request->validate([
            'title' => 'required',
            'menus' => 'required|array',
        ]);

        // Extract title and total from the request
        $title = $request->input('title');
        $notes = $request->input('notes');
        $total = $request->input('total');
        $menuIds = $request->input('menus');

        // Create the order
        $orderData = [
            'title' => $title,
            'total' => $total,
            'notes' => $notes,
        ];

        // If user is authenticated, set the user_id
        if ($user) {
            $orderData['user_id'] = $user->id;
        }

        $order = Order::create($orderData);

        $order->menus()->attach($menuIds);

        return redirect()->route('order.show', $order->id);
    }


    /**
     * Display the specified resource.
     */
    public function show()
    {
        // Get the authenticated user's ID
        $user_id = Auth::user()->id;

        // Fetch orders associated with the authenticated user
        $orders = Order::where('user_id', $user_id)->get();

        // Loop through each order
        foreach ($orders as $order) {
            // Fetch menu IDs associated with the order
            $menuIds = $order->menus()->pluck('id')->toArray();

            // Sync menu IDs with the order
            $order->menus()->sync($menuIds);
        }

        // Dump and die for debugging purposes

        // Return the view with orders data
        return view('orders.show', ['orders' => $orders]);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return view('orders.edit', ['order' => $order]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'total' => 'required',
            'menus' => 'required|array',
            'menus.*.id' => 'required|exists:menus,id',
            'menus.*.count' => 'required|numeric|min:0',
        ]);

        $order->update([
            'total' => $request->total,
        ]);

        // Update menu details
        foreach ($request->menus as $menuData) {
            $menu = Menu::findOrFail($menuData['id']);
            $menu->update([
                'count' => $menuData['count'],
            ]);
        }

        return redirect()->route('orders.show', $order);
    }




    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        $order = Order::where('id' , $id) ;
        $order->delete();

        return redirect()->route('order.show' , $id);
    }


    public function accept($id)
    {
        $order = Order::findOrFail($id);

        $order->update(['status' => '1']);

        return redirect()->back()->with('success', 'Menu Item Activated successfully');
    }
    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        $order->update(['status' => '2']);

        return redirect()->back()->with('success', 'Menu Item Canceled successfully');
    }
}
