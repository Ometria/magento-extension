<?php

require_once('/server/apps/ometria.common/ext/IXR_Library.php');


if (@$argv[1]=='--remote'){
	$config = require('config-remote.php');
	unset($argv[1]);
	$argv = array_values($argv);
} else {
	$config = require('config.php');
}

$method = @$argv[1];
if (!$method) die('Supply method');
$_params = array_slice($argv,2);
$params = array();

foreach($_params as $p){
	$params[] = json_decode($p, true);
}

$res = doXMLRPCCall($config, $method, $params);
print_r($res);

function doXMLRPCCall($settings, $method, $params){
	try{
		$client = new \IXR_Client($settings['endpoint']);
		$ok = $client->query('login', $settings['user'],$settings['password']);
		if (!$ok) throw new \Exception($client->getErrorMessage());
		$res = $client->getResponse();
		if (is_array($res) && @$res['faultCode']) throw new \Exception($res['faultString']);

		$session = $res;
		$client = $client;
	} catch (Exception $e){
		echo $e->getMessage(), "\n";
		die('=== Could not connect'."\n");
	}

	$ok = $client->query('call', $session, $method, $params);
	if (!$ok) throw new \Exception($client->getErrorMessage());
	$res = $client->getResponse();
	if (is_array($res) && @$res['faultCode']) throw new \Exception($res['faultString']);

	return $res;
}