<?php
//connection to database
include 'database.php';
 //enables the export function to be called from the plot, veteran, download all, and availability pages
if(isset($_POST["Export"])){
    $query = "SELECT * from grave ORDER BY GraveID DESC
    #into file is the destination of the downloaded file (in this case, the address of my downloads folder)
            INTO OUTFILE `D:/Downloads/exports.csv`
               ";
}

 ?>