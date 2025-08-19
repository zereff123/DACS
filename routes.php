<?php
function callAction($controller, $action) {
    $controllerName = ucfirst($controller) . "Controller";
    $controllerFile = ROOT_PATH . "/app/controllers/{$controllerName}.php";

    if (!file_exists($controllerFile)) {
        http_response_code(404);
        echo "Controller <b>$controllerName</b> không tồn tại.";
        exit;
    }
    require_once $controllerFile;

    $ctrl = new $controllerName();
    if (!method_exists($ctrl, $action)) {
        http_response_code(404);
        echo "Action <b>$action</b> không tồn tại trong $controllerName.";
        exit;
    }
    $ctrl->$action();
}
