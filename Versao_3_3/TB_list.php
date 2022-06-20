<?php header ('Content-type: text/html; charset=ISO-8859-1'); ?>
<head>
	<link rel="icon"       type="image/ico"       href="favicon.ico">
	<meta charset="ISO-8859-1"/>
	<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
	<style>
		BODY {font-family: Arial;}
		DIV.hide {display: none;}
		H1 {text-align: center;}
	</style>
	<script type="text/javascript" src="BMyFrmwk.js"></script>
	<script type="text/javascript" charset="iso-8859">
	// Handle para o framework BMy
	var ob = new BMy();
	// Lê parâmetro "Tabela" na URL
	var url = window.location;
	var sUrl = url.search;
	var pos = url.search.search(/Tabela/);
	var TABELA = sUrl.substr(pos+7,99);
	var S = "";
	// Pega o conteúdo do arquivo e trabalha, separando os campos
	function relTab(resultado){
		console.log(resultado);
		// Descarrega o conteúdo lido em array
		var arrRes = resultado.split("\n");
		console.log(arrRes);
		var jitem = null;
		var html = null;
		var tmp = null;
		html = "<table border=1 cellspacing=0 cellpadding=4>";
		html += "<tr>";
		jitem = JSON.parse(arrRes[0]);
		for( var i in jitem){
			html += "<th>" +  i + "</th>";
			}
		html += "</tr>";
		var k = 0;
		var w = 0;
		for( item in arrRes ){
			// Última linha pode conter vazio
			if( arrRes[item] != "" ){
				k++;
				html += "<tr>";
				jitem = JSON.parse(arrRes[item]);
				// Rastreia as variáveis deste tipo de registro
				w = 0;
				for( var i in jitem){
					w++;
					console.log(i + " " + jitem[i]);
					html += "<td id=\"i" + ob.ZeroField(k,4) + "" + w + "\">" +  jitem[i] + "</td>";
					}
				html += "</tr>";
				}
			}
		html += "</table>";
		(ob.getById("tb")).innerHTML = html;
		return html;
		}
	// Lê a tabela em seu formato txt de extensão .dat
	function lisTab(tabela){
		// LEIA O ARQUIVO EM javascript com fetch
		var RES = "";
		var myHeaders = new Headers();
		myHeaders.append('Content-Type','text/plain; charset=iso-8859-1');

		fetch(tabela, myHeaders)
			.then(function (response) {
						return response.arrayBuffer();
					})
			.then(function (result) {
				const decoder = new TextDecoder('iso-8859-1');
				const text = decoder.decode(result);
				RES = text;
				return relTab(text);
				});
		}
	// Função disparada quando o fonte está todo carregado (DOM e PHP)
	function init(){
		var fragmento = document.createDocumentFragment();
		// Checa o parâmetro Tabela
		// 1 - Vazio
		if( TABELA == "" ){
			alert("Nome da tabela não foi fornecido.");
			return;
			}
		// 2 - Sem extensão
		var EXT = ob.right(TABELA,4);
		if( EXT != ".dat" ){
			TABELA = TABELA + ".dat";
			}		
		// Ajusta o action do form
		// ob.getById("frm1").action = "TB_add.php?Tabela="+TABELA;
		// Lista registros da TABELA
		var html = lisTab(TABELA);
		
		return;		
		}
	</script>
</head>
<body onload="init();">
<?php
?>
<!-- table>
	<tr><td>xxxx</td></tr>
	<tr><td>xxxx</td><td>yyyy</td></tr>
	<tr><td>xxxx</td><td>yyyy</td><td>zzzz</td></tr>
</table -->
<div id="tb"></div>
</body>
