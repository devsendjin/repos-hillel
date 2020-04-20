<?php

require_once 'vendor/autoload.php';

/*
// Mongo Client
$client = new MongoDB\Client('mongodb://root:example@mongo:27017');
$usersRepository = new \App\Repository\User\MongoUserRepository($client);
*/


/*
// PDO instance
$pdo = new PDO('mysql:host=mysql;port=3306;dbname=blog', 'root', 'secret');
$usersRepository = new \App\Repository\User\PdoUserRepository($pdo);
*/


/*
// test
$user = $usersRepository->find(1);
$user->setEmail('test@gmail.com');
var_dump($user);
$usersRepository->save($user);
//$usersRepository->delete($user);
var_dump($usersRepository->find(1));
*/


/*
// Services
$serviceFind = new \App\Service\FindUserService($usersRepository);
$user = $serviceFind->execute(1);
$user->setEmail('test_2@gmail.com');
var_dump($user);

$serviceSave = new \App\Service\SaveUserService($usersRepository);
$serviceSave->execute($user);

//$serviceDelete = new \App\Service\DeleteUserService($usersRepository);
//$serviceDelete->execute($user);
var_dump($serviceFind->execute(1));
*/
