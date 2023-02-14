<?php 

// Headers 
header('Access-Control-Allow-Origin: *');
header('Type-Content: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Type-Content, Access-Control-Allow-Headers, Authorization, X-Requested-With');
// files 
require_once('../../config/Database.php');
require_once('../../config/Tools.php');
require_once('../../models/Post.php');
// db stuff
$database = new Database();
$db = $database->connect();

$post = new Post($db);

$data = json_decode(file_get_contents('php://input'));
$post->id = $data->id;
$post->title = $data->title;
$post->author = $data->author;
$post->category_id = $data->category_id;

if ($post->update()){
    echo json_encode(
        array(
            'message' => 'Post updeted'
        )
    );

} else{
    echo json_encode(
        array(
            'message' => 'Post not updated'
        )
    );
}
?>
