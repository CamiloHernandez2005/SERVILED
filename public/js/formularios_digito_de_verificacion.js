
//    Cálculo dígito de verificación (campo de solo lectura, se calcula solo)

function calcularDigitoVerificacion(nit) {

  const primos = [3, 7, 13, 17, 19, 23, 29, 37, 41, 43, 47, 53, 59];
  let digitosNit = nit.split("");
  let digitosNitRev = [];
  let sumatoria = 0;

  for (let i=digitosNit.length;i>0;i--) {
      digitosNitRev.push(digitosNit[i-1]);
  }

  for (let j=0;j<digitosNitRev.length;j++) {
      sumatoria += parseInt(digitosNitRev[j])*primos[j];
  }

  let mod = sumatoria % 11;
  let digit_verification = mod;

  if (mod>1) {
    digit_verification = 11 - mod;
  }

  if (isNaN(digit_verification)) {
      return '';
  }
  else {
      return digit_verification;
  }
}

document.addEventListener('DOMContentLoaded', function() {
  const nitInput = document.getElementById('identification_number1');
  const dvInput  = document.getElementById('digit_verification1');

  if (!nitInput || !dvInput) {
      return;
  }

  // Calcula el dígito de verificación a partir del número de identificación
  function recalcularDV() {
      const nit = nitInput.value;
      const nitValido = nit >>> 0 === parseFloat(nit);

      if (nitValido && nit.length >= 5) {
          dvInput.value = calcularDigitoVerificacion(nit);
      } else {
          dvInput.value = "";
      }
  }

  // Estado inicial (al abrir crear/editar)
  recalcularDV();

  // Recalcula al escribir el número de identificación
  nitInput.addEventListener('input', recalcularDV);
});

// Cierre cálculo dígito de verificación
