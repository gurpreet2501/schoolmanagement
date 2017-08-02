<?php

function is_role($role){
  return ($role == user_role() );
}

function user_role(){

  global $user_role;
  if($user_role)
    return $user_role;

  if(!logged_in()){
    $user_role = 'guest';
    return $user_role;
  }

	$ci = get_instance();
	$status = Models\Users::select('role')->where('id',$ci->tank_auth->get_user_id())->first();
  
  $user_role = $status->role;
  return $status->role;
}


function user_data($key = false){
  if(!logged_in())
    return null;

  global $_user_data;

  if(!$_user_data){
    $_user_data = lako::get('objects')->get('users')->read(user_id());
    $_user_data = $_user_data[0];
  }

  if(!$key)
    return $_user_data;
  elseif(!isset($_user_data[$key]))
    return null;
  else
    return $_user_data[$key];
}

function user_id(){
	$ci=get_instance();
  return $ci->tank_auth->get_user_id();
}

function logged_in(){
  $ci = get_instance();
  return $ci->tank_auth->is_logged_in();
}

function auth_force(){
  if(!logged_in())
    redirect('auth/login');
}

function admin_force(){
  if(!is_role('admin'))
    redirect('auth/login');
}

