<?php
  class EncryptService {

    public static function hashPassword($password) {
      
      return password_hash($password,PASSWORD_BCRYPT);
    }

    public static function checkPassword($password,$encryptedPassword){
      return password_verify($password,$encryptedPassword);
    }

  }
?>