<?php

//namespace ProcessMaker\Packages\Connectors\DataSources\Seeds\code;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class BusinessRules
{
    public function main($data)
    {
        return ["a" => eval("return " . $this->api('GET', '/businessrules', [])[0] . ";")];

    }

    private function call($method, $url, $headers, $body)
    {
        $client = new Client([
            'curl' => [CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYHOST => 0],
            'allow_redirects' => false,
            'cookies' => true,
            'verify' => false
        ]);
        $request = new Request($method, $url, $headers, $body);
        return $client->send($request);
    }

    private function api($method, $route, $body = null)
    {
        $headers = $this->getApiHeaders();
        $response = $this->call($method, getenv('HOST_URL') . '/api/1.0' . $route, $headers, isset($body) ? json_encode($body) : '');
        $content = $response->getBody()->getContents();
        return json_decode($content, true);
    }

    private function getApiHeaders()
    {
        $token = getenv('API_TOKEN');
        return [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}

return (new BusinessRules)->main($data, $config);
