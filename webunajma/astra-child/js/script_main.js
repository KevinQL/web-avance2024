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
    // 
    let element = document.querySelector("div.ast-below-header-wrap");
    
    if(element){
        window.addEventListener('scroll', function(){
            console.log("fn scroll navegacion!!")
            element.style.position = "relative";
            element.style.top = "";
            element.style.display = "block";
            element.style.width = "100%";
            if(element.offsetTop <= window.scrollY){
                console.log("mover navegacion cabecera!!!")
                element.style.position = "fixed";
                element.style.top = "0";
            }
        });
    }






// FIN CODIGO--------------------
}