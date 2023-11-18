<?php
  class EncryptService {

    public function hashPassword($password) {
      
      return password_hash($password,PASSWORD_BCRYPT);
    }

    public function checkPassword($password,$encryptedPassword){
      return password_verify($password,$encryptedPassword);
    }

  }
?>