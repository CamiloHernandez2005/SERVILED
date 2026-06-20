//Funcion para ocultar y ver la contraseña
function togglePassword() {
    var passwordInput = document.getElementById('password');
    var icon = document.getElementById('togglePassword');
    // Cambiar el tipo de entrada de la contraseña entre 'password' y 'text'
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        // Cambiar el icono a 'fa-eye-slash' cuando la contraseña es visible
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    } else {
        passwordInput.type = 'password';
        // Cambiar el icono a 'fa-eye' cuando la contraseña es oculta
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }
}
function togglePassword2() {
    var passwordInput = document.getElementById('password-confirm');
    var icon = document.getElementById('togglePassword2');
    // Cambiar el tipo de entrada de la contraseña entre 'password' y 'text'
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        // Cambiar el icono a 'fa-eye-slash' cuando la contraseña es visible
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    } else {
        passwordInput.type = 'password';
        // Cambiar el icono a 'fa-eye' cuando la contraseña es oculta
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }
}
//Funcion de oculatar y ver contraseña en el input nueva contraseña
function togglePasswordNew() {
    var passwordInput = document.getElementById('Newpassword');
    var icon = document.getElementById('togglePasswordNew');
    // Cambiar el tipo de entrada de la contraseña entre 'password' y 'text'
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        // Cambiar el icono a 'fa-eye-slash' cuando la contraseña es visible
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    } else {
        passwordInput.type = 'password';
        // Cambiar el icono a 'fa-eye' cuando la contraseña es oculta
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }
}
//Funcion de oculatar y ver contraseña en el input confirmar contraseña
function togglePasswordNewConfir() {
    var passwordInput = document.getElementById('NewpasswordConfirm');
    var icon = document.getElementById('togglePasswordNewConfir');
    // Cambiar el tipo de entrada de la contraseña entre 'password' y 'text'
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        // Cambiar el icono a 'fa-eye-slash' cuando la contraseña es visible
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    } else {
        passwordInput.type = 'password';
        // Cambiar el icono a 'fa-eye' cuando la contraseña es oculta
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }
}
