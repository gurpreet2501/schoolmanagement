<?php

function ht($text){
  return htmlentities($text);
}

function at($text){
  return htmlspecialchars($text);
}

function printDate($date){
	$parsed = strtotime($date);
	if(!$parsed)
		return '';
	return date('d-m-Y h:i A', strtotime($date));
}