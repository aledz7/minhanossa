<?php require_once('Connections/conexao.php'); ?>
<?php
include('funcoes.php');

$colname_rs_usuario_header = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rs_usuario_header = $_SESSION['MM_Username'];
}
mysql_select_db($database_conexao, $conexao);
$query_rs_usuario_header = sprintf("SELECT * FROM tbl_admin WHERE login = %s", GetSQLValueString($colname_rs_usuario_header, "text"));
$rs_usuario_header = mysql_query($query_rs_usuario_header, $conexao) or die(mysql_error());
$row_rs_usuario_header = mysql_fetch_assoc($rs_usuario_header);
$totalRows_rs_usuario_header = mysql_num_rows($rs_usuario_header);
?>
<script>
function marcaPonto(tipo) {
	document.getElementById('enviaColuna').src='cartao_ponto.php?id='+tipo+'&idLogado=<?=$_SESSION['dadosUser']['id'];?>&nomeLogado=<?=$_SESSION['dadosUser']['nome'];?>';
}
</script>
  <div class="header">
    <div class="logo"> <a href="."><img src="images/logopng.png" alt="" /></a> </div>
    <div class="headerinner">
      <ul class="headmenu">
        <!--<li class="odd"> <a class="dropdown-toggle" data-toggle="dropdown" data-target="#"> <span class="count">1</span> <span class="head-icon head-bar"></span> <span class="headmenu-label">Atualiza&ccedil;&otilde;es</span> </a>
          <ul class="dropdown-menu">
            <li class="nav-header">Atualiza&ccedil;&otilde;es</li>
            <li><a href=""><span class="icon-align-left"></span> 21/03/2016 - Inclus&atilde;o autom&aacute;tica da retirada ao imprimir a Nota Promiss&oacute;ria</a></li>
            <li><a href=""><span class="icon-align-left"></span> 21/03/2016 - Inclus&atilde;o do bot&atilde;o devolu&ccedil;&atilde;o na Agenda de devolu&ccedil;&otilde;es</a></li>
          </ul>
        </li>-->
        <li class="right">
          <div class="userloggedinfo"> 
            <div class="userinfo">
              <h5><?php echo $row_rs_usuario_header['nome'];?></h5>
              <ul>
                <!--<li><a href="editprofile.html">Usu&aacute;rios</a></li>-->
                <li><a href="logout.php">Sair</a></li>
              </ul>
            </div>
          </div>
        </li>
      </ul>
      <!--headmenu--> 
    </div>
  </div>
  <?php
mysql_free_result($rs_usuario_header);
?>
