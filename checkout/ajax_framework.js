// JavaScript Document

function getHTTPObject() {
var xmlhttp;
if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
try {
xmlhttp = new XMLHttpRequest();
} catch (e) {
xmlhttp = false; }
}
return xmlhttp; }

var http = getHTTPObject();


/// EXCLUSÃO DE REGISTROS
function ExcluirRegistro(IdRegistro, tabela, voltaURL) {
	if(confirm("Tem certeza que deseja excluir este registro?")) {
		http.open("GET", 'outrosPHP.php?acao=excluirRegistro&id='+IdRegistro+'&tbl='+tabela, true);
		http.send(null);
		parent.MudaPagina(voltaURL);
	} 
}

/// EXCLUSÃO DE REGISTROS
function ExcluirRegistroJanela(IdRegistro, tabela, voltaURL, janela) {
	if(confirm("Tem certeza que deseja excluir este registro?")) {
		http.open("GET", 'outrosPHP.php?acao=excluirRegistro&id='+IdRegistro+'&tbl='+tabela, true);
		http.send(null);
		parent.AtualizaJanela(voltaURL, janela);
	} 
}


/// EXCLUSÃO DE ANUNCIOS
function ExcluirRegistroFotoMaisControle(IdRegistro, tbl, volta, foto, NomeControle) {
if(confirm("Tem certeza que deseja excluir este registro?")) {

http.open("GET", 'outrosPHP.php?acao=ExcluirRegistroFotoMaisControle&id='+IdRegistro + '&tbl='+tbl + '&volta='+volta + '&foto='+foto + '&NomeControle='+NomeControle, true);
http.send(null);
parent.window.MudaPagina(volta);
} 
}



/// EXCLUSÃO DE REGISTROS + FOTO
function ExcluirRegistroFoto(IdRegistro, tabela, voltaURL, foto) {
if(confirm("Tem certeza que deseja excluir este registro?")) {
http.open("GET", 'outrosPHP.php?acao=excluirRegistroFoto&id='+IdRegistro+'&tbl='+tabela+'&foto='+foto, true);
http.send(null);
parent.MudaPagina(voltaURL);
MudaPagina(voltaURL);
} 
}


/// EXCLUSÃO DE REGISTROS DE CLASSES + FOTOS
function ExcluirRegistroClasse(IdRegistro, tabela, voltaURL) {
if(confirm("Tem certeza que deseja excluir este registro?")) {

http.open("GET", 'outrosPHP.php?acao=ExcluirRegistroClasse&id='+IdRegistro+'&tbl='+tabela, true);
http.send(null);
parent.MudaPagina(voltaURL);
MudaPagina(voltaURL);
} 
}



/// ESQUECI MINHA SENHA...
function enviaSenha() {
http.open("GET", 'outrosPHP.php?acao=esqueciSenha&email='+document.getElementById("email").value, true);
http.onreadystatechange = handleHttpResponse;
http.send(null);

var arr; //array com os dados retornados
function handleHttpResponse() {
if (http.readyState == 4) {
var response = http.responseText;
eval("var arr = "+response); //cria objeto com o resultado

if(arr.erro == 'S') {
document.getElementById('formSenha').style.display = 'none';
document.getElementById('sucessoSenha').style.display = '';
document.getElementById('Loading').innerHTML = '';
document.getElementById('sucessoSenha').innerHTML = "E-mail n&atilde;o encontrado em nossa base de dados.<br><br><a href=javascript:; onclick=javascript:document.getElementById('formSenha').style.display='';document.getElementById('sucessoSenha').style.display='none'>Tentar novamente</a>"; 
} else {
document.getElementById('sucessoSenha').style.display = '';
document.getElementById('sucessoSenha').innerHTML = '<br><br>A senha solicitada foi enviada para o seu e-mail.';
document.getElementById('formSenha').style.display = 'none'; }
}
}
}


/// LOGIN...
function Login() {
if(document.getElementById('login').value == '') {
	document.getElementById('msglogin').style.display = '';
	document.getElementById('login').focus();
}

if(document.getElementById('senha').value == '') {
	document.getElementById('msgsenha').style.display = '';
	document.getElementById('senha').focus();
}

http.open("GET", 'outrosPHP.php?acao=Login&login='+document.getElementById("login").value+'&senha='+document.getElementById("senha").value, true);
http.onreadystatechange = handleHttpResponse;
http.send(null);

var arr; //array com os dados retornados
function handleHttpResponse() {
if (http.readyState == 4) {
var response = http.responseText;
eval("var arr = "+response); //cria objeto com o resultado
if(arr.login == 'ok') {
window.location='.' } else {
document.getElementById('erroLogin').style.display = '';
document.getElementById('Loading').style.display = 'none'; }

}
}
}