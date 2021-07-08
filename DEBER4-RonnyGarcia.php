<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>DEBER3</title>
  </head>
  <body style = "background-color:#B0C4DE; font-family: sans-serif;">
    <h1>ESCUELA POLITECNICA NACIONAL</h1>
    <h2>Nombre: Ronny Garcia</h2>
  <style type="text/css">
      h1 {
        color:#2F4F4F;
        font-size: 1.5rem;
        text-align: center;
      }
      h2 {
        color:#2F4F4F;
        font-size: 1rem;
        text-align: left;
      }
     .boton{
          font-size:1rem;
          margin-top: 10px;
          font-family: sans-serif;
          height: 50px;
          width:150px;
          align-content: center;
      }

      table, th, td {
        border: 1px solid black;
      }
  </style>

  		<form action="DEBER4-RonnyGarcia.php" method="post">
  		Ingrese el punto donde desea calcular la derivada
  		<br>
  		<br>
      <h2>Ingrese la funcion</h2>
  		<input type="text" name="funcion" style = "font-size:1.5rem; height: 50px; width:150px;"><br>
      <h2>Ingrese el limite inferior</h2>
      <input type="text" name="limIn" style = "font-size:1.5rem; height: 50px; width:150px;"><br>
      <h2>Ingrese el limite superior</h2>
      <input type="text" name="limSu" style = "font-size:1.5rem; height: 50px; width:150px;"><br>
      <h2>Ingrese el numero de intervalos</h2>
      <input type="text" name="numIntervalos" style = "font-size:1.5rem; height: 50px; width:150px;"><br>
      <h2>Ingrese la tolerancia</h2>
      <input type="text" name="tolerancia" style = "font-size:1.5rem; height: 50px; width:150px;"><br>
  		<input class="boton"type="submit">
  		</form>
  	</body>
</html>
<?php
function funcion($number,$strEval)
{
  $resultado = 0;
  $strEval = str_replace("x","(".$number.")",$strEval);
  eval("\$resultado =".$strEval.";");
  return $resultado;
}
function derivada($number,$strEval){
  $delta = 0.1;
  $i = 0;
  do{
    $f1 = funcion(($number+$delta),$strEval);
    $f2 = funcion(($number-$delta),$strEval);
    $resultado = ($f1 - $f2)/(2*$delta);
    $i++;

  }while(($i != 1)&&(abs()));


}


function metodoDerivada ($number,$strEval){

  $margen_error = 0.000000001;
	$iterator = 0.1;
	do{
		$x1= $number;
		$x2= $number-$iterator;
		$result = ((funcion($x1,$strEval)-funcion($x2,$strEval))/($x1-$x2));
		$iterator=$iterator/10;
	}while($iterator > $margen_error);
  return $result;
}

function cambioDeSigno($limIn, $limSu, $numIntervalos, $strEval,$tolerancia){
  $tamanioIntervalo = (($limSu - $limIn)/$numIntervalos);
  $arregloIntervalos = array();
  $aux = $limIn;
  array_push($arregloIntervalos,($limIn));

  for($i = 0;$i<$numIntervalos;$i++){
    $aux = $aux+$tamanioIntervalo;
    array_push($arregloIntervalos,($aux));
  }
  for ($i=0; $i < $numIntervalos;$i++) {
     $f1 = funcion($arregloIntervalos[$i],$strEval);
     $f2 = funcion($arregloIntervalos[$i+1],$strEval);
     echo "<br>Subintervalo ".($i+1)."[".$arregloIntervalos[$i].",".$arregloIntervalos[$i+1]."]";
     if(($f1*$f2) < 0 ){
       echo "<br>En el subintervalo ".($i+1)." se encontro un cambio de signo<br>";
       $iteraciones = 0;
       metodoNewton($arregloIntervalos[$i],$arregloIntervalos[$i+1],$tolerancia,$strEval);
       echo "<br>salio del metodo<br>";
     }else {
       echo "<br>En el intervalo ".($i+1)." no se encontro un cambio de signo<br>";
     }
  }


}
function metodoNewton($a,$b,$tolerancia,$strEval){
$num_max_iteraciones = log (($b-$a)/$tolerancia, 2);
$num_max_iteraciones = round($num_max_iteraciones);
$h = $b-$a/$num_max_iteraciones;
$xAnterior = $a;
echo "El numero de iteraciones maxima es: ".$num_max_iteraciones."<br>";
  for($i=1;$i<=$num_max_iteraciones;$i++){
    if($i==$num_max_iteraciones){
      echo "Se llego a la iteracion k-1 y no converge el metodo newton";
      return;
    }
    echo "<br>Metodo newton en la iteracion i = $i<br>";
    echo "x anterior es: ".$xAnterior."<br>";
    $f1 = funcion($xAnterior,$strEval);
    echo "f1 es: ".$f1."<br>";
    $derivadaf1 = metodoDerivada($xAnterior,$strEval);
  echo "derivada f1 es: ".$derivadaf1."<br>";
    $x = $xAnterior - ($f1/$derivadaf1);
      if (abs(funcion($xAnterior,$strEval))< $tolerancia) {
        echo "la raiz esta en el punto $xAnterior";
        return;
      }elseif(metodoDerivada($xAnterior,$strEval)==0){
          echo "Se encontro una raiz nula en la iteacion: $i";
      }elseif ( abs($x - $xAnterior)<=$tolerancia) {
        echo "la raiz se encuentra en: $x";
        return;
      }
      $xAnterior = $x;
  }
}


function metodoBiseccion($a,$b,$tolerancia,$strEval,$iteraciones){
  $c = ($a + $b)/2;
  $fb = funcion($b,$strEval);
  $fc = funcion($c,$strEval);
  ?>
    <tr>
      <td><?php echo $iteraciones ?></td>
      <td><?php echo $a ?></td>
      <td><?php echo $b ?></td>
      <td><?php echo $c ?></td>
      <td><?php echo $fc ?></td>
    </tr>

  <?php
  if ((abs($b - $c))<=$tolerancia && (abs($fc)<$tolerancia)){
    echo"<br>Se encontro la raiz en el punto: $c";
    ?>
    </table>
    <?php
    return $c;
  }else{
    $iteraciones++;
    if(($fb*$fc)<=0){
      $a = $c;
    }else{
      $b = $c;
    }
    metodoBiseccion($a,$b,$tolerancia,$strEval,$iteraciones);
  }
}
if($_POST['funcion']!=NULL&&$_POST['limIn']!=NULL&&$_POST['limSu']!=NULL&&$_POST['numIntervalos']!=NULL&&$_POST['tolerancia']!=NULL){
cambioDeSigno($_POST['limIn'],$_POST['limSu'],$_POST['numIntervalos'],$_POST['funcion'],$_POST['tolerancia']);
}
 ?>
