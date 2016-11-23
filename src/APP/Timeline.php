<?php

namespace Qlurk\APP;
use Qlurk\APP;
use Qlurk\Data\Plurk;
use Qlurk\Data\User;

/**
 * API request/response handler for Timeline
 * @TODO Fill me
 */
class Timeline
{
    private $app;

    public function __construct(APP $app)
    {
        $this->app = $app;
    }

    /////////////////////////////////////////////////////////////////////////

    public function getPublicPlurks($params)
    {
        $data = $this->app->call('/APP/Timeline/getPublicPlurks', $params)['body'];
        $data['plurks'] = Plurk::makeArray($data['plurks'], $this->app);
        $data['plurk_users'] = User::makeArray($data['plurk_users'], $this->app);
        return $data;
    }

}
