<?php 

$model = $_POST['model'];
$db = $_POST['db'];

$server_db = 'localhost';
$user_db = 'root';
$db = $db;
$password_db = '';

include"../db/db.php";

$sel = mysql_query('SHOW COLUMNS FROM '.$model);

if ($sel)
	$total = mysql_num_rows($sel);
else
	$total = 0;

for ($i=0; $i < $total; $i++) { 
	$campos[] = mysql_fetch_assoc($sel);
}
if (!empty($campos))
	unset($campos[0]);
	unset($campos[$total-1]);	
	unset($campos[$total-2]);
?>

<?php if (empty($campos)): ?>
	<h2>Tabela não encontrada.</h2>
<?php else: ?>

<div class="container" style="margin-bottom:70px;">

	<div class="row">
		<form id="formulario">
			<div class="span12">
				<div class="control-group">
					<div class="label-control"><label>Campos da busca</label></div>
					<div class="controls"><input type="text" name="camposBusca"></div>
				</div>

				<div class="control-group">
					<div class="label-control"><label>Campos a serem mostrados na list</label></div>
					<div class="controls"><input type="text" name="camposMostrados" id="camposMostrados"></div>
				</div>
			</div>

			<input type="hidden" name="model" value="<?php echo $model; ?>">
			<?php $i = 0; ?>
			<?php foreach ($campos as $key => $campo): ?>
					<?php 
						//vericar se campo é chave primaria de outra tabela
						$fieldExplode = explode("_", $campo['Field']);
						$total = count($fieldExplode);
			
						if ($total == 2){
							$fk_key = true;
						}else
							$fk_key = false;

						//Desmarcar 'mostrar na list'
						if ($campo['Field'] != 'created' AND $campo['Field'] != 'modified')
							$checked = 'checked';
						else
							$checked = '';

						$valor = "";
						if ($campo['Null'] == "NO") {
							$valor .= "required,";
						}
						if ($campo['Type'] == "datetime" OR $campo['Type'] == 'date') {
							$valor .= "date,";
						}
						$tipo = explode("(",$campo['Type']);
						if ($tipo[0] == 'int') {
							$valor .= 'numeric,';
						}
						if ($campo['Field'] == 'email') {
							$valor .= "email,";
						}
						if ($campo['Type'] == 'text') {
							$valor .= "text,";
						}

						$valor = substr($valor, 0, -1);

					?>
						<div class="span12">
							<div class="control-group">
								<label class="control-label"><?php echo $campo['Field'] ?></label>
								<div class="controls">
									<input type="hidden" class="span2" name="campo<?php echo $i;?>" value="<?php echo $campo['Field']; ?>">
									<input type="text" class="span2" name="label<?php echo $i;?>" placeholder="Label">
									<input type="hidden" name="type<?php echo $i;?>" placeholder="Label" value="<?php echo $campo['Type']; ?>">

									<?php if (!$fk_key): ?>
										<textarea class="span2" placeholder="Validação" name="validation"><?php echo $valor; ?></textarea>
									<?php endif ?>

									<?php if ($fk_key): ?>
										<input type="text" class="span2" placeholder="Campo que será mostrado na combo" name="campoList<?php echo $i;?>" id="campoList<?php echo $i;?>">
									<?php endif ?>

								</div>
							</div>
						</div>
						<?php $i++; ?>
			<?php endforeach ?>
			
			<input type="hidden" name="total" value="<?php echo $i;?>">
		</form>
	</div>

	<br>

</div>

<div style="position:fixed;bottom:0; background-color:gray; width:100%; height:70px;">
	<div class="container">
		<button type="button" class="btn btn-large" style="margin-top:15px;" id="btn" onclick="return teste();">Gerar MVC</button>
	</div>
</div>

<?php endif ?>

<script type="text/javascript">
	function teste(){
		$.post('ajax/cria-codigo.php',$('#formulario').serialize(),function(callback){
			var model = $('#model').val();

			var admin_add = 0;
			var admin_edit = 0;
			var admin_list = 0;
			var admin_view = 0;
			var add = 0;
			var admin_delete = 0;

			var codigo = jQuery.parseJSON(callback);

			if (confirm("Deseja Criar o add na rota admin ?")) { var admin_add = 1;};
			if (confirm("Deseja Criar o edit na rota admin?")) { var admin_edit = 1;};
			if (confirm("Deseja Criar o list na rota admin?")) { var admin_list = 1;};
			if (confirm("Deseja Criar o view na rota admin?")) { var admin_view = 1;};
			if (confirm("Deseja Criar o controller delete na rota admin?")) { var admin_delete = 1;};
			//if (confirm("Deseja Criar o add na rota normal?")) { var add = 1;};

			// Carrega por ajax o arquivo php que cria /*
			$.post('ajax/cria-arquivos.php',{codigo:callback,admin_delete:admin_delete,model:model,admin_add:admin_add,admin_edit:admin_edit,admin_list:admin_list,admin_view:admin_view,add:add},function(callback){
				alert(callback);
			});
		});
	}
</script>

