<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_study_freedown_log extends discuz_table {

	public function __construct() {
		$this->_table = 'study_freedown_log';
		$this->_pk = 'id';

		parent::__construct();
	}

	public function fetch_first_by_aid_uid($aid, $uid) {
		return DB::fetch_first('SELECT * FROM %t where aid=%d and uid=%d ORDER BY dateline DESC', array($this->_table, $aid, $uid));
	}
	
	public function count_by_aid_uid($uid, $todaytime) {
		return DB::result_first('SELECT count(*) FROM %t where uid=%d AND dateline > %d', array($this->_table, $uid, $todaytime));
	}	
}
?>