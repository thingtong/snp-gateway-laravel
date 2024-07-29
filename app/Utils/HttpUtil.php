<?php

namespace App\Utils;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class HttpUtil
{
    private $client;

    private $url;

    private $method;

    private $options;

    public function __construct()
    {
        $this->client = new Client();
    }

    public static function get($url): self
    {
        $self = new HttpUtil();
        $self->method = 'GET';
        $self->url = $url;

        return $self;
    }

    public static function post($url): self
    {
        $self = new HttpUtil();
        $self->method = 'POST';
        $self->url = $url;

        return $self;
    }

    public static function put($url): self
    {
        $self = new HttpUtil();
        $self->method = 'PUT';
        $self->url = $url;

        return $self;
    }

    public static function delete($url): self
    {
        $self = new HttpUtil();
        $self->method = 'DELETE';
        $self->url = $url;

        return $self;
    }

    public function headers($headers): self
    {
        $this->options['headers'] = $headers;

        return $this;
    }

    public function formParams($params): self
    {
        $this->options['form_params'] = $params;

        return $this;
    }

    public function json($data): self
    {
        $this->options['json'] = $data;

        return $this;
    }

    public function query($params): self
    {
        $this->options['query'] = $params;

        return $this;
    }

    public function multipart($data): self
    {
        $this->options['multipart'] = $data;

        return $this;
    }

    public function send(): array
    {
        try {
            $response = $this->client->request(
                method: $this->method,
                uri: $this->url,
                options: $this->options
            );
            $contents = json_decode($response->getBody()->getContents(), true);

            return [$contents, null, $response->getStatusCode()];
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return [$e->getResponse()->getBody()->getContents(), null, $e->getCode()];
            } else {
                return [$e->getMessage(), null, $e->getCode()];
            }
        }
    }
}
