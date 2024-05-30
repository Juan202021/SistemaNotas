<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modal</title>
  <style>
    
  </style>
</head>
<body>

<button id="Guardar">Abrir Modal</button>



<script>
  function abrirModal(funcionConfirmar) {
    const modal = document.getElementById('myModal');
    modal.style.display = 'block';

    const closeBtn = document.getElementsByClassName('close')[0];
    closeBtn.addEventListener('click', function() {
      modal.style.display = 'none';
    });

    const confirmBtn = document.getElementById('confirmBtn');
    confirmBtn.addEventListener('click', function() {
      // Ejecuta la función proporcionada como parámetro
      if (typeof funcionConfirmar === 'function') {
        funcionConfirmar();
      }
      modal.style.display = 'none';
    });

    const cancelBtn = document.getElementById('cancelBtn');
    cancelBtn.addEventListener('click', function() {
      modal.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
      if (event.target === modal) {
        modal.style.display = 'none';
      }
    });
  }

  /*document.getElementById('openModalBtn').addEventListener('click', function() {
    abrirModal(function() {
      // Aquí puedes colocar la función que deseas ejecutar cuando el usuario confirme la acción
      alert('Acción realizada!');
    });
  });*/

  document.getElementById('Guardar').addEventListener('click', function() {
    abrirModal(function() {
      // Aquí puedes colocar la función que deseas ejecutar cuando el usuario confirme la acción
      alert('Acción puto!');
    });
  });

  // Ejemplo de cómo abrir el modal con una función personalizada al cargar la página
  // abrirModal(function() {
  //   // Aquí puedes colocar la función que deseas ejecutar cuando el usuario confirme la acción
  //   console.log('Función personalizada ejecutada');
  // });
</script>

</body>
</html>
