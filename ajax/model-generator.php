<script type="text/javascript">
	$(document).ready(function(){
		$('#geraCod').click(function(){
			var campos = $('#formulario').serialize();
			$.post('ajax/cria-codigo-model.php',$('#formulario').serialize(),function(callback){
				$('#codigo').val(callback);
			});
		});
	});
</script>

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
if (!empty($campos)){
	unset($campos[0]);
	$total = count($campos);
	unset($campos[$total]);
	unset($campos[$total-1]);
}
?>

<?php if (empty($campos)): ?>
	<h2>Tabela não encontrada.</h2>
<?php else: ?>

<div class="row">
	<form id="formulario" name="formulario">
	<?php foreach ($campos as $key => $campo): ?>
			<?php 
				$valor = "";
				if ($campo['Null'] == "NO") {
					$valor .= "required, ";
				}
				if ($campo['Type'] == "datetime" OR $campo['Type'] == 'date') {
					$valor .= "date, ";
				}
				$tipo = explode("(",$campo['Type']);
				if ($tipo[0] == 'int') {
					$valor .= 'numeric,';
				}
				if ($campo['Field'] == 'email') {
					$valor .= "email, ";
				}
				if ($campo['Type'] == 'text') {
					$valor .= "text, ";
				}

				$valor = substr(trim($valor), 0, -1);
			?>
			<div class="span4">
				<div class="control-group">
					<label class="control-label"><?php echo $campo['Field'] ?></label>
					<div class="controls">
						<textarea class="span4" name="<?php echo $campo['Field'] ?>" id="<?php echo $campo['Field'] ?>"><?php echo $valor; ?></textarea>
					</div>
				</div>		
			</div>
	<?php endforeach ?>	
	</form>
</div>

	<div class="control-group">
		<div class="controls">
			<textarea class="span12" style="height:140px;" placeholder="Código" id="codigo"></textarea>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button type="button" class="btn" id="geraCod">Gerar código</button>
		</div>
	</div>

<?php endif ?>