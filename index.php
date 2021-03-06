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
	H1.grad {
		background: linear-gradient(90deg, rgba(121,83,9,1) 3%, rgba(255,0,44,44) 30%, rgba(255,0,88,44) 50%, rgba(255,0,128,88) 75%, rgba(255,0,11,1) 100%);
		border-radius: 8px;
		color: palegoldenrod;
		font-size: 24px;
		padding: 10px;
		text-align: center;
		width: 440px;
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
	var nomeBD = (ob.getById("bd")).value;
	var nomeTB = (ob.getById("tb")).value;
	var txtUrl = "TB_fields5.php?Banco="+nomeBD+"&Tabela="+nomeTB;
	window.location = txtUrl;
	}
function listaTB(){
	var nomeBD = (ob.getById("bd")).value;
	var nomeTB = (ob.getById("tb")).value;
	var txtUrl = "TB_list4.php?Tabela="+nomeTB;
	window.location = txtUrl;
	}
</script>
</head>
<body>
	<h1 class=grad>BDGer - BANCO DE DADOS</h1>
	<div id="menu">
		<div><div onclick="criaBD();">Cria??o do Banco de Dados</div></div>
		<div><div class="tb" onclick="criaTB();">Cria??o de Tabela</div></div>
		<div><div class="stru" onclick="criaStru();">Cria??o da Estrutura das Tabelas</div></div>
		<div><div class="tb" onclick="listaTB();">Lista uma Tabela</div></div>
	</div>
	<div id="dados">
		<table>
			<tr><td><label>Nome do Banco:</label></td><td><input type=text id="bd"></td></tr>
			<tr><td><label>Nome da Tabela:</label></td><td><input type=text id="tb"></td></tr>
		</table>
	</div>
</body>