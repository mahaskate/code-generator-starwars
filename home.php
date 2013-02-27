<?php session_start(); ?>
<!DOCTYPE html>
<html dir="ltr" lang="pt">

<head>

	<title>Model Generator</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/bootstrap.min.css">

	<script src="js/jquery.min.js"></script>
	<script src="js/core.js"></script>

	<script type="text/javascript">
		$(function(){
			$('#command').focus();
			$('#frm').submit(function(){
				var $command = $('#command');
				var command = $command.val();
				
				if (command != '') {
					$('#display').append("# "+command+"<br>");

					$.post('ajax/core.php',{command:command},function(callback){
						if (callback == true) {
							execute(command); //executa a parte do JS referente ao comando digitado
						}else{
							$('#display').append(callback);
						}

						$command.val('');
					});
				}
				return false; // para o form nao ser 'submitado'
			});
		});
	</script>

	<style type="text/css">
		.container-fluid {margin-top: 10px;}
		.display-cont {height: 400px; border: solid 1px #eee; margin-bottom: 10px; border-radius: 6px;}
		.display {padding: 10px;}
		.error {color: red;}
	</style>

</head>

<body>

<?php 

if (!isset($_SESSION['path']))
	$_SESSION['path'] = "c:/xampp/htdocs/";
?>

<div class="container-fluid">

	<div class="row-fluid">
		<div class="span12">
			<div id="info-cont" class="info-cont">
				<div id="path" class="path">Path: <?php echo $_SESSION['path']; ?></div>
				<div id="currentApp" class="currentApp">Current app: <?php if (isset($_SESSION['app'])) { echo $_SESSION['app']; } ?></div>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span12">
			<div id="display-cont" class="display-cont">
				<div id="display" class="display"></div>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span12">
			<form id="frm">
				<input type="text" id="command" class="input-block-level" style="height:40px;" autocomplete="off">
			</form>
		</div>
	</div>

</div>

</body>
</html>
