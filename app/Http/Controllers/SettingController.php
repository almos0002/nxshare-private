<?php
namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Edit Settings
    public function editSettings()
    {
        $settings = Settings::firstOrNew();
        return view('settings.settings', compact('settings'));
    }

    // Update Settings
    public function updateSettings(Request $request)
    {

        // Settings Validation
        $settingsValidated = $request->validate(['active_domain' => 'nullable|url', 'redirect_enabled' => 'boolean', 'ad1' => 'nullable|string', 'ad2' => 'nullable|string', ]);

        // Update Settings
        Settings::updateOrCreate(['id' => 1], $settingsValidated);

        return back()->with('status', 'Settings updated successfully!');
    }

    // Edit Profile
    public function editProfile()
    {
        $user = auth()->user();
        return view('settings.profile', compact('user'));
    }

    // Update Profile
    public function updateProfile(Request $request)
    {
        // User Validation
        $userValidated = $request->validate(['name' => 'required|string|max:255', 'email' => 'required|email|unique:users,email,' . auth()
            ->id() , 'password' => 'nullable|min:8|confirmed', ]);

        // Update User
        $user = auth()->user();
        $user->update(['name' => $userValidated['name'], 'email' => $userValidated['email'], 'password' => isset($userValidated['password']) ? Hash::make($userValidated['password']) : $user->password, ]);

        return back()->with('status', 'Profile updated successfully!');
    }

}

