<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?><?php
$posttop = <<<EOF

<div class="pob cl tyhj_posttop" style="background:{$specialbg};border:1px dashed {$study_border};">
<em class="tyhj_posttop_em">
<b>天涯海角搜一下：</b>
<a class="tyhj_baidu" href="http://www.baidu.com/s?wd={$keyword['gbk']}{$site}" title="百度一下相关的内容" target="_blank">百度</a>
<a class="tyhj_google" href="http://www.google.com.hk/search?sourceid=chrome&amp;ie=UTF-8&amp;q={$keyword['utf8']}{$site}" title="用谷歌搜索相关的内容" target="_blank">谷歌</a>
<a class="tyhj_360" href="http://www.so.com/s?q={$keyword['utf8']}{$site}" title="360搜索相关的内容" target="_blank">360</a>
<a class="tyhj_sogou" href="http://www.sogou.com/web?query={$keyword['gbk']}{$site}" title="用搜狗搜索相关的内容" target="_blank">搜狗</a>
<a class="tyhj_soso" href="http://www.soso.com/q?pid=s.idx&amp;w={$keyword['gbk']}{$site}" title="用SOSO搜索相关的内容" target="_blank">搜搜</a>
<a class="tyhj_youdao" href="http://www.yodao.com/search?keyfrom=web.suggest&amp;q={$keyword['gbk']}{$site}" title="用有道搜索相关的内容" target="_blank">有道</a>
<a class="tyhj_gfsoso" href="http://www.gfsoso.com/?q={$keyword['gbk']}{$site}" title="用谷粉搜索相关的内容" target="_blank">谷粉</a>
<a class="tyhj_yahoo" href="https://sg.search.yahoo.com/search?p={$keyword['utf8']}{$site}" title="用雅虎搜索相关的内容" target="_blank">雅虎</a>
<a class="tyhj_bing" href="http://cn.bing.com/search?q={$keyword['utf8']}{$site}" title="用必应搜索相关的内容" target="_blank">必应</a>
<a class="tyhj_jike" href="http://www.chinaso.com/search/pagesearch.htm?q={$keyword['utf8']}{$site}" title="用即刻搜索相关的内容" target="_blank">即刻</a>
</em>
</div>

EOF;
?>