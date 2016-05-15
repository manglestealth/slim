<?php
spl_autoload_register(function($classname){
    require ('../model/'.$classname.'.php');
});