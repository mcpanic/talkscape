<?php
include "conn.php";
include "class.Label.php";
$conn->query("SET NAMES utf8");
$success = true;
$html = "";

if ($_POST["action"] == "create"){
	try {
	  $stmt = $conn->prepare('INSERT INTO labels (talk_id, title, start_at, detail) VALUES(:talk_id, :title, :start_at, :detail)');
	  $stmt->bindParam(':talk_id', $_POST["talk_id"], PDO::PARAM_INT);
	  $stmt->bindParam(':title', $_POST["title"], PDO::PARAM_STR);
	  $stmt->bindParam(':start_at', $_POST["start_at"], PDO::PARAM_STR);
	  $stmt->bindParam(':detail', $_POST["detail"], PDO::PARAM_STR);
	  $stmt->execute();
	  if ($stmt->rowCount() != 1)
	  	$success = false;
	  else {
	  	$stmt2 = $conn->prepare("SELECT * from labels WHERE id=:id");  
	    $stmt2->setFetchMode(PDO::FETCH_CLASS, "Label");
	    $stmt2->execute(array('id' => $conn->lastInsertId()));  
	    while($obj = $stmt2->fetch()) {          
	        $label = $obj;
	    }  
	    $html = $label->getAdminHTML();	    
	    $json = array(
	      "id"=>$label->id,
	      "start_at"=>$label->start_at,
		  "html"=>$html,
		  "success"=>$success
		);
	  }
	} catch(PDOException $e) {
		$success = false;
	  	file_put_contents('log/database.log',  date("Y-m-d H:i:s") . " " . $e->getMessage() . "\n", FILE_APPEND);  
	}

} else if ($_POST["action"] == "update"){
	try {
	  $stmt = $conn->prepare('UPDATE labels SET title=:title, start_at=:start_at, detail=:detail WHERE id=:id');
	  $stmt->bindParam(':id', $_POST["id"], PDO::PARAM_INT);
	  $stmt->bindParam(':title', $_POST["title"], PDO::PARAM_STR);
	  $stmt->bindParam(':start_at', $_POST["start_at"], PDO::PARAM_STR);
	  $stmt->bindParam(':detail', $_POST["detail"], PDO::PARAM_STR);	  
	  $stmt->execute();

	  // not checking for rowCount == 1, because if duplicate info was inserted for save, it will return 0.
	  	$stmt2 = $conn->prepare("SELECT * from labels WHERE id=:id");  
	    $stmt2->setFetchMode(PDO::FETCH_CLASS, "Label");
	    $stmt2->execute(array('id' => $_POST["id"]));  
	    while($obj = $stmt2->fetch()) {          
	        $label = $obj;
	    }  
	    $html = $label->getAdminHTML();
	    $json = array(
	      "id"=>$label->id,
	      "start_at"=>$label->start_at,
		  "html"=>$html,
		  "success"=>$success
		);	    
	} catch(PDOException $e) {
		$success = false;
	  	file_put_contents('log/database.log',  date("Y-m-d H:i:s") . " " . $e->getMessage() . "\n", FILE_APPEND);  
	}

} else if ($_POST["action"] == "delete"){
	try {
	  $stmt = $conn->prepare('DELETE FROM labels WHERE id=:id');
	  $stmt->execute(array(
	    'id' => $_POST["id"]
	  ));
	  if ($stmt->rowCount() != 1)
	  	$success = false;
	  else {
	  	$json = array(
		  "success"=>$success
		);
	  }
	} catch(PDOException $e) {
		$success = false;
	  	file_put_contents('log/database.log',  date("Y-m-d H:i:s") . " " . $e->getMessage() . "\n", FILE_APPEND);  
	}
}


echo json_encode($json);

?>