<?php 
	$router_config = array(
		'default'=>'home',
		'nguyen/(:any)/(:any)' => 'test/$2/$1',
	);
	define(EXTENSION,'pnpt');
?>
