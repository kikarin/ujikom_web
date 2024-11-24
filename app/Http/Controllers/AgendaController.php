<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::all();
        return view('admin.agendas.index', compact('agendas'));
    }

    public function userIndex()
    {
        $agendas = Agenda::all();
        return view('agendas.index', compact('agendas'));
    }

    public function create()
    {
        return view('admin.agendas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'nullable|date',
        ]);

        $agenda = Agenda::create($validated);

        // Log the activity with timestamp
        Log::info(Auth::user()->name . ' created a new agenda: ' . $agenda->title);


        return redirect()->route('agendas.index')->with('success', 'Agenda created successfully.');
    }

    public function edit(Agenda $agenda)
    {
        return view('admin.agendas.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'nullable|date',
        ]);

        $agenda->update($validated);

        // Log the activity with timestamp
        Log::info(Auth::user()->name . ' updates the agenda: ' . $agenda->title);


        return redirect()->route('agendas.index')->with('success', 'Agenda updated successfully.');
    }

    public function destroy(Agenda $agenda)
    {
        $agendaTitle = $agenda->title; // Save title for logging before deletion
        $agenda->delete();

        // Log the activity with timestamp
        Log::info(Auth::user()->name . ' deleted the agenda: ' . $agenda->title);

        return redirect()->route('agendas.index')->with('success', 'Agenda deleted successfully.');
    }
}
