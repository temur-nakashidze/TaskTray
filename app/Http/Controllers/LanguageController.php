<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    /**
     * Set the application language.
     */
    public function set(string $language): RedirectResponse
    {
        // Validate the language is supported
        $supportedLanguages = ['en', 'ru', 'ka'];

        if (! in_array($language, $supportedLanguages)) {
            return redirect()->back();
        }

        // Store the language in session
        $langsession = session(['locale' => $language]);

        app()->setLocale($language);

        return redirect()->back();
    }
}
