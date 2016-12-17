<?php
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    private $client;

    public function setUp()
    {
        $this->client = new Client();
    }

    public function test_normarlRequest()
    {
        $response = $this->client->get('http://weblog-1.github.io/');
        $this->assertTrue(
            is_int(
                strpos($response->getBody()->__toString(), '<title>si dimentica subito</title>')
            )
        );
        $types = $response->getHeader('Content-Type');
        $this->assertEquals('text/html; charset=utf-8', $types[0]);
    }

    public function test_stubRequest()
    {
        $client = $this->getStubClient();
        $response = $client->get('http://weblog-1.github.io/');
        $parsed = json_decode($response->getBody()->__toString());
        $this->assertEquals('OK', $parsed->test);
        $types = $response->getHeader('Content-Type');
        $this->assertEquals('application/json', $types[0]);
    }

    private function getStubClient()
    {
        $mock = new MockHandler([new Response(200, ['Content-Type' => 'application/json'], '{"test":"OK"}')]);
        $handler = HandlerStack::create($mock);
        return new Client(['handler' => $handler]);
    }
}