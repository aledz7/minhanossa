<?php require_once('Connections/conexao.php'); ?>
<?php
include('funcoes.php');

// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  if (!isset($_SESSION)) { session_start(); }
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if(isset($_POST['login'])) {
	$loginUsername=$_POST['login'];
	$password=$_POST['senha'];
	$MM_fldUserAuthorization = "";
	$MM_redirectLoginSuccess = "index.php";
	$MM_redirectLoginFailed = "login_incorreto.php";
	$MM_redirecttoReferrer = false;
	mysql_select_db($database_conexao, $conexao);
  
	$LoginRS__query=sprintf("SELECT * FROM tbl_admin WHERE login=%s AND senha=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
	$LoginRS = mysql_query($LoginRS__query, $conexao) or die(mysql_error());
	$loginFoundUser = mysql_num_rows($LoginRS);

	if ($loginFoundUser) {
		$loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
		//declare two session variables and assign them
		$_SESSION['dadosUser'] = mysql_fetch_assoc($LoginRS);
		$_SESSION['MM_Username'] = $loginUsername;
		$_SESSION['MM_UserGroup'] = $loginStrGroup;	      
		
		// Marca ponto
		$_GET['id'] = 'chegada';
		$_GET['idLogado'] = $_SESSION['dadosUser']['id'];
		$_GET['nomeLogado'] = $_SESSION['dadosUser']['nome'];
		include('cartao_ponto.php');
		
    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    echo "	<script>
			window.location='{$MM_redirectLoginSuccess}';
			</script>";
			exit;
  }
  else {
	  echo "	<script>
			window.location='{$MM_redirectLoginFailed}';
			</script>";
			exit;
    
  }
}



?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Sistema</title>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/style.shinyblue.css" type="text/css" />
<style type="text/css">
body,td,th {
	font-family: RobotoRegular, "Helvetica Neue", Helvetica, sans-serif;
}
</style>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#login').submit(function(){
            var u = jQuery('#username').val();
            var p = jQuery('#password').val();
            if(u == '' && p == '') {
                jQuery('.login-alert').fadeIn();
                return false;
            }
        });
    });
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" /></head>

<body class="loginpage">

<div class="loginpanel">
    <div class="loginpanelinner">
       <!-- <div class="logo animate0 bounceIn"><img src="images/logo_top.png" alt="" /></div> -->
        <form id="formLogin" method="post" name="formLogin" /> 
            <div class="inputwrapper login-alert">
                <!--<div class="alert alert-error">Invalid username or password</div>-->
            </div>
            <div class="inputwrapper animate1 bounceIn">
                <input type="text" name="login" id="login" placeholder="Seu Login" />
            </div>
            <div class="inputwrapper animate2 bounceIn">
                <input type="password" name="senha" id="senha" placeholder="Sua Senha" />
            </div>
            <div class="inputwrapper animate3 bounceIn">
                <button name="submit">Entrar</button>
            </div>
		</form>
    </div><!--loginpanelinner-->
</div><!--loginpanel-->

<div class="loginfooter">
    <p>&copy; <?php echo date('Y');?>. Minha nossa. Todos os Direitos Reservados.</p>
</div>

</body>
</html>
