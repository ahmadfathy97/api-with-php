<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../config/database.php';
    include_once '../modules/post.php';
    
    $db = new Database();
    $connection = $db->connect();

    $post = new Post($connection);

    $post->id = isset($_GET['id']) ? $_GET['id'] : die();
    $result = $post->readOne();
    $num = $result->rowCount();
    $row = $result->fetch(PDO::FETCH_ASSOC);
    if($num >0){
        $post_obj = array();
        $post_obj['data'] = array(
            'id' => $row['id'],
            'title' => $row['title'],
            'body' => html_entity_decode($row['body']),
            'created_at' => $row['created_at'],
            'author' => $row['username'],
            'category_name' => $row['category_name']
        );
        print_r(json_encode($post_obj));
    } else {
        echo json_encode(
            array(
                'msg'=> 'error'
            )
        );
    }
?>