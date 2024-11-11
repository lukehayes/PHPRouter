<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use PHPMin\Router;

final class RouterTest extends TestCase
{
    private $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function testCanSplitRequestMethods(): void
    {
        $this->assertEqual(
            $this->router->defineRoutes("GET|POST|PATCH"),
            ["GET", "POST", "PATCH"]
        );
    }
}
