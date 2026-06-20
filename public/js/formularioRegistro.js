const formularioRegistro = document.getElementById('formulario_registro');
const inputRegistro = document.querySelectorAll('#formulario_registro input');


//La constante expresiones la puedo llamar del otro archivo formulario.js
// const expresiones = {
// 	usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
// 	nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
// 	password: /^.{4,12}$/, // 4 a 12 digitos.
// 	correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
// 	telefono: /^\d{10}$/, // 7 a 14 numeros.
// 	identificacion: /^\d{6,12}$/ // 6 a 12 digitos.
// }



const CampoRegistro = {
	nombre: false,
	email: false,
	phone_number: false,
	document_type: false,
	identification_number: false,
	contrasena: false
}

const validarFormularioRegistro = (evento) => {
	switch (evento.target.name){
		case "email":
			validarCampoRegistro(expresiones.correo, evento.target, 'email');
		break;
		case "phone_number":
			validarCampoRegistro(expresiones.telefono, evento.target, 'phone_number');
		break;
		case "document_type":

		break;
		case "identification_number":
			validarCampoRegistro(expresiones.identificacion, evento.target, 'identification_number');
		break;

	}
}

const validarFormularioRegistroID = (event) =>{
	switch(event.target.id){
		case "nombre":
            validarCampoRegistro(expresiones.nombre, event.target, 'nombre');
		break;
		case "contrasena":
			validarCampoRegistro(expresiones.password, event.target, 'contrasena')
		break;
	}
}

const validarCampoRegistro = (declaracion, entrada, espacio) => {
	if(declaracion.test(entrada.value)){
		document.getElementById(`grupo__${espacio}`).classList.remove('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${espacio}`).classList.add('formulario__grupo-correcto');
		document.querySelector(`#grupo__${espacio} i`).classList.add('fa-check-circle');
		document.querySelector(`#grupo__${espacio} i`).classList.remove('fa-times-circle');
		document.querySelector(`#grupo__${espacio} .formulario__input-error`).classList.remove('formulario__input-error-activo');
		CampoRegistro[espacio] = true;
	}else{
		document.getElementById(`grupo__${espacio}`).classList.add('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${espacio}`).classList.remove('formulario__grupo-correcto');
		document.querySelector(`#grupo__${espacio} i`).classList.remove('fa-check-circle');
		document.querySelector(`#grupo__${espacio} i`).classList.add('fa-times-circle');
		document.querySelector(`#grupo__${espacio} .formulario__input-error`).classList.add('formulario__input-error-activo');
		CampoRegistro[espacio] = false;
	}
}

const validarSelect = (select, espacio) => {
    if (select.value !== "") {
        document.getElementById(`grupo__${espacio}`).classList.remove('formulario__grupo-incorrecto');
        document.getElementById(`grupo__${espacio}`).classList.add('formulario__grupo-correcto');
        CampoRegistro[espacio] = true;
    } else {
        document.getElementById(`grupo__${espacio}`).classList.add('formulario__grupo-incorrecto');
        document.getElementById(`grupo__${espacio}`).classList.remove('formulario__grupo-correcto');
        CampoRegistro[espacio] = false;
    }
}

inputRegistro.forEach((input) => {
	input.addEventListener('keyup', validarFormularioRegistro);
	input.addEventListener('blur', validarFormularioRegistro);
    input.addEventListener('keyup', validarFormularioRegistroID);
	input.addEventListener('blur', validarFormularioRegistroID);
});



formularioRegistro.addEventListener('submit',(evento) => {
	//Aqui se pone la conecxion hacia otro archivo de php para la validacion.
	// evento.preventDefault();
	if(CampoRegistro.nombre && CampoRegistro.email && CampoRegistro.phone_number &&  CampoRegistro.identification_number && CampoRegistro.contrasena){
		// formularioRegistro.reset(); //Esta funcion se quita para enviar los datos hacia el controlador
		console.log('Formulario enviado correctamente');
		document.querySelectorAll('.formulario__grupo-correcto').forEach((figura) => {
			figura.classList.remove('formulario__grupo-correcto');
		});
	}else{
		document.getElementById('formulario__mensaje2').classList.add('formulario__mensaje-activo2');
		setTimeout( () => {
			document.getElementById('formulario__mensaje2').classList.remove('formulario__mensaje-activo2');
		},5000);
	}
});

//Funcion para ocultar y ver la contraseña
function togglePasswordRegister() {
    var passwordInput = document.getElementById('contrasena');
    var icon = document.getElementById('togglePasswordRegi');
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
