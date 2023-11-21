<?php
  class EncryptService {
    private static $key = "S3cPr0gG3m1nk";
    public static function hashPassword($password) {
      
      return password_hash($password,PASSWORD_BCRYPT);
    }

    public static function checkPassword($password,$encryptedPassword){
      return password_verify($password,$encryptedPassword);
    }
    
    public static function encryptData($data){
      
      $iv = openssl_random_pseudo_bytes(16);
      $cipher = "aes-256-cbc";
      $options = 0;

      $encryptedData = openssl_encrypt($data, $cipher, self::$key, $options, $iv);
      $token = $encryptedData;
      return $token;
    }

    public static function getEncryptedData($combinedData){
      $encryptedData = substr($combinedData, 16);
      return $encryptedData;
    }
    public static function decryptData($combinedData){
      $cipher = "aes-256-cbc";
      $options = 0;
      var_dump($combinedData);
      $iv = substr($combinedData, 0, 16);
      $encryptedData = self::getEncryptedData($combinedData);
      $decryptedData = openssl_decrypt($encryptedData, $cipher, self::
      $key, $options, $iv);

      return $decryptedData;
    }
  }
?>