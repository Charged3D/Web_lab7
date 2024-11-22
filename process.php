<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$name = htmlspecialchars($_POST["name"]);
$email = htmlspecialchars($_POST["email"]);
$age = (int)$_POST["age"];
$Favorite_subject = htmlspecialchars($_POST["Fav_subject"]);
$video_game = htmlspecialchars($_POST["video_game"]);
$working_out = htmlspecialchars($_POST["Working_out"]);
$dream_profession = htmlspecialchars($_POST["dream_profession"]);

$date = date("Y-m-d_H-i-s");

try {

    $pdo = new PDO('mysql:host=sql313.infinityfree.com;dbname=if0_37695981_survey_db', 'if0_37695981', 'Lab61qazxsw233'); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
    
    $sql = "INSERT INTO survey_responses (name, email, age, Fav_subject, video_game, Working_out, dream_profession)
            VALUES(:name, :email, :age, :Fav_subject, :video_game, :Working_out, :dream_profession)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([

        ':name' => $name,
        ':email'=> $email,
        ':age'=> $age,
        ':Fav_subject'=> $Favorite_subject,
        ':video_game'=> $video_game,
        ':Working_out'=> $working_out,
        ':dream_profession'=> $dream_profession

    ]);

echo"Thanks for compleating survey. Your answers was saved succesfully!";

} catch(PDOException $e) {

echo"There is error in connecting to the Data Base". $e->getMessage();

}

}
?>