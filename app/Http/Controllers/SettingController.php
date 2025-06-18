<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function index()
    {
        return view('setting.index', [
            'app_name' => config('app.name'),
            'app_logo' => config('app.logo'),
            'app_favicon' => config('app.favicon'),
            'app_timezone' => config('app.timezone'),
            'app_currency' => config('app.currency'),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:50',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'favicon' => 'nullable|image|mimes:png|dimensions:ratio=1/1|max:1024',
            'timezone' => 'required|timezone',
            'currency' => 'required|string|size:3',
        ]);

        $settings = [
            'app.name' => $request->app_name,
            'app.timezone' => $request->timezone,
            'app.currency' => strtoupper($request->currency),
        ];

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('public/logos');
            $settings['app.logo'] = Storage::url($logoPath);
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('public/favicons');
            $settings['app.favicon'] = Storage::url($faviconPath);
        }

        // Update config file
        $this->updateConfigFile($settings);

        return redirect()->route('setting.index')
            ->with('success', 'Pengaturan berhasil diperbarui');
    }

    protected function updateConfigFile($settings)
    {
        $configPath = config_path('app.php');
        $content = file_get_contents($configPath);

        foreach ($settings as $key => $value) {
            $pattern = "/'{$key}' => '.*?'/";
            $replacement = "'{$key}' => '".addslashes($value)."'";
            $content = preg_replace($pattern, $replacement, $content);
        }

        file_put_contents($configPath, $content);
    }

}
