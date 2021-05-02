<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - Create a New Record</title>
      
    <!-- Boostrap CSS Stylesheet Link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
          
</head>
<body>
  
    <!-- container -->
    <div class="container">
   
        <div class="page-header">
            <h1>New Book Keeping Entry</h1>
        </div>
      
        <?php
if($_POST){
 
    // include database connection
    include 'database.php'; //had to change from '/config/database.php'
 

       
    
$query = 'INSERT INTO grave
        SET  PlotNum=:PlotNum, LotNum=:PlotNum, GraveNum=:GraveNum, 
        FName=:FName, MName=:MName, LName=:LName,
        BirthMonth=:BirthMonth,BirthDay=:BirthDay,BirthYear=:BirthYear,
        DeathMonth=:DeathMonth, DeathDay=:DeathDay, DeathYear=:DeathYear,
        ContactInfo=:ContactInfo, Notes=:Notes, IsVeteran=:IsVeteran, GraveStatus=:GraveStatus';




// prepare query for execution (Move all variables to line 30 (was below query))
$stmt = $con->prepare($query);
//$GraveID=htmlspecialchars(strip_tags($_POST['GraveID']));
$PlotNum=htmlspecialchars(strip_tags($_POST['PlotNum']));
$LotNum=htmlspecialchars(strip_tags($_POST['LotNum']));
$GraveNum=htmlspecialchars(strip_tags($_POST['GraveNum']));

$FName=htmlspecialchars(strip_tags($_POST['FName']));
$MName=htmlspecialchars(strip_tags($_POST['MName']));
$LName=htmlspecialchars(strip_tags($_POST['LName']));

$BirthMonth=htmlspecialchars(strip_tags($_POST['BirthMonth']));
$BirthDay=htmlspecialchars(strip_tags($_POST['BirthDay']));
$BirthYear=htmlspecialchars(strip_tags($_POST['BirthYear']));
$DeathMonth=htmlspecialchars(strip_tags($_POST['DeathMonth']));
$DeathDay=htmlspecialchars(strip_tags($_POST['DeathDay']));
$DeathYear=htmlspecialchars(strip_tags($_POST['DeathYear']));
$ContactInfo=htmlspecialchars(strip_tags($_POST['ContactInfo']));
$Notes=htmlspecialchars(strip_tags($_POST['Notes']));
$IsVeteran=htmlspecialchars(strip_tags($_POST['IsVeteran']));
$GraveStatus=htmlspecialchars(strip_tags($_POST['GraveStatus']));



// bind the parameters
$stmt->bindParam(':PlotNum',$PlotNum);
$stmt->bindParam(':LotNum',$LotNum);
$stmt->bindParam(':GraveNum',$GraveNum);
$stmt->bindParam(':GraveStatus',$GraveStatus);
$stmt->bindParam(':FName', $FName);
$stmt->bindParam(':MName', $MName);
$stmt->bindParam(':LName', $LName);

$stmt->bindParam(':Notes',$Notes);
$stmt->bindParam(':BirthDay',$BirthDay);
$stmt->bindParam(':BirthMonth',$BirthMonth);
$stmt->bindParam(':BirthYear',$BirthYear);
$stmt->bindParam(':DeathDay',$DeathDay);
$stmt->bindParam(':DeathMonth',$DeathMonth);
$stmt->bindParam(':DeathYear',$DeathYear);
$stmt->bindParam(':ContactInfo', $ContactInfo);
$stmt->bindParam(':IsVeteran', $IsVeteran);


         
        // Execute the query
        if($stmt->execute()){
            echo "<div class='alert alert-success'>Record was saved.</div>";
}
}
 



?>
 
<!-- html form here where the product information will be entered -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">

    <table class='table table-hover table-responsive table-bordered'>
        <!--<tr>
            <td>GraveID</td>
            <td><input type='int' name='GraveID' class='form-control' /></td>
        </tr>-->
        
        <tr>
            <td>
            <form action="/action_page.php">
                <label for="plots">Select Plot Number:</label></td>
                <td><select name="PlotNum">
                    <option input type='int' value=1>1</option>
                    <option input type='int' value=2>2</option>
                    <option input type='int' value=3>3</option>
                    <option input type='int' value=4>4</option>
                </select></td>
        </tr>
      
        <tr>
        
            <td>Lot Number</td>
            <td><input type='int' name='LotNum' class='form-control' /></td>
        </tr>

        <tr>
            <td>Grave Number</td>
            <td><input type='int' name='GraveNum' class='form-control' /></td>
        </tr>
        <tr>
            <td>
            <form action="/action_page.php">
                <label for="GraveStatus">Grave Status:</label></td>
                 <td><select name="GraveStatus">
                    <option input type='int' value=0>Available</option>
                    <option input type='int' value=1>Occupied</option>
                   
                </select></td>
        </tr>
        
        <tr>
            <td>First Name</td>
            <td><input type='text' name='FName' class='form-control' /></td>
        </tr>

        <tr>
            <td>Middle Name</td>
            <td><input type='text' name='MName' class='form-control' /></td>
        </tr>

        <tr>
            <td>Last Name</td>
            <td><input type= 'text' name='LName' class='form-control'></textarea></td>
        </tr>

        
        <tr>
            <td>Birth Month (mm)</td>
            <td><input type= 'int' name='BirthMonth' class='form-control'></textarea></td>
        </tr>

        <tr>
            <td>Birth Day (dd)</td>
            <td><input type= 'int' name='BirthDay' class='form-control'></textarea></td>
        </tr>

        <tr>
            <td>Birth Year (yyyy)</td>
            <td><input type= 'int' name='BirthYear' class='form-control'></textarea></td>
        </tr>

        <tr>
            <td>Death Month (mm)</td>
            <td><input type= 'int' name='DeathMonth' class='form-control'></textarea></td>
        </tr>

        <tr>
            <td>Death Day (dd)</td>
            <td><input type= 'int' name='DeathDay' class='form-control'></textarea></td>
        </tr>
        
        <tr>
            <td>Death Year (yyyy)</td>
            <td><input type= 'int' name='DeathYear' class='form-control'></textarea></td>
        </tr>
        
        <tr>
            <td>
            <form action="/action_page.php">
                <label for="IsVeteran">Veteran:</label></td>
                 <td><select name="IsVeteran">
                    <option input type='int' value=0>No</option>
                    <option input type='int' value=1>Yes</option>
                   
                </select></td>
        </tr>
        <tr>
            <td>Contact Info</td>
            <td><input type='text' name='ContactInfo' class='form-control' /></td>
        </tr>
        
        <tr>
            <td>Notes</td>
            <td><input type="text" name="Notes" /></td>
        </tr>


        

        <tr>
            <td></td>
            <td>
                <input type='submit' value='Save' class='btn btn-primary' />
                <a href='index.php' class='btn btn-danger'>Cancel</a>
            </td>
        </tr>
    </table>
</form>
          
    </div> <!-- end .container -->
      
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
   
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
</body>
</html>