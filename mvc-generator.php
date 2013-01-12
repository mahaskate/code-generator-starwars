<!DOCTYPE html>
<html dir="ltr" lang="pt">

<head>

	<title>Model Generator</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/bootstrap.min.css">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

	<script type="text/javascript">
		

	$(document).ready(function(){

		$('#go').click(function(){
			var model = $('#model').val();
			var db = $('#db').val();
			$('#campos').load('ajax/mvc-generator.php',{model:model,db:db});
			return false;
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
		<label class="control-label">Tabela</label>
		<div class="input-append">
 			<input class="span2" type="text" name="model" id="model">
 			<button class="btn" type="button" id="go">Go!</button>
		</div>
	</div>
<hr>
</div>

<div id="campos"></div>
