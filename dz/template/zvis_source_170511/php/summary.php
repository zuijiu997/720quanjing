<?php
$summary = DB::result(DB::query("SELECT message FROM ".DB::table('forum_post')." WHERE tid = '$thread[tid]' AND first = '1' ")); $summary_echo = preg_replace ("/\[[a-z][^\]]*\]|\[\/[a-z]+\]/i",'',preg_replace("/\[attach\]\d+\[\/attach\]/i",'',$summary));

?>