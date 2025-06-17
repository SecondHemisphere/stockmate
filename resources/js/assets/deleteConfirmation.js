document.addEventListener('DOMContentLoaded', function () {
    const botones = document.querySelectorAll('.btn-eliminar');

    botones.forEach(boton => {
        boton.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡No podrás revertir esto!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ef4444",
                cancelButtonColor: "#14b8a6",
                confirmButtonText: "Sí, eliminarlo",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
