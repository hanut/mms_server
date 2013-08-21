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
            return false;
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
    
    public function execute(PDOStatement $pstmt,$get_result=false){
        try{
            $result = $pstmt->execute();
            
            //Check if result set is to be returned or not.
            if($get_result){
                //if result set is being returned, set return value
                //based on the number of rows.
                //returns false if no rows are returned
                if($pstmt->rowCount() > 1){
                    $result = $pstmt->fetchAll();
                    $result['count'] = count($result);
                    return $result;
                }
                else if($pstmt->rowCount() == 1){
                    $result = $pstmt->fetch();
                    return $result;
                }
                else{
                    return false;
                }
            }
            else{
                //if no result set is to be returned simply return true or false
                //status of the $pstmt->execute() command.
                return $result;
            }
        }catch(PDOException $e){
            echo $e->getTraceAsString();
            return false;
        }
    }
    
    /**
     * Static  method to return an object of type myPDO. take a number of optional
     * parameters.
     * 
     * @param Array $dbparams contains following keys (all of which are optional)
     *      $dbparams['engine'] default is mysql
     *      $dbparams['host']   default is 127.0.0.1
     *      $dbparams['db']     default is mms_demo
     *      $dbparams['user']   default is 'root' PLEASE MAKE SURE You change it
     *      $dbparams['pass']   default is 127.0.0.1
     *      $dbparams['rtype']  default is 127.0.0.1
     * 
     * @return \myPDO 
     */
    static function get_dbcon($dbparams = array()){
        //Is Engine set ?
        if(array_key_exists("engine", $dbparams)){
            $engine= $dbparams['engine'];
        }
        else{
            $engine='mysql';
        }
        
        //Is the host defined ?
        if(array_key_exists("host", $dbparams)){
            $host= $dbparams['host'];
        }
        else{
            $host='127.0.0.1';
        }
        
        //Is the database selected ?
        if(array_key_exists("db", $dbparams)){
            $db= $dbparams['db'];
        }
        else{
            $db='mms_demo';
        }
        
        //Is the user given ?
        if(array_key_exists("user", $dbparams)){
            $user= $dbparams['user'];
        }
        else{
            $user='root';
        }
        
        //Is the password given ?
        if(array_key_exists("pass", $dbparams)){
            $pass= $dbparams['pass'];
        }
        else{
            $pass='';
        }
        
        //Is the return type set ?
        if(array_key_exists("rtype", $dbparams)){
            $rtype= $dbparams['rtype'];
        }
        else{
            $rtype = myPDO::ARRAY_ASSOC;
        }
        //call parent constructor of class myPDO
        $dbo =  new myPDO($engine, $host, $db,$user, $pass, $rtype);
        if($dbo == false)
            die("Database connection error. Contact server admin...");
        else
            return $dbo;
    }

    static function do_error_log($error_msg){
        $msg = $error_msg." From user : ".$_SERVER['HTTP_USER_AGENT']
                    ."[".$_SERVER['REMOTE_ADDR']."] @ ".$_SERVER['REQUEST_TIME'];
        error_log($msg);
    }
} 
?>
