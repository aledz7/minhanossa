<?php
include('../class/info-site.php');
$infoSite = InfoSite::getInstance(Conexao::getInstance())->rsDados();

require("phpmailer/class.phpmailer.php");

if($_POST['acao'] == 'contato'){

	      // Define os dados do servidor e tipo de conexão
          $mail = new PHPMailer();
		  
		  $mensagem = "<b>Contato via site - {$infoSite->nome}</b> <br /> <br />";
		  $mensagem.= "<b>Nome:</b> ".$_POST['nome']." <br />";
		  $mensagem.= "<b>E-Mail:</b> ".$_POST['email']." <br />";
		  $mensagem.= "<b>Mensagem:</b> ". $_POST['msg']."  <br />";
		  
		  $mail->IsSMTP(); // telling the class to use SMTP


		  try {
			 $mail->Host       = "smtp-vip.uni5.net";// sets GMAIL as the SMTP server
			 $mail->SMTPDebug  = 1;// enables SMTP debug information (for testing)
			 $mail->SMTPAuth   = true;// enable SMTP authentication
			// $mail->SMTPSecure = "ssl";// sets the prefix to the servier
			 $mail->Host       = "smtp-vip.uni5.net";// sets GMAIL as the SMTP server
			 $mail->Port       = 587;// set the SMTP port for the GMAIL server
			 $mail->Username   = $infoSite->usuario_smtp;// GMAIL username
			 $mail->Password   = $infoSite->senha_smtp;// GMAIL password
			 $mail->AddReplyTo($_POST['email'], $_POST['nome']);
			 $mail->AddAddress($infoSite->email);
			 $mail->SetFrom($infoSite->email, $infoSite->nome);
			 $mail->Subject = 'Contato via site - '.$infoSite->nome;
			 $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; 
			 $mail->MsgHTML($mensagem);
			 $mail->Send();
			 
			 echo "
			        <script type='text/javascript'>
					 alert('Sua mensagem foi enviada com sucesso!');
					 window.location='contato.php';
				    </script>\n";
		 
		  } catch (phpmailerException $e) {
			  echo $e->errorMessage(); //Pretty error messages from PHPMailer
		  } catch (Exception $e) {
			  echo $e->getMessage(); //Boring error messages from anything else!
		  }
		  
}

if($_POST['acao'] == 'comunicarErro'){

	      // Define os dados do servidor e tipo de conexão
          $mail = new PHPMailer();
		  
		  $mensagem = "<b>Comunicar Erro - EQUILIBRIO BIORGÂNICA</b> <br /> <br />";
		  $mensagem.= "<b>Nome:</b> ".$_POST['nome']." <br />";
		  $mensagem.= "<b>E-Mail:</b> ".$_POST['email']." <br />";
		  $mensagem.= "<b>Mensagem:</b> ". $_POST['msg']."  <br />";
		  
		  $mail->IsSMTP(); // telling the class to use SMTP


		  try {
			 $mail->Host       = "smtp-vip.uni5.net";// sets GMAIL as the SMTP server
			 $mail->SMTPDebug  = 1;// enables SMTP debug information (for testing)
			 $mail->SMTPAuth   = true;// enable SMTP authentication
			// $mail->SMTPSecure = "ssl";// sets the prefix to the servier
			 $mail->Host       = "smtp-vip.uni5.net";// sets GMAIL as the SMTP server
			 $mail->Port       = 587;// set the SMTP port for the GMAIL server
			$mail->Username   = $infoSite->usuario_smtp;// GMAIL username
			 $mail->Password   = $infoSite->senha_smtp;// GMAIL password
			 $mail->AddReplyTo($_POST['email'], $_POST['nome']);
			$mail->AddReplyTo($_POST['email'], $_POST['nome']);
			 $mail->AddAddress($infoSite->email);
			 $mail->SetFrom($infoSite->email, $infoSite->nome);
			 $mail->Subject = 'Comunicar Erro - '.$infoSite->nome;
			 $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; 
			 $mail->MsgHTML($mensagem);
			 $mail->Send();
			 
			 echo "
			        <script type='text/javascript'>
					 alert('Sua mensagem foi enviada com sucesso!');
					 window.location='contato.php';
				    </script>\n";
		 
		  } catch (phpmailerException $e) {
			  echo $e->errorMessage(); //Pretty error messages from PHPMailer
		  } catch (Exception $e) {
			  echo $e->getMessage(); //Boring error messages from anything else!
		  }
		  
}
	
?>