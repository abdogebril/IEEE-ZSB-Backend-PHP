
<?php

$router->get('/myproject/', "controllers/index.php");
$router->get('/myproject/about', "controllers/about.php");
$router->get('/myproject/contact', "controllers/contact.php");

$router->get('/myproject/notes', "controllers/notes/index.php")->only('auth');
$router->get('/myproject/note', "controllers/notes/show.php");
$router->delete('/myproject/note', "controllers/notes/destroy.php");

$router->get('/myproject/note/edit', "controllers/notes/edit.php");
$router->patch('/myproject/note', "controllers/notes/update.php");

$router->get('/myproject/notes/create', "controllers/notes/create.php");
$router->post('/myproject/notes', "controllers/notes/store.php");

$router->get('/myproject/register', "controllers/registration/create.php")->only('guest');
$router->post('/myproject/register', "controllers/registration/store.php")->only('guest');

$router->get('/myproject/login', "controllers/session/create.php")->only('guest');
$router->post('/myproject/session', "controllers/session/store.php")->only('guest');
$router->delete('/myproject/session', "controllers/session/destroy.php")->only('auth');