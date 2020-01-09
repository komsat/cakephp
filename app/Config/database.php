<?php
class DATABASE_CONFIG {

	public $test = array(
		'datasource' => 'Database/Database/Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'user',
		'password' => 'password',
		'database' => 'test_database_name',
	);
	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'port' => 3306,
		'login' => 'root',
		'password' => 'root@123',
		'database' => 'bulletin',
		//'encoding' => 'utf-8'
	);
}
