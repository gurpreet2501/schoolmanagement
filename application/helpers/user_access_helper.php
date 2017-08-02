<?php

function canAccess($key){
	$ci = &get_instance();
	$user = Models\Users::select('role')->where('id', $ci->tank_auth->get_user_id())->first();
	
	$count = Models\UserAccess::where('role', $user->role)->where('feature',$key)->count();

	if(!$count)
	  return false;

	return true;

	
}

function filterMenus($data){

	$ci = &get_instance();
	$filteredItems = [];
	$user = Models\Users::select('role')->where('id', $ci->tank_auth->get_user_id())->first();
	//If role admin then show all items
	if($user->role == 'admin')
		return $data;

	$dbKeys = Models\UserAccess::select('feature')->where('role', $user->role)->get();
	
	if(empty($dbKeys))
		return [];

    $dbKeys = array_column($dbKeys->toArray(),'feature');
    
	foreach ($data as $key => $v) {
		if(in_array($key,$dbKeys))
			$filteredItems[$key] = $v;
   
	}

	return $filteredItems;
	
}