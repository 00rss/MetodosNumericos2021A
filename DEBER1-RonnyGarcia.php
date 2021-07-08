<html>
	<head>
	<title>TAREA 1 Ronny Garcia</title>

	</head>
	<body style = "background-color:#B0C4DE; font-family: sans-serif;">
		<h1 style= "color:#2F4F4F; font-size: 1.5rem;">La ecuacion de la cual se va a hacer el proceso iterativo para encontrar la derivada es: y = x^2 -3</h1>
		<form action="DEBER1-RonnyGarcia.php" method="post">
		Ingrese el punto donde desea calcular la derivada
		<br>
		<br>
		<input type="text" name="x" style = "font-size:1.5rem; height: 50px; width:150px;"><br>
		<input style = "font-size:1rem; margin-top: 10px; font-family: sans-serif; height: 50px; width:150px; align-content: center; "type="submit">
		</form>
	</body>
</html>
<?php
//ecuacion y = x^2-3
function ecuacion ($number){
	return ($number*$number)-3;
}
function derivada ($number){
	$margen_error = 0.0000001;
	$iterator = 0.1;
	$i=0;
	do{
	//despues de cada iteracion el iterador se divide para 10
		$x1= $number;
		$x2= $number-$iterator;
		$result = (ecuacion($x1)-ecuacion($x2))/($x1-$x2);
		echo "el resultado es $result con el iterador de valor: $iterator <br>";
		$iterator=$iterator/10;
		$i++;
	}while($iterator > $margen_error);
	echo "el resultado final es: $result en la iteracion: $i con marguen de error: $margen_error";
}if($_POST['x']!=NULL){
derivada($_POST['x']);
}
?>
