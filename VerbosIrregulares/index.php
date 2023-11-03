<?php

/**
 * @author Manuel David Ayala Reina
 */

include 'config/config.php';
$valoresAleatorios = [];
$valoresAleatorios2 = [];
$inputs = [];
if (isset($_POST['envresp'])) {
    for ($h = 0; $h < 208; $h++) {
        for ($p = 0; $p <= 3; $p++) {
            $nombre_input = 'input' . $h . $p;
            if (isset($_POST[$nombre_input])) {
                $inputs[$nombre_input] = $_POST[$nombre_input];
            }
        }
    }
    write_to_console($inputs);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="css/css.css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RA3_IT2_ACT1 Manuel David Ayala Reina</title>
    <?php
    $envnivel = isset($_POST['envnivel']);
    $resolver = isset($_POST['envresp']);
    if ($envnivel) {
        $cantidad = $_POST['cantidad'];
        $nivel = $_POST['nivel'];
    }
    ?>
</head>

<body>
    <h1>Verbos Irregulares</h1>
    <form action="" method="post">
        <label for="nivel">Cantidad de verbos: </label><br>
        <input type="number" name="cantidad" value="<?php echo $cantidad ?>"><br><br>
        <label for="nivel">Nivel de dificultad: </label><br>
        <select name="nivel" value="<?php echo $nivel ?>">
            <option value=1>1</option>
            <option value=2>2</option>
            <option value=3>3</option>
        </select>

        <br><br>
        <input type="submit" name="envnivel" value="Hacer cuestionario"><br><br><br><br>
    </form>
    <form action="" method="post">
        <table border='1'>
            <?php
            if ($envnivel) {
                if ($valoresAleatorios == []) {
                    while (count($valoresAleatorios) < $cantidad) {
                        $numeroAleatorio1 = rand(0, 208);
                        if (!in_array([$numeroAleatorio1], $valoresAleatorios)) {
                            $valoresAleatorios[] = $numeroAleatorio1;
                        }
                    }
                    for ($i = 0; $i < count($valoresAleatorios); $i++) {
                        echo "<tr>";
                        echo "<td>Nº " . $valoresAleatorios[$i] . "</td>";
                        $posiblesValores = range(0, 3);
                        shuffle($posiblesValores);
                        $valoresAleatorios2 = array_slice($posiblesValores, 0, $nivel);
                        write_to_console($valoresAleatorios2);

                        for ($j = 0; $j <= 3; $j++) {
                            write_to_console($j);

                            if (!in_array($j, $valoresAleatorios2)) {
                                echo "<td>" . $verbosIrregulares[$valoresAleatorios[$i]][$j] . "</td>";
                            } else {
                                echo '<td><input type="text" name="input' . $valoresAleatorios[$i] . '' . $j . '"><br><br>
                                </td>';
                                write_to_console('input' . $valoresAleatorios[$i] . $j);
                            }
                        }
                        echo "</tr>";
                    }
                }

            ?>
        </table><br><br><br><br>
        <input type="submit" name="envresp" value="Resolver"><br><br><br><br>
    <?php
            }
            if ($resolver) {
                echo "<table border='1'>";





                $contadorsolucion = 0;
                $porcentaje = 0;


                for ($h = 0; $h < 208; $h++) {
                    if (isset($inputs['input' . $h . '0']) || isset($inputs['input' . $h . '1']) || isset($inputs['input' . $h . '2']) || isset($inputs['input' . $h . '3'])) {
                        echo "<tr>";
                        echo "<td> Nº " . $h . "</td>";

                        foreach ($verbosIrregulares[$h] as $p => $verbo) {
                            $tdClass = '';
                            $marcador = '';
                            $nombre_input2 = 'input' . $h . $p;
                            if (isset($inputs[$nombre_input2])) {
                                if ($verbosIrregulares[$h][$p] == $inputs[$nombre_input2]) {
                                    $contadorsolucion++;
                                    $tdClass = "verdadero";
                                    $marcador = "✔";
                                    echo "<td id='$tdClass'>" . $verbo . " " . $marcador . "</td>";
                                } else {
                                    $tdClass = "falso";
                                    $marcador = "X";

                                    echo "<td id='$tdClass'>" . $verbo . " " . $marcador . "</td>";
                                }
                            }else{
                                echo "<td id='$tdClass'>" . $verbo . " " . $marcador . "</td>";
                            }




                            
                        }

                        echo "</tr>";
                    }








                    for ($p = 0; $p <= 3; $p++) {
                    }
                }
                if (count($inputs) != 0) {
                    $porcentaje = ($contadorsolucion * 100) / count($inputs);
                }
                echo "</table>";
                echo '<h3>Has acertado: ' . $contadorsolucion . ' tiempo/s</h3>';
                echo '<h3>Has acertado: ' . $porcentaje . ' %</h3>';
            }

            function write_to_console($data)
            {
                $console = $data;
                if (is_array($console))
                    $console = implode(',', $console);

                echo "<script>console.log('Console: " . $console . "' );</script>";
            }


    ?>



    </form>
</body>

</html>