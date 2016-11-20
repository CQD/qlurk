<?php
namespace Qlurk;

/**
 *
 * @property \Qlurk\APP\Alerts       alerts
 * @property \Qlurk\APP\Blocks       blocks
 * @property \Qlurk\APP\Cliques      cliques
 * @property \Qlurk\APP\Emoticons    emoticons
 * @property \Qlurk\APP\FriendsFans  friendsFans
 * @property \Qlurk\APP\PlurkSearch  plurksearch
 * @property \Qlurk\APP\PlurkTop     plurktop
 * @property \Qlurk\APP\Polling      polling
 * @property \Qlurk\APP\Profile      profile
 * @property \Qlurk\APP\Realtime     realtime
 * @property \Qlurk\APP\Responses    responses
 * @property \Qlurk\APP\Timeline     timeline
 * @property \Qlurk\APP\UserSearch   usersearch
 * @property \Qlurk\APP\Users        users
 */
class APP
{
    private $api_client;
    private $handlers;

    private $class_names = [
        "Alerts",
        "Blocks",
        "Cliques",
        "Emoticons",
        "FriendsFans",
        "PlurkSearch",
        "PlurkTop",
        "Polling",
        "Profile",
        "Realtime",
        "Responses",
        "Timeline",
        "UserSearch",
        "Users",
    ];

    public function __construct($consumer_key, $consumer_secret, $token_key, $token_secret)
    {
        foreach ($this->class_names as $class_name) {
            $lower_class_name = strtolower($class_name);
            $this->handlers[$lower_class_name] = false;
            $this->class_names[$lower_class_name] = $class_name;
            unset($this->class_names[$class_name]);
        }
        $this->api_client = new ApiClient($consumer_key, $consumer_secret, $token_key, $token_secret);
    }

    public function __get($key)
    {
        if (!isset($this->handlers[$key])) {
            throw new \Exception("{$key} is not available!");
        }

        $handler = $this->handlers[$key];

        if (!$handler) {
            $class_name = sprintf("\\Qlurk\\APP\\%s", $this->class_names[$key]);
            $handler = new $class_name($this->api_client);
            $this->handlers[$key] = $handler;
        }

        return $handler;
    }
}
