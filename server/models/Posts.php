<?php
class Post {
    private $conn;
    private $table_name = "posts";

    public $id;
    public $content;
    public $category;
    public $author_id;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET content=:content, category=:category, author_id=:author_id";
        $stmt = $this->conn->prepare($query);

        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));

        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":author_id", $this->author_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function read() {
        $query = "SELECT p.id, p.content, p.category, p.created_at, u.username as author FROM " . $this->table_name . " p LEFT JOIN users u ON p.author_id = u.id ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
