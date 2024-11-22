<?php 

require "db_connection.php";


if(isset($_POST["export_csv"])) 
    {

        $stmt = $pdo->query("SELECT * FROM survey_responses");
        $responses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename='survey_responses.csv'");

        $output = fopen("php://output","w");
        fputcsv($output, ["ID", "Name", "Age", "Favorite Subject", "Video Game", "Working Out", "Gream Profession"]);

        foreach($responses as $response) 
        {

            fputcsv($output, $response);

        }
        fclose($output);
        exit();

    }

    if (isset($_POST["export_json"])) 
    {

        $stmt = $pdo->query("SELECT * FROM survey_responses");
        $responses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header("Content-Type: application/json");
        header("Content-Disposition: attachment; filename='survey_responses.json'");
        echo json_encode($responses, JSON_PRETTY_PRINT);
        exit();

    }



?>