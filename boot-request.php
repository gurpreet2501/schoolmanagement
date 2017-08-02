<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;

global $__container;
$__container = new ContainerBuilder();
$__container->set('request', Request::createFromGlobals());

$__container->compile();


//make easily accessible
function app(){
  global $__container;
  return $__container;
}
