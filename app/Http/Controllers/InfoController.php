<?php

namespace App\Http\Controllers;

use App\Models\Info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InfoController extends Controller
{
    public function index()
    {
        $infos = Info::all();
        return view('admin.infos.index', compact('infos'));
    }

    public function userIndex()
    {
        $infos = Info::all();
        return view('infos.index', compact('infos'));
    }

    public function create()
    {
        return view('admin.infos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',  
            'content' => 'required|string'        
        ]);

        $info = Info::create($request->all());

        // Log activity
        Log::info(Auth::user()->name . ' created a new info: ' . $info->title);

        return redirect()->route('infos.index')->with('success', 'Info posted successfully');
    }

    public function edit(Info $info)
    {
        return view('admin.infos.edit', compact('info'));
    }

    public function update(Request $request, Info $info)
    {
        $info->update($request->all());

        // Log activity
        Log::info(Auth::user()->name . ' updated the info: ' . $info->title);

        return redirect()->route('infos.index')->with('success', 'Info updated successfully');
    }

    public function destroy(Info $info)
    {
        $title = $info->title; // Save title before deletion
        $info->delete();

        // Log activity
        Log::info(Auth::user()->name . ' deleted the info: ' . $title);

        return redirect()->route('infos.index')->with('success', 'Info deleted successfully');
    }
}
