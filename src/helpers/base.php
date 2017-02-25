<?php

use JumpGate\Database\Collections\EloquentCollection;

if (! function_exists('start_debug')) {
    /**
     * Start a debugbar measurement
     *
     * @param string $name
     * @param string $label
     *
     * @return mixed
     */
    function start_debug($name, $label)
    {
        if (app()->environment('local') && app()->bound('debugbar')) {
            start_measure($name, $label);
        }
    }
}

if (! function_exists('stop_debug')) {
    /**
     * Stop a debugbar measurement
     *
     * @param string $name
     *
     * @return mixed
     */
    function stop_debug($name)
    {
        if (app()->environment('local') && app()->bound('debugbar')) {
            stop_measure($name);
        }
    }
}

if (! function_exists('pp')) {
    /**
     * Print Pre data.
     *
     * @param mixed $data   The data you would like to display
     * @param bool  $return Return the data instad of echoing it.
     *
     * @return string $output The data to display wrapped in pre tags.
     */
    function pp($data, $return = false)
    {
        $output = '<pre>';
        $output .= print_r($data, true);
        $output .= '</pre>';

        if ($return == true) {
            return $output;
        } else {
            echo $output;
        }
    }
}

if (! function_exists('ppd')) {
    /**
     * Print Pre and die.
     *
     * @param mixed $data The data you would like to display
     *
     * @return void
     */
    function ppd($data)
    {
        $output = '<pre>';
        $output .= print_r($data, true);
        $output .= '</pre>';

        echo $output;
        die;
    }
}
