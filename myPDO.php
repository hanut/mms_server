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
    private $return_type;
    /**
     * Get as an associative array
     */
    const ARRAY_ASSOC = myPDO::FETCH_ASSOC;
    /**
     * Get as a numeric array
     */
    const ARRAY_NUM = myPDO::FETCH_NUM;
    /**
     * Get both numeric as well as associative arrays
     */
    const ARRAY_BOTH = myPDO::FETCH_BOTH;

    public function __construct($engine='mysql', $host='127.0.0.1', $db='mms_demo', 
                    $user='root', $pass='', $rtype = myPDO::ARRAY_ASSOC){ 
        $this->engine = $engine; 
        $this->host = $host; 
        $this->database = $db; 
        $this->user = $user; 
        $this->pass = $pass; 
        $dns = $this->engine.':dbname='.$this->database.";host=".$this->host; 
        try{
            parent::__construct( $dns, $this->user, $this->pass ); 
        }catch(PDOException $e){
           echo $e->getMessage();
        }
        $this->return_type = $rtype;
    } 
    
    private function get_pstmt($statement,$rtype=' '){
        $pstmt = $this->prepare($statement);
        if($rtype == ' ')
            $pstmt->setFetchMode($this->return_type);
        else
            $pstmt->setFetchMode($rtype);
        return $pstmt;
    }
    
    public function select_unconditional($table_name, $col_names = ' '){
        $statement = "SELECT ";
        
        //Add the column names to the select statement
        if($col_names == ' '){
            $statement .= "* ";
        }
        else{
            for($i=0;$i<(count($col_names)-1);$i++){
                $statement .= "`".$col_names[$i]."`, ";
            }
            $statement .= "`".$col_names[$i]."` ";
        }
        
        //Now add the table name
        $statement .= "FROM `".$table_name."` ";
        //return the prepared statement
        return $this->get_pstmt($statement);
    }
    
    static function get_dbcon(){
        return new myPDO();
    }
} 
?>
