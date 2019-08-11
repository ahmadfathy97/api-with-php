<?php
    class Post{
        private $conn;
        private $table = 'posts';
        public $id;
        public $category_id;
        public $title;
        public $body;
        public $author_id;
        public $created_at;
        
        public function __construct($connection){
            $this->conn = $connection;
        }
        
        // get all posts
        public function readAll(){
            
            $query = '
                SELECT
                    c.name as category_name,
                    u.*,
                    p.*
                FROM
                '   . $this->table
                    . ' p
                LEFT JOIN
                    categories c
                ON
                    p.category_id = c.id
                LEFT JOIN
                    users u
                ON
                    p.author_id = u.id
                ORDER BY
                    p.created_at
                DESC
                ';
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }
        
        //get one post
        public function readOne(){
            $query = '
                SELECT 
                    c.name as category_name,
                    u.*,
                    p.*
                FROM
                '   . $this->table
                    . ' p
                LEFT JOIN
                    categories c
                ON
                    p.category_id = c.id
                LEFT JOIN
                    users u
                ON
                    p.author_id = u.id
                WHERE
                    p.id = ?
                LIMIT 0,1
                ';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id);// 1 is the position of the param
            $stmt->execute();
            
            return $stmt;
        }
        
        //create post
        public function create(){
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->created_at = htmlspecialchars(strip_tags($this->created_at));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $query = '
                INSERT INTO '
                    . $this->table .
                '
                    (title,
                    body,
                    created_at,
                    author_id,
                    category_id
                    )
                VALUES(
                    :title,
                    :body,
                    :created_at,
                    :author_id,
                    :category_id
                    )';
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':created_at', $this->created_at);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);
            
            if($stmt->execute()){
                return true;
            }
            printf("Error: %s.\n ", $stmt->error);
            return false;
        }
        
        
        //update post
        public function update(){
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->created_at = htmlspecialchars(strip_tags($this->created_at));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $query = '
                UPDATE '
                    . $this->table .
                ' SET
                    title = :title,
                    body = :body,
                    category_id = :category_id
                WHERE id = :id
                    ';
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':id', $this->id);
            
            if($stmt->execute()){
                return true;
            }
            printf("Error: %s.\n ", $stmt->error);
            return false;
        }
        
        
        
        //delete post
        public function delete(){
            $query = '
                DELETE FROM '
                    .$this->table. 
                ' WHERE
                    id = :id';
            $stmt = $this->conn->prepare($query);
            $this->id = htmlspecialchars(strip_tags($this->id));
            $stmt->bindParam(':id', $this->id);
            if($stmt->execute()){
                return true;
            }
            printf("Error: %s.\n ", $stmt->error);
            return false;
        }
        
    }
?>