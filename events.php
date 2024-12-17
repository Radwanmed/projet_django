<?php
session_start(); // Démarre la session pour récupérer l'ID utilisateur
header('Content-Type: application/json');

$host = "localhost";
$dbname = "auth_db";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["error" => $e->getMessage()]));
}

if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "User not authenticated"]);
    exit;
}

$user_id = $_SESSION['id']; // Récupère l'ID utilisateur depuis la session

// Récupération des événements de l'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $month = $_GET['month'];
    $year = $_GET['year'];

    $stmt = $pdo->prepare("SELECT * FROM calendrier 
                           WHERE YEAR(event_date) = :year 
                           AND MONTH(event_date) = :month 
                           AND user_id = :user_id");
    $stmt->execute(['year' => $year, 'month' => $month, 'user_id' => $user_id]);

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// Ajout d'un nouvel événement pour l'utilisateur
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['event_date']) || !isset($data['details'])) {
        echo json_encode(["error" => "Invalid input"]);
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO calendrier (event_date, details, user_id) 
                           VALUES (:event_date, :details, :user_id)");
    $stmt->execute([
        'event_date' => $data['event_date'],
        'details' => $data['details'],
        'user_id' => $user_id
    ]);

    echo json_encode(["success" => true]);
}

// Suppression d'un événement appartenant à l'utilisateur
elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);

    if (!isset($data['event_date'])) {
        echo json_encode(["error" => "Invalid input"]);
        exit;
    }

    $stmt = $pdo->prepare("DELETE FROM calendrier 
                           WHERE event_date = :event_date 
                           AND user_id = :user_id");
    $stmt->execute([
        'event_date' => $data['event_date'],
        'user_id' => $user_id
    ]);

    echo json_encode(["success" => true]);
}

// Mise à jour d'un événement appartenant à l'utilisateur
elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['event_date']) || !isset($data['details'])) {
        echo json_encode(["error" => "Invalid input"]);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE calendrier 
                           SET details = :details 
                           WHERE event_date = :event_date 
                           AND user_id = :user_id");
    $stmt->execute([
        'details' => $data['details'],
        'event_date' => $data['event_date'],
        'user_id' => $user_id
    ]);

    echo json_encode(["success" => true]);
}
?>