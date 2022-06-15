<style>
	BODY {
		font-family: Arial;
		}
</style>
<?php
	/*
		BD_create.php?Banco=<banco>.dmy
	*/
	// Existe o parâmetro Banco na URL ?
	if(	isset($_GET["Banco"]) ){ 
		$Banco = $_GET["Banco"];
		// O parâmetro Banco está preenchido ?
		if( $Banco != "" ){
			$ext = substr($Banco,-3);
			// A extensão é dmy ?
			if( !($ext == "dmy") ){
				$Banco = $Banco . ".dmy";
				}
			// O arquivo correspondente ao banco existe ?
			
			if( !file_exists($Banco) ){
				$fp = fopen($Banco, "w");
				//$txt = mb_convert_encoding($txt, 'ISO-8859-1', 'auto');
				$txt = "[ { \"Id\" : \"OK\" }, { \"Nome\" : \"" . $Banco . "\"}]\n";
				fwrite($fp, $txt);
				$txt = "{ \"tabelas\":[ ] }\n";
				fwrite($fp, $txt);
				fclose($fp);
				// Depois de criar confere se foi criado
				if( !file_exists($Banco) ){
					echo "DB_Err 003:Não consegui criar o banco. Verifique as permissões da pasta";
					} else {
					echo "[{ Id : \"OK\" }, { Erro : \"DB_Err 200:Banco criado com sucesso\" }]";
					}
				} else {
				echo "[{ Id : \"Err\" }, { Erro : \"DB_Err 400:Banco já existe\" }]";
				}
				
			} else {
			echo "[{ Id : \"Err\" }, { Erro : \"DB_Err 002:Nome do banco não preenchido. Use ?Banco=xxxx.dmy\" } ]";
			}
		} else {
			echo "[ { Id : \"Err\" }, { Erro : \"DB_Err 001:Sem nome do banco. Use ?Banco=xxxx.dmy\" } ]";
		}
		
	// Lock de Banco
	/*
	$lck = "LCK_" . $_GET["origin"] . "_" .$arq;
	$fp = fopen($lck, 'w');
	fwrite($fp, "SND\r\n");
	fclose($fp);
	*/
?>
<br><a href="index.php">VOLTAR AO MENU</a>