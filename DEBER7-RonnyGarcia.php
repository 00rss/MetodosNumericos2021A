<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>DEBER7</title>
  </head>
  <body>
    <h1>ESCUELA POLITECNICA NACIONAL</h1>
    <h2>Nombre: Ronny Garcia</h2>
    <h2>Materia: Metodos Numericos</h2>
  <style type="text/css">
      body{
        background-color:#B0C4DE;
        font-family: sans-serif;
      }
      h1,h2,h3 {
        color:#2F4F4F;
        font-size: 1.25rem;
      }
      h1{
        text-align: center;
        font-size: 1.5rem;
      }
      label {
        color:#2F4F4F;
        font-size: 1rem;
        text-align: left;
        display: block;
      }
     .boton{
          font-size:1rem;
          margin-top: 10px;
          font-family: sans-serif;
          height: 50px;
          width:150px;
          display: block;
      }

      table, th, td {
        border: 1px solid black;
      }
      div{
        display: inline-block;
        padding-right:30px;
      }
      input,select{
        font-size:1.5rem;
        height: 30px;
        width:275px;
      }
  </style>

  		<form action="DEBER7-RonnyGarcia.php" method="post">
  		<h3>Ingrese los datos para encontrar la integral de una funcion mediante integracion Cuadratura Gaussiana </h3>
      <br>
      <div>
        <label>Ingrese la funcion a calcular la integral</label>
      <input type="text" name="funcion" value="<?php if(isset($_POST['funcion'])){echo $_POST['funcion'];}?>"><br>
      </div>
      <div>
        <label>Ingrese el grado del polinomio Legendre</label>
      <input type="text" name="grado" value="<?php if(isset($_POST['grado'])){echo $_POST['grado'];}?>"><br>
      </div>
      <div>
        <label>Ingrese el limite inferior para la integral</label>
        <input type="text" name="limIn" value="<?php if(isset($_POST['limIn'])){echo $_POST['limIn'];}?>" ><br>
      </div>
      <div>
        <label>Ingrese el limite superior para la integral </label>
        <input type="text" name="limSu" value="<?php if(isset($_POST['limSu'])){echo $_POST['limSu'];}?>" ><br>
      </div>
      <div>
        <label>Ingrese el # de intervalos para hallar las raices <br>del polinomio Legendre mediante biseccion</label>
        <input type="text" name="numIntervalos" value="<?php if(isset($_POST['numIntervalos'])){echo $_POST['numIntervalos'];}?>"><br>
      </div>
      <div>
        <label>Ingrese la tolerancia para la biseccion</label>
        <input type="text" name="tolerancia" value="<?php if(isset($_POST['tolerancia'])){echo $_POST['tolerancia'];}?>"><br>
      </div>
      <br>
  		<input class="boton"type="submit" >
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

function metodoDerivadaPoliLegendre ($number,$grado){

  $margen_error = 0.000000001;
	$iterator = 0.1;
	do{
		$x1= $number;
		$x2= $number-$iterator;
    $f1 = polinomioLegendre($x1,$grado);
    $f2 = polinomioLegendre($x2,$grado);
		$result = ($f1-$f2)/($x1-$x2);
		$iterator=$iterator/10;
	}while($iterator > $margen_error);
  return $result;
}
function integracionCuadraturaGaussiana($arrayRaices,$limIn,$limSu,$grado,$strEval){
  $aux1 = ($limSu - $limIn)/2;
  $aux2 = ($limSu + $limIn)/2;
  $n = $grado;
  $suma = 0;
  for ($i=0; $i < $n ; $i++) {
    $xi = $aux1*$arrayRaices[$i]+$aux2;
    $fi = funcion($xi,$strEval);
    $derivadaPoliLegrende = metodoDerivadaPoliLegendre($arrayRaices[$i],$grado);
    $poliLegendre = polinomioLegendre($arrayRaices[$i],($grado+1));
    $wi = -2/(($n+1)*$derivadaPoliLegrende*$poliLegendre);
    $suma =$suma + $fi*$wi;
  }
  $suma= $suma*$aux1;
  return $suma;
}

//function cambioDeSigno($limIn, $limSu, $numIntervalos, $grado,$tolerancia){
function cambioDeSigno($numIntervalos, $grado,$tolerancia){
  $limIn = -1;
  $limSu = 1;
  $tamanioIntervalo = (($limSu - $limIn)/$numIntervalos);
  $arregloIntervalos = array();
  $aux = $limIn;
  $raices = array();
  array_push($arregloIntervalos,($limIn));

  //SE CREA UN ARREGLO CON LOS PUNTOS DE LOS INTERVALOS
  for($i = 0;$i<$numIntervalos;$i++){
    $aux = $aux+$tamanioIntervalo;
    array_push($arregloIntervalos,($aux));
  }

  for ($i=0; $i < $numIntervalos;$i++) {
     //$f1 = funcion($arregloIntervalos[$i],$strEval);
     //$f2 = funcion($arregloIntervalos[$i+1],$strEval);
     $f1 = polinomioLegendre($arregloIntervalos[$i],$grado);
     $f2 = polinomioLegendre($arregloIntervalos[$i+1],$grado);
     //echo "<br>Subintervalo ".($i+1)."[".$arregloIntervalos[$i].",".$arregloIntervalos[$i+1]."]";
     if(($f1*$f2) < 0 ){
       //echo "<br>En el subintervalo ".($i+1)." se encontro un cambio de signo<br>";
       $iteraciones = 0;
       /*
       switch ($metodo) {
         case 'Bisección':
            metodoBiseccion($arregloIntervalos[$i],$arregloIntervalos[$i+1],$tolerancia,$strEval,$iteraciones);
           break;
         case 'Newton':
            metodoNewton($arregloIntervalos[$i],$arregloIntervalos[$i+1],$tolerancia,$strEval);
             break;
         case 'Secante':
            metodoSecante($arregloIntervalos[$i],$arregloIntervalos[$i+1],$tolerancia,$strEval);
             break;
         case 'Secante-Bisección':
            metodoHibridoSecanteBiseccion($arregloIntervalos[$i],$arregloIntervalos[$i+1],$tolerancia,$strEval,$iteraciones);
             break;
         case 'Falsa Posición':
            metodoFalsaPosicion($arregloIntervalos[$i],$arregloIntervalos[$i+1],$tolerancia,$strEval);
             break;
       }
       */

       $raiz = metodoBiseccion($arregloIntervalos[$i],$arregloIntervalos[$i+1],$tolerancia,$grado,$iteraciones);
       array_push($raices,$raiz);
       //echo "<br>fin del metodo $metodo<br>";
     }else {
       //echo "<br>En el intervalo ".($i+1)." no se encontro un cambio de signo<br>";
     }
  }
 return $raices;
}
//function metodoBiseccion($a,$b,$tolerancia,$strEval,$iteraciones){
function metodoBiseccion($a,$b,$tolerancia,$grado,$iteraciones){
  do{
  $c = ($a + $b)/2;
  $fb = polinomioLegendre($b,$grado);
  $fc = polinomioLegendre($c,$grado);
  if ((abs($b - $c))<=$tolerancia && (abs($fc)<$tolerancia)){
    //echo"<br>Se encontro la raiz en el punto: $c";
    break;
  }else{
    $iteraciones++;
    if(($fb*$fc)<=0){
      $a = $c;
    }else{
      $b = $c;
    }
  }
}while(1);
return $c;
}
function polinomioLegendre($number,$iteracion){
  if($iteracion == 0){
    //caso P0, retorna 1
    return 1;
  }elseif ($iteracion == 1) {
    //caso P1, retorna x
    return $number;
  }elseif ($iteracion > 1) {
    $pNMenos1 = polinomioLegendre($number,($iteracion -1));
    $pNMenos2 = polinomioLegendre($number,($iteracion -2));
    $polinomio = (1/$iteracion)*(((2*$iteracion)-1)*$number*$pNMenos1 -($iteracion-1)*$pNMenos2);
    return $polinomio;
  }



}
if($_POST['grado']!=NULL&&$_POST['limIn']!=NULL&&$_POST['limSu']!=NULL&&$_POST['numIntervalos']!=NULL&&$_POST['tolerancia']!=NULL&&$_POST['funcion']!=NULL){
//cambioDeSigno($_POST['limIn'],$_POST['limSu'],$_POST['numIntervalos'],$_POST['grado'],$_POST['tolerancia'],$_POST['metodo']);

$raices= cambioDeSigno($_POST['numIntervalos'],$_POST['grado'],$_POST['tolerancia']);
echo "<br>Se calcularon las raices del polinomio Legendre de grado ".$_POST['grado']."<br>Las raices son: <br>";
$n = sizeof($raices);
  for ($i=0; $i < $n ; $i++) {
    echo "raiz °".($i + 1)." =  ".$raices[$i]."<br>";
  }
echo "ahora se hara el metodo de integracion Cuadratura Gaussiana con las raices calculadas y la funcion insertada <br>";
  //$resultado = integracionCuadraturaGaussiana($raices,$limIn,$limSu,$grado,$strEval);
  $resultado = integracionCuadraturaGaussiana($raices,$_POST['limIn'],$_POST['limSu'],$_POST['grado'],$_POST['funcion']);
  echo "El resultado aproximado de la integral es: ".$resultado."<br>";
  //$aux = funcion(-0.771875,"x*x");
  //echo "El resultado es: ".$aux."<br>";
}


 ?>
