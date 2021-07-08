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

  		<form action="DEBER3-RonnyGarcia.php" method="post">
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
function cambioDeSigno($limIn, $limSu, $numIntervalos, $strEval,$tolerancia){
  $tamanioIntervalo = (($limSu - $limIn)/$numIntervalos);
  $arregloRaices = array();
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
       ?>
       <table >
       <tr>
         <th>k</th>
         <th>a</th>
         <th>b</th>
         <th>c</th>
         <th>f(c)</th>
       </tr>
       <?php
       $iteraciones = 0;
       $resultado = metodoBiseccion($arregloIntervalos[$i],$arregloIntervalos[$i+1],$tolerancia,$strEval,$iteraciones);
       echo $resultado;
       //array_push($arregloRaices,$raiz);
     }else {
       echo "<br>En el intervalo ".($i+1)." no se encontro un cambio de signo<br>";
     }
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


/*
if($_POST['funcion']!=NULL&&$_POST['x']!=NULL){
$resultado = funcion($_POST['x'],$_POST['funcion']);
echo "el valor de la funcion es: $resultado";
}
*/
if($_POST['funcion']!=NULL&&$_POST['limIn']!=NULL&&$_POST['limSu']!=NULL&&$_POST['numIntervalos']!=NULL&&$_POST['tolerancia']!=NULL){
cambioDeSigno($_POST['limIn'],$_POST['limSu'],$_POST['numIntervalos'],$_POST['funcion'],$_POST['tolerancia']);
}
 ?>
