console.log("exe script main wp UNAJMA")


// clik para mision, vision y grado y tutulo. se encarga de abrir modal
let click_mision = document.querySelectorAll(".click-mision");
click_mision.forEach(element => {
    element.addEventListener("click", function(){
        modal_mision = element.previousElementSibling.firstChild;
        modal_mision.click();
    })
});