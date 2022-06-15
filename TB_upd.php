<?php

	// Script main body
	
	$Tb = $_POST["_Tabela"];
	$ftb = substr($Tb,0,strlen($Tb)-4) . ".dat";
	echo $Tb . "-" . $ftb ."<br>";
	foreach ($_POST as $key=>$valor) {
		$pref = substr($key,0,1);
		if( $pref != "_" ){
			$S .= " \"" . $key . "\" : \"" . $valor . "\" ,";
			}
		}
	$S = substr($S, 0, strlen($S)-1);
	$S = "{ " . $S . " }";
	echo $S;
	$fp = fopen($ftb,"a");
	fwrite($fp,$S."\n");
	fclose($fp);

?>