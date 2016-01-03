<?php

use Illuminate\Database\Capsule\Manager as Capsule;

require_once './config.php';

$capsule = new Capsule;
$capsule->addConnection([
  'driver' => 'mysql',
  'host' => $dbhost,
  'database' => $db,
  'username' => $username,
  'password' => $dbpass,
  'charset' => 'utf8',
  'collation' => 'utf8_unicode_ci',
  'prefix' => ''
]);

use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$capsule->setEventDispatcher(new Dispatcher(new Container));
$capsule->setAsGlobal();
$capsule->bootEloquent();

 ?>
