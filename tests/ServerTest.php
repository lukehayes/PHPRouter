<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use LDH\Server;

final class ServerTest extends TestCase
{
    private $server;

    public function setUp() : void
    {
        $this->server = new Server();
    }

	public function test_can_get_request_uri() : void
	{
		$this->assertEquals(Server::$REQUEST_URI, '/');
	}

	public function test_can_get_request_method() : void
	{
		$this->assertEquals(Server::$REQUEST_METHOD, 'GET');
	}
}
