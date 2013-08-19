<?php
if(empty($script)){   
    exit();  
}
/**
 * This script contains function definitions for a variety of functions that are
 * addons for features such as security etc. For example the pk/sk generation 
 * function.
 * 
 * @author Hanut Singh, <hanut@kroesoft.in> 
 */


function rsa_keypair_generator($usr, $pass){
    $keypair = array();
    $keypair['pk'] = hash("sha256", $time);
    $keypair['sk'] = hash_hmac("sha256", md5($pass.$usr), $keypair['pk']);
    return $keypair;
}

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
?>
