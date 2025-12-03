<?php
header('Content-Type: application/json');
$mysqli = new mysqli("mysql", getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), getenv('MYSQL_DATABASE'));
$redis = new Redis();
$redis->connect('redis', 6379);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Endpoint /api/articles
if (strpos($path, '/articles') !== false) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $result = $mysqli->query("SELECT * FROM articles");
        $rows = [];
        while($r = $result->fetch_assoc()) $rows[] = $r;
        echo json_encode($rows);
    } 
    elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        if($data) {
            $stmt = $mysqli->prepare("INSERT INTO articles (user_id, title, content) VALUES (1, ?, ?)");
            $stmt->bind_param("ss", $data['title'], $data['content']);
            $stmt->execute();
            echo json_encode(["status" => "created"]);
        }
    }
}
// Endpoint /api/stats
elseif (strpos($path, '/stats') !== false) {
    $visitas = $redis->get('visitas');
    $articulos = $mysqli->query("SELECT COUNT(*) as c FROM articles")->fetch_assoc()['c'];
    echo json_encode(["visitas" => $visitas, "articulos" => $articulos]);
}
else {
    http_response_code(404);
    echo json_encode(["error" => "Endpoint not found"]);
}
?>