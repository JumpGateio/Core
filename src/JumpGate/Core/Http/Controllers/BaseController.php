<?php

namespace JumpGate\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;

abstract class BaseController extends Controller
{
    protected $layoutOptions = [
        'default' => 'layouts.default',
        'sidebar' => 'layouts.sidebar',
        'ajax'    => 'layouts.ajax',
    ];

    /**
     * Set the page title for use in the header.
     *
     * @param string $customPageTitle
     */
    protected function setPageTitle($customPageTitle)
    {
        $this->setViewData(compact('customPageTitle'));
    }

    /**
     * Pass data to the view.
     *
     * @param mixed $key
     * @param mixed $value
     */
    protected function setViewData($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $name => $data) {
                view()->share($name, $data);
            }
        } else {
            view()->share($key, $value);
        }
    }

    /**
     * Pass data directly to Javascript.
     *
     * @link https://github.com/laracasts/PHP-Vars-To-Js-Transformer
     *
     * @param mixed $key
     * @param mixed $value
     */
    protected function setJavascriptData($key, $value = null)
    {
        if (is_array($key)) {
            JavaScriptFacade::put($key);
        } else {
            JavaScriptFacade::put([$key => $value]);
        }
    }
}
