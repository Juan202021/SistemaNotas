function abrirModal(funcionConfirmar, mensaje, ...args) {
    const modal = document.getElementById('myModal');
    var texto = document.getElementById('confirmacion');
    texto.innerText = mensaje;
    modal.style.display = 'block';

    const closeBtn = document.getElementsByClassName('close')[0];
    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    const confirmBtn = document.getElementById('confirmBtn');
    confirmBtn.addEventListener('click', function() {
        // Ejecuta la función proporcionada como parámetro
        if (typeof funcionConfirmar === 'function') {
            if (args.length > 0) {
                funcionConfirmar(...args);
            } else {
                funcionConfirmar();
            }
        }
        funcionConfirmar = null;
        args = [];
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