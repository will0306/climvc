<?php
function loadClass($className) {
    $fileName = '';
    $namespace = '';

    // Sets the include path as the "src" directory
    $basePath = dirname(__FILE__).'/../';
    $includePath = $basePath.'/src';
    if (false !== ($lastNsPos = strripos($className, '\\'))) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    $fullFileName = $includePath . DIRECTORY_SEPARATOR . $fileName;
    
    if(file_exists($basePath.DIRECTORY_SEPARATOR.$fileName )) {
        require $basePath.DIRECTORY_SEPARATOR.$fileName;
    } else if (file_exists($fullFileName)) {
        require $fullFileName;
    } else {
        echo 'Class "'.$className.'" does not exist.';
        die;
    }
}
spl_autoload_register('loadClass'); // Registers the autoloader
