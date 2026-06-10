<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadmin']);
    }
    
    public function edit()
    {
        $settings = WebsiteSetting::get();
        
        return view('admin.settings.edit', compact('settings'));
    }
    
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'favicon' => 'nullable|image|mimes:ico,png,jpg|max:1024', // 1MB
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048', // 2MB
            'maintenance_mode' => 'boolean',
            'maintenance_message' => 'nullable|string',
        ]);
        
        $settings = WebsiteSetting::get();
        
        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            // Delete old favicon
            if ($settings->favicon) {
                Storage::disk('public')->delete('settings/' . $settings->favicon);
            }
            
            $favicon = $request->file('favicon');
            $faviconName = 'favicon_' . time() . '.' . $favicon->getClientOriginalExtension();
            $favicon->storeAs('settings', $faviconName, 'public');
            $validated['favicon'] = $faviconName;
        }
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($settings->logo) {
                Storage::disk('public')->delete('settings/' . $settings->logo);
            }
            
            $logo = $request->file('logo');
            $logoName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $logo->storeAs('settings', $logoName, 'public');
            $validated['logo'] = $logoName;
        }
        
        $validated['maintenance_mode'] = $request->has('maintenance_mode');
        
        $settings->update($validated);
        
        return back()->with('success', 'Pengaturan website berhasil disimpan!');
    }
}
