<?php
include (dirname(__FILE__)."/mailer.php");



//Tyler hall password generator https://gist.github.com/tylerhall/521810
function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds') 
{
	$sets = array();
	if(strpos($available_sets, 'l') !== false)
		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
	if(strpos($available_sets, 'u') !== false)
		$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
	if(strpos($available_sets, 'd') !== false)
		$sets[] = '23456789';
	if(strpos($available_sets, 's') !== false)
		$sets[] = '!@#$%&*?';

	$all = '';
	$password = '';
	foreach($sets as $set)
	{
		$password .= $set[array_rand(str_split($set))];
		$all .= $set;
	}

	$all = str_split($all);
	for($i = 0; $i < $length - count($sets); $i++)
		$password .= $all[array_rand($all)];

	$password = str_shuffle($password);

	if(!$add_dashes)
		return $password;

	$dash_len = floor(sqrt($length));
	$dash_str = '';
	while(strlen($password) > $dash_len)
	{
		$dash_str .= substr($password, 0, $dash_len) . '-';
		$password = substr($password, $dash_len);
	}
	$dash_str .= $password;
	return $dash_str;
}


function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }

function createAccount($mail){
    if (file_exists("../model/account.json")) {
        
        $contents = file_get_contents("../model/account.json");
        $info = json_decode($contents, true);
        //console_log($contents);
        $password = generateStrongPassword();
        $account = ["mail"=>$mail,"password"=>$password];
        array_push($info,$account);
        $modif = json_encode($info);
        $file = fopen("../model/account.json", "w");
        fwrite($file, $modif);
    return $account;    
    }
    

}

function accountExist($mail){
	$item = FALSE;
	if (file_exists("../model/account.json")) {
        
        $contents = file_get_contents("../model/account.json");
        $info = json_decode($contents, true);
        foreach($info as $struct) {
			if ($mail == $struct["mail"]) {
				$item = $struct;
				break;
			}
		}
    }
	//console_log($item);
	return $item;

}

function login($mail,$mdp){
    if(($account = accountExist($mail))==FALSE){
        return "Le compte n'existe pas";
    }else if($account["password"]==$mdp){
        return "Mauvais mot de passe";
    }
    else{
        return TRUE;
    }
}



?>