<?php

// Lấy tham số từ URL
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'user';
$action = isset($_GET['action']) ? $_GET['action'] : 'home';
$id_lambai = $_GET['id_lambai'] ?? null;
// Gọi file controller
$controllerFile = 'controller/' . ucfirst($controller) . 'Controller.php';
if (file_exists($controllerFile)) {
    include $controllerFile;
    $controllerClass = ucfirst($controller) . 'Controller';
    $obj = new $controllerClass();
    
    if (method_exists($obj, $action)) {
        $obj->$action();
    } else {
        echo "Action không tồn tại!";
    }
} else {
    echo "Controller không tồn tại!";
}
