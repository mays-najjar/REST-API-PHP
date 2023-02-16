<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Category.php';


// DB stuff
$database = new Database();
$db = $database->connect();

// Category object 
$category = new Category($db);

// Get data from user
$data = json_decode(file_get_contents("php://input"));
$category->id = $data->id;

// Delete post
if($category->delete()) {
  echo json_encode(
    array('message' => 'Category deleted')
  );
} else {
  echo json_encode(
    array('message' => 'Category not deleted')
  );
}
?> 