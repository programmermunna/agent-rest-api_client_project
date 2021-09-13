<?php

use Carbon\Carbon;

if (! function_exists('appName')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function appName()
    {
        return config('app.name', 'Agent');
    }
}

if (! function_exists('carbon')) {
    /**
     * Create a new Carbon instance from a time.
     *
     * @param $time
     *
     * @return Carbon
     * @throws Exception
     */
    function carbon($time)
    {
        return new Carbon($time);
    }
}

if (! function_exists('homeRoute')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function homeRoute()
    {
        if (auth()->check()) {
            if (auth()->user()->isAdmin()) {
                return 'admin.dashboard';
            }

            if (auth()->user()->isUser()) {
                // return 'frontend.user.dashboard';
                # samain aja ke backend dashboard
                return 'admin.dashboard';
            }
        }

        // return 'frontend.index';
        return 'frontend.auth.login';
    }
}

if (! function_exists('prefix_key_inarray')) {
    function prefix_key_inarray($array, $prefix)
    {
        return array_combine(
            array_map(function ($key) use ($prefix) {
                return $prefix.'-'.$key;
            }, array_keys($array)),
            $array
        );
    }
}

if (! function_exists('checkOnline')) {
    function checkOnline($domain)
    {
        $curlInit = curl_init($domain);
        curl_setopt($curlInit, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curlInit, CURLOPT_HEADER, true);
        curl_setopt($curlInit, CURLOPT_NOBODY, true);
        curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curlInit);

        curl_close($curlInit);
        if ($response) {
            return true;
        }

        return false;
    }
}

if (! function_exists('change_key')) {
    function change_key($array, $old_key, $new_key)
    {
        if (! array_key_exists($old_key, $array)) {
            return $array;
        }

        $keys = array_keys($array);
        $keys[ array_search($old_key, $keys) ] = $new_key;

        return array_combine($keys, $array);
    }
}
