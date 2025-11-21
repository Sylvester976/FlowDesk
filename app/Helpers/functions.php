<?php
use App\Models\County;
use App\Models\Country;
use App\Models\Subcounty;

if (!function_exists('generateRandomStrongPassword')) {

    /**
     * Generate a strong random password
     *
     * @param int $length
     * @return string
     */
    function generateRandomStrongPassword($length = 12)
    {
        // Define character pools
        $upper   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lower   = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $symbols = '!@#$%^&*()-_=+[]{}<>?';

        // Combine all pools
        $all = $upper . $lower . $numbers . $symbols;

        // Make sure the password contains at least one of each
        $password = '';
        $password .= $upper[random_int(0, strlen($upper) - 1)];
        $password .= $lower[random_int(0, strlen($lower) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $symbols[random_int(0, strlen($symbols) - 1)];

        // Fill the rest with random characters from all pools
        for ($i = 4; $i < $length; $i++) {
            $password .= $all[random_int(0, strlen($all) - 1)];
        }

        // Shuffle to mix mandatory characters
        return str_shuffle($password);
    }

    function getCountryName($country)
    {
        $countryName = Country::where('id', $country)->first('name');
        return $countryName ? $countryName->name : null;
    }

    function getCountyName($county)
    {
        $countyName = County::where('id', $county)->first('name');
        return $countyName ? $countyName->name : null;
    }

    function getSubcountyName($subcounty){
        $subcountyName = Subcounty::where('id', $subcounty)->first('name');
        return $subcountyName ? $subcountyName->name : null;
    }

}
