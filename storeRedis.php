<?php
require_once __DIR__ . '/config.php';
if (!isset($_POST['username'])) {
    die('nothing to process');
}
//Connecting to Redis server on localhost
$redis = new Redis();
$redis->connect(REDIS_HOST, REDIS_PORT);
echo "Connected to redis server successfully";

if (empty($_POST['username']) || empty($_POST['useremail'])) {
    die('name and email both are required');
}

$username = $_POST['username'];
$useremail = $_POST['useremail'];
$userID = time();
//set the data in redis string
$redis->set("user_object_" . $userID, json_encode(['username' => $username, 'useremail' => $useremail]));

echo PHP_EOL . 'Data stored successfully';


