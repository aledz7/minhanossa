<?php 
include('Connections/conexao.php');
include('funcoes.php');

if($_POST['estado'] <> '') {
	
//CONECTA AO MYSQL                     
require_once("conecta.php");           

//RECEBE PARÃMETRO                     
$pEstado = $_POST["estado"];           

//QUERY  
$sql = " 
       SELECT *
        FROM  dados_cidades 
		WHERE id_estado = ".$pEstado."  
		ORDER BY nome asc";            

//EXECUTA A QUERY               
$sql = mysql_query($sql);       

$row = mysql_num_rows($sql);    

//VERIFICA SE VOLTOU ALGO 
if($row) {                
   //XML
   $xml  = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
   $xml .= "<cidades>\n";               
   
   //PERCORRE ARRAY            
   for($i=0; $i<$row; $i++) {  
      $codigo    = mysql_result($sql, $i, "id"); 
	  $descricao = mysql_result($sql, $i, "nome");
      $xml .= "<cidade>\n";     
      $xml .= "<codigo>".$codigo."</codigo>\n";                  
      $xml .= "<descricao>".$descricao."</descricao>\n";         
      $xml .= "</cidade>\n";    
   }//FECHA FOR                 
   
   $xml.= "</cidades>\n";
   
   //CABEÇALHO
   Header("Content-type: application/xml; charset=iso-8859-1"); 
}//FECHA IF (row)                                               

//PRINTA O RESULTADO  
echo $xml;   
exit;
}

$colname_rs_cidades = "-1";
if (isset($_GET['id_estado'])) {
  $colname_rs_cidades = $_GET['id_estado'];
}
mysql_select_db($database_conexao, $conexao);
$query_rs_cidades = sprintf("SELECT * FROM dados_cidades WHERE id_estado = %s ORDER BY nome ASC", GetSQLValueString($colname_rs_cidades, "int"));
$rs_cidades = mysql_query($query_rs_cidades, $conexao) or die(mysql_error());
$row_rs_cidades = mysql_fetch_assoc($rs_cidades);
$totalRows_rs_cidades = mysql_num_rows($rs_cidades);
?>
<link href="css.css" rel="stylesheet" type="text/css" />
 Cidade<br>
<div class="input-prepend">

<select name="cidade" class="uniformselect" id="cidade">
<option value="">Selecione <?php echo ($_GET['id_estado'] == '') ? 'um Estado' : 'uma Cidade';?></option>
  <?php
do {  
?>
  <option value="<?php echo $row_rs_cidades['id']?>"<?php if (!(strcmp($row_rs_cidades['id'], $_GET['id_cidade']))) {echo "selected=\"selected\"";} ?>><?php echo texto($row_rs_cidades['nome']);?></option>
  <?php
} while ($row_rs_cidades = mysql_fetch_assoc($rs_cidades));
  $rows = mysql_num_rows($rs_cidades);
  if($rows > 0) {
      mysql_data_seek($rs_cidades, 0);
	  $row_rs_cidades = mysql_fetch_assoc($rs_cidades);
  }
?>
</select>
</div>
<?
mysql_free_result($rs_cidades);
?>