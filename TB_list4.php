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
	var arrCampos = [];
	var S = "";
	function sortFunction(a, b) {
		if (a[0] === b[0]) {
			return 0;
			} else {
			return (a[0] < b[0]) ? -1 : 1;
			}
	}
	// Carrega a estrutura da tabela
	function loadStru(tabela){
		var myHeaders = new Headers();
		myHeaders.append('Content-Type','text/plain; charset=iso-8859-1');
		// <tabela>.tmy
		fetch(tabela, myHeaders)
			.then(function (response) {
				return response.text();
			})
			.then(function (result) {
				RES = result;
				//ob.getById("tbRes").innerText = RES;
				console.log("R:"+result);
				var arr = result.split("\n");
				// Carrega os campos no grid
				var flds = (JSON.parse(arr[1])).campos;
				console.log(flds);
				for(i=0;i<flds.length;i++){
					console.log(flds[i]);
					arrCampos[i] = [];
					arrCampos[i].Nomestru = flds[i].Nomestru;
					arrCampos[i].Nome = flds[i].Nome;
					arrCampos[i].Tipo = flds[i].Tipo;
					arrCampos[i].Tamanho = flds[i].Tamanho;
					//addline();
					}
				var arrT = tabela.split(".");
				var html = lisTab(arrCampos, arrT[0]+".dat");
				return arrCampos;
				});
		}
	// Pega o conteúdo do arquivo e trabalha, separando os campos
	function relTab(arrCps, resultado){
		console.log(resultado);
		// Descarrega o conteúdo lido em array
		var arrRes = resultado.split("\n");
		console.log(arrRes);
		var jitem = null;
		var html = null;
		var tmp = null;
		var arrCab = [];
		var arrCabTp = [];
		var arrCabTam = [];
		var arrCabNome = [];
		var arrTmp = [];
		var arrReg = [];
		// Procedimentos para ordenação
		//jitem = JSON.parse(arrRes[0]);
		arrCab.push("uuid");
		arrCabTp.push("text");
		arrCabTam.push("10");
		arrCabNome.push("Chave");
		//for( var i in jitem){
		for( var i in arrCps){
			//arrCab.push(i);
			arrCab.push(arrCps[i].Nomestru);
			arrCabTp.push(arrCps[i].Tipo);
			arrCabTam.push(arrCps[i].Tamanho);
			arrCabNome.push(arrCps[i].Nome);
			}
		var k = 0;
		var w = 0;
		// Alimenta o array
		for( item in arrRes ){
			// Última linha pode conter vazio
			if( arrRes[item] != "" ){
				jitem = JSON.parse(arrRes[item]);
				// Rastreia as variáveis deste tipo de registro
				arrTmp = [];
				for( var i in jitem){
					console.log(i + " " + jitem[i]);
					arrTmp.push( jitem[i]);
					}
				arrReg.push(arrTmp);
				}
			}
		console.log("ArrReg: ");
		console.log(arrReg);
		arrReg.sort(sortFunction);
		// Apresentação do resultado da ordenação
		html = "<style>TH { background: lightgrey; color: dimgrey; }</style>";
		html += "<table border=1 cellspacing=0 cellpadding=4>";
		// Cabeçalho
		html += "<tr>";
		for( item in arrCab ){
			html += "<th>" +  arrCabNome[item] + "</th>";
			}
		html += "</tr>";
		arrTmp = null;
		var k = 0;
		var w = 0;
		var uuid_ant = "";
		var uuid = "";
		var Shtml = html;
		for( item in arrReg ){
			uuid = arrReg[item][0];
			if( item == 0 ) uuid_ant = uuid;
			// Só imprime se for diferente, para o caso de haverem registros editados
			// Desta forma, só o último registro editado é pego
			if( uuid != uuid_ant ){
				Shtml += html;
				uuid_ant = uuid;
				}
			html = ""; // Zera a linha de html
			arrTmp = arrReg[item];
			k++;
			html += "<tr>";
			w = 0;
			for( cp in arrTmp ){
				w++;
				html += "<td id=\"i" + ob.ZeroField(k,4) + "" + w + "\" align=";
				switch(arrCabTp[cp]){
					case "date":
						html += "right";
						break;
					case "number":
						html += "right";
						break;
					case "text":
						html += "left";
						break;
					default:
						html += "left";
					}
				html += ">";
				// Impressão excepcional do tipo date
				if( arrCabTp[cp] == "date" ){
					html += invData(arrTmp[cp]);
					} else {
					html += arrTmp[cp];
					}
				html += "</td>";
				}
			html += "<td><a href=\"TB_FormEdit.php?";
			w = 0;
			// Envia os campos na URL
			for( cp in arrTmp ){
				w++;
				html += arrCab[cp]+"="+arrTmp[cp]+"&";
				}
			//html = html.substr(0,html.length-1);
			html += "_Tabela="+TABELA;
			html += "\">Editar</a></td>";
			html += "</tr>";
			}
		Shtml += html;
		Shtml += "</table>";
		(ob.getById("tb")).innerHTML = Shtml;
		return html;
		}
	// Função de endireitamento da data, para apresentação em formato dd/mm/aaaa
	function invData(txtData){
		return ob.right(txtData,2)+"/"+ob.mid(txtData,5,2)+"/"+ob.left(txtData,4);
		}
	// Lê a tabela em seu formato txt de extensão .dat
	function lisTab(arrCps, tabela){
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
				return relTab(arrCps, text);
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
		// 3 - Extrai o nome da tabela sem extensão
		var arrt = TABELA.split(".");
		// Ajusta o action do form
		// ob.getById("frm1").action = "TB_add.php?Tabela="+TABELA;
		// Lista registros da TABELA
		
		var arrf = loadStru(arrt[0]+".tmy");
		//var html = lisTab(TABELA);
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
