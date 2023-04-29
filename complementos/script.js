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

  