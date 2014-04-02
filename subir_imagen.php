<?php
$mi_usuario='root';
$mi_password='mispassword';

$dir_destino = '/var/www/miweb/uploads/';
$imagen_subida = $dir_destino . basename($_FILES['foto']['name']);

//Variables del metodo POST
$codigo=$_POST['codigo'];
$descripcion=$_POST['descripcion'];

if(!is_writable($dir_destino)){
	echo "no tiene permisos";
}else{
	if(is_uploaded_file($_FILES['foto']['tmp_name'])){
		/*echo "Archivo ". $_FILES['foto']['name'] ." subido con éxtio.\n";
		echo "Mostrar contenido\n";
		echo $imagen_subida;*/
		if (move_uploaded_file($_FILES['foto']['tmp_name'], $imagen_subida)) {
			$link = mysql_connect('localhost', $mi_usuario, $mi_password)
				or die('Uyy!!!: ' . mysql_error());
			mysql_select_db('test') or die('No pudo selecionar la BD');
			//Creamos nuestra consulta sql
			$query="insert into producto(codigo, descripcion, imagen) value ('$codigo', '$descripcion', '$imagen_subida')";
			//Ejecutamos la consutla
			mysql_query($query) or die('Error al procesar consulta: ' . mysql_error());

			echo "El archivo es fue cargado exitosamente.\n";

			echo "<p>$codigo</p>";
			echo "<p>$descripcion</p>";
			echo "<img src='http://localhost/miweb/uploads/". basename($imagen_subida) ."' />";
		} else {
			echo "Posible ataque de carga de archivos!\n";
		}
	}else{
		echo "Posible ataque del archivo subido: ";
		echo "nombre del archivo '". $_FILES['archivo_usuario']['tmp_name'] . "'.";
	}
}

?>
