<?php

if (! function_exists('classify')) {
    /**
     * Converts a string into a class name.
     * Hello world would become Hello_World.
     *
     * @param $value
     *
     * @return mixed
     */
    function classify($value)
    {
        $value  = mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
        $search = ['_', '-', '.', '/', ':'];

        return str_replace(' ', '_', str_replace($search, ' ', $value));
    }
}

if (! function_exists('humanReadableImplode')) {
    /**
     * Implode an array but add 'and' before the last result.
     *
     * @param $array
     *
     * @return string
     */
    function humanReadableImplode($array, $separator = 'and')
    {
        $last  = array_slice($array, -1);
        $first = implode(', ', array_slice($array, 0, -1));
        $both  = array_filter(array_merge([$first], $last));

        return implode(" $separator ", $both);
    }
}
