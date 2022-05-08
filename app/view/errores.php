<?php
        if(isset($data["errores"])) {
            if(count($data["errores"])){
                print "<div class='alert alert-danger text-center fw-bold mt-2'>";
                foreach($data["errores"] as $key => $valor){
                    print "<strong> ". $valor. " </strong>";
                }
                print "</div>";
            }
        }
    ?>