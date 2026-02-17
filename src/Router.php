<?php
namespace LDH;

use Symfony\Component\HttpFoundation\Request;

class Router
{
    /**
     * @var array $routes.
     *
     * All defined routes available to to router object. */
    private $routes = [];

    /**
     * @var string $uri.
     *
     * The current REQUEST_URI that has been sent to the router. */
    private $uri = NULL;

    /**
     * @var string $method.
     *
     * The current REQUEST_METHOD that has been sent to the router. */
    private $method = NULL;

    /**
     * @var string $route_found.
     *
     * True when a route has been found. False otherwise. */
    private $route_found = false;


    /**
     * Constructor.
     **/
    public function __construct(public Request $request)
    {
		$this->uri            = $request->server->get('REQUEST_URI');
		$this->method         = $request->server->get('REQUEST_METHOD');
		$this->routes['GET']  = [];
		$this->routes['POST'] = [];
    }


    /**
     * Make a route available to the router.
     *
     * @param string $methods    A string of request methods seperated
     *                           by a "|" character.
     *
     * @param string $pattern    The url pattern that applies to this route.
     *
     * @param mixed  $fn         Closure or "nameController@method" can be used
     *                           for the defined route.
     *
     * @return array.
     */
    public function addRoute($methods, $pattern, $fn)
    {
        $this->loadRoutes($methods, $pattern, $fn);
    }

    /**
     * Load all of the defined routes into the internal routes array.
     *
     *
     * @param string $methods    A string of request methods seperated
     *                           by a "|" character.
     *
     * @param string $pattern    The url pattern that applies to this route.
     *
     * @param mixed  $fn         Closure or "nameController@method" can be used
     *                           for the defined route.
     *
     * @return array.
     */
    private function loadRoutes($methods, $pattern, $fn) : array
    {
        $request_methods = explode('|', strtoupper($methods));

        foreach($request_methods as $method)
        {
            $this->routes[$method][$pattern] = $fn;
        }

        return $this->routes;
    }

    /**
     * Add GET route.
     *
     * @param string $path    The path of the route
     *
     * @param mixed  $fn         Closure or "nameController@method" can be used
     *                           for the defined route.
     *
     * @return array.
     */
	public function get($path, callable $fn)
	{
		if( ! array_key_exists($path, $this->routes['GET']))
		{
			$this->routes['GET'][$path]  = $fn;
		}
	}

    /**
     * Try to match a defined route with the current REQUEST_URI.
     *
     * @param array $routes    The routes for the current REQUEST_METHOD.
     *
     * @return bool.
     */
    private function matchedRoute(array $routes) : bool
    {
        // Check if a pattern matches using a regex.
        foreach($routes as $pattern => $fn)
        {
            $pattern = preg_replace("/\//", "", $pattern);
            if(preg_match("~$pattern$~", $this->uri, $matches) && !$this->route_found)
            {
                if($matches[0] == trim($this->uri,"/"))
                {
                    $this->route_found = true;

                    // Check if action is a closure or a string with the format "controller@action".
                    $this->matchAction($fn);

                    return true;
                }
            }
        }

        return false;
    }


    /**
     * Match whether the current routes supplied action is a closure or a string
     * in the format "controller@action".
     *
     * @param  mixed $action    Closure or "controller@action" string that will be
     *                          used for the current route.
     *
     * @return bool.
     */
    private function matchAction($action) : bool
    {
        if(is_int($action) || is_array($action)) return false;

        if(is_callable($action))
        {
            $action();
            return true;

        }else if(is_string($action))
        {
            $sections   = explode("@", $action);
            $namespace  = "LDH\\";
            $controller = $namespace . $sections[0];
            $controller = new $controller;
            $action     = $sections[1];

            $controller->$action();
            return true;
        }

        return false;
    }

	/**
	 * Executes the router.
	 *
	 * Checks whether the incoming request URI matches any of the
	 * routes defined within the router instance and dispatches
	 * the corresponding handler.
	 *
	 * @throws \Exception If no routes have been defined.
	 * @throws \Exception If no matching route is found.
	 *
	 * @return bool True on successful route dispatch.
	 */
    public function run()
    {
		if(empty($this->routes[$this->method]))
			throw new \Exception('No routes have been defined yet!');

        $routes  = $this->routes[$this->method];

        if($this->matchedRoute($routes))
        {
            return true;
        }else
        {
            throw new \Exception("Route for $this->uri could not be found");
        }
    }


    /**
     * Get a list of all defined routes.
     *
     * @return array.
     */
    public function getRoutes() : array
    {
        return $this->routes;
    }
}
