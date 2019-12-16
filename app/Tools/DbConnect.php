<?php
namespace App\Tools;

use PDO;

class DbConnect
{
   private $dbHost;
   private $dbName;
   private $dbUser;
   private $dbPassword;

   public function setDbHost()
   {
      $this->dbUser =  getenv('DB_USER');
      $this->dbPassword = getenv('DB_PASSWORD');
      $this->dbHost = getenv('DB_HOST');
      $this->dbName = getenv('DB_NAME');

      return $db = new PDO("mysql:host={$this->dbHost}; dbname={$this->dbName}", $this->dbUser, $this->dbPassword );
   }
}