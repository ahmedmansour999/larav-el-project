<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tables = Table::all();
        return view('admin.tables.index', compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tables.create');
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'guest_number' => 'required|integer',
            'status' => 'required|string',
            'location' => 'required|string',
        ]);

        $table = new Table();
        $table->name = $request->name;
        $table->guest_number = $request->guest_number;
        $table->status = $request->status;
        $table->location = $request->location;
        $table->save();

        return redirect()->route('admin.tables.index')->with('success', 'Table Added successfully');
    }



    public function show(Table $table)
    {
        //
    }


    public function edit(Table $table)
    {
        return view('admin.tables.edit', compact('table'));

    }

    public function update(Request $request, Table $table)
    {
        $request->validate([
            'name' => 'required|string',
            'guest_number' => 'required|integer',
            'status' => 'required|string',
            'location' => 'required|string',
        ]);

        $table->update([
            'name' => $request->name,
            'guest_number' => $request->guest_number,
            'status' => $request->status,
            'location' => $request->location,
        ]);

        return redirect()->route('admin.tables.index')->with('warning', 'Table Updated successfully');
    }


    public function destroy(Table $table)
    {
        $table->delete();

        return redirect()->route('admin.tables.index')->with('danger', 'Table Deleted successfully');
    }
}
