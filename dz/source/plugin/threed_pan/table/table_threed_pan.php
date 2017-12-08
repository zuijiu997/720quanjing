<?php
 /**
 *	[网盘虚拟附件--免跳转下载(threed_pan.{modulename})] (C)2014-2099 Powered by 3D设计者.
 *	Version: 商业版
 *	Date: 2014-12-3 21:54
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_threed_pan extends discuz_table
{
	public function __construct() {
		$this->_table = 'threed_pan';
		$this->_pk = 'id';
		parent::__construct();
	}
}

?>