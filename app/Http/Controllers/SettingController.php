<?php
namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Edit Settings
    public function editSettings()
    {
        $settings = Settings::first() ?: new Settings();
        return view('settings.settings', compact('settings'));
    }

    // Update Settings
    public function updateSettings(Request $request)
    {
        // Settings Validation
        $settingsValidated = $request->validate([
            'active_domain' => 'nullable|url', 
            'redirect_enabled' => 'boolean', 
            'ad1' => 'nullable|string', 
            'ad2' => 'nullable|string',
        ]);

        // Update Settings
        Settings::updateOrCreate(['id' => 1], $settingsValidated);

        return back()->with('status', 'Settings updated successfully!');
    }

    // Edit Profile
    public function editProfile()
    {
        $user = Auth::user();
        return view('settings.profile', compact('user'));
    }

    // Update Profile
    public function updateProfile(Request $request)
    {
        // User Validation
        $userValidated = $request->validate([
            'name' => 'required|string|max:255', 
            'email' => 'required|email|unique:users,email,' . Auth::id(), 
            'password' => 'nullable|min:8|confirmed', 
        ]);

        // Prepare update data
        $userData = [
            'name' => $userValidated['name'],
            'email' => $userValidated['email'],
        ];
        
        // Add password only if provided
        if (!empty($userValidated['password'])) {
            $userData['password'] = Hash::make($userValidated['password']);
        }

        // Update User
        User::where('id', Auth::id())->update($userData);

        return back()->with('status', 'Profile updated successfully!');
    }

    // Toggle NSFW Setting
    public function toggleNsfw(string $status)
    {
        // Validate status
        if (!in_array($status, ['enabled', 'disabled'])) {
            return back()->with('error', 'Invalid NSFW status');
        }

        // Get the authenticated user
        $user = Auth::user();

        // Update or create settings with the new NSFW status
        Settings::updateOrCreate(
            ['user_id' => $user->id],
            ['nsfw' => $status]
        );

        $statusMessage = $status == 'enabled' ? 'NSFW content enabled' : 'NSFW content disabled';
        return back()->with('status', $statusMessage);
    }

    // Toggle NSFW Setting via AJAX
    public function toggleNsfwAjax(Request $request)
    {
        // Validate status
        $status = $request->input('status');
        if (!in_array($status, ['enabled', 'disabled'])) {
            return response()->json(['success' => false, 'message' => 'Invalid NSFW status']);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Update or create settings with the new NSFW status
        Settings::updateOrCreate(
            ['user_id' => $user->id],
            ['nsfw' => $status]
        );

        return response()->json([
            'success' => true, 
            'message' => $status == 'enabled' ? 'NSFW content enabled' : 'NSFW content disabled'
        ]);
    }
}
