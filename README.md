# SimFul

> SimFul is a PHP micro RESTFul library.

## Usage

```php
<?php

require_once 'SimFul.php';

$app = new SimFul();

$app -> cookie('SimFul_Key', 'SimFul_Value');
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

    // init1 - init2 - getUsers()
});

$app -> get('/user/:id', function ($req, $resp) {

    echo 'getUser() - ' . $req['params']['id'];

    // init1 - init2 - getUser() - 5
});

$app -> get('/user/:id/item/:no', function ($req, $resp) {

    echo 'getUserItemSlot() - ' . $req['params']['id'] . ' - ' . $req['params']['no'];

    // init1 - init2 - getUserItemSlot() - 5 - 10
});

$app -> post('/user', function ($req, $resp) {

    echo 'addUser() - ' . json_encode($req['body']);

    // init1 - init2 - addUser() - { "name" : "u4bi", "age" : 17, "admin" : true }
});

$app -> put('/user/:id', function ($req, $resp) {

    echo 'updateUser() - ' . $req['params']['id'];

    // init1 - init2 - updateUser() - 5
});

$app -> patch('/user/:id', function ($req, $resp) {

    echo 'assignUser() - ' . $req['params']['id'];

    // init1 - init2 - assignUser() - 5
});

$app -> delete('/user/:id', function ($req, $resp) {

    echo 'removeUser() - ' . $req['params']['id'];

    // init1 - init2 - removeUser() - 5
});


$app -> run();

?>
```

## License

[MIT](LICENSE)
