<?php
function Render(String $view, Array $array){

    $template = file_get_contents('App/Views/'.$view.'view.php');
    $campos = array_keys($array);
echo $template; exit;
    return str_replace($campos,$array, $template);
}