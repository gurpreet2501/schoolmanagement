<?php 
function success($msg){
	$ci = &get_instance();
	return $ci->session->set_flashdata('success_msgs', $msg);
}

function failure($msg){
	$ci = &get_instance();
	return $ci->session->set_flashdata('error_msgs', $msg);
}