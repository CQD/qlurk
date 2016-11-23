<?php

namespace Qlurk\Data;

use Qlurk\APP;

class User
{
    public $id;
    public $nick_name;
    public $display_name;
    public $premium;
    public $has_profile_image;
    public $avatar;
    public $location;
    public $default_lang;
    public $date_of_birth;
    public $bday_privacy;
    public $full_name;
    public $gender;
    public $karma;
    public $recruited;
    public $relationship;

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
            $rows[$row['id']] = new User($row, $app);
        }

        return $rows;
    }

    /**
     * @param array $params
     * @return \Qlurk\Data\Plurk[]
     */
    public function publicPlurks($params = [])
    {
        $params['user_id'] = $this->id;
        return $this->app->timeline->getPublicPlurks($params)['plurks'];
    }
}