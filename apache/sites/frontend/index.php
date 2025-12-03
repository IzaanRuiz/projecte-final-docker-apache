<?php
// --- CONFIGURACIÓN DE ERRORES ---
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$mensaje_redis = "Cargando...";
$mensaje_mysql = "";

// --- 1. CONEXIÓN MYSQL ---
$mysqli = new mysqli("mysql", getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), getenv('MYSQL_DATABASE'));

// --- 2. CONEXIÓN REDIS ---
try {
    $redis = new Redis();
    if ($redis->connect('redis', 6379)) {
        $visitas = $redis->incr('visitas');
        $mensaje_redis = "Visitas totales: " . $visitas;
    } else {
        $mensaje_redis = "No se pudo conectar a Redis";
    }
} catch (Exception $e) {
    $mensaje_redis = "Redis no disponible (Excepción)";
}

// --- 3. PROCESAR FORMULARIO (POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['title'])) {
    $stmt = $mysqli->prepare("INSERT INTO articles (user_id, title, content) VALUES (1, ?, ?)");
    $stmt->bind_param("ss", $_POST['title'], $_POST['content']);
    $stmt->execute();
    // Recargar para limpiar formulario
    header("Location: /");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Projecte Final Izan</title>
    <style>
        body{font-family:sans-serif; max-width:800px; margin:0 auto; padding:20px;} 
        .card{border:1px solid #ccc; padding:15px; margin-bottom:15px; border-radius: 5px;}
        .stats{background:#e0f7fa; padding:15px; border-radius: 5px; margin-bottom: 20px;}
        input, textarea { width: 100%; margin-bottom: 10px; padding: 5px; }
        button { background: #007bff; color: white; border: none; padding: 10px 20px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Frontend Projecte Final</h1>
    
    <div class="stats">
        <strong>Estadísticas (Redis):</strong> <?php echo $mensaje_redis; ?>
    </div>

    <h2>Crear Artículo</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Título del artículo" required>
        <textarea name="content" rows="4" placeholder="Contenido del artículo" required></textarea>
        <button type="submit">Guardar Artículo</button>
    </form>

    <h2>Últimos Artículos (MySQL)</h2>
    <?php
    $result = $mysqli->query("SELECT * FROM articles ORDER BY id DESC LIMIT 5");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='card'>";
            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<p>" . htmlspecialchars($row['content']) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No hay artículos o error de conexión.</p>";
    }
    ?>
</body>
</html>