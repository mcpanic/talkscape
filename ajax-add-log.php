<?php
//print_r($_POST);
/* example format
    [logger] => [default]
    [timestamp] => 1345848273272
    [level] => INFO
    [url] => http://localhost:8888/labeler/index.php
    [message] => [object Object]
    [layout] => HttpPostDataLayout

    message format: JSON
    - talk_id
    - user_id
    - action
    - object type
    - object id
*/

include "conn.php";

$conn->query("SET NAMES utf8");
$success = true;

try {
  $stmt = $conn->prepare('INSERT INTO logs (logger, time_logged, level, url, message) VALUES (:logger, :time_logged, :level, :url, :message)');
  $stmt->bindParam(':logger', $_POST["logger"], PDO::PARAM_STR);
  $stmt->bindParam(':time_logged', $_POST["timestamp"], PDO::PARAM_STR);
  $stmt->bindParam(':level', $_POST["level"], PDO::PARAM_STR);
  $stmt->bindParam(':url', $_POST["url"], PDO::PARAM_STR);
  $stmt->bindParam(':message', $_POST["message"], PDO::PARAM_STR);

  $stmt->execute();
//  if ($stmt->rowCount() != 1)
//    $success = false;

} catch(PDOException $e) {
    $success = false;
    file_put_contents('log/database.log',  date("Y-m-d H:i:s") . " " . $e->getMessage() . "\n", FILE_APPEND);  
}
?>