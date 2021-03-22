<?php

class HttpMessage
{
    private string $body;

    /**
     * @var array<string,string>
     */
    private array $headers;

    /**
     * @param array<string,string> $headers
     */
    public function __construct(string $body, array $headers)
    {
        $this->body = $body;
        $this->headers = $headers;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return array<string,string>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}
