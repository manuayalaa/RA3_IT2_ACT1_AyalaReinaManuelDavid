<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RA3_IT2_ACT1 Manuel David Ayala Reina</title>
</head>
<link rel="stylesheet" type="text/css" href="css/style.css" />

<?php
include 'config/tests_cnf.php';
$envtest = isset($_POST['envtest']);
$resolver = isset($_POST['resolver']);
if ($envtest) {
    $numtest = intval($_POST['test']) - 1;
}
if ($resolver) {
    if (isset($_POST['respuesta01']) || isset($_POST['respuesta02']) || isset($_POST['respuesta03']) || isset($_POST['respuesta04']) || isset($_POST['respuesta05']) || isset($_POST['respuesta06']) || isset($_POST['respuesta07']) || isset($_POST['respuesta08']) || isset($_POST['respuesta09']) || isset($_POST['respuesta010'])) {
        $numtest = 0;
    }
    if (isset($_POST['respuesta11']) || isset($_POST['respuesta12']) || isset($_POST['respuesta13']) || isset($_POST['respuesta14']) || isset($_POST['respuesta15']) || isset($_POST['respuesta16']) || isset($_POST['respuesta17']) || isset($_POST['respuesta18']) || isset($_POST['respuesta19']) || isset($_POST['respuesta110'])) {
        $numtest = 1;
    }
    if (isset($_POST['respuesta21']) || isset($_POST['respuesta22']) || isset($_POST['respuesta23']) || isset($_POST['respuesta24']) || isset($_POST['respuesta25']) || isset($_POST['respuesta26']) || isset($_POST['respuesta27']) || isset($_POST['respuesta28']) || isset($_POST['respuesta29']) || isset($_POST['respuesta210'])) {
        $numtest = 2;
    }
}
?>

<body>
    <h1>Test carné de conducir</h1>
    <form action="" method="post">
        <label for="test">Selecciona el test: </label><br>
        <select name="test">
            <?php
            foreach ($aTests as $test) {
                echo '<option value=' . $test["idTest"] . '>Id: ' . $test["idTest"] . ' Permiso: ' . $test["Permiso"] . ' Categoría: ' . $test["Categoria"] . '</option>';
            }
            ?>
        </select>
        <br><br>
        <input type="submit" name="envtest" value="Hacer cuestionario"><br><br><br><br>
    </form>
    <?php
    function write_to_console($data)
    {
        $console = $data;
        if (is_array($console))
            $console = implode(',', $console);

        echo "<script>console.log('Console: " . $console . "' );</script>";
    }



    if ($envtest) {
        write_to_console($numtest);
        echo '<form action="" method="post">';
        foreach ($aTests[intval($numtest)]["Preguntas"] as $id => $pregunta) {
            echo '<h3>' . $pregunta["Pregunta"] . '</h3>';
            $ruta = 'dir_img_test' . $numtest + 1 . '/img' . $id + 1 . '.jpg';
            if (file_exists($ruta)) {
                echo '<img src="' . $ruta . '"><br/><br/>';
            }
            foreach ($pregunta["respuestas"] as $id => $respuesta) {
                if ($id == 0) {
                    $valor = 'a';
                } elseif ($id == 1) {
                    $valor = 'b';
                } elseif ($id == 2) {
                    $valor = 'c';
                }
                echo '<input type="radio" name="respuesta' . $numtest . $pregunta['idPregunta'] . '" value="' . $valor . '"> ' . $respuesta . '<br>';
                write_to_console('respuesta' . $numtest . $pregunta['idPregunta']);
            }
        }
        echo '<br><br><br><input type="submit" name="resolver" value="Resolver test">';
        echo '</form>';
    }
    if ($resolver) {
        write_to_console($numtest);
        $aciertos = 0;
        $fallos = 0;
        $numpreguntas = 0;
        foreach ($aTests[$numtest]["Preguntas"] as $id => $pregunta) {
            $numpreguntas++;
            write_to_console('respuesta'.$numtest. $pregunta['idPregunta']);
            if (isset($_POST['respuesta'.$numtest. $pregunta['idPregunta']])) {
                write_to_console($_POST['respuesta'.$numtest. $pregunta['idPregunta']]);
                write_to_console($aTests[intval($numtest)]["Corrector"][$id]);
                
                if ($_POST['respuesta'.$numtest. $pregunta['idPregunta']] == $aTests[intval($numtest)]["Corrector"][$id]) {
                    $aciertos++;
                } else {
                    $fallos++;
                }
            }else{
                $fallos++;
            }
        }
        echo '<h2>Has acertado ' . $aciertos . ' preguntas de ' . $numpreguntas . '</h2>';
        echo '<h2>Has fallado ' . $fallos . ' preguntas de ' . $numpreguntas . '</h2>';
        if($aciertos>=5){
            echo '<h2>😊 Has superado el test 😊</h2>';
        }else{
            echo '<h2>☹️ No has superado el test ☹️</h2>';
        }
    }
    ?>
</body>

</html>