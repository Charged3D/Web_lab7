<?php
session_start();

// Перевірка, чи користувач увійшов в систему
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: login.php");
    exit();
}

// Підключення до бази даних
include("db_connection.php");

// Сортування за колонками
$sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'name'; // за замовчуванням сортуємо за ім'ям
$sort_order = isset($_GET['sort_order']) && $_GET['sort_order'] == 'desc' ? 'desc' : 'asc'; // за замовчуванням сортуємо по зростанню

// Запит на отримання всіх записів з сортуванням
try {
    $stmt = $pdo->prepare("SELECT * FROM survey_responses ORDER BY $sort_column $sort_order");
    $stmt->execute();
    $responses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database query failed: " . $e->getMessage());
}

// Якщо натиснуто кнопку видалення
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    try {
        $deleteStmt = $pdo->prepare("DELETE FROM survey_responses WHERE id = :id");
        $deleteStmt->execute([':id' => $id]);
        header("Location: admin.php"); // Перезавантажуємо сторінку після видалення
        exit();
    } catch (PDOException $e) {
        die("Delete failed: " . $e->getMessage());
    }
}

// Функція експорту в CSV
function exportToCSV($responses)
{
    $filename = "survey_responses_" . date("Y-m-d_H-i-s") . ".csv";
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Name', 'Email', 'Age', 'Favorite Subject', 'Video Game', 'Working Out', 'Dream Profession']);

    foreach ($responses as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit();
}

// Функція експорту в JSON
function exportToJSON($responses)
{
    $filename = "survey_responses_" . date("Y-m-d_H-i-s") . ".json";
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    echo json_encode($responses);
    exit();
}

// Якщо натиснуто кнопку експорту
if (isset($_POST['export_csv'])) {
    exportToCSV($responses);
} elseif (isset($_POST['export_json'])) {
    exportToJSON($responses);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Survey Admin</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        form {
            display: inline-block;
        }

        /* Стилі для кнопок сортування */
        .sort-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 5px 2px;
            cursor: pointer;
            border-radius: 5px;
        }

        .sort-button:hover {
            background-color: #45a049;
        }

    </style>
</head>
<body>

    <h2>Survey Responses</h2>

    <!-- Таблиця з відповідями -->
    <table>
        <thead>
            <tr>
                <th><a href="admin.php?sort_column=name&sort_order=<?php echo $sort_order == 'asc' ? 'desc' : 'asc'; ?>" class="sort-button">Name</a></th>
                <th><a href="admin.php?sort_column=email&sort_order=<?php echo $sort_order == 'asc' ? 'desc' : 'asc'; ?>" class="sort-button">Email</a></th>
                <th><a href="admin.php?sort_column=age&sort_order=<?php echo $sort_order == 'asc' ? 'desc' : 'asc'; ?>" class="sort-button">Age</a></th>
                <th><a href="admin.php?sort_column=Fav_subject&sort_order=<?php echo $sort_order == 'asc' ? 'desc' : 'asc'; ?>" class="sort-button">Favorite Subject</a></th>
                <th><a href="admin.php?sort_column=video_game&sort_order=<?php echo $sort_order == 'asc' ? 'desc' : 'asc'; ?>" class="sort-button">Video Game</a></th>
                <th><a href="admin.php?sort_column=Working_out&sort_order=<?php echo $sort_order == 'asc' ? 'desc' : 'asc'; ?>" class="sort-button">Working Out</a></th>
                <th><a href="admin.php?sort_column=dream_profession&sort_order=<?php echo $sort_order == 'asc' ? 'desc' : 'asc'; ?>" class="sort-button">Dream Profession</a></th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($responses as $response): ?>
                <tr>
                    <td><?php echo htmlspecialchars($response['name']); ?></td>
                    <td><?php echo htmlspecialchars($response['email']); ?></td>
                    <td><?php echo htmlspecialchars($response['age']); ?></td>
                    <td><?php echo htmlspecialchars($response['Fav_subject']); ?></td>
                    <td><?php echo htmlspecialchars($response['video_game']); ?></td>
                    <td><?php echo htmlspecialchars($response['Working_out']); ?></td>
                    <td><?php echo htmlspecialchars($response['dream_profession']); ?></td>
                    <td>
                        <!-- Форма для видалення -->
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $response['id']; ?>">
                            <button type="submit" name="delete" class="sort-button">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br><br>

    <!-- Кнопки експорту -->
    <form method="post">
        <button type="submit" name="export_csv" class="sort-button">Export to CSV</button>
        <button type="submit" name="export_json" class="sort-button">Export to JSON</button>
    </form>

    <br><br>

    <!-- Кнопка для виходу -->
    <form action="logout.php" method="post">
        <input type="submit" value="Logout" class="sort-button">
    </form>

</body>
</html>
