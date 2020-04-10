<?php

namespace Norival\Spine\Core;

class Request
{
    private $body;
    private $method;
    private $parameters;
    private $uri;

    public function __construct()
    {
        $this->body       = [];
        $this->method     = '';
        $this->parameters = [];
        $this->uri        = '';
    }

    public function initialize($server = [], $post = [])
    {
        $this->method = array_key_exists('REQUEST_METHOD', $server) ? $server['REQUEST_METHOD'] : '';

        if (array_key_exists('REQUEST_URI', $server)) {
            $this->uri = explode('?', $server['REQUEST_URI'])[0];
        }

        if (array_key_exists('QUERY_STRING', $server) && !empty($server['QUERY_STRING'])) {
            foreach (explode('&', $server['QUERY_STRING']) as $chunk) {
                $param = explode('=', $chunk);
                $this->parameters[$param[0]] = $param[1];
            }
        }

        if (!empty($post)) {
            $this->body = $post;
        }

        return $this;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getUri(): string
    {
        return $this->uri;
    }
}
