<?php
namespace Qlurk;

/**
 * Handles OAUTH flow
 */
class Oauth
{
    private $apiClient;

    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function getRequestToken()
    {
        $r = $this->apiClient->call('/OAuth/request_token');
        $token = $r['oauth_token'];
        $secret = $r['oauth_token_secret'];
        $this->apiClient->setAccessToken($token, $secret);
        return $r;
    }

    public function getAuthUrl($params = [])
    {
        return $this->getRealAuthUrl($params, 'https://www.plurk.com/OAuth/authorize');
    }

    public function getMobileAuthUrl($params = [])
    {
        return $this->getRealAuthUrl($params, 'https://www.plurk.com/m/authorize');
    }

    private function getRealAuthUrl($params, $endpoint)
    {
        if (! $token = $this->apiClient->token_key) {
            $token = $this->getRequestToken()['oauth_token'];
        }
        $params['oauth_token'] = $token;

        return sprintf("%s?%s", $endpoint, http_build_query($params));
    }

    public function getAccessToken($verifier, $accessToken = null, $accessTokenSecret= null)
    {
        $token = $accessToken ?: $this->apiClient->token_key;
        $secret = $accessTokenSecret ?: $this->apiClient->token_secret;
        $this->apiClient->setAccessToken($token, $secret);

        $r = $this->apiClient->call('/OAuth/access_token', [
            'oauth_verifier' => $verifier,
            'oauth_token' => $this->apiClient->token_key,
        ]);
        $this->apiClient->setAccessToken($r['oauth_token'], $r['oauth_token_secret']);
        return $r;
    }

    public function checkTokenValid()
    {
        try {
            $r = $this->apiClient->call('/APP/Users/me');
            return is_array($r) && (!!$r);
        } catch (\Exception $e) {
            return false;
        }
    }
}
