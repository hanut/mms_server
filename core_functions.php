<?php
if(empty($script)){   
    exit();  
}
/**
 * This script contains function definitions for a variety of functions that are
 * addons for features such as security,validation etc. For example the pk/sk generation 
 * function.
 * 
 * @author Hanut Singh, <hanut@kroesoft.in> 
 */


/**
 * Generates an array containing private key(pk) and secret key(sk) and returns
 * them as an associative $keypair array.
 * This function uses the md5 of the concatenated password+username as the message
 * and hash of current time to generate the hashed MAC that is the sk.
 * 
 * @param type $usr Name of the user
 * @param type $pass Password
 * @return type 
 */
function rsa_keypair_generator($usr, $pass){
    $time = time();
    $keypair = array();
    $keypair['pk'] = hash("sha256", $time);
    $keypair['sk'] = hash_hmac("sha256", md5($pass.$usr), $keypair['pk']);
    return $keypair;
}

/**
 * Function checks that the entered user name and password combination is valid
 * by generating the new vs2010
 * 
 * @param type $usr
 * @param type $pass
 * @param type $private
 * @param type $secret
 * @return boolean 
 */
function rsa_keypair_check($usr, $pass, $private, $secret){
    $public = md5($pass.$usr);
    $test_key = hash_hmac("sha256", $public, $private);
    if($secret != $test_key){
        return FALSE;
    }
    else{
        return TRUE;
    }
}

function validate_blanks(array $fields){
    for($i=0;$i<count($fields);$i++){
        
    }
}
?>
