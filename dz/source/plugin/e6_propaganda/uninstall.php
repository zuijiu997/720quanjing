<?php
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$sql = "DROP TABLE `pre_e6_pro_user`, `pre_e6_pro_user_count`, `pre_e6_pro_credit`, `pre_e6_pro_clientorder`, `pre_e6_pro_finance`, `pre_e6_pro_task`, `pre_e6_pro_task_list`, `pre_e6_pro_visit`;";
runquery($sql);
$finish = TRUE;
@unlink(DISCUZ_ROOT . '/data/e6_propaganda.config.php');
?>