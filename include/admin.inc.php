<?php

include_once 'services/GroupService.php';

$group_user = GroupService::getGroupsByUserId($_SESSION['user']['id']);
foreach ($group_user as $group) {
	if ($group->getNome() == 'Bibliotecario') {
		$smarty->assign('admin', 1);
	} else {
		$smarty->assign('admin', 0);
	}
}

?>