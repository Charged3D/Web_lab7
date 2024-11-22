include("db_connection.php");

try {
    // Запит для отримання всіх записів
    $stmt = $pdo->query("SELECT * FROM survey_responses");
    $responses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Перевірка на наявність даних
    if (count($responses) > 0) {
        echo json_encode($responses); // Повертаємо дані у форматі JSON
    } else {
        echo json_encode(["message" => "No survey responses found."]);
    }
} catch (PDOException $e) {
    // Обробка помилок
    echo json_encode(["error" => $e->getMessage()]);
}
?>