<?php
function env($key, $defaultVal){
  $envFile = __DIR__.'/environment.php';

  if(!file_exists($envFile))
     return $defaultVal;

  $config = require($envFile);

  if(!isset($config[$key]))
    return $defaultVal;
  return $config[$key];
}
