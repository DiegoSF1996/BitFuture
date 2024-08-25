<?php
class Controller
{
    public function __construct()
    {
        try{
            if (method_exists($this, $_GET['method'])) {
                $this->{$_GET['method']}();
            }
        } catch (\Exception $e){
            print_r ($e);
            exit;
        }
    }
    function render(String $view, array $array)
    {
        extract($array);
        include "App/Views/$view.view.php";
        exit;
    }

    
}
