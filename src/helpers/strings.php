<?php

if (!function_exists('classify')) {
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

if (!function_exists('humanReadableImplode')) {
    /**
     * Implode an array but add 'and' before the last result.
     *
     * @param        $array
     * @param string $separator
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

if (!function_exists('json_validate')) {
    /**
     * Validate that JSON is properly set up and display
     * readable errors if not.
     *
     * @param $string
     *
     * @return mixed
     */
    function json_validate($string)
    {
        // decode the JSON data
        $result = json_decode($string);

        // switch and check possible JSON errors
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                $error = ''; // JSON is valid // No error has occurred
                break;
            case JSON_ERROR_DEPTH:
                $error = 'The maximum stack depth has been exceeded.';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = 'Invalid or malformed JSON.';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = 'Control character error, possibly incorrectly encoded.';
                break;
            case JSON_ERROR_SYNTAX:
                $error = 'Syntax error, malformed JSON.';
                break;
            // PHP >= 5.3.3
            case JSON_ERROR_UTF8:
                $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
                break;
            // PHP >= 5.5.0
            case JSON_ERROR_RECURSION:
                $error = 'One or more recursive references in the value to be encoded.';
                break;
            // PHP >= 5.5.0
            case JSON_ERROR_INF_OR_NAN:
                $error = 'One or more NAN or INF values in the value to be encoded.';
                break;
            case JSON_ERROR_UNSUPPORTED_TYPE:
                $error = 'A value of a type that cannot be encoded was given.';
                break;
            default:
                $error = 'Unknown JSON error occured.';
                break;
        }

        if ($error !== '') {
            // throw the Exception or exit // or whatever :)
            exit($error);
        }

        // everything is OK
        return $result;
    }
}
