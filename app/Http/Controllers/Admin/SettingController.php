<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSettingsRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Show the Tetapan Laman page with current setting values.
     */
    public function edit(): View
    {
        $settings = Setting::pluck('value', 'key')->all();

        return view('admin.landing', compact('settings'));
    }

    /**
     * Persist whichever editable settings were submitted. Each of the three
     * forms (WhatsApp / Contact / Hero) posts only its own fields, so we only
     * write the keys actually present in the request.
     */
    public function update(UpdateSettingsRequest $request): RedirectResponse
    {
        $submitted = array_intersect_key(
            $request->validated(),
            array_flip(UpdateSettingsRequest::EDITABLE_KEYS),
        );

        $saved = false;

        foreach ($submitted as $key => $value) {
            Setting::set($key, $value);
            $saved = true;
        }

        // File inputs: store on the public disk, save the relative path as the value.
        foreach (UpdateSettingsRequest::FILE_KEYS as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $path = $request->file($fileKey)->store('settings', 'public');
                Setting::set($fileKey, $path);
                $saved = true;
            }
        }

        // Nothing editable in the payload → the form isn't wired to any setting.
        if (! $saved) {
            return back()->with('error', 'Borang ini belum aktif — tiada tetapan disimpan.');
        }

        return back()->with('success', 'Tetapan berjaya disimpan.');
    }
}
