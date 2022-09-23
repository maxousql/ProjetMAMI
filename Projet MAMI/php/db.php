<?php
$ip = "maximenlylt.mysql.db";
$username = "maximenlylt";
$password = "Maxime140902";

$db_name = "maximenlylt";

try {
    $db = new PDO('mysql:host='.$ip.';dbname='.$db_name.';charset=utf8mb4', ''.$username.'', ''.$password.'');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>