/**
 * public/js/validation.js
 * Primera capa de validación (Frontend).
 * Se complementa siempre con la validación obligatoria del servidor (PHP).
 */
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-estudiante');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        let valido = true;
        limpiarErrores(form);

        valido = validarCedula() && valido;
        valido = validarRequerido('nombres', 'El nombre es obligatorio.') && valido;
        valido = validarRequerido('apellidos', 'El apellido es obligatorio.') && valido;
        valido = validarEmail() && valido;
        valido = validarRequerido('carrera', 'La carrera es obligatoria.') && valido;
        valido = validarRango('semestre', 1, 10, 'El semestre debe estar entre 1 y 10.') && valido;
        valido = validarRango('nota_final', 0, 10, 'La nota debe estar entre 0 y 10.') && valido;

        if (!valido) {
            e.preventDefault();
        }
    });

    function limpiarErrores(form) {
        form.querySelectorAll('.error-text').forEach(el => el.textContent = '');
    }

    function mostrarError(campo, mensaje) {
        const el = document.getElementById('error-' + campo);
        if (el) el.textContent = mensaje;
    }

    function validarCedula() {
        const valor = document.getElementById('cedula').value.trim();
        if (!/^\d{10}$/.test(valor)) {
            mostrarError('cedula', 'La cédula debe tener exactamente 10 dígitos.');
            return false;
        }
        return true;
    }

    function validarRequerido(id, mensaje) {
        const valor = document.getElementById(id).value.trim();
        if (valor === '') {
            mostrarError(id, mensaje);
            return false;
        }
        return true;
    }

    function validarEmail() {
        const valor = document.getElementById('email').value.trim();
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!regex.test(valor)) {
            mostrarError('email', 'Ingrese un correo electrónico válido.');
            return false;
        }
        return true;
    }

    function validarRango(id, min, max, mensaje) {
        const valor = parseFloat(document.getElementById(id).value);
        if (isNaN(valor) || valor < min || valor > max) {
            mostrarError(id, mensaje);
            return false;
        }
        return true;
    }
});

/** Confirmación antes de eliminar un registro */
function confirmarEliminacion(nombre) {
    return confirm('¿Está seguro de eliminar al estudiante "' + nombre + '"? Esta acción no se puede deshacer.');
}
