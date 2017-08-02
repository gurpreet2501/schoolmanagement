<?php

function vue_app_bundle($bundleName){
	$base = APPPATH.'../assets/js/vue/app/'.$bundleName.'/';
	$webBase = 'assets/js/vue/app/'.$bundleName.'/';
	$parts = ['init','data','computed','methods','watch','create'];
	$filesToinclude = [];
	foreach($parts as $part)
		$filesToinclude[] = base_url("{$webBase}{$part}.js");
  	return $filesToinclude;
}
