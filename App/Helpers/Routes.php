<?php
class Routes
{
    private static $routes = [];

    public static function addRoute($route_name,  $controller_path,  $method_controler_name, $method_request_name)
    {
        if (key_exists($route_name, Self::$routes)) {
            return false;
        }
        Self::$routes[$route_name] = [
            'controller_path' => $controller_path,
            'method_controler_name' => $method_controler_name,
            'method_request_name' => $method_request_name
        ];
    }

    public static function callRoute($route_name)
    {
        try {

            $route = self::$routes[$route_name];
            if (!file_exists($route['controller_path'])) {
                throw new Exception("Arquivo do controlador {$route['controller_path']} não encontrado.");
            }
            require $route['controller_path'];
            $controller_name = self::getClassNameFromPath($route['controller_path']);
            // Verifica se a classe do controlador existe
            if (!class_exists($controller_name)) {
                throw new Exception("Classe do controlador {$route['controller_class']} não encontrada.");
            }

            // Instancia o controlador
            $controller = new $controller_name;

            // Verifica se o método do controlador existe
            if (!method_exists($controller, $route['method_controler_name'])) {
                throw new Exception("Método {$route['method_controler_name']} não encontrado na classe {$route['controller_class']}.");
            }

            // Chama o método do controlador
            $controller->{$route['method_controler_name']}();
        } catch (\Exception $e) {
            echo "Rota não encontrada.";
            //print_r($e);
        }
    }

    public static function getClassNameFromPath($filePath)
    {
        // Obtém informações sobre o caminho do arquivo
        $pathInfo = pathinfo($filePath);
        // Retorna o nome do arquivo sem a extensão
        return $pathInfo['filename'];
    }
}
