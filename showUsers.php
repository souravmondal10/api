<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/config.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Content-type: application/json');
$source = 'database';
if (isset($_GET['source'])) {
    $source = $_GET['source'];
}

if ($source == 'database') {
    echo retrive_database_users();
    die;
}

echo retrive_redis_users();
die;

function retrive_database_users()
{
    $con = connectDatabase();
    if (!$con) {
        return "Can not connect to database";
    }
    $sql = "SELECT * FROM users";
    $result = mysqli_query($con, $sql);
    // Fetch all
    $processed_results = mysqli_fetch_all($result, MYSQLI_ASSOC);
    // Free result set
    mysqli_free_result($result);
    mysqli_close($con);
    return json_encode($processed_results);
}

function retrive_redis_users()
{
    $redis = new Redis();
    $redis->connect(REDIS_HOST, REDIS_PORT);
    $allKeys = $redis->keys('*');
    $allUsersData = [];
    foreach ($allKeys as $singleKeys) {
        $singleUserData = json_decode($redis->get($singleKeys));
        $userId = str_replace('user_object_', '', $singleKeys);
        $allUsersData[] = [
            'userId' => $userId,
            'useremail' => $singleUserData->useremail,
            'username' => $singleUserData->username
        ];
    }
    return json_encode($allUsersData);
}

function connectDatabase()
{
    $con = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE, MYSQL_PORT);
    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        return false;
    }
    return $con;
}
