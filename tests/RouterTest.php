<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use LDH\Router;

final class RouterTest extends TestCase
{
    private $router;
	private $server = [];

    public function setUp() : void
    {
		$SERVER = [
			'REQUEST_URI'    => '/',
			'REQUEST_METHOD' => 'GET'
		];

		$this->router = new Router($SERVER);
    }

	public function testCanAddGetRoute()
	{
		$this->router->get('/', function() {});

		$this->assertArrayHasKey(
			'/',
			$this->router->getRoutes()['GET'],
			'Route does not exist for "\" path'
		);
	}

	public function testCanGetRoutes()
	{
		$this->assertIsArray(
			$this->router->getRoutes()
		);
	}
}
