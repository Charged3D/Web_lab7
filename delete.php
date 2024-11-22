<?php

require "db_connection.php";

if (isset($_POST["delete"])) {
    $id = (int)$_POST["id"];
    
    try {

        $stmt = $pdo->prepare("DELETE FROM survey_responses WHERE id = :id");
        $stmt->execute([":id" => $id]);
        header("Location: admin.php");
        exit();

    } catch (PDOException $e) {
        echo "Error deleting record: " . $e->getMessage();
    }
}
?>