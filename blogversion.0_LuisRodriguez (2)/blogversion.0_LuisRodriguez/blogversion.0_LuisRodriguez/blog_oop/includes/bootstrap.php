<?php
// Luis Rodriguez - 0812903

     require_once("config.php");
	 

	 
	 spl_autoload_register(function ($class) {
	$class = ucfirst($class);
	$ext = '.php';
	$file = 'classes/' . $class . $ext;
    echo "Autoloading class $file <br>";
    if (is_readable($file)) {
        require_once($file);
    }
});
	 
     
	 
	/* require_once("Database.php");
     require_once("Session.php");
     require_once("Category.php");
     require_once("Entry.php");
     require_once("Comment.php");
     require_once("User.php"); */
	 
	 ?>
