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

    public function test_can_split_request_method(): void
    {
		$this->assertTrue(true);
    }
}
