<?php
// *** Logout the current user.
$logoutGoTo = ".";
if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['MM_Username'] = NULL;
$_SESSION['MM_UserGroup'] = NULL;
$_SESSION['compra'] = NULL;
unset($_SESSION['MM_Username']);
unset($_SESSION['MM_UserGroup']);

session_destroy();

if ($logoutGoTo != "") {
echo "	<script>
		window.location='$logoutGoTo';
		</script>";
exit;
}
?>