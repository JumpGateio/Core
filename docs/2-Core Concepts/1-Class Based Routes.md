# Class Based Routing

- [Introduction](#introduction)
- [RouteServiceProvider](#service-provider)
- [Usage](#usage)

<a name="introduction"></a>
## Introduction
Class based routing is an idea to use proper PHP classes for route groups.  Each class used in this way behaves like a route 
group.

<a name="service-provider"></a>
## RouteServiceProvider
You will first need to make sure your `RouteServiceProvider` can understand these classes.  In `jumpgate/jumpgate` this is 
done for you.  To set it up manually, you would need something like the following example.

```php
<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use JumpGate\Core\Contracts\Routes;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Route providers that contain the configuration of a route group.
     *
     * @var array
     */
    protected $providers = [
        \App\Http\Routes\Home::class,
    ];

    public function __construct($app)
    {
        parent::__construct($app);

        if (empty($this->providers)) {
            $this->getProvidersFromServicesConfig();
        }
    }

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $router = $this->app['router'];

        foreach ($this->providers as $key => $provider) {
            $provider = new $provider;

            if (! $provider instanceof Routes) {
                unset($this->providers[$key]);
                continue;
            }

            $router->patterns($provider->getPatterns());
        }

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapRouteClasses();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    /**
     * Convert class route files into valid routes.
     */
    private function mapRouteClasses()
    {
        $router = $this->app['router'];

        foreach ($this->providers as $provider) {
            $provider = new $provider;

            $router->group([
                'prefix'     => $provider->getPrefix(),
                'namespace'  => $provider->getNamespace(),
                'middleware' => $provider->getMiddleware(),
            ], function ($router) use ($provider) {
                $provider->routes($router);
            });
        }
    }

    /**
     * Get an array of providers from the services.json.
     */
    private function getProvidersFromServicesConfig()
    {
        if (file_exists(base_path('bootstrap/services.json'))) {
            $services = collect(
                json_decode(
                    file_get_contents(base_path('bootstrap/services.json'))
                )
            );

            $this->providers = $services->flatMap(function ($service) {
                if (isset($service->routes)) {
                    return $service->routes;
                }
            })->toArray();
        }
    }
}
```

This example does a lot, so lets break it down.

The providers array is used to list out your route classes.  Each route class you make will need to be listed here.

In the constructor, you check to see if that array is empty.  If so, it checks the local services.json for any possible 
route files.

The boot method is handling the patterns from the route files.  These will be things like `['id' => '[0-9]+']`.  These are 
patterns that routes should know exist to behave properly.

Now in the map method we handle three things.  The first two are the default laravel API and web route implementations.  The 
third one is handling our route classes.

mapRouteClasses loops through each class in the providers array and assigns the routes within as a route group.

<a name="usage"></a>
## Usage
So how does this provider help us?  Let's first look at an example route class.

```php
<?php

namespace App\Http\Routes;

use JumpGate\Core\Contracts\Routes;
use JumpGate\Core\Http\Routes\BaseRoute;
use Illuminate\Routing\Router;

class Home extends BaseRoute implements Routes
{
    public $namespace = 'App\Http\Controllers';

    public $middleware = ['web'];

    public function routes(Router $router)
    {
        $router->get('/')
               ->name('home')
               ->uses('HomeController@index')
               ->middleware('active:home');
    }
}
```

This is a very basic example of a route class.  It must implement `Routes` and a lot of helpers are provided for you in 
`JumpGate\Core\Providers\Routes`.  Simply extend it if you want to.

So the methods.  The namespacing method sets the namespace for the route group as a whole.  The prefix would be something that
 should proceed every uri.  An example is below.
 
 ```php
public function prefix()
{
    return $this->getContext('default') .'/dashboard';
}
```

The `getContext` method is a helper on the BaseRoutes class mentioned earlier.  This simply grabs common prefixes for you.  Default
returns a `/` and `admin` return `/admin`.  You can add any contexts you want at any time with the `setContext()` method.

The middleware method returns an array of middleware the group will use.  Patterns will set the patterns as mentioned earlier.

Lastly is the routes method.  This is where you define all the routes this group will use.  These can look like normal routes
using the facade or you can use the new laravel 5.3+ fluent style methods.
