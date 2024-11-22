<?php
$host = "localhost";
$dbname = "survey_db";
$username = "root";
$password = "";


try 
{

    $pdo = new PDO('mysql:host=sql313.infinityfree.com;dbname=if0_37695981_survey_db', 'if0_37695981', 'Lab61qazxsw233');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} 
catch (PDOException $e) 
{
    die("Database connection failed: ". $e->getMessage());
}

?>