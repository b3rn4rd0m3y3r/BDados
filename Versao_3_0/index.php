<?php

?>
<head>
	<link rel="icon"       type="image/ico"       href="favicon.ico">
<style>
	BODY {font-family: Arial;}
	DIV#menu {display: table-row;}
	DIV#menu DIV{
		background: rgb(121,83,9);
		background: linear-gradient(90deg, rgba(121,83,9,1) 3%, rgba(255,0,11,1) 100%);
		border-radius: 6px;
		color: white;
		float: left;
		height: 85px;
		margin-left: 10px;
		margin-bottom: 10px;
		padding: 6px;
		text-align: center;
		width: 90px;
		}
	DIV#menu DIV DIV{
		background: transparent;
		cursor: pointer;
		margin: 0px;
		padding: 6px;
		vertical-align: middle;
		width: 85px;
		}
	DIV#menu DIV DIV.tb{
		padding: 0px;
		padding-top: 20px;
		}
	DIV#menu DIV DIV.stru{
		padding: 0px;
		padding-top: 10px;
		}
		
</style>
<script type="text/javascript" src="BMyFrmwk.js"></script>
<script type="text/javascript">
var ob = new BMy();
function criaBD(){
	//alert('criaBD');
	var nomeBD = (ob.getById("bd")).value;
	var txtUrl = "BD_create.php?Banco=" + nomeBD;
	window.location = txtUrl;
	}
function criaTB(){
	//alert('criaTB');
	var nomeBD = (ob.getById("bd")).value;
	var nomeTB = (ob.getById("tb")).value;
	var txtUrl = "TB_create.php?Banco="+nomeBD+"&Tabela="+nomeTB;
	window.location = txtUrl;
	}
function criaStru(){
	alert('criaStru');
	}
</script>
</head>
<body>
<h1>BANCO DE DADOS</h1>
<div id="menu">
	<div><div onclick="criaBD();">Criação do Banco de Dados</div></div>
	<div><div class="tb" onclick="criaTB();">Criação de Tabela</div></div>
	<div><div class="stru" onclick="criaStru();">Criação da Estrutura das Tabelas</div></div>
</div>
<div id="dados">
	<table>
		<tr><td><label>Nome do Banco:</label></td><td><input type=text id="bd"></td></tr>
		<tr><td><label>Nome da Tabela:</label></td><td><input type=text id="tb"></td></tr>
	</table>
</div>
</body>