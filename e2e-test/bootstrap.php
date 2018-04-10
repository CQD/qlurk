<?php
call_user_func(function(){
$envVars = [
    'CONSUMER_KEY',
    'CONSUMER_SECRET',
    'TOKEN_KEY',
    'TOKEN_SECRET',
];
foreach ($envVars as $envVar) {
    $v = getenv($envVar);
    if (!$v) {
        echo "Following enviroment variable should be set to run E2E tests: ", implode(', ', $envVars), "\n";
        die(-1);
    }
    define($envVar, $v);
}
});
