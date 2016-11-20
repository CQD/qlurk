<?php
namespace Qlurk;

use GuzzleHttp\Client as HttpClient;

/**
 * Class ApiClient
 *
 * This class is for accessing Plurk API 2.0 (which uses OAuth 1.0a)
 *
 * @TODO Need to support access_token/access_secret renewal
 *
 * @package Qlurk
 */
class ApiClient
{
    private $http_client;

    private $options = [
        'base_uri' => 'https://www.plurk.com',
    ];

    public function __construct($consumer_key, $consumer_secret, $token_key, $token_secret)
    {
        $this->options['consumer_key'] = $consumer_key;
        $this->options['consumer_secret'] = $consumer_secret;
        $this->options['token_key'] = $token_key;
        $this->options['token_secret'] = $token_secret;
    }

    public function call($path, $params = [])
    {
        $request = new Request('POST', $path, $params);
        $request = $this->sign($request);
        return $this->POST($request);
    }

    ///////////////////////////////////////////////

    private function POST(Request $request)
    {
        $resp = $this->getHttpClient()->request('POST', $request->path, [
            'headers' => $request->headers,
            'form_params' => $request->params,
            'http_errors' => false,
        ]);

        $status_code = (int) $resp->getStatusCode();
        return [
            'success' => (200 === $status_code),
            'status' => $status_code,
            'body' => json_decode((string) $resp->getBody(), true),
        ];
    }

    private function sign(Request $request)
    {
        $oauth_params = [
            'oauth_consumer_key' => $this->consumer_key,
            'oauth_timestamp' => time(),
            'oauth_nonce' => $this->genRandomString(),
            'oauth_version' => '1.0',
            'oauth_token' => $this->token_key,
            'oauth_signature_method' => 'HMAC-SHA1',
        ];

        $data_to_sign = sprintf(
            '%s&%s&%s',
            rawurlencode($request->method),
            rawurlencode($this->base_uri . $request->path),
            rawurlencode($this->normalizeParameters($request->params, $oauth_params))
        );

        $signing_key = sprintf(
            '%s&%s',
            rawurlencode($this->consumer_secret),
            rawurlencode($this->token_secret)
        );

        $signature = base64_encode(hash_hmac('sha1', $data_to_sign, $signing_key, true));
        $oauth_params['oauth_signature'] = $signature;

        $oauth_header_string = 'OAuth realm=""';
        foreach ($oauth_params as $key => $val) {
            $oauth_header_string .= sprintf(', %s="%s"', $key, rawurlencode($val));
        }

        $request->headers['Authorization'] = $oauth_header_string;

        return $request;
    }

    private function normalizeParameters($params, $oauth_params)
    {
        $params = array_merge($params, $oauth_params);

        ksort($params);
        $string = "";
        foreach ($params as $key => $val) {
            $string .= sprintf('%s=%s&', rawurlencode($key), rawurlencode($val));
        }

        return substr($string, 0, -1);
    }

    private function genRandomString($len = 8, $chars = null)
    {
        $chars = $chars ?: '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pool_size = strlen($chars);
        $nonce = '';
        $rands = unpack("N{$len}", openssl_random_pseudo_bytes($len * 4));
        foreach ($rands as $rand) {
            $nonce .= $chars[$rand % $pool_size];
        }
        return $nonce;
    }
    ///////////////////////////////////////////////

    public function __get($key)
    {
        if (isset($this->options[$key])) {
            return $this->options[$key];
        }
    }

    public function setBaseUri($base_uri)
    {
        $this->options['base_uri'] = $base_uri;
    }

    private function getHttpClient()
    {
        if (!$this->http_client) {
            $this->http_client = new HttpClient([
                'base_uri' => $this->base_uri,
            ]);
        }

        return $this->http_client;
    }
}