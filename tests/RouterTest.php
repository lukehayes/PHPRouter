<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use LDH\Router;

final class RouterTest extends TestCase
{
    private $router;

    public function setUp() : void
    {
        $this->router = new Router();
    }

	public function testCanGetRoutes()
	{
		$this->assertIsArray(
			$this->router->getRoutes()
		);
	}

	public function testHasGetRouteKey()
	{
		$this->assertArrayHasKey(
			'GET',
			$this->router->getRoutes()
		);
	}

	public function testHasPostRouteKey()
	{
		$this->assertArrayHasKey(
			'POST',
			$this->router->getRoutes()
		);
	}
}
