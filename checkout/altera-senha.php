<? 
include('Connections/conexao.php');
include('funcoes.php');

if($_POST[tipo] == 'altera_senha') {
	$updateSQL = sprintf("UPDATE tbl_users SET senha=%s WHERE id=%s",
                       GetSQLValueString($_POST['senha'], "text"),
					   GetSQLValueString($_POST['id'], "text")); 
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());

		   
		    require("phpmailer/class.phpmailer.php");
	// Define os dados do servidor e tipo de conexão
          $mail = new PHPMailer();
		  
		  $mensagem = "<b>Solicitação de troca de senha!</b> <br /> <br />";
		  $mensagem.= "Foi solicitado a troca de senha, caso não tenha sido você por favor clique no link abaixo para recuperar sua conta: <br/>";
		  $mensagem.= "<a href=\"recupera-senha.php\">Recuperar minha conta</a><br/>";
		  $mensagem.= "Caso tenha solicitado a alteração da senha por favor desconsidere esse email!";
		  
		  $mail->IsSMTP(); // telling the class to use SMTP


		  try {
			 $mail->Host       = "smtp-vip.uni5.net";// sets GMAIL as the SMTP server
			 $mail->SMTPDebug  = 1;// enables SMTP debug information (for testing)
			 $mail->SMTPAuth   = true;// enable SMTP authentication
			// $mail->SMTPSecure = "ssl";// sets the prefix to the servier
			 $mail->Host       = "smtp-vip.uni5.net";// sets GMAIL as the SMTP server
			 $mail->Port       = 587;// set the SMTP port for the GMAIL server
			 $mail->Username   = "emailPadrão";// GMAIL username
			 $mail->Password   = "senha do emailPadrão";// GMAIL password
			 $mail->AddReplyTo($_POST['email'], $_POST['nome']);
			 $mail->AddAddress($_POST['email']);
			 $mail->SetFrom('emailPadrão', 'Nome da Empresa');
			 $mail->Subject = 'Solicitação de troca de senha!';
			 $mail->AltBody = 'Para ver a mensagem utilize um visualizador de e-mail compatível com HTML!'; 
			 $mail->MsgHTML($mensagem);
			 $mail->Send();
			 
			 echo "<script type='text/javascript'>
			         alert('Senha alterada com sucesso!');
			         window.location='area-cliente.php';
                   </script>";
		 
		  } catch (phpmailerException $e) {
			  echo $e->errorMessage(); //Pretty error messages from PHPMailer
		  } catch (Exception $e) {
			  echo $e->getMessage(); //Boring error messages from anything else!
		  }
}
?>