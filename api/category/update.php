<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization ');

include_once('../../config/Database.php');
include_once('../../models/Category.php');
$database = new Database();
$db = $database->connect();

$category = new Category($db);

$data = json_decode(file_get_contents('php://input'));
$category->name = $data->name;
$category->id = $data->id;

if($category->update()){
    echo json_encode(
        array('message' => 'Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Not Updated')
    );
}
?>