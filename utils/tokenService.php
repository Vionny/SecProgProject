<?php
  function generateToken() {
        
    if(isset($_SESSION["token"])){
        return $_SESSION["token"];
    }
    $token = bin2hex(random_bytes(32));
    $_SESSION["token"] = $token;
    
    return $token;
  }
  
  function getToken(){
    return $_SESSION["token"];
  }

  function removeToken(){
    unset($_SESSION["token"]);
  }

?>