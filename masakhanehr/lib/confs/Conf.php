<?php
class Conf {

	var $smtphost;
	var $dbhost;
	var $dbport;
	var $dbname;
	var $dbuser;
	var $version;

	function __construct() {

		$this->dbhost	= 'localhost';
		$this->dbport 	= '3306';
		if(defined('ENVIRNOMENT') && ENVIRNOMENT == 'test'){
		$this->dbname    = 'test_masakhanehrm_mysql';		
		}else {
		$this->dbname    = 'masakhanehrm_mysql';
		}
		$this->dbuser    = 'Masakhanehrm';
		$this->dbpass	= 'Mas@khanehr_20#$';
		$this->version = '4.2.0.1';

		$this->emailConfiguration = dirname(__FILE__).'/mailConf.php';
		$this->errorLog =  realpath(dirname(__FILE__).'/../logs/').'/';
	}
}
?>