<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 14-10-2
 * Time: 下午2:49
 */
showtableheader();
$Plang =  $scriptlang['youka_pay'];//lang('youka_pay:help_content');
echo '<style>
qq_c_box{ width:100%; height:auto;}
qq_c_b_title{ width:100%; text-indent:10px; color:#000000; text-align:left}
qq_c_b_body{ width:25%; height:50px; text-indent: 23pt;; line-height:50px; float:left; padding-right:10px;}
imgtop{ padding-top:15px;}
</style>
';
echo '<div style="width:100%; height:75px; border-bottom:1px solid #D9D9D9"><img src="'.$_G['site_url'].'source/plugin/youka_pay/template/about.jpg" /></div>
<div style="height:10px; width:100%;"></div>
<div style=" width:100%; height:35px; line-height:35px; ">'.$Plang['help_content_1'].'</div><br>
<div style=" width:100%; height:35px; line-height:35px; ">'.$Plang['help_content_2'].'</div>
<div style="width:100%; height:75px; border-bottom:1px solid #D9D9D9"><img src="'.$_G['site_url'].'source/plugin/youka_pay/template/shuoming.jpg"></div>
<div style="height:10px; width:100%;"></div><div style=" width:100%; height:35px; line-height:35px; ">'.$Plang['help_content_3'].'</div>
<div style="width:100%; height:75px; border-bottom:1px solid #D9D9D9"><img src="'.$_G['site_url'].'source/plugin/youka_pay/template/kefu.jpg"></div>
<div style="height:10px; width:100%;"></div>'.$Plang['help_content_4'];


showtablefooter();