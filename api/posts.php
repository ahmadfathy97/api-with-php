<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../config/database.php';
    include_once '../modules/post.php';
    
    $db = new Database();
    $connection = $db->connect();

    $post = new Post($connection);
    
    $result = $post->readAll();
    /*print_r($result->fetch(PDO::FETCH_ASSOC));*/
    $num = $result->rowCount();
    if($num > 0){
        $posts_arr = array();
        $posts_arr['data'] = array();
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $post = array(
                'id' => $id,
                'title' => $title,
                'body' => html_entity_decode($body),
                'created_at' => $created_at,
                'author' => $username,
                'category_name' => $category_name
            );
            array_push($posts_arr['data'], $post);
        }
        echo json_encode($posts_arr['data']);
    }else{
        echo json_encode(array('massege' => 'err'));
    }
?>