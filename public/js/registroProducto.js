window.onload = function() {
    if(document.getElementById("tipoProducto").value==1){
        document.getElementById("libro").style.display = "none";
        document.getElementById("curso").style.display = "block";
    }else if(document.getElementById("tipoProducto").value==2){
        document.getElementById("libro").style.display = "block";
        document.getElementById("curso").style.display = "none";
    }else{
        document.getElementById("libro").style.display = "none";
        document.getElementById("curso").style.display = "none";
    }
    
    document.getElementById("tipoProducto").onchange = function() {
        if (this.value==1) {
            document.getElementById("libro").style.display = "none";
            document.getElementById("curso").style.display = "block";
        } else if(this.value==2) {
            document.getElementById("libro").style.display = "block";
            document.getElementById("curso").style.display = "none";
        } else {
            document.getElementById("libro").style.display = "none";
            document.getElementById("curso").style.display = "none";
        }
    }
}