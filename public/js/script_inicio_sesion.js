document.getElementById("btn_iniciar_sesion").addEventListener("click", iniciarSesion);
document.getElementById("btn_registrarse").addEventListener("click", register);
window.addEventListener("resize", anchoPagina);

// Declaracion de variables
var contenedor_login_register = document.querySelector(".contenedor_login-registro")
var formulario_login = document.querySelector(".formulario_login");
var formulario_register = document.querySelector(".formulario_registro");
var caja_trasera_login = document.querySelector(".caja-tra-login");
var caja_trasera_register = document.querySelector(".caja-tra-register");


function anchoPagina() {
    if (window.innerWidth > 850) {
        caja_trasera_login.style.display = "block";
        caja_trasera_register.style.display = "block";
    } else {
        caja_trasera_register.style.display = "block";
        caja_trasera_register.style.opacity = "1";
        caja_trasera_login.style.display = "none";
        formulario_login.style.display = "block";
        formulario_register.style.display = "none";
        contenedor_login_register.style.left = "0rem";
    }
}
anchoPagina();

function iniciarSesion() {

    if (window.innerWidth > 850) {
        formulario_register.style.display = "none";
        contenedor_login_register.style.left = "0.625rem";
        formulario_login.style.display = "block";
        caja_trasera_register.style.opacity = "1";
        caja_trasera_login.style.opacity = "0";
    } else {
        formulario_register.style.display = "none";
        contenedor_login_register.style.left = "0rem";
        formulario_login.style.display = "block";
        caja_trasera_register.style.display = "block";
        caja_trasera_login.style.display = "none";
    }

}


function register() {

    if (window.innerWidth > 850) {
        formulario_register.style.display = "block";
        contenedor_login_register.style.left = "25.625rem";
        formulario_login.style.display = "none";
        caja_trasera_register.style.opacity = "0";
        caja_trasera_login.style.opacity = "1";
    } else {
        formulario_register.style.display = "block";
        contenedor_login_register.style.left = "0rem";
        formulario_login.style.display = "none";
        caja_trasera_register.style.display = "none";
        caja_trasera_login.style.display = "block";
        caja_trasera_login.style.opacity = "1";
    }

}