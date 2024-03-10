<?php

namespace App\Http\Controllers;

use App\Enums\TableStatus;
use App\Http\Requests\ReservationStoreRequest;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Table;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservation = Reservation::all();
        return view('admin.reservations.index', compact('reservation'));
    }


    public function create()
    {
        $tables = Table::where('status', TableStatus::Available) ->get() ;
        return view('admin.reservations.create', compact('tables'));
    }


    public function store(ReservationStoreRequest $request)
    {
       $table = Table::findOrfail($request->table_id);
       if ($request->guest_number > $table->guest_number){
        return back()->with('warning','Please chose  table with enough guest capacity');
       };
       $request_date = Carbon::parse($request->res_date);
       foreach ($table->reservations as $res) {
           // Parse $res->res_date into a Carbon instance
           $reservationDate = Carbon::parse($res->res_date);

           // Check if the dates match (ignoring time)
           if ($reservationDate->format('Y-m-d') == $request_date->format('Y-m-d')) {
               return back()->with('danger', 'The selected date has been reserved! Please choose another day.');
           }
       }


        Reservation::create($request->validated());

        return redirect()->route('admin.reservation.index')->with('success', 'Reservation created successfully');
    }

    public function show(Reservation $reservation)
    {
        
    }

    public function edit(Reservation $reservation)
    {
        $tables = Table::all();
        return view('admin.reservations.edit', compact('reservation', 'tables'));
    }
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'tel_number' => 'required|string',
            'res_date' => 'required|date',
            'table_id' => 'required|exists:tables,id',
            'guest_number' => 'required|integer|min:1',
        ]);

        $reservation->update($request->all());

        return redirect()->route('admin.reservations.index')->with('warning', 'Reservation updated successfully');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('admin.reservation.index')->with('danger', 'Reservation deleted successfully');
    }
    public function cancel($id)
    {
        // Find the reservation by its ID
        $reservation = Reservation::find($id);
    
        // Check if the reservation exists
        if (!$reservation) {
            return redirect()->back()->with('error', 'Reservation not found.');
        }
    
        // Delete the reservation
        $reservation->delete();
    
        return redirect()->back()->with('success', 'Reservation canceled successfully.');
    }
}
