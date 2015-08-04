<?php
error_reporting(E_ALL);

require '.././libs/Slim/Slim.php';
require_once '../includes/include.php';
require_once 'dbHelper.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

function api_autoloader($class_name) {
    $directory = '../class/';
    if (file_exists($directory . $class_name . '.class.php')) {
        require_once $directory . $class_name . '.class.php';
        
        return;
    }
}
spl_autoload_register('api_autoloader');
//$app = \Slim\Slim::getInstance();
//$db = new dbHelper();
$db = new db(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Products
$app->get('/products', function() { 
    $product = new product();
    $response = $product->getAllProduct();
    echoResponse(200, $response);

});

$app->post('/products', function() use ($app) { 
    $product = new product();
    $data = json_decode($app->request->getBody(),TRUE);
    $id = $product->AddProduct($data);
    echoResponse(200, $id);
});

$app->put('/products/:id', function($id) use ($app) { 
    $product = new product();
    $data = json_decode($app->request->getBody(), TRUE);
    $result =  $product->updateProduct($id, $data);
       // $rows["message"] = "Product information updated successfully.";
    echoResponse(200, $result);
});

$app->delete('/products/:id', function($id) { 
    $product = new product();
    $id = $product->deleteProduct($id);
    echoResponse(200, $id);
});

function echoResponse($status_code, $response) {
    global $app;
    $app->status($status_code);
    $app->contentType('application/json');
    echo json_encode($response,JSON_NUMERIC_CHECK);
}

$app->run();
?>