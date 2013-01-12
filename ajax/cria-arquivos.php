<?php 

$caminho = $_SERVER['DOCUMENT_ROOT'];
$app = '/starwars/mvc/';
$model = $_POST['model']."/";

$codigo = json_decode($_POST['codigo']);

$r = "";

function criaArquivo($nome,$options = array()){
	global $caminho;
	global $app;
	global $model;

	$r = "";

	if (0 == 0) {
		if (!file_exists($caminho.$app."/view/".$model)) {
			mkdir($caminho.$app."/view/".$model);
		}
		if (!file_exists($caminho.$app."/controller/".$model)) {
			mkdir($caminho.$app."/controller/".$model);
		}
		//Cria view
		if (isset($options['view'])) {
			$view = $caminho.$app."view/".$model.$nome.".war";

			$file = fopen($caminho.$app."view/".$model.$nome.".war", 'w+');
			fwrite($file, $options['view']);
			fclose($file);
			$r = "View ".$nome." Criada com sucesso! \n\n";
		}

		//Cria Controller
		$file = fopen($caminho.$app."controller/".$model.$nome."Controller.php", 'w+');
		fwrite($file, $options['controller']);
		fclose($file);
		$r .= "Controller ".$nome." Criada com sucesso! \n\n";

		return $r;
	}
}

//admin_add
if ($_POST['admin_add'] == 1)
	$r .= criaArquivo('admin_add',array('view'=>$codigo[1],'controller'=>$codigo[3]));
//admin_edit
if ($_POST['admin_edit'] == 1)
	$r .= criaArquivo('admin_edit',array('view'=>$codigo[1],'controller'=>$codigo[5]));
//admin_list
if ($_POST['admin_list'] == 1)
	$r .= criaArquivo('admin_list',array('view'=>$codigo[0],'controller'=>$codigo[4]));
//admin_view
if ($_POST['admin_view'] == 1)
	$r .= criaArquivo('admin_view',array('view'=>$codigo[2],'controller'=>$codigo[6]));

//delete
if ($_POST['admin_delete'] == 1)
	$r .= criaArquivo('admin_delete',array('controller'=>$codigo[7]));

echo "Arquivos criados com sucesso";

?>