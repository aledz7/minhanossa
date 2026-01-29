<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rs_fotos = 100;
$pageNum_rs_fotos = 0;
if (isset($_GET['pageNum_rs_fotos'])) {
  $pageNum_rs_fotos = $_GET['pageNum_rs_fotos'];
}
$startRow_rs_fotos = $pageNum_rs_fotos * $maxRows_rs_fotos;

mysql_select_db($database_conexao, $conexao);
$query_rs_fotos = "SELECT * FROM tbl_fotos where id_galeria = '$_GET[id]' and tipo = '$_GET[tipo]' order by id desc";
$query_limit_rs_fotos = sprintf("%s LIMIT %d, %d", $query_rs_fotos, $startRow_rs_fotos, $maxRows_rs_fotos);
$rs_fotos = mysql_query($query_limit_rs_fotos, $conexao) or die(mysql_error());
$row_rs_fotos = mysql_fetch_assoc($rs_fotos);

if (isset($_GET['totalRows_rs_fotos'])) {
  $totalRows_rs_fotos = $_GET['totalRows_rs_fotos'];
} else {
  $all_rs_fotos = mysql_query($query_rs_fotos);
  $totalRows_rs_fotos = mysql_num_rows($all_rs_fotos);
}
$totalPages_rs_fotos = ceil($totalRows_rs_fotos/$maxRows_rs_fotos)-1;

$queryString_rs_fotos = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs_fotos") == false && 
        stristr($param, "totalRows_rs_fotos") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs_fotos = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs_fotos = sprintf("&totalRows_rs_fotos=%d%s", $totalRows_rs_fotos, $queryString_rs_fotos);

if($_POST[id_galeria] <> '') {

/// UPLOAD
function getmicrotime()
      {
         list($usec, $sec) = explode(" ", microtime());
         return ((float)$usec + (float)$sec);
      }
$tmp = getmicrotime();


$n=0;
for ($i=0; $i< $_POST[opcoes]; $i++) 
{
$n++;

$campo = 'foto_'.$n;
if($_FILES[$campo][name]) {
$file = $_FILES[$campo];
$ext = substr($file[name],strrpos($file[name],"."));
copy($file[tmp_name],"../img_noticias/$tmp-$campo$ext");
$$campo = "$tmp-$campo$ext"; }

$insertSQL = sprintf("INSERT INTO tbl_fotos (id_galeria, tipo, descricao, foto) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_galeria'], "text"),
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST["descricao_$n"], "text"),
                       GetSQLValueString($$campo, "text"));

  mysql_select_db($database_conexao, $conexao);
  $Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());

}


echo "	<script>
		window.location='controle-de-fotos.php?id=$_POST[id_galeria]&tipo=$_POST[tipo]';
		</script>";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Controle de Fotos</title>

<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />
<style type="text/css">
body,td,th {
	font-family: RobotoRegular, "Helvetica Neue", Helvetica, sans-serif;
}
</style>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-fileupload.min.js"></script>
<script type="text/javascript" src="js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="js/jquery.autogrow-textarea.js"></script>
<script type="text/javascript" src="js/charCount.js"></script>
<script type="text/javascript" src="js/ui.spinner.min.js"></script>
<script type="text/javascript" src="js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/forms.js"></script>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="load.js"></script>
<meta charset="UTF-8" />
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) 
	
if(document.getElementById('titulo').value == '') {
	document.getElementById('erro_titulo').style.color = 'red'; } else { 	document.getElementById('erro_titulo').style.color = 'black'; }
	
    document.MM_returnValue = (errors == '');
} }
</script>
</head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
    
<?php include_once('header.php');?>
    
<?php include_once('inc_coluna.php');?>
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="marcas.php">Controle de Fotos</a> <span class="separator"></span></li>
            <li>Adicionar Fotos</li>
        </ul>
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-edit"></span>Controle de Fotos</h4>
            <div class="widgetcontent">
           
               
<div style="margin-left:3px; margin-right:3px;">
  <table width="100%" border="0">
                <tr>
                  <td width="10%" align="right" class="texto_preto">
                  	<strong>Quantidade:</strong>
                  </td>
                  <td width="4%">
                  	<input name="opcoes" type="text" class="input-small" id="opcoes" value="<? if($_GET[opcoes] == '') { echo 1; } else { echo $_GET[opcoes]; } ?>" size="2" style="height:19px; text-align:center">
                  </td>
                  <td width="86%">
                  	<a href="javascript:;" onClick="window.location='controle-de-fotos.php?tipo=<?=texto($_GET[tipo]);?>&id=<?=$_GET[id];?>&opcoes=' + document.getElementById('opcoes').value" class="btn btn-mini btn-success" style="float:left; margin-left:7px; margin-top: 10px; " >Avan&ccedil;ar</a>
                  	<input name="id" type="hidden" id="id" value="<?=$_GET[id];?>">
                  </td>
                </tr>
              </table>	
          
            <form action="?pg=controle-de-fotos" method="post" enctype="multipart/form-data" id="form1" name="form1">
            <?
$n=0;
for ($i=0; $i< $_GET[opcoes]; $i++) 
{
$n++;
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:5px;">
                <tr>
                  <td width="9%" align="right" nowrap class="texto_preto"><strong>Nova foto <?=$n;?>:&nbsp;</strong></td>
                  <td width="91%"><input name="foto_<?=$n;?>" type="file" class="txtbox2" id="foto_<?=$n;?>"></td>
                  </tr>
              </table>
<span class="texto_preto">   
<? } 
if ($_GET[opcoes] <> '') {?>
<br>
              <input name="id_galeria" type="hidden" id="id_galeria" value="<?=$_GET[id];?>">
              <input name="opcoes" type="hidden" id="opcoes" value="<?=$_GET[opcoes];?>" />
              <input name="tipo" type="hidden" id="tipo" value="<?=texto($_GET[tipo]);?>" />
</span>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    	<a href="javascript:document.getElementById('Loading').innerHTML = '<img src=images/loading2.gif>'; document.form1.submit();" class="btn btn-mini btn-success" style="float:left" >Confirmar</a>
    	&nbsp;&nbsp;<span id="Loading"><img src="images/loading2.gif" width="0" height="0" /></span><input name="" type="image" style="width:0px; height:0px;" value="" />
    </td>
  </tr>
</table>
<? } ?>
            </form>
          <div class="row">
            <?php if ($totalRows_rs_fotos > 0) { // Show if recordset not empty ?>
  <?php do { ?>
   <div class="col-md-3">
   <img src="../img_noticias/<?php echo $row_rs_fotos['foto']; ?>" width="150" style="margin-bottom:5px;"><br>

<a href="javascript:;" class="btn btn-mini btn-danger" style="text-align:left; margin-left:37px;" onClick="MM_openBrWindow('excluir-foto.php?volta=<?=$_GET[tipo];?>&id=<?php echo $row_rs_fotos['id']; ?>&idGaleria=<?=$_GET['id'];?>&tbl=tbl_fotos','excluir','status=yes,width=300,height=130')">Excluir</a>

    </div>
    <?php } while ($row_rs_fotos = mysql_fetch_assoc($rs_fotos)); ?>
	</div>         
  <div style="width:640px; display:inline;">
    <table border="0">
      <tr>
        <td><?php if ($pageNum_rs_fotos > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rs_fotos=%d%s", $currentPage, 0, $queryString_rs_fotos); ?>"><img src="First.gif" border="0"></a>
          <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_rs_fotos > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rs_fotos=%d%s", $currentPage, max(0, $pageNum_rs_fotos - 1), $queryString_rs_fotos); ?>"><img src="Previous.gif" border="0"></a>
          <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_rs_fotos < $totalPages_rs_fotos) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rs_fotos=%d%s", $currentPage, min($totalPages_rs_fotos, $pageNum_rs_fotos + 1), $queryString_rs_fotos); ?>"><img src="Next.gif" border="0"></a>
          <?php } // Show if not last page ?></td>
        <td><?php if ($pageNum_rs_fotos < $totalPages_rs_fotos) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rs_fotos=%d%s", $currentPage, $totalPages_rs_fotos, $queryString_rs_fotos); ?>"><img src="Last.gif" border="0"></a>
          <?php } // Show if not last page ?></td>
      </tr>
    </table>
  </div>
<?php } // Show if recordset not empty ?></div>
           
            </div>
            </div>
            
       
            <?php include_once('footer.php');?>