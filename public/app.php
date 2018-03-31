<?php

require_once '../SimFul.php';

$app = new SimFul();

$app -> cookie('SimFul_Value', 'SimFul_Value');
$app -> header('X-SimFul-Test', 'SimFul_TEST_Value');
$app -> header('Access-Control-Allow-Origin', '*');

$app -> init(function ($req, $resp) {
    echo 'init1 - ';
});

$app -> init(function ($req, $resp) {
    echo 'init2 - ';
});

$app -> get('/users', function ($req, $resp) {
    echo 'getUsers()';
});

$app -> get('/user/:id', function ($req, $resp) {
    echo 'getUser() - ' . $req['params']['id'];
});

$app -> get('/user/:id/item/:no', function ($req, $resp) {
    echo 'getUserItemSlot() - ' . $req['params']['id'] . ' - ' . $req['params']['no'];
});

$app -> post('/user', function ($req, $resp) {
    echo 'addUser() - ' . json_encode($req['body']);
});

$app -> put('/user/:id', function ($req, $resp) {
    echo 'updateUser() - ' . $req['params']['id'];
});

$app -> patch('/user/:id', function ($req, $resp) {
    echo 'assignUser() - ' . $req['params']['id'];
});

$app -> delete('/user/:id', function ($req, $resp) {
    echo 'removeUser() - ' . $req['params']['id'];
});


$app -> run();

?>