<?php
    class Post{
        private $conn;
        private $table = 'posts';
        public $id;
        
        /*public $category_id;
        public $categoray_name;
        public $title;
        public $body;
        public $author;
        public $created_at;*/
        
        public function __construct($db){
            $this->conn = $db->connect();
        }
        
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
    }
?>