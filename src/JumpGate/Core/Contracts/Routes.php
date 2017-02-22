<?php

namespace JumpGate\Core\Contracts;

use Illuminate\Routing\Router;

interface Routes
{
    public function setContext($name, $uri);

    public function getContext($name);

    public function getNamespace();

    public function getPrefix();

    public function getMiddleware();

    public function getPatterns();

    public function routes(Router $router);
}
