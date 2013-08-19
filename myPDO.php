<?php 
if(empty($script)){   
    exit();  
}
/**
 * Basic PDO connection wrapper class for creating PDOs for database interaction.
 * Allows all sorts of database activities wihout running the risk of degree one
 * and two SQL injection
 * 
 * @author Hanut Singh, <hanut@koresoft.in> 
 */

class myPDO extends PDO { 
    
    private $engine; 
    private $host; 
    private $database; 
    private $user; 
    private $pass; 
    
    public function __construct(){ 
        $this->engine = 'mysql'; 
        $this->host = 'localhost'; 
        $this->database = 'mms_demo'; 
        $this->user = 'root'; 
        $this->pass = ''; 
        $dns = $this->engine.':dbname='.$this->database.";host=".$this->host; 
        parent::__construct( $dns, $this->user, $this->pass ); 
    } 
    
    static function get_dbcon(){
        return new myPDO();
    }
} 
?>
