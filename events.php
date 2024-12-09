<?php
header('Content-Type: application/json');

$host = "localhost";
$dbname = "univevent";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
} catch (PDOException $e) {
    die(json_encode(["error" => $e->getMessage()]));
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $month = $_GET['month'];
    $year = $_GET['year'];

    $stmt = $pdo->prepare("SELECT * FROM calendrier WHERE YEAR(event_date) = :year AND MONTH(event_date) = :month");
    $stmt->execute(['year' => $year, 'month' => $month]);

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("INSERT INTO calendrier (event_date, details) VALUES (:event_date, :details)");
    $stmt->execute(['event_date' => $data['event_date'], 'details' => $data['details']]);

    echo json_encode(["success" => true]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    $stmt = $pdo->prepare("DELETE FROM calendrier WHERE event_date = :event_date");
    $stmt->execute(['event_date' => $data['event_date']]);

    echo json_encode(["success" => true]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("UPDATE calendrier SET details = :details WHERE event_date = :event_date");
    $stmt->execute(['details' => $data['details'], 'event_date' => $data['event_date']]);

    echo json_encode(["success" => true]);
}
?>    