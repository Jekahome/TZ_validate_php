<?php

require_once  realpath(__DIR__) . '/vendor/autoload.php';

require_once('define.php');

$newsletter = new App\Newsletter(new App\Repository\GenUserRepository(),new App\Validate\Validator());
echo "Send\n";
$newsletter->send();
echo "Notify\n";
$newsletter->notify();