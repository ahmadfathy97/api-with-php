<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, authorization, Access-Control-Allow-Methods, X-Requested-With ');

    include_once '../config/database.php';
    include_once '../modules/post.php';
    
    $db = new Database();
    $connection = $db->connect();

    $post = new Post($connection);

    $data = json_decode(file_get_contents('php://input'));
    $post->title = $data->title;
    $post->body = $data->body;
    $post->category_id = $data->category_id;
    $post->id = $_GET['id'] ? $_GET['id'] : die();

    if($post->update()){
        echo json_encode(array(
            'msg'=> 'post updated'
        ));
    } else {
        echo json_encode(array(
            'msg'=> 'post not updated'
        ));
    }
?>