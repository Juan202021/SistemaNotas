<?php
// include_once('/var/www/html/SistemaNotas/Views/header.php');
include_once('/var/www/html/SistemaNotas/Controllers/inscritosController.php');
$insController = new inscritosController();

$id = 1;
// $id = session_id();
// $data = $insController->find($id,$_POST['año'], $_POST['periodo'], $_POST['cod_cur'],$_POST['query']);

echo $_POST['año'];
echo $_POST['periodo'];
echo $_POST['cod_cur'];
echo $_POST['query'];
echo "lpm";
echo "xd";

// print_r($data);
// if (!$data) {
//     foreach ($data as $d) {
//         echo "<tr>";
//         echo "<td>{$d['apell_est']} {$d['nomb_est']}</td>";
//         echo "<td class='td-cent'>{$d['nomb_pro']}</td>";
//         echo "<td class='td-der'><a href='inscribir_inter.php?cod_est={$d['cod_est']}&cod_cur={$_POST['cod_cur']}&año={$_POST['año']}&periodo=<{$_POST['periodo']}&cod_doc={$id}&nomb_cur={$d['nomb_cur']}' class='add button'><span><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'><path fill='none' d='M0 0h24v24H0z'></path><path fill='currentColor' d='M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z'></path></svg><span class='tooltip'>Eliminar</span></span></a></td>";
//         echo "</tr>";
//     }
// } else {
//     echo "<li>No se encontraron resultados.</li>";
// }