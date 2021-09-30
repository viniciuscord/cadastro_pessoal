<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

$active_group = 'SR611';
$query_builder = TRUE;

if(ENVIRONMENT=='production'){
	$bd="bd_suporte";
}else{
	$bd="desenvolvimento";	
}


$db ['default'] = array (
		'dsn' => "DRIVER={SQL Server Native Client 11.0};SERVER=DF7436SR496;DATABASE=bd_ident;Mars_Connection=yes",
		'hostname' => 'DF7436SR496',
		'username' => 's517101',
		'password' => '517101',
		'database' => 'bd_ident',
		'dbdriver' => 'sqlsrv',
		'dbprefix' => '',
		'pconnect' => FALSE,
		'db_debug' => TRUE,
		'cache_on' => FALSE,
		'cachedir' => '',
		'char_set' => 'utf-8',
		'dbcollat' => 'Latin1_General_CI_AS',
		'swap_pre' => '',
		'autoinit' => TRUE,
		'encrypt'  => FALSE,
		'compress' => FALSE,
		'stricton' => FALSE,
		'failover' => array (),
		'save_queries' => TRUE 
);

$db ['SR330'] = array (
		'dsn' => "DRIVER={SQL Server Native Client 11.0};SERVER=DF7436SR330;DATABASE=$bd;Mars_Connection=yes",
		'hostname' => 'DF7436SR330',
		'username' => 's739201',
		'password' => 's739201@',
		'database' => $bd,
		'dbdriver' => 'sqlsrv',
		'dbprefix' => '',
		'pconnect' => FALSE,
		'db_debug' => TRUE,
		'cache_on' => FALSE,
		'cachedir' => '',
		'char_set' => 'utf-8',
		'dbcollat' => 'Latin1_General_CI_AS',
		'swap_pre' => '',
		'autoinit' => TRUE,
		'encrypt'  => FALSE,
		'compress' => FALSE,
		'stricton' => FALSE,
		'failover' => array (),
		'save_queries' => TRUE
);



$db ['SR611'] = array (
		'dsn' => "DRIVER={SQL Server Native Client 11.0};SERVER=DF7436SR611;DATABASE=DB7392_CADASTRO_PESSOAL;Mars_Connection=yes",
		'hostname' => 'DF7436SR611',
		'username' => 'S756001',
		'password' => 'ceati7560t1066',
		'database' => 'DB7392_CADASTRO_PESSOAL',
		'dbdriver' => 'sqlsrv',
		'dbprefix' => '',
		'pconnect' => FALSE,
		'db_debug' => TRUE,
		'cache_on' => FALSE,
		'cachedir' => '',
		'char_set' => 'utf-8',
		'dbcollat' => 'Latin1_General_CI_AS',
		'swap_pre' => '',
		'autoinit' => TRUE,
		'encrypt'  => FALSE,
		'compress' => FALSE,
		'stricton' => FALSE,
		'failover' => array (),
		'save_queries' => TRUE
);

$db['odbc'] = array (
	'dsn' => "DRIVER={SQL Server Native Client 11.0};SERVER=DF7436SR611;DATABASE=DB7392_CADASTRO_PESSOAL;Mars_Connection=yes",
	'hostname' => 'DF7436SR611',
	'username' => 'S756001',
	'password' => 'ceati7560t1066',
	'database' => 'DB7392_CADASTRO_PESSOAL',
	'dbdriver' => 'odbc',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf-8',
	'dbcollat' => 'Latin1_General_CI_AS',
	'swap_pre' => '',
	'autoinit' => TRUE,
	'encrypt'  => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array (),
	'save_queries' => TRUE
);