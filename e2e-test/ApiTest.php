<?php
namespace Qlurk;

use PHPUnit\Framework\TestCase;
use PHPUnit\Runner\Version as PHPUnitVersion;

class ApiTest extends TestCase
{
    private static $apiClient;

    public static function setUpBeforeClass()
    {
        static::$apiClient = new ApiClient(CONSUMER_KEY, CONSUMER_SECRET, TOKEN_KEY, TOKEN_SECRET);
    }

    /**
     * @dataProvider apiProvider
     */
    public function testApi($path, $expected, $params = [])
    {
        if (is_array($expected)) {
            $result = static::$apiClient->call($path, $params);
            foreach ($expected as $key => $expectedValue) {
                $this->assertEquals($expectedValue, $this->deepValue($key, $result));
            }
        } elseif (is_callable($expected)) {
            $expected($params);
        } else {
            throw new \Exception("Can not verify result");
        }
    }

    public function apiProvider()
    {
        return [
            [
                '/APP/echo',
                ['data' => 'miew miew miew'],
                ['data' => 'miew miew miew']

            ],
            [
                '/APP/Profile/getPublicProfile',
                [
                    'plurks.0.owner_id' => 14533660,
                    'user_info.uid' => 14533660,
                    'user_info.nick_name' => 'qlurk_ci',
                ],
                ['user_id' => 14533660],
            ],
            [
                '/APP/Timeline/getPlurk',
                [
                    'plurk.plurk_id' => 1372880647,
                    'plurk.content' => 'second plurk',
                    'user.id' => 14533660,
                    'user.nick_name' => 'qlurk_ci',
                ],
                ['plurk_id' => 1372880647]
            ],
        ];
    }

    private function deepValue($key, $v)
    {
        $keys = explode('.', $key);
        foreach ($keys as $key) {
            $v = $v[$key];
        }
        return $v;
    }
}
