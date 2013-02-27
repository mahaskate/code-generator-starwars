function execute(command) {
	var tab = "&nbsp;&nbsp;&nbsp;&nbsp;";
	var split = command.split(' ');
	switch (split[0]) {
		case 'clear':
			$('#display').html('');
			break;
		case 'app':
			$('#currentApp').html('Current app: '+split[1]);
			$('#display').append(tab+'Your current app is '+split[1]+'<br>');
			break;
		case 'path':
			$('#path').html('Path: '+split[1]);
			$('#display').append(tab+'You just set the path to \''+split[1]+'\'<br>');
			break;
		case 'mvc':
			$('#display').append(tab+'created<br>');
			break;
		case 'newapp':
			$('#display').append(tab+'App created<br>');
			break;
		default:
			$('#display').append("<span style='color:red;'>"+tab+"Comando inválido</span><br>");
			break;
	}
}