# Qlurk, the Plurk API library
`Qlurk` is a simple [Plurk API](https://www.plurk.com/API) library written in PHP

```php
$qlurk = new \Qlurk\ApiClient(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
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

