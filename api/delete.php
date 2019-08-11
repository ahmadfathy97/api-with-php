<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, authorization, Access-Control-Allow-Methods, X-Requested-With ');

    include_once '../config/database.php';
    include_once '../modules/post.php';
    
    $db = new Database();
    $connection = $db->connect();

    $post = new Post($connection);
    $post->id = $_GET['id'] ? $_GET['id'] : die();

    if($post->delete()){
        echo json_encode(array(
            'msg'=> 'post deleted'
        ));
    } else {
        echo json_encode(array(
            'msg'=> 'post not deleted'
        ));
    }
?>