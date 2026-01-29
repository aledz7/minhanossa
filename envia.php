<?php require_once('Connections/conexao.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_conexao, $conexao);
$query_rs_email = "SELECT * FROM tbl_cliente WHERE email = '".$_POST['email']."'";
$rs_email = mysql_query($query_rs_email, $conexao) or die(mysql_error());
$row_rs_email = mysql_fetch_assoc($rs_email);
$totalRows_rs_email = mysql_num_rows($rs_email);

$email = $row_rs_email['email'];

if($totalRows_rs_email > 0){

 include('funcoes.php');

 require("phpmailer/class.phpmailer.php");

 require 'recaptchalib.php';
	// Define os dados do servidor e tipo de conex?o

	$response = null;

	

	$secret = "6LcYpz4nAAAAACq5ydUKquPnEDy89uKVMGkbbY19"; ////ESSE É A SECRET KEY

	$ip = $_SERVER['REMOTE_ADDR'];

	$captcha = $_POST['g-recaptcha-response'];



	// verifique a chave secreta

	$reCaptcha = new ReCaptcha($secret);



	$rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");

		

		// var_dump($rsp);

	   $arr = json_decode($rsp,TRUE);



	   if($arr['success'] == 1)



        $mail = new PHPMailer();
		  
		  $mensagem = "Olá conforme solicitado informamos que sua senha para acesso ao painel de cliente é: <strong>'".$row_rs_email['senha']."'</strong><br>
		  	Qualquer dúvida nao deixe de entrar em contato conosco.
<br>
<br>

Muito obrigado.<br>
Equipe Minha Nossa!
<hr>";
		  
		  $mail->IsSMTP(); // telling the class to use SMTP


		  try {
			 $mail->Host       = "smtp-vip.uni5.net";// sets GMAIL as the SMTP server
			 $mail->SMTPDebug  = 1;// enables SMTP debug information (for testing)
			 $mail->SMTPAuth   = true;// enable SMTP authentication
			// $mail->SMTPSecure = "ssl";// sets the prefix to the servier
			 $mail->Host       = "smtp-vip.uni5.net";// sets GMAIL as the SMTP server
			 $mail->Port       = 587;// set the SMTP port for the GMAIL server
			 $mail->Username   = "minhanossa@minhanossa.net.br";// GMAIL username
			 $mail->Password   = "df123456";// GMAIL password
			 //$mail->AddReplyTo($_POST['email'], $_POST['nome']);
			 $mail->AddAddress($email);
			 $mail->SetFrom('minhanossa@minhanossa.net.br', 'MINHA NOSSA!');
			 $mail->Subject = 'Recuperação de senha - MINHA NOSSA!';
			 $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; 
			 $mail->MsgHTML($mensagem);
			 $mail->Send();
			 
		 
		  } catch (phpmailerException $e) {
			  echo $e->errorMessage(); //Pretty error messages from PHPMailer
		  } catch (Exception $e) {
			  echo $e->getMessage(); //Boring error messages from anything else!
		  }
 
/* Mostrando na tela as informações enviadas por e-mail */
echo 
"
<script>
alert('$assunto enviada com sucesso!');
window.location='index.php';
</script>
";


	} else{
echo 
"
<script>
alert('Email não cadastrado em nosso sistema!');
history.back();
</script>
";		
		
	}
	
	
 
		

	



	echo "<script type='text/javascript'>alert('Sua mensagem foi enviada com sucesso!');window.location='index.php?nome=Home';</script>\n";

	

	

	

?> 