<?php 
//Código List

$model = $_POST['model'];
$modelSing = substr($_POST['model'], 0 , -1);

//Tira espaços e transforma em array
$_POST['camposMostrados'] = str_replace(' ', '', $_POST['camposMostrados']);
$camposMostrados = explode(',', $_POST['camposMostrados']);

if ($camposMostrados[0] == "") {
	$totalCamposMostrados = $_POST['total'];
}else{
	$totalCamposMostrados = count($camposMostrados);
}

//Se n setar campos busca ele joga default o primeiro campo
if ($_POST['camposBusca'] != "")
	$camposBusca = $_POST['camposBusca'];
else
	$camposBusca = $_POST['campo0'];

$totalCamposMostrados++;

$list = "<h3>".ucfirst($model)."</h3>\n";
$list .= "<hr>\n";
$list .= "<?php echo a('Novo',array('class'=>'btn btn-block', 'controller'=>'".$_POST['model']."', 'action'=>'admin_add')); ?>\n";
$list .= "<br>\n";

$list .= "<?php\n";
$list .= "\tif (#total >= #paginationLimit){\n";
	$list .= "\t\tpaginatorGmail(#total,array('align'=>'right'));\n";
	$list .= "\t\techo \"<br><br>\";\n";
$list .= "\t}\n
";
$list .= "?>\n\n";

$list .= "<table id=\"tableSorter\" class=\"table table-bordered table-condensed table-hover table-striped tableSorter\">\n";
	$list .= "\t<thead>\n";
		for ($i=0; $i < $_POST['total']; $i++) {
			//Só mostrada campos selecionados para serem mostrados
			if ($camposMostrados[0] == "" OR in_array($_POST['campo'.$i], $camposMostrados)){
				if($_POST['label'.$i] == "")
					$campo = ucfirst($_POST['campo'.$i]);
				else
					$campo = $_POST['label'.$i];

				$list .= "\t\t<th>".ucfirst($campo)."</th>\n";
			}
		}
		$list .="\t\t<th class=\"span2\" style=\"text-align:center;\">Ações</th>\n";
	$list .= "\t</thead>\n";
	$list .= "\t<tbody>\n";

		$list .= "\t<?php if(!empty(#".$model.")): ?>\n";
			$list .= "\t\t<?php foreach (#".$model." as #".$modelSing."): ?>\n";
			
				$list .= "\t\t\t\t<tr>\n";

					for ($i=0; $i < $_POST['total']; $i++) { 
						if ($camposMostrados[0] == "" OR in_array($_POST['campo'.$i], $camposMostrados)){
							$list .= "\t\t\t\t\t<td>";
								$list .= "<?php echo #".$modelSing."['".$_POST['campo'.$i]."']; ?>";
							$list .= "</td>\n";
						}
					}
					$list .= "\t\t\t\t\t<td style=\"text-align:center;\">\n";
					$list .= "\t\t\t\t\t\t<?php echo a(\"<i class='icon-eye-open'></i>\",array('class'=>'btn btn-mini', 'controller'=>'".$_POST['model']."', 'action'=>'admin_view'),#".$modelSing."['id']); ?>\n";
					$list .= "\t\t\t\t\t\t<?php echo a(\"<i class='icon-pencil icon-white'></i>\",array('class'=>'btn btn-primary btn-mini', 'controller'=>'".$_POST['model']."', 'action'=>'admin_edit'),#".$modelSing."['id']); ?>\n";
					$list .= "\t\t\t\t\t\t<?php echo deleteAjax(\"<i class='icon-trash icon-white'></i>\",'deseja remover o post?',array('controller'=>'posts','action'=>'delete'),$".$modelSing."['id']);?>\n";
					$list .= "\t\t\t\t\t</td>\n";
				$list .= "\t\t\t\t</tr>\n";

			$list .= "\t\t\t<?php endforeach; ?>\n";

		$list .= "\t\t\t<?php else: ?>\n";
			$list .= "\t\t\t\t<tr>\n";
				$list .= "\t\t\t\t\t<td colspan=\"".$totalCamposMostrados."\">\n";
					$list .= "\t\t\t\t\t\tNenhuma informação adicionada, <?php echo a('clique aqui',array('controller'=>'".$model."','action'=>'admin_add')); ?> para adicionar.\n";
				$list .= "\t\t\t\t\t</td>\n";
			$list .= "\t\t\t\t</tr>\n";

		$list .= "\t\t<?php endif; ?>\n";
		
	$list .= "\t</tbody>\n";
$list .= "</table>";

$list = str_replace("#", "$", $list);

$r[] = $list;

//Código add

$add = "<ul class=\"breadcrumb\">\n";
	$add .= "<li><?php echo a('".ucfirst($model)."',array('controller'=>'".$_POST['model']."', 'action'=>'admin_list')); ?> <span class=\"divider\">/</span></li>\n";
	$add .= "<li class=\"active\">Adicionar</li>\n";
$add .= "</ul>\n";

$add .= "<?php\n";
	$add .= "\techo form(array('type'=>'vertical'));\n";
	$add .= "\techo formLegend('".ucfirst($model)."');\n";
		for ($i=0; $i < $_POST['total']; $i++) {
			if($_POST['label'.$i] != "")
				$label = ", 'label'=>'".$_POST['label'.$i]."'";
			else
				$label = "";

			$explode = explode("_",$_POST['campo'.$i]);
			$total = count($explode);
			
			if ($total > 1 AND $explode['1'] == 'id'){
				if ($label != ""){
					$label = trim(substr($label, 1));
					$label = ", array(".$label.")";
				}
					
				$add .= "\t\techo formList('".$_POST['campo'.$i]."', #".$explode[0]."s".$label.");\n";
			}else{
				if ($_POST['type'.$i] == 'text')
					$add .= "\t\techo formText('".$_POST['campo'.$i]."',array('type'=>'textarea','style'=>'height:150px;','class'=>'input-block-level'".$label."));\n";
				else
					$add .= "\t\techo formText('".$_POST['campo'.$i]."',array('class'=>'input-block-level'".$label."));\n";
			}
		}
		$add .= "\t\techo formSubmit('Salvar');\n";
	$add .= "\techo formEnd();\n";
$add .= "?>";

$add = str_replace("#", "$", $add);

$r[] = $add;

//Código View

$view = "";
for ($i=0; $i < $_POST['total']; $i++) {
	$view .="<p><strong>".ucfirst($_POST['campo'.$i])."</strong><br><?php echo #".$modelSing."['".$_POST['campo'.$i]."']; ?></p>\n";
}

$view = str_replace("#", "$", $view);

$r[] = $view;

// Código add Controller

$addC = "<?php\n\n";
$addC .= "acl();\n";
$addC .= "#layout = 'admin';\n\n";

//Verifica se tem alguma chave estrangeira e carrega
for ($i=0; $i < $_POST['total']; $i++) {
	$explode = explode("_",$_POST['campo'.$i]);
	$total = count($explode);
	if ($total > 1 AND $explode['1'] == 'id') {
		if ($_POST['campoList'.$i] == "")
			$_POST['campoList'.$i] = 'id';

		$addC .= "#".$explode[0]."s = findList('".$explode[0]."s','".$_POST['campoList'.$i]."');\n\n";
	}
}

$addC .= "if (isRequest('post')) {\n";
$addC .= "\tif (save('".$model."',#data)) {\n";
		$addC .= "\t\tsetFlash('Dados salvos com sucesso','success');\n";
		$addC .= "\t\tredirect(array('controller'=>'".$model."','action'=>'admin_list'));\n";
	$addC .= "\t} else {\n";
		$addC .= "\t\tsetFlash('Erro ao gravar os seus dados','error');\n";
	$addC .= "\t}\n";
$addC .= "}\n";
$addC .= "?>";

$addC = str_replace("#", "$", $addC);

$r[] = $addC;

$listC = "<?php\n";
$listC .= "acl();\n";
$listC .= "#layout = 'admin';\n\n";

$listC .= "#pluginsJsCss = array('tablesorter'=>array('style'));\n";
$listC .= "#pluginsJs = array('tablesorter'=>array('tablesorter'));\n\n";

$listC .= "#paginationLimit = 10;\n\n";
$listC .= "#total = totalRecords('".$model."');\n";

$listC .= "#".$model." = pagination('".$model."',array('where'=>getQ(array('".$camposBusca."'))));\n";
$listC .= "?>";

$listC = str_replace("#", "$", $listC);

$r[] = $listC;

// Código Edit Controller

$editC = "<?php\n";
$editC .= "acl();\n";
$editC .= "#layout = 'admin';\n\n";
$editC .="if (!isset(#vars[0]))\n";
	$editC .="\t#vars[0] = 0;\n\n";

//Verifica se tem alguma chave estrangeira e carrega
for ($i=0; $i < $_POST['total']; $i++) {
	$explode = explode("_",$_POST['campo'.$i]);
	$total = count($explode);
	if ($total > 1 AND $explode['1'] == 'id') {
		if ($_POST['campoList'.$i] == "")
			$_POST['campoList'.$i] = 'id';

		$editC .= "#".$explode[0]."s = findList('".$explode[0]."s','".$_POST['campoList'.$i]."');\n\n";
	}
}

$editC .= "if (isRequest('post')) {\n";
$editC .= "\tif (save('".$model."',#data,#vars[0])) {\n";
		$editC .= "\t\tsetFlash('Suas alterações foram salvas com sucesso','success');\n";
		$editC .= "\t\tredirect(array('controller'=>'".$model."','action'=>'admin_list'));\n";
	$editC .= "\t} else {\n";
		$editC .= "\t\tsetFlash('Erro ao gravar os seus dados','error');\n";
	$editC .= "\t}\n";
$editC .= "}";
$editC .= "else {\n";
	$editC .= "\t#data = findOne('".$model."','id',#vars[0]);\n\n";
$editC .= "}\n";
$editC .= "?>";

$editC = str_replace("#", "$", $editC);

$r[] = $editC;

//View Controller

$viewC = "<?php\n";
$viewC .= "acl();\n";
$viewC .= "#layout = 'admin';\n\n";
$viewC .="if (!isset(#vars[0]))\n";
	$viewC .="\t#vars[0] = 0;\n\n";

$viewC .= "#".$modelSing." = findOne('".$model."','id',#vars[0]);\n";
$viewC .= "redirect (array('controller'=>'erros','action'=>'404'));\n";
$viewC .= "?>\n";

$viewC = str_replace("#", "$", $viewC);

$r[] = $viewC;

$delete = "<?php\n";
$delete .= "#layout = 'ajax';\n\n";
$delete .= "if(isRequest('post')){\n";
	$delete .= "\t#layout = 'ajax';\n";
	$delete .= "\t#delete = mysql_query('DELETE FROM posts WHERE id='.#_POST['id']);\n";
	$delete .= "\tif (#delete)\n";
	$delete .= "\t\techo true;\n";
$delete .= "\telse\n";
	$delete .= "\t\techo false;\n";
$delete .= "}\n";
$delete .= "?>";

$delete = str_replace("#", "$", $delete);

$r[] = $delete;

$r = json_encode($r);

echo $r;

?>