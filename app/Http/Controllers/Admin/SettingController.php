<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'studio_name' => Setting::get('studio_name', 'Studio Foto Booking'),
            'studio_address' => Setting::get('studio_address', ''),
            'studio_phone' => Setting::get('studio_phone', ''),
            'studio_email' => Setting::get('studio_email', ''),
            'studio_logo' => Setting::get('studio_logo', ''),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'studio_name' => 'required|string|max:255',
            'studio_address' => 'nullable|string',
            'studio_phone' => 'nullable|string|max:50',
            'studio_email' => 'nullable|email|max:255',
            'studio_logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        // Handle remove logo
        if ($request->remove_logo === '1') {
            $oldLogo = Setting::get('studio_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            Setting::set('studio_logo', '');
        }

        // Handle cropped image (base64)
        if ($request->cropped_image) {
            $oldLogo = Setting::get('studio_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->cropped_image));
            $filename = 'settings/logo_' . time() . '.png';
            Storage::disk('public')->put($filename, $imageData);
            Setting::set('studio_logo', $filename);
        }
        // Handle regular file upload (if no crop)
        elseif ($request->hasFile('studio_logo')) {
            $oldLogo = Setting::get('studio_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            $path = $request->file('studio_logo')->store('settings', 'public');
            Setting::set('studio_logo', $path);
        }

        Setting::set('studio_name', $request->studio_name);
        Setting::set('studio_address', $request->studio_address);
        Setting::set('studio_phone', $request->studio_phone);
        Setting::set('studio_email', $request->studio_email);

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil disimpan.');
    }
}
