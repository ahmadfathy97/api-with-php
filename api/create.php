<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, authorization, Access-Control-Allow-Methods, X-Requested-With ');

    include_once '../config/database.php';
    include_once '../modules/post.php';
    
    $db = new Database();
    $connection = $db->connect();

    $post = new Post($connection);

    $data = json_decode(file_get_contents('php://input'));
    $post->title = $data->title;
    $post->body = $data->body;
    $post->author_id = $data->author_id;
    $post->created_at = date("Y-m-d");
    $post->category_id = $data->category_id;

    if($post->create()){
        echo json_encode(array(
            'msg'=> 'post created'
        ));
    } else {
        echo json_encode(array(
            'msg'=> 'post not created'
        ));
    }
?>