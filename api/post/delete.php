<?php 
// headers 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers:Access-Control-Allow-Methods, Content-Type , Access-Control-Allow-Headers ');

include_once('../../config/Database.php');
include_once('../../config/Tools.php');
include_once('../../models/Post.php');

//db stuff 
$database = new Database();
$db = $database->connect();

// Post object 
$post = new Post($db);

$data = json_decode(file_get_contents('php://input'));
$post->id = $data->id;

if($post->delete()){
    echo json_encode(
        array('message' => 'Post Deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Post not Deleted')
    );
}
?>

