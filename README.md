# Qlurk，噗浪 API PHP 函式庫

![Build result](https://github.com/CQD/qlurk/actions/workflows/e2e_test.yaml/badge.svg)

`Qlurk` 是個用 PHP 寫成的簡單 [Plurk API](https://www.plurk.com/API) 函式庫

```php
$qlurk = new \Qlurk\ApiClient(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
$resp = $qlurk->call('/APP/Timeline/getPlurk', ['plurk_id' => 134]);
var_dump($resp);
```

```php
// 取得 request token
$qlurk = new \Qlurk\ApiClient(CONSUMER_KEY, CONSUMER_SECRET);
$oauth = new Oauth($qlurk);

$r = $oauth->getRequestToken();
$token = $r['oauth_token'];
$tokenSecret = $r['oauth_token_secret'];

// 把 $token 跟 $tokenSecret 存到某處...

// 使用者在介面上授權之後
// 會透過 callback 帶回 oauth_token 跟 oauth_verifier

// 將 request token 換成 access token
$qlurk = new \Qlurk\ApiClient(CONSUMER_KEY, CONSUMER_SECRET);
$oauth = new Oauth($qlurk);
$tokenSecret = getSecretFromStorage($token);
$oauth->getAccessToken($verifier, $token, $tokenSecret);

$resp = $qlurk->call('/APP/Timeline/getPlurk', ['plurk_id' => 134]);
var_dump($resp);
```

套件靈感來自於 [clsung](https://github.com/clsung) 的 [plurkoauth](https://github.com/clsung/plurkoauth)

# 系統需求
- PHP 5.6 ~ 8.1
- GuzzleHttp 6.x 或 7.x

# 安裝

`qlurk` 可以用 composer 安裝

```
$ composer require qlurk/qlurk
```

# 參考閱讀
- [Plurk API 官方文件](https://www.plurk.com/API)

