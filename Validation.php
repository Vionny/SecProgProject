<?php
    require "../db/DBConnection.php";

    session_start();

    $conn = Connect::getInstance();
    $db = $conn->getDBConnection();

    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT * FROM users WHERE username=? AND password=?";
    $statement = $db->prepare($query);
    $statement->bind_param("ss", $username, $password);
    $statement->execute();
    $result = $statement->get_result();

    if ( $result->num_rows > 0) {
      $_SESSION["error"]= "";
      $_SESSION["username"] = $username;
      $_SESSION["password"] = $password;
      $_SESSION["is_login"] = true;

      header("Location: ../pages/dashboard.php");
    } else {
        $_SESSION["error"]= "Login Failed!";
        header("Location: ../pages/login.php");
    }
?>