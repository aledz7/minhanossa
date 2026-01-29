<?php
@ session_start();

if($_SESSION['MM_Username'] == '' or $_SESSION['grupoLogin'] <> 'site') {
	echo "	<script>
			window.location='{$redireciona}';
			</script>";
			exit;
}
?>