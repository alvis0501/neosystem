<?php
class FatalErrorShow {
	function execute($smarty, $errors){
		$smarty->assign("errors", $errors);
		$smarty->display("fatalerror.html");
	}
}
?>
