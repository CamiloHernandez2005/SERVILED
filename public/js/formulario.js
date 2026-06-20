const formulario = document.getElementById('formulario');
const inputs = document.querySelectorAll('#formulario input');

const expresiones = {
	usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
	nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
    password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/,
    correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
	telefono: /^\d{10}$/, // 7 a 14 numeros.
	identificacion: /^\d{6,12}$/ // 6 a 12 digitos.
}

const campos = {
	name: false,
	password: false
}


const validarFormulario = (e) => {
	switch (e.target.name){
		case "name":
			validarCampo(expresiones.correo, e.target, 'name');
		break;
		case "password":
			validarCampo(expresiones.password, e.target, 'password');
		break;
	}
}

const validarCampo = (expresion, input, campo) => {
	if(expresion.test(input.value)){
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('fa-check-circle');
		document.querySelector(`#grupo__${campo} i`).classList.remove('fa-times-circle');
		document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo');
		campos[campo] = true;

	}else{
		document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('fa-times-circle');
		document.querySelector(`#grupo__${campo} i`).classList.remove('fa-check-circle');
		document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.add('formulario__input-error-activo');
		campos[campo] = false;
	}
}


inputs.forEach((input) => {
	input.addEventListener('keyup', validarFormulario);
	input.addEventListener('blur', validarFormulario);
});
formulario.addEventListener('submit', (e) => {
	// e.preventDefault(); //Este se quita para redireccionar al usuario, a la pagina principal del proyecto

	if(campos.name && campos.password){
		// formulario.reset(); //Esta accion se quita para enviar los datos hacia el controlador
		document.querySelectorAll('.formulario__grupo-correcto').forEach( (icono) => {
			icono.classList.remove('formulario__grupo-correcto')
		} );
	}else{
		document.getElementById('formulario__mensaje').classList.add('formulario__mensaje-activo');
		setTimeout( () =>{
			document.getElementById('formulario__mensaje').classList.remove('formulario__mensaje-activo');
		}, 5000);
	}
});

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

