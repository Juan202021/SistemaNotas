<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tabla Interactiva</title>
<style>
    table {
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid black;
        padding: 8px;
    }
    td {
        cursor: pointer;
    }
</style>
</head>
<body>

<table id="miTabla">
    <tr>
        <td rowspan="2" onclick="borrarCelda(this)">Celda 1</td>
        <td onclick="borrarCelda(this)">Celda 2</td>
        <td onclick="borrarCelda(this)">Celda 3</td>
        <td colspan="2" onclick="borrarCelda(this)">Celda 4</td>
    </tr>
    <tr>
        <td onclick="borrarCelda(this)">Celda 5</td>
        <td onclick="borrarCelda(this)">Celda 6</td>
        <td colspan="2" onclick="borrarCelda(this)">Celda 7</td>
    </tr>
</table>

<script>
function borrarFila(celda) {
    var fila = celda.parentNode;
    var numCeldas = fila.cells.length;
    console.log("Número de celdas en la fila: " + numCeldas);
    
    var rowIndex = fila.rowIndex;
    console.log("Índice de fila: " + rowIndex);
    
    var table = document.getElementById("miTabla");
    table.deleteRow(rowIndex);
}
</script>

</body>
</html>
