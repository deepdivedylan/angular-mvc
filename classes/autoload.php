<?php
/**
 * automatically loads the class on demand
 *
 * @param string $className class name to load
 * @return bool true if the class loaded correctly, false if not
 **/
function loadClass($className) {
	$classFile = __DIR__ . "/" . strtolower($className) . ".php";
	if(is_readable($classFile) === true && require_once($classFile)) {
		return(true);
	} else {
		return(false);
	}
}
// tell PHP to use the loadClass() function to automatically load class files
spl_autoload_register("loadClass");