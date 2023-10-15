<?php
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset=utf-8");
include './/conn_db.php';

$data = json_decode(file_get_contents("php://input"));

if ($_SERVER['REQUEST_METHOD'] !== 'PATCH'){
    echo json_encode(array("status" =>"error"));
    die();
}

try {
    $stmt = $conn->prepare("UPDATE  user SET fname=?, lname=?, email=?, address=? WHERE id=?");
    $stmt->bindParam(1, $data->fname);
    $stmt->bindParam(2, $data->lname);
    $stmt->bindParam(3, $data->email);
    $stmt->bindParam(4, $data->address);
    $stmt->bindParam(5, $data->id);

    if ($stmt->execute()){
        echo json_encode(array('status' => "ok"));
    }else{
        echo json_encode(array('status' => "error"));
    }
    $conn = null;
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

?>