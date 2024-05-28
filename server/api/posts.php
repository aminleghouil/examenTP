<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/Post.php';

$database = new Database();
$db = $database->getConnection();

$post = new Post($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $post->read();
    $num = $stmt->rowCount();

    if ($num > 0) {
        $posts_arr = array();
        $posts_arr["records"] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $post_item = array(
                "id" => $id,
                "content" => $content,
                "category" => $category,
                "author" => $author,
                "created_at" => $created_at
            );

            array_push($posts_arr["records"], $post_item);
        }

        http_response_code(200);
        echo json_encode($posts_arr);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "No posts found."));
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->content) && !empty($data->category) && !empty($data->author_id)) {
        $post->content = $data->content;
        $post->category = $data->category;
        $post->author_id = $data->author_id;

        if ($post->create()) {
            http_response_code(201);
            echo json_encode(array("message" => "Post was created."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create post."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Unable to create post. Data is incomplete."));
    }
}
?>
