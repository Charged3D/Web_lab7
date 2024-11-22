<?php 

session_start();

if (isset($_SESSION["logged_in"]) && $_SESSION["Logged_in"] === true) {

    header ("Location: admin.php");
    exit();

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST["username"] == "admin" && $_POST["password"] == "12345678") {  //here can be changed login and password//

        $_SESSION ["logged_in"] = true;
        header("Location: admin.php");
        exit();
    }
} else {

    echo"Invalid Username or Password";

}

?>


<form method="post">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Login">
    </form>