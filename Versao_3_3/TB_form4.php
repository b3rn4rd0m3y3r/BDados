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
	// Conversão de caracteres, byte a byte
	function stringToBytes(text) {
		const length = text.length;
		const result = new Uint8Array(length);
		var S = "";
		for (let i = 0; i < length; i++) {
			const code = text.charCodeAt(i);
			const byte = code > 255 ? code : code;
			result[i] = byte;
			S += String.fromCharCode(code);
			}
			return result;
			//return S;
	}
	function checa(){
		console.log((ob.getById("Tabela")).value);
		alert("vai");
		return false;
		}
	// Função disparada quando o fonte está todo carregado (DOM e PHP)
	function init(){
		//var raiz = ob.getById("tbCampos");
		var fragmento = document.createDocumentFragment();
		//raiz.innerHTML = displayTable();
		// Checa o parâmetro Tabela
		// 1 - Vazio
		if( TABELA == "" ){
			alert("Nome da tabela não foi fornecido.");
			return;
			}
		// 2 - Sem extensão
		var EXT = ob.right(TABELA,4);
		if( EXT != ".tmy" ){
			TABELA = TABELA + ".tmy";
			}		
		// Ajusta o action do form
		//ob.getById("frm1").action = "TB_add.php?Tabela="+TABELA;
		// Carrega a estrutura da TABELA
		loadStru(TABELA);
		return;		
		}
	// Carrega a estrutura da tabela nos campos do grid (TELA)
	function loadStru(tabela){
		var myHeaders = new Headers();
		myHeaders.append('Content-Type','text/plain; charset=iso-8859-1');
		// <tabela>.tmy
		fetch(tabela, myHeaders)
			.then(function (response) {
						return response.arrayBuffer();
						//return response.text();
					})
			.then(function (result) {
				var arrTit = tabela.split(".");
				ob.getById("tit").innerText = arrTit[0];
				const decoder = new TextDecoder('iso-8859-1');
				const text = decoder.decode(result);
				
				RES = text;
				ob.getById("tbRes").innerText = RES;
				console.log("R:"+RES);
				
				var arr = RES.split("\n");
				
				// Carrega os campos no grid
				var flds = (JSON.parse(arr[1])).campos;
				console.log(flds);
				var html = "";
				var frm = "";
				for(i=0;i<flds.length;i++){
					console.log(flds[i]);
					console.log("Nomestru: "+flds[i].Nomestru);
					console.log("Nome: "+flds[i].Nome);
					console.log("Tipo: "+flds[i].Tipo);
					console.log("Tamanho: "+flds[i].Tamanho);
					html += "<tr><td><label>"+flds[i].Nome+"</label></td><td><input type=\""+flds[i].Tipo+"\" id=\""+flds[i].Nomestru+"\" name=\"f_"+flds[i].Nomestru+"\" size="+flds[i].Tamanho+"></td></tr>";
					}
				html += "<tr><td colspan=2 align=center><input name=\"Tabela\" type=hidden value=\"" + tabela + "\"></td></tr>";
				html += "<tr><td colspan=2 align=center><input type=submit value=Grava></td></tr>";
				frm = "<form id=\"frm1\" method=\"post\" action=\"TB_add.php\" enctype=\"multipart/form-data\" onsubmit=\"checa();\">";
				ob.getById("frm1").innerHTML = frm+"<table>"+html+"</form></table>";
				
				return RES;
				});
		}
	</script>
</head>
<body onload="init();">
	<h1 id="tit"></h1>
	<center id="frm1">

	</center>
	<div id="tbRes" class="hide"></div>
</body>
