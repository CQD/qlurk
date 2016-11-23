<?php

namespace Qlurk\APP;
use Qlurk\ApiClient;
use Qlurk\APP;
use Qlurk\Data\User;

/**
 * API request/response handler for Users
 * @TODO Fill me
 */
class Users
{
    private $app;

    public function __construct(APP $app)
    {
        $this->app = $app;
    }

    ////////////////////////////////////////////////////////

    /**
     * @return User
     */
    public function me()
    {
        $data = $this->app->call('/APP/Users/me');
        $me = new User($data['body'], $this->app);
        return $me;
    }
}
