<?php
    class Connect{
        public $connect =  null;

        private $host = 'localhost';
        private $db = 'mtvawards';
        private $user = 'root';
        private $password = '';
        private $charset = 'utf8';

        public function __construct() {
            try{
                //Data Source Name
                $dsn = "mysql:host=".$this->host.";dbname=".$this->db.";charset=".$this->charset;

                //New Object
                $this->connect = new PDO($dsn, $this->user, $this->password);

                //Settings error
                $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // echo ' <div class="alert alert-success" role="alert">
                //     Conexión estable con la BD
                // </div>';
            }//end try
            catch(PDOException $e){
                echo ' <div class="alert alert-danger" role="alert">
                    Error to connect with DB '. $e->getMessage().'
                </div>';
            }//end catch
        }//end __construct
    }//end Connect