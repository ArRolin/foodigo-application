<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Language\App\Models\Language;
use Symfony\Component\HttpFoundation\Response;

class ApiLangSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Get lang_code from request parameter
            $lang_code = $request->query('lang_code') ?? $request->input('lang_code');

            // If lang_code is provided and valid, set it in session
            if ($lang_code && Language::where('lang_code', $lang_code)->where('status', 1)->exists()) {
                $language = Language::where('lang_code', $lang_code)->first();

                session([
                    'front_lang' => $language->lang_code,
                    'lang_dir' => $language->lang_direction ?? 'left_to_right',
                    'front_lang_name' => $language->lang_name
                ]);

                app()->setLocale($language->lang_code);
            } else {
                // Use default language if no valid lang_code is provided
                $default_lang = Language::where('status', 1)->orderBy('id')->first();

                if ($default_lang) {
                    session([
                        'front_lang' => $default_lang->lang_code,
                        'lang_dir' => $default_lang->lang_direction ?? 'left_to_right',
                        'front_lang_name' => $default_lang->lang_name
                    ]);

                    app()->setLocale($default_lang->lang_code);
                } else {
                    // Fallback to English
                    session(['front_lang' => 'en', 'lang_dir' => 'left_to_right', 'front_lang_name' => 'English']);
                    app()->setLocale('en');
                }
            }
        } catch (\Exception $e) {
            // Tables may not exist yet during initial setup
            session(['front_lang' => 'en', 'lang_dir' => 'left_to_right', 'front_lang_name' => 'English']);
            app()->setLocale('en');
        }

        return $next($request);
    }
}

