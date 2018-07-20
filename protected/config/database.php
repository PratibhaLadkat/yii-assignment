<?php

// This is the database connection configuration.
return array(
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database

/*	'connectionString' => 'mysql:host=localhost;dbname=assignment',
    'username' => 'root',
	'password' => 'root',*/
	'charset' => 'utf8',
    'emulatePrepare' => true,
    'connectionString' => 'pgsql:host=localhost;port=5432;dbname=assignment',
    'username' => 'postgres',
    'password' => 'postgres',
);