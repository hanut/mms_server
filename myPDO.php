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
    
    public function select_conditional($table_name, array $conditions, $col_names = ' '){
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
        
        //Get the column names from array keys
        $keys = array_keys($conditions);
        
        //count the number of keys and save in num_keys
        $num_keys = count($keys);
        
        //Process and add the WHERE Clauses to the statement
        $statement .= "WHERE ";
        for($i=0;$i<($num_keys-1);$i++){
                $statement .= "`".$keys[$i]."` = :".$keys[$i].", ";
        }
        $statement .= "`".$keys[$i]."` = :".$keys[$i]." ";
        
        //get the prepared statement
        $pstmt = $this->get_pstmt($statement);
        
        //bind the values of each WHERE clause
        for($i=0;$i<($num_keys);$i++){
            $pstmt->bindValue($keys[$i], $conditions[$keys[$i]]);
        }
        
        return $pstmt;
    }
    
    public function execute(PDOStatement$pstmt,$get_result=false){
        try{
            $pstmt->execute();
            if($get_result){
                if($pstmt->rowCount() > 1){
                    $result = $pstmt->fetchAll();
                    $result['count'] = count($result);
                }
                else if($pstmt->rowCount() == 1){
                    $result = $pstmt->fetch();
                }
                else{
                    return false;
                }
                return $result;
            }
            else{
                return true;
            }
        }catch(PDOException $e){
            echo $e->getTraceAsString();
            return false;
        }
    }
    
    static function get_dbcon(){
        return new myPDO();
    }
} 
?>
