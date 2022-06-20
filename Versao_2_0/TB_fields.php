<?php
function lstTabelas($Bank,$tipoProc){
	$retorno = false;
	// Abre o banco
	$fp = fopen($Bank, "r");
	// Primeira Linha (Cabeçalho banco)
	$linha1 = fgets($fp);
	// Segunda Linha
	$txt = fgets($fp);
	fclose($fp);
	//echo "T:".$txt. "<br>";
	// Lê tabelas do Banco
	if( $txt == "" ){
		$retorno = false;
		echo "";
		} else {
		// Existem tabelas
		// Conteúdo da linha em string para JSON
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
			} else {
			echo "[{ Id : \"Err\" }, { Erro : \"DB_Err 002:Nome do banco não preenchido. Use ?Banco=xxxx.dmy\" }]";
			}
		} else {
			echo "[{ Id : \"Err\" }, { Erro : \"DB_Err 001:Sem nome do banco. Use ?Banco=xxxx.dmy\" }]";
		}
	// Existe o parâmetro Tabela na URL ?
	if(	isset($_GET["Tabela"]) ){ 
		$Tabela = $_GET["Tabela"];
		// O parâmetro Tabela está preenchido ?
		if( $Tabela != "" ){
			$ext = substr($Tabela,-3);
			// A extensão é tmy ?
			if( !($ext == "tmy") ){
				$Tabela = $Tabela . ".tmy";
				}
			// O arquivo correspondente a tabela existe ?
			if( !file_exists($Tabela) ){
					echo "TB_Err 007:Tabela não existe. Verifique a grafia";
					} else {
					// Acrescenta tabela na lista de tabelas no registro do Banco
					if( lstTabelas($Banco, "testa") ){
						echo "<h1>Tabelas do Banco: " . $Banco . "</h1>";
						echo displayForm(lstTabelas($Banco, "html"));
						echo "[{ Id : \"Err\" }, { Erro : \"TB_Err 200:Tabelas lidas com sucesso\" }]";
						} else {
						echo "[{ Id : \"Err\" },{ \"DB_Err 500\" : \"Banco danificado, sem referência às tabelas\" } ] } ]";
						}
					}
			} else {
			echo "[{ Id : \"Err\" }, { Erro : \"TB_Err 002:Nome da tabela não preenchido. Use ?Tabela=xxxx.tmy\" }]";
			}
		} else {
			echo "[{ Id : \"Err\" }, { Erro : \"TB_Err 001:Sem nome da tabela. Use ?Tabela=xxxx.tmy\" }]";
		}
?>