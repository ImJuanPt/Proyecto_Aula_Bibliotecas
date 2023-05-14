document.addEventListener('DOMContentLoaded', function() {
    const inputImagen = document.getElementById('imagen');
    const vistaPrevia = document.getElementById('vista-previa');
  
    inputImagen.addEventListener('change', () => {
      const archivo = inputImagen.files[0];
  
      if (archivo) {
        const lector = new FileReader();
  
        lector.addEventListener('load', () => {
          vistaPrevia.setAttribute('src', lector.result);
          vistaPrevia.style.display = 'block';
        });
        lector.readAsDataURL(archivo);
      }
    });
    
  });

  function submitForm(formId) {
    document.getElementById(formId).submit();
  }

  function confirmarEliminacion(formId) {
    if (confirm('¿Estás seguro de que desea eliminar este libro?')) {
        document.getElementById(formId).submit();
    }
    
}

function agregar_ruta(fileId, ruta){
  document.getElementById(fileId).value = ruta;
}