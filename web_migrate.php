<?php
use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\StreamOutput;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

$app = require __DIR__ . '/vendor/robmorgan/phinx/app/phinx.php';
require_once __DIR__.'/boot-extra.php';

$capsule = new Capsule;

$capsule->addConnection(array(
        'host'      => 'localhost',
        'database'  => env('database','sms'),
        'username'  => env('username','root'),
        'password'  => env('password',''),
        'driver'  => 'mysql',
        'charset'   => 'utf8',
        'collation' => 'utf8_general_ci',
        'prefix'    => ''
));


$capsule->setEventDispatcher(new Dispatcher(new Container));
$capsule->setAsGlobal();
$capsule->bootEloquent();

$stream = fopen('php://temp', 'w+');
$command = [
			    '0' => 'migrate', // Command 
			    '-e' => 'local', //Envioronment
			    '-t' => 'ALL', //Target
			    '-p'  => 'yaml' //Parser
			];
$app->doRun(new ArrayInput($command), new StreamOutput($stream));
$result = stream_get_contents($stream, -1, 0);

echo "<pre>";
print_r($result);
fclose($stream);



