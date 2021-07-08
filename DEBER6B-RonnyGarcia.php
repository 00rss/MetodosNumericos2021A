<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>DEBER6B</title>
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
        width:220px;
      }
  </style>

  		<form action="DEBER6B-RonnyGarcia.php" method="post">
  		<h3>Ingrese los datos para encontrar las raices de una funcion</h3>
      <div>
        <label>Ingrese la funcion</label>
      <input type="text" name="funcion" value="<?php if(isset($_POST['funcion'])){echo $_POST['funcion'];}?>"><br>
      </div>
      <div>
        <label>Ingrese el limite inferior</label>
        <input type="text" name="limIn" value="<?php if(isset($_POST['limIn'])){echo $_POST['limIn'];}?>" ><br>
      </div>
      <div>
        <label>Ingrese el limite superior</label>
        <input type="text" name="limSu" value="<?php if(isset($_POST['limSu'])){echo $_POST['limSu'];}?>" ><br>
      </div>
      <div>
        <label>Ingrese el numero de intervalos</label>
        <input type="text" name="numIntervalos" value="<?php if(isset($_POST['numIntervalos'])){echo $_POST['numIntervalos'];}?>"><br>
      </div>
      <div>
        <label>Ingrese la tolerancia</label>
        <input type="text" name="tolerancia" value="<?php if(isset($_POST['tolerancia'])){echo $_POST['tolerancia'];}?>"><br>
      </div>
        <label for="metodo">Seleccione el metodo para encontrar las raices</label>
      <div>

          <select name="metodo" id="metodo"value="">
            <?php
            $arregloMetodos = array('Bisección','Newton','Secante','Secante-Bisección','Falsa Posición');
            $tamMetodos = sizeof($arregloMetodos);
            if(isset($_POST['metodo'])){
              $aux = $_POST['metodo'];
                ?>
                <option><?php echo $aux;?></option>
                <?php
                for ($i=0; $i <$tamMetodos; $i++) {
                  if($aux != $arregloMetodos[$i]){
                    ?>
                    <option><?php echo $arregloMetodos[$i];?></option>
                    <?php
                  }
                }
              }else {
                for ($i=0; $i <$tamMetodos; $i++) {
                    ?>
                    <option><?php echo $arregloMetodos[$i];?></option>
                    <?php
                  }
              }
            ?>
          </select>
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

function cambioDeSigno($limIn, $limSu, $numIntervalos, $strEval,$tolerancia,$metodo){
  $tamanioIntervalo = (($limSu - $limIn)/$numIntervalos);
  $arregloIntervalos = array();
  $aux = $limIn;
  array_push($arregloIntervalos,($limIn));

  //SE CREA UN ARREGLO CON LOS PUNTOS DE LOS INTERVALOS
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
       echo "<br>fin del metodo $metodo<br>";
     }else {
       echo "<br>En el intervalo ".($i+1)." no se encontro un cambio de signo<br>";
     }
  }


}
function metodoSecante($a,$b,$tolerancia,$strEval){
$num_max_iteraciones = log (($b-$a)/$tolerancia, 2);
$num_max_iteraciones = round($num_max_iteraciones);
$x0 = $a;
$x1 = $b;
echo "Metodo Secante, el numero de iteraciones maxima es: ".$num_max_iteraciones."<br>";
?>
<table>
  <tr>
    <th>k</th>
    <th>Xk-1</th>
    <th>Xk</th>
    <th>Xk+1</th>
    <th>f(x(k-1))</th>
    <th>f(x(k))</th>
    <th>f(x(k+1))</th>
  </tr>
<?php
  for($i=1;$i<=$num_max_iteraciones;$i++){
    if($i==$num_max_iteraciones){
      ?>
      </table>
      <?php
      echo "Se llego a la iteracion k-1 y no converge el metodo Secante";
      return;
    }
    $f0 = funcion($x0,$strEval);
    $f1 = funcion($x1,$strEval);
    $x = $x1 - $f1*(($x1 - $x0)/($f1-$f0));
    $fx = funcion($x,$strEval);
    ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $x0; ?></td>
        <td><?php echo $x1; ?></td>
        <td><?php echo $x; ?></td>
        <td><?php echo $f0; ?></td>
        <td><?php echo $f1; ?></td>
        <td><?php echo $fx; ?></td>
      </tr>
    <?php
      if(abs($x-$x1)<=$tolerancia && $fx <= $tolerancia ){
        ?>
        </table>
        <?php
        echo "<br>La raiz esta en: ".$x." <br>";
        return;
      }
      $x0 = $x1;
      $x1 = $x;
    }

}
function metodoHibridoSecanteBiseccion($a,$b,$tolerancia,$strEval,$iteraciones){
  if($iteraciones == 0){
    echo "Metodo Secante-Bisección";
    ?>
    <table >
    <tr>
      <th>k</th>
      <th>a</th>
      <th>b</th>
      <th>c</th>
      <th>f(b)</th>
      <th>f(c)</th>
    </tr>
    <?php
  }
  $fa = funcion($a,$strEval);
  $fb = funcion($b,$strEval);
  $c = $b - $fb*(($b-$a)/($fb-$fa));
  $fc = funcion($c,$strEval);

  ?>
    <tr>
      <td><?php echo $iteraciones ?></td>
      <td><?php echo $a ?></td>
      <td><?php echo $b ?></td>
      <td><?php echo $c ?></td>
      <td><?php echo $fb ?></td>
      <td><?php echo $fc ?></td>
    </tr>

  <?php

    if(abs($b - $c)<=$tolerancia&&abs($fc)<$tolerancia){
      ?>
      </table>
      <?php
      echo "la raiz se encuentra en el punto = $c";
      return;
    }else
    $iteraciones++;
    if (($fb*$fc) <= 0) {
      $a = $c;
    }else{
      $b = $c;
    }
    metodoHibridoSecanteBiseccion($a,$b,$tolerancia,$strEval,$iteraciones);
}

function metodoNewton($a,$b,$tolerancia,$strEval){
$num_max_iteraciones = log (($b-$a)/$tolerancia, 2);
$num_max_iteraciones = round($num_max_iteraciones);
$h = $b-$a/$num_max_iteraciones;
$xAnterior = $a;
echo "Uso del metodo Newton, el numero de iteraciones maxima sera: ".$num_max_iteraciones."<br>";
?>
<table>
  <tr>
    <th>k</th>
    <th>Xk-1</th>
    <th>Xk</th>
    <th>f(x(k-1))</th>
    <th>f'(x(k-1))</th>
  </tr>

<?php
  for($i=1;$i<=$num_max_iteraciones;$i++){
    if($i==$num_max_iteraciones){
      ?>
      </table>
      <?php
      echo "Se llego a la iteracion k-1 y no converge el metodo newton";
      return;
    }
    $f1 = funcion($xAnterior,$strEval);
    $derivadaf1 = metodoDerivada($xAnterior,$strEval);
    $x = $xAnterior - ($f1/$derivadaf1);
    ?>
      <tr>
        <td><?php echo $i ?></td>
        <td><?php echo $xAnterior ?></td>
        <td><?php echo $x ?></td>
        <td><?php echo $f1 ?></td>
        <td><?php echo $derivadaf1 ?></td>
      </tr>
    <?php
      if (abs(funcion($xAnterior,$strEval))< $tolerancia) {
        ?>
        </table>
        <?php
        echo "<br>la raiz esta en el punto $xAnterior";
        return;

      }elseif(metodoDerivada($xAnterior,$strEval)==0){
          echo "<br>Se encontro una raiz nula en la iteacion: $i";
      }elseif ( abs($x - $xAnterior)<=$tolerancia) {
        ?>
        </table>
        <?php
        echo "<br>la raiz se encuentra en: $x";
        return;
      }
      $xAnterior = $x;
  }
}


function metodoBiseccion($a,$b,$tolerancia,$strEval,$iteraciones){
  if($iteraciones == 0){
    echo "Metodo biseccion";
    ?>
    <table >
    <tr>
      <th>k</th>
      <th>a</th>
      <th>b</th>
      <th>c</th>
      <th>f(b)</th>
      <th>f(c)</th>
    </tr>
    <?php
  }
  $c = ($a + $b)/2;
  $fb = funcion($b,$strEval);
  $fc = funcion($c,$strEval);
  ?>
    <tr>
      <td><?php echo $iteraciones ?></td>
      <td><?php echo $a ?></td>
      <td><?php echo $b ?></td>
      <td><?php echo $c ?></td>
      <td><?php echo $fb ?></td>
      <td><?php echo $fc ?></td>
    </tr>

  <?php
  if ((abs($b - $c))<=$tolerancia && (abs($fc)<$tolerancia)){
    ?>
    </table>
    <?php
    echo"<br>Se encontro la raiz en el punto: $c";
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
function metodoFalsaPosicion($a,$b,$tolerancia,$strEval){
$num_max_iteraciones = log (($b-$a)/$tolerancia, 2);
$num_max_iteraciones = round($num_max_iteraciones);
$xa = $a;
$xb = $b;
echo "Metodo falsa posicion, el numero de iteraciones maxima es: ".$num_max_iteraciones."<br>";
?>
<table>
  <tr>
    <th>k</th>
    <th>Xa</th>
    <th>Xb</th>
    <th>Xc</th>
    <th>f(a)</th>
    <th>f(b)</th>
    <th>f(c)</th>
  </tr>
<?php
  for($i=1;$i<=$num_max_iteraciones;$i++){
    if($i==$num_max_iteraciones){
      ?>
      </table>
      <?php
      echo "Se llego a la iteracion k-1 y no converge el falsa posicion";
      return;
    }
    $fa = funcion($xa,$strEval);
    $fb = funcion($xb,$strEval);

    $c = ($fb*$xa - $fa*$xb)/($fb-$fa);
    $fc = funcion($c,$strEval);
    ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $xa; ?></td>
        <td><?php echo $xb; ?></td>
        <td><?php echo $c; ?></td>
        <td><?php echo $fa; ?></td>
        <td><?php echo $fb; ?></td>
        <td><?php echo $fc; ?></td>
      </tr>
    <?php
      if(abs($c-$xb)<=$tolerancia && $fc <= $tolerancia ){
        ?>
        </table>
        <?php
        echo "<br>La raiz esta en: ".$c." <br>";
        return;
      }
      $xa = $xb;
      $xb = $c;
    }

}
if($_POST['funcion']!=NULL&&$_POST['limIn']!=NULL&&$_POST['limSu']!=NULL&&$_POST['numIntervalos']!=NULL&&$_POST['tolerancia']!=NULL&&$_POST['metodo']!=NULL){

cambioDeSigno($_POST['limIn'],$_POST['limSu'],$_POST['numIntervalos'],$_POST['funcion'],$_POST['tolerancia'],$_POST['metodo']);
}
 ?>
