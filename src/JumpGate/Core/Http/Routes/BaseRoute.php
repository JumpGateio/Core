<?php

namespace JumpGate\Core\Http\Routes;

abstract class BaseRoute
{
    /**
     * @var string|null
     */
    public $namespace = null;

    /**
     * @var string|null
     */
    public $prefix = null;

    /**
     * @var string|null
     */
    public $context = null;

    /**
     * @var array
     */
    public $contexts = [
        'admin'   => '/admin',
        'default' => '/',
    ];

    /**
     * @var array
     */
    public $middleware = [];

    /**
     * @var array
     */
    public $patterns = [];

    /**
     * Add a context to the array.
     *
     * @param string $name
     * @param string $uri
     *
     * @return \JumpGate\Core\Http\Routes\Routes
     */
    public function setContext($name, $uri)
    {
        $this->contexts[$name] = $uri;

        return $this;
    }

    /**
     * Get a context URI from the array.
     *
     * @param string|null $name
     *
     * @return string
     */
    public function getContext($name = null)
    {
        if (is_null($name)) {
            $name = $this->context;
        }

        return isset($this->contexts[$name]) ? $this->contexts[$name] : null;
    }

    /**
     * Get the namespace for this route group.
     *
     * @return string|null
     */
    public function getNamespace()
    {
        if (! is_string($this->namespace)) {
            return null;
        }

        return $this->namespace;
    }

    /**
     * Get the prefix for this route group.
     *
     * @return string|null
     */
    public function getPrefix()
    {
        $prefix = null;

        if (! is_null($this->getContext())) {
            $prefix = $this->getContext();
        }

        if (! is_string($this->prefix)) {
            return $prefix;
        }

        return $prefix . $this->prefix;
    }

    /**
     * Get the middleware for this route group.
     *
     * @return array|null
     */
    public function getMiddleware()
    {
        if (! is_array($this->middleware)) {
            return null;
        }

        return $this->middleware;
    }

    /**
     * Get the patterns for this route group.
     *
     * @return array|null
     */
    public function getPatterns()
    {
        if (! is_array($this->patterns)) {
            return null;
        }

        return $this->patterns;
    }
}
