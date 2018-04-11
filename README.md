# Qlurk, the Plurk API library

[![Build result](https://api.travis-ci.org/CQD/qlurk.svg?branch=master)](https://travis-ci.org/CQD/qlurk)

`Qlurk` is a simple [Plurk API](https://www.plurk.com/API) library written in PHP

```php
$qlurk = new \Qlurk\ApiClient(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
$resp = $qlurk->call('/APP/Timeline/getPlurk', ['plurk_id' => 134]);
var_dump($resp);
```

```php
// ask for request token
$qlurk = new \Qlurk\ApiClient(CONSUMER_KEY, CONSUMER_SECRET);
$oauth = new Oauth($qlurk);

$r = $oauth->getRequestToken();
$token = $r['oauth_token'];
$tokenSecret = $r['oauth_token_secret'];

// save $token and $tokenSecret to somewhere...

// auth via user interaction
// call back with oauth_token and oauth_verifier

// exchange request token for access token
$qlurk = new \Qlurk\ApiClient(CONSUMER_KEY, CONSUMER_SECRET);
$oauth = new Oauth($qlurk);
$tokenSecret = getSecretFromStorage($token);
$oauth->getAccessToken($verifier, $token, $tokenSecret);

$resp = $qlurk->call('/APP/Timeline/getPlurk', ['plurk_id' => 134]);
var_dump($resp);
```

This package is inspired by [clsung](https://github.com/clsung)'s [plurkoauth](https://github.com/clsung/plurkoauth)

# Installation

`qlurk` can be installed with composer.

```
$ composer require qlurk/qlurk
```

# Reference
- [Official Plurk API document](https://www.plurk.com/API)

