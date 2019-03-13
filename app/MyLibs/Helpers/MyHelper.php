<?php

function random_str($length,$keys='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
	$str='';
	$max = mb_strlen($keys,'8bit') - 1;
	for ($i=0; $i < $length; $i++) { 
		$str .= $keys[random_int(0, $max)];
	}
	return $str;
}

function getMeasurementUnits()
{
	//'W'=>1,'KW'=>1000,'MW'=>1000000,'GW'=>1000000000
	return ['W'=>'W','KW'=>'KW','MW'=>'MW','GW'=>'GW'];
}