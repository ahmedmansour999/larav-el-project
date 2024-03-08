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
        // Check if the user is authenticated
        if (!Auth::check()) {
            // Redirect the user to the login page if they are not authenticated
            return redirect()->route('login');
        }

        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the user object is not null
        if (!$user) {
            // Handle the case where the user object is null
            abort(404, 'User not found');
        }

        // Retrieve the user's reservations and order them by res_date
        $reservations = $user->reservations()->orderBy('res_date', 'desc')->get();

        // Return the view with reservations data
        return view('user.reservations', compact('reservations'));
    }


    public function items(Request $request) {
        $id = $request->input('userId');
        $member = User::findOrFail($id);
        $users = User::all() ;
        $menus = $member->menus; // Remove the parentheses
        return view('admin.user.items', compact( 'member' , 'users' , 'menus'));
    }




}
