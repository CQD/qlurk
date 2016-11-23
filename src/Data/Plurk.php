<?php

namespace Qlurk\Data;


use Qlurk\APP;

class Plurk
{
    public $plurk_id;
    public $qualifier;
    public $qualifier_translated;
    public $is_unread;
    public $plurk_type;
    public $user_id;
    public $owner_id;
    public $posted;
    public $no_comments;
    public $content;
    public $content_raw;
    public $response_count;
    public $responses_seen;
    public $limited_to;
    public $favorite;
    public $favorite_count;
    public $favorers;
    public $replurkable;
    public $replurked;
    public $replurker_id;
    public $replurkers_count;
    public $replurkers;

    private $app;

    public function __construct($data, APP $app)
    {
        foreach ($data as $key => $val) {
            $this->$key = $val;
        }

        $this->app = $app;
    }

    public static function makeArray($array, APP $app)
    {
        $rows = [];
        foreach ($array as $row) {
            $rows[] = new Plurk($row, $app);
        }

        return $rows;
    }

}