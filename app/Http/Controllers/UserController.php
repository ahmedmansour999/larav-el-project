<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class UserController extends Controller
{
    /**
     * Show the user's reservations.
     *
     * @return \Illuminate\Http\Response
     */
    public function showReservations()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$user) {
            abort(404, 'User not found');
        }

        $reservations = $user->reservations()->orderBy('res_date', 'desc')->get();

        return view('user.reservations', compact('reservations'));
    }


    public function items(Request $request) {
        $id = $request->input('userId');
        $member = User::findOrFail($id);
        $users = User::all() ;
        $menus = $member->menus; // Remove the parentheses
        return view('admin.user.items', compact( 'member' , 'users' , 'menus'));
    }

    public function orders(Request $request) {
        $id = $request->input('userId');

        if (!$id) {
            return redirect()->back()->with('error', 'User ID is missing.');
        }

        $member = User::with('orders')->findOrFail($id);

        $users = User::all();

        $orders = $member->orders;

        return view('admin.orders.index', compact('member', 'users', 'orders'));
    }







}
