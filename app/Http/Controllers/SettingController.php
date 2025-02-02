<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = Settings::firstOrNew();
        return view('settings.redirect', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'active_domain' => 'nullable|url',
            'redirect_enabled' => 'boolean'
        ]);

        Settings::updateOrCreate(
            ['id' => 1],
            $validated
        );

        return back()->with('status', 'Settings updated!');
    }
}