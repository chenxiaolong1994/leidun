<?php
if(is_file("./data/conf/config.php") )
{
    cosconfig(include './data/conf/config.php');
}
function cosconfig($name=null, $value=null) {
    static $_config = array();
    if (empty($name))   return $_config;
    if (is_string($name)) {
        if (!strpos($name, '.')) {
            $name = strtolower($name);
            if (is_null($value))
                return isset($_config[$name]) ? $_config[$name] : null;
            $_config[$name] = $value;
            return;
        }
        $name = explode('.', $name);
        $name[0]   =  strtolower($name[0]);
        if (is_null($value))
            return isset($_config[$name[0]][$name[1]]) ? $_config[$name[0]][$name[1]] : null;
        $_config[$name[0]][$name[1]] = $value;
        return;
    }
    if (is_array($name)){
        return $_config = array_merge($_config, array_change_key_case($name));
    }
    return null; 
 }