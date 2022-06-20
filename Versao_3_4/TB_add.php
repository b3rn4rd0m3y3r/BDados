<?php
/*
function guidv4($data){
    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
	}
*/
function GUID (){
	return  $bytes = substr(str_shuffle(str_repeat('012!3456@789#abcde$fghij|klmnopqr*stuvwxyz:ABCDEFGHIJKLM-NOPQRST_UVWXYZ', mt_rand(1,10))), 1, 10);
	}

   

	// Script main body
	
	$Tb = $_POST["Tabela"];
	$ftb = substr($Tb,0,strlen($Tb)-4) . ".dat";
	echo $Tb . "-" . $ftb ."<br>";
	//var_dump($_POST);
	//$S = "";
	$S = " \"uuid\" : \"" . GUID() . "\" ,";
	foreach ($_POST as $key=>$valor) {
		$pref = substr($key,0,2);
		$chave = substr($key,2,99);
		if( $pref == "f_" ){
			$S .= " \"" . $chave . "\" : \"" . $valor . "\" ,";
			}
		}
	$S = substr($S, 0, strlen($S)-1);
	$S = "{ " . $S . " }";
	echo $S;
	$fp = fopen($ftb,"a");
	fwrite($fp,$S."\n");
	fclose($fp);
?>