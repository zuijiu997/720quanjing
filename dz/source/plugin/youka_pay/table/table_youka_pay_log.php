<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_myrepeats.php 31512 2012-09-04 07:11:08Z monkey $
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_youka_pay_log extends discuz_table
{
	public function __construct() {

		$this->_table = 'youka_pay_log';
		$this->_pk    = '';

		parent::__construct();
	}



	public function fetch_by_orderid($orderid) {
		return DB::fetch_first("SELECT * FROM %t WHERE orderid=%s limit 1", array($this->_table, $orderid));
    }
    function update_by_orderid($orderid,$sysorderid,$completiontime){
        return DB::query("update %t set status=1,sysorderid=%s,completiontime=%s WHERE orderid=%s limit 1", array($this->_table,$sysorderid,$completiontime,$orderid));
    }
    function updatecard_by_orderid($orderid,$price,$extcredits,$sysorderid,$completiontime){
        return DB::query("update %t set status=1 ,price=%s ,extcredits=%s,sysorderid=%s,completiontime=%s WHERE orderid=%s  limit 1", array($this->_table,$price,$extcredits,$sysorderid,$completiontime, $orderid));
    }
    function updatestatus_by_orderid($orderid,$opstate){
        return DB::query("update %t set status=%s WHERE orderid=%s  limit 1", array($this->_table,$opstate, $orderid));
    }

}

?>