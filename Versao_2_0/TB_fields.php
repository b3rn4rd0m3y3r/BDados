<?php
function lstTabelas($Bank,$tipoProc){
	$retorno = false;
	// Abre o banco
	$fp = fopen($Bank, "r");
	// Primeira Linha (Cabe�alho banco)
	$linha1 = fgets($fp);
	// Segunda Linha
	$txt = fgets($fp);
	fclose($fp);
	//echo "T:".$txt. "<br>";
	// L� tabelas do Banco
	if( $txt == "" ){
		$retorno = false;
		echo "";
		} else {
		// Existem tabelas
		// Conte�do da linha em string para JSON
		$arrTab = json_decode(str_replace('\n', '', $txt),true);
		$tabelas = $arrTab['tabelas'];
		//echo "J1:" . $tabelas . "<br>";
		$Html = "";
		foreach( $tabelas as $valor ) {
			//echo $valor . "<br>";
			$Html .= "<option value=\"" . $valor . "\">" . $valor . "</option>";
			}
		$retorno = true;
		}
	if( $tipoProc == "testa" ){
		return $retorno;
		} else {
		return $Html;
		}
	}
function displayForm($html){
	$cod = "<form method=\"post\" action =\"\">";
	$cod .= "<select id=tabelas>";
	$cod .= $html;
	$cod .= "</select>";
	$cod .= "</form>";
	return $cod;
	}
	/*
		TB_create.php?Banco=Berna.dmy&Tabela=Contatos.tmy
	*/
	// Existe o par�metro Banco na URL ?
	if(	isset($_GET["Banco"]) ){ 
		$Banco = $_GET["Banco"];
		// O par�metro Banco est� preenchido ?
		if( $Banco != "" ){
			$ext = substr($Banco,-3);
			// A extens�o � dmy ?
			if( !($ext == "dmy") ){
				$Banco = $Banco . ".dmy";
				}
			} else {
			echo "[{ Id : \"Err\" }, { Erro : \"DB_Err 002:Nome do banco n�o preenchido. Use ?Banco=xxxx.dmy\" }]";
			}
		} else {
			echo "[{ Id : \"Err\" }, { Erro : \"DB_Err 001:Sem nome do banco. Use ?Banco=xxxx.dmy\" }]";
		}
	// Existe o par�metro Tabela na URL ?
	if(	isset($_GET["Tabela"]) ){ 
		$Tabela = $_GET["Tabela"];
		// O par�metro Tabela est� preenchido ?
		if( $Tabela != "" ){
			$ext = substr($Tabela,-3);
			// A extens�o � tmy ?
			if( !($ext == "tmy") ){
				$Tabela = $Tabela . ".tmy";
				}
			// O arquivo correspondente a tabela existe ?
			if( !file_exists($Tabela) ){
					echo "TB_Err 007:Tabela n�o existe. Verifique a grafia";
					} else {
					// Acrescenta tabela na lista de tabelas no registro do Banco
					if( lstTabelas($Banco, "testa") ){
						echo "<h1>Tabelas do Banco: " . $Banco . "</h1>";
						echo displayForm(lstTabelas($Banco, "html"));
						echo "[{ Id : \"Err\" }, { Erro : \"TB_Err 200:Tabelas lidas com sucesso\" }]";
						} else {
						echo "[{ Id : \"Err\" },{ \"DB_Err 500\" : \"Banco danificado, sem refer�ncia �s tabelas\" } ] } ]";
						}
					}
			} else {
			echo "[{ Id : \"Err\" }, { Erro : \"TB_Err 002:Nome da tabela n�o preenchido. Use ?Tabela=xxxx.tmy\" }]";
			}
		} else {
			echo "[{ Id : \"Err\" }, { Erro : \"TB_Err 001:Sem nome da tabela. Use ?Tabela=xxxx.tmy\" }]";
		}
?>