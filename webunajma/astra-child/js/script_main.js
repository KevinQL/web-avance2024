console.log("ejecutando scripts main");

    /**
     * ***********************************************************************
     * ***********************************************************************
     * Función de filtro para el cambio de colore para la página principal
     * s
     * ***********************************************************************
     * ***********************************************************************
    */

    function ejecuta(){
        let blocks = document.querySelectorAll(".filtros-css");
        blocks.forEach(block => {
            block.classList.toggle("mostrar");
        })
        fn_test();
    }


window.onload = function() {

    /**
     * ***********************************************************************
     * ***********************************************************************
     * Scripts para la sección del CARRUSEL DE IMAGENES DE ENLACES DE INTERES
     * 
     * ***********************************************************************
     * ***********************************************************************
     * 
    */
    const cscroll = document.querySelector(".container-scroll");
    
    if(cscroll){
        const imag = document.querySelectorAll(".images");
        const scrollBox = document.querySelectorAll('.scroll-box');
        const prevButton = document.querySelectorAll('#prev');
        const nextButton = document.querySelectorAll('#next');
        let autoScrollIntervalArr = [];

        // Función para desplazamiento automático hacia la derecha
        function autoScrollRight(i=0) {
            clearInterval(autoScrollIntervalArr[i]); // Detener el desplazamiento automático
            autoScrollIntervalArr[i] = setInterval(function() {
                scrollBox[i].scrollBy({
                    left: 1,
                    behavior: 'smooth'
                });
            }, 50);
        }
    
        // Función para desplazamiento automático hacia la izquierda
        function autoScrollLeft(i=0) {
            clearInterval(autoScrollIntervalArr[i]); // Detener el desplazamiento automático
            autoScrollIntervalArr[i] = setInterval(function() {
                scrollBox[i].scrollBy({
                    left: -1,
                    behavior: 'smooth'
                });
            }, 50);
        }
    
        // Agregar evento clic al botón anterior
        prevButton[0].addEventListener('click', function() {
            autoScrollLeft()
        });
        // --
        prevButton[1].addEventListener('click', function() {
            autoScrollLeft(1)
        });
    
        // Agregar evento clic al botón siguiente
        nextButton[0].addEventListener('click', function() {
            autoScrollRight();
        });
        // --
        nextButton[1].addEventListener('click', function() {
            autoScrollRight(1);
        });
    
        // Iniciar desplazamiento automático hacia la derecha al cargar la página
        autoScrollRight(0);
        autoScrollRight(1);
    
        // Clonar imágenes para crear el efecto de scroll infinito
        imag[0].innerHTML += imag[0].innerHTML;
        imag[1].innerHTML += imag[1].innerHTML;
    
        // Detectar cuando el desplazamiento llega al final para reiniciar el scroll
        scrollBox[0].addEventListener('scroll', function() {
            if (this.scrollLeft === 0) {
                autoScrollRight();
            } else if (this.scrollLeft >= this.scrollWidth / 2) {
                autoScrollLeft()
            }
        });
         // --
         scrollBox[1].addEventListener('scroll', function() {
            if (this.scrollLeft === 0) {
                autoScrollRight(1);
            } else if (this.scrollLeft >= this.scrollWidth / 2) {
                autoScrollLeft(1)
            }
        });
    }



    /**
     * ***********************************************************************
     * ***********************************************************************
     * Scripts para la sección de la NAVEGACIÓN PRINCIPAL
     * Controla la navegación de la cabecera. Para que se quede fijo en la prte superior del viewport.
     * 
     * ***********************************************************************
     * ***********************************************************************
     * 
    */
    
    // Selecciona el primer elemento <div> con la clase "ast-main-header-wrap"
    let element = document.querySelector("div.ast-main-header-wrap");
    
    // Verifica si el elemento existe
    if(element){
        // Agrega un evento de escucha para el evento 'scroll' en la ventana
        window.addEventListener('scroll', function(){
            // Muestra un mensaje en la consola para indicar que se ha activado la función de desplazamiento
            console.log("fn scroll navegacion!!")

            // Establece el estilo del elemento:
            // Cambia la posición a "relative"
            element.style.position = "relative";
            // Restablece la propiedad 'top'
            element.style.top = "";
            // Asegura que el elemento esté visible
            element.style.display = "block";
            // Establece el ancho del elemento al 100%
            element.style.width = "100%";

            // Si la distancia del elemento desde la parte superior de la página es menor o igual al desplazamiento vertical
            if(element.offsetTop <= window.scrollY){
                // Muestra un mensaje en la consola para indicar que la cabecera se moverá
                console.log("mover navegacion cabecera!!!");
                
                // Cambia la posición del elemento a "fixed"
                element.style.position = "fixed";
                // Establece la propiedad 'top' a 0 para fijar el elemento en la parte superior
                element.style.top = "0";
            }
        });
    }


    /**
     * ***********************************************************************
     * ***********************************************************************
     * Scripts para el post de AGENDA Y EVENTOS
     * Coloca las href de los botones de inscribir y contactar
     * 
     * ***********************************************************************
     * ***********************************************************************
     * 
    */
    let el = document.querySelector(".card-detalles-evento")

    if(el){
        console.log("probandooo actualizar linkss333");
        let btn_inscribirme = document.querySelector(".btn_inscribirme a");
        let btn_contactar = document.querySelector(".btn_contactar a"); 

        let txt_link_evento =  document.querySelector("#txt_link_evento").value; 
        let txt_contacto_evento = document.querySelector("#txt_contacto_evento").value; 
    
        btn_inscribirme.href = txt_link_evento;
        btn_contactar.href = "https://wa.me/51"+txt_contacto_evento;

    }


// FIN CODIGO--------------------
}