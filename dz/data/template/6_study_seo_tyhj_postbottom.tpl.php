<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?><?php
$postbottom = <<<EOF

<br>
<div class="tyhj_sousuo" style="zoom:1;padding:0px 8px 5px 8px;background:{$specialbg};border:1px dashed {$study_border};">
<div>
<div class="tyhj_self">
天涯海角也要找到Ni：<a href="search.php?mod=forum&amp;searchsubmit=yes&amp;srchtxt={$_G['thread']['subject']}" title="在论坛搜索与 {$_G['thread']['subject']} 相关的帖子"target="_blank" rel="nofollow">{$_G['thread']['subject']}</a>
</div>
<div class="tyhj_tag_div">
<div class="tyhj_tag">
{$tag}
</div>
</div>
</div>
<div>
<div class="tyhj_sousuo_left tyhj_baidu">
<a href="http://www.baidu.com/s?word={$keyword['gbk']}{$site}"  title="{$_G['thread']['subject']}" target="_blank">中发现Ni：{$_G['thread']['subject']}</a><br />
</div>
<div class="tyhj_sousuo_right tyhj_google">
<a href="http://www.google.com.hk/search?sourceid=chrome&amp;ie=UTF-8&amp;q={$keyword['utf8']}{$site}" title="{$_G['thread']['subject']}" target="_blank">中发现Ni：{$_G['thread']['subject']}</a><br />
</div>
</div>
<div>
<div class="tyhj_sousuo_left tyhj_360">
<a href="http://www.so.com/s?q={$keyword['utf8']}{$site}" title="{$_G['thread']['subject']}" target="_blank">中发现Ni：{$_G['thread']['subject']}</a><br />
</div>
<div class="tyhj_sousuo_right tyhj_sogou">
<a href="http://www.sogou.com/web?query={$keyword['gbk']}{$site}" title="{$_G['thread']['subject']}" target="_blank">中发现Ni：{$_G['thread']['subject']}</a><br />
</div>
</div>
<div>
<div class="tyhj_sousuo_left tyhj_soso">
<a href="http://www.soso.com/q?w={$keyword['gbk']}{$site}" title="{$_G['thread']['subject']}" target="_blank">中发现Ni：{$_G['thread']['subject']}</a>
</div>
<div class="tyhj_sousuo_right tyhj_youdao">
<a href="http://www.yodao.com/search?keyfrom=web.suggest&amp;q={$keyword['gbk']}{$site}" title="{$_G['thread']['subject']}" target="_blank">中发现Ni：{$_G['thread']['subject']}</a><br />
</div>
</div>
<div>
<div class="tyhj_sousuo_left tyhj_gfsoso">
<a href="http://www.gfsoso.com/?q={$keyword['gbk']}{$site}" title="{$_G['thread']['subject']}" target="_blank">中发现Ni：{$_G['thread']['subject']}</a><br />
</div>
<div class="tyhj_sousuo_right tyhj_yahoo">
<a href="https://sg.search.yahoo.com/search?p={$keyword['utf8']}{$site}" title="{$_G['thread']['subject']}" target="_blank">中发现Ni：{$_G['thread']['subject']}</a><br />
</div>
</div>
<div>
<div class="tyhj_sousuo_left tyhj_bing">
<a href="http://cn.bing.com/search?q={$keyword['utf8']}{$site}" title="{$_G['thread']['subject']}" target="_blank">中发现Ni：{$_G['thread']['subject']}</a><br />
</div>
<div class="tyhj_sousuo_right tyhj_jike">
<a href="http://www.chinaso.com/search/pagesearch.htm?q={$keyword['utf8']}{$site}" title="{$_G['thread']['subject']}" target="_blank">中发现Ni：{$_G['thread']['subject']}</a>
</div>
</div>
</div>

EOF;
?>