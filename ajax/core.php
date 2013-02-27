<?php
session_start();

require 'functions.php';

$command = trim($_POST['command']);
$command = explode(' ', $command);

$tab = '&nbsp;&nbsp;&nbsp;&nbsp;';

switch ($command[0]) {
	case 'clear':
		echo true;
		break;
	case 'path':
		if (isset($command[1])) {
			if (file_exists($command[1])) {
				$_SESSION['path'] = str_replace("\\", "/", $command[1]);
				echo true;
			} else
				echo $tab."<span class='error'>Path not found!</span> <br>";
			
		} else
			echo $tab."<span class='error'>Try: path <'path'></span> <br>";
		break;
	case 'app':
		if (isset($command[1])) {
			if (file_exists($_SESSION['path']."/".$command[1])) {
				$_SESSION['app'] = $command[1];
				echo true;
			}else
				echo $tab."<span class='error'>App not found!</span> <br>";
			
		}else
			echo $tab."<span class='error'>Try use <code><app name></code></span> <br>";
		break;
	case 'mvc':
		if (isset($command[2])) {
			if (isset($_SESSION['app'])) {
				// Copia Controller
				if (!file_exists($_SESSION['path']."/".$_SESSION['app']."/mvc/controller/".$command[1]))
					mkdir($_SESSION['path']."/".$_SESSION['app']."/mvc/controller/".$command[1]);
				copy('../files/controller.php', $_SESSION['path'].'/'.$_SESSION['app'].'/mvc/controller/'.$command[1].'/'.$command[2].'.php');
				//Copia view
				if (!file_exists($_SESSION['path']."/".$_SESSION['app']."/mvc/view/".$command[1]))
					mkdir($_SESSION['path']."/".$_SESSION['app']."/mvc/view/".$command[1]);
				copy('../files/view.war', $_SESSION['path'].'/'.$_SESSION['app'].'/mvc/view/'.$command[1].'/'.$command[2].'.war');
				
				echo true;
			}else
				echo $tab.'You need set your current app <br>';
		}else
			echo $tab."<span class='error'>Command not found!</span> <br>";
		break;

	case 'newapp':
		
		$source = '../app';
		$dest = $_SESSION['path']."/".$command[1];

		recurse_copy($source,$dest);
		echo true;
	break;

	default:
			echo $tab."<span class='error'>Command not found!</span> <br>";
		break;
}

?>