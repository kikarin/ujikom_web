<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $settings = Setting::first();
        // Add $settings to your existing view data
        return view('admin.dashboard', compact('settings', /* your existing variables */));
    }

    public function updateColors(Request $request)
    {
        $request->validate([
            'color_start' => 'required|string',
            'color_end' => 'required|string',
            'color_background' => 'required|string',
        ]);

        $settings = Setting::firstOrNew(['id' => 1]);
        $settings->color_start = $request->color_start;
        $settings->color_end = $request->color_end;
        $settings->color_background = $request->color_background;
        $settings->save();

        return redirect()->back()->with('success', 'Color settings updated successfully!');
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $settings = Setting::firstOrNew(['id' => 1]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($settings->logo && Storage::disk('public')->exists($settings->logo)) {
                Storage::disk('public')->delete($settings->logo);
            }

            $path = $request->file('logo')->store('logos', 'public');
            $settings->logo = $path;
            $settings->save();
        }

        return redirect()->back()->with('success', 'Logo updated successfully!');
    }
} 