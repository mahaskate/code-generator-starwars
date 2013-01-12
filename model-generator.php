<!DOCTYPE html>
<html dir="ltr" lang="pt">

<head>

	<title>Model Generator</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/bootstrap.min.css">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

	<script type="text/javascript">
		
		function carrega(){
			var model = $('#model').val();
			var db = $('#db').val();
			$('#campos').load('ajax/model-generator.php',{model:model,db:db});
			return false;
		}		

		$(document).ready(function(){
			$('#model').keyup(function(){
				carrega();
			});
		});
	</script>

</head>

</html>

<div class="container">

	<div class="control-group">
		<label class="control-label">Banco de dados</label>
		<div class="controls">
			<input type="text" name="db" id="db">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">Model</label>
		<div class="controls">
			<input type="text" name="model" id="model">
		</div>
	</div>

<div id="campos"></div>

</div>
