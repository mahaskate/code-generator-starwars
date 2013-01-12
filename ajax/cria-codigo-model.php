<?php 

$campos ="";
$args = "";

$r = "<?php\n";
$r .= "function model(){\n";
	
	foreach ($_POST as $key => $value) {
		//Coloca aspas em cada argumento
		$explode = explode(",", $value);
		foreach ($explode as $arg) {
			$arg = trim($arg);
			//Verifica se é minlength
			$minExplode = explode("(", $arg);
			$total = count($minExplode);
			if ($total == 2) {
				$arg = "'minlength'=>".$minExplode[1];
				$args .= $arg;
			}else
				$args .= "'".$arg."',";
		}

		$args = substr($args, 0, -1);

		$campos .= "'".$key."'=>array(".$args."), ";
		$args = "";
	}

	$campos = substr(trim($campos), 0, -1);
	$r .= "\treturn array(".$campos.");\n";
$r .= "}\n";
$r .= "?>";

echo $r;

?>