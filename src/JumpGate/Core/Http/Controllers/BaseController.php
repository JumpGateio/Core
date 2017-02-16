<?php

namespace JumpGate\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;

abstract class BaseController extends Controller
{
    protected $layoutOptions = [
        'default' => 'layouts.default',
        'ajax'    => 'layouts.ajax',
    ];

    /**
     * Pass data to the view.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return $this
     */
    public function setViewData($key, $value = null)
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
     *
     * @return $this
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
