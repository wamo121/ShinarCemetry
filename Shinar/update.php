<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - Update a Record - PHP CRUD Tutorial</title>
     
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
         
</head>
<body>
 
    <!-- container -->
    <div class="container">
  
        <div class="page-header">
            <h1>Update Entry</h1>
        </div>
        <?php
// get passed parameter value, in this case, the record ID
// isset() is a PHP function used to verify if a value is there or not
$id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
 
//include database connection
include 'database.php';
 
// read current record's data
try {
    // prepare select query
    $query = "SELECT * FROM grave WHERE GraveID = ? LIMIT 0,1";
    $stmt = $con->prepare( $query );
     
    // this is the first question mark
    $stmt->bindParam(1, $id);
     
    // execute our query
    $stmt->execute();
     
    // store retrieved row to a variable
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
    // values to fill up our form
    $FName = $row['FName'];
    $MName = $row['MName'];
    $LName = $row['LName'];
    $PlotNum = $row['PlotNum'];
    $LotNum=$row['LotNum'];
    $GraveNum=$row['GraveNum'];
    $ContactInfo=$row['ContactInfo'];
    $Notes=$row['Notes'];
    $BirthMonth=$row['BirthMonth'];
    $BirthDay=$row['BirthDay'];
    $BirthYear=$row['BirthYear'];
    $DeathMonth=$row['DeathMonth'];
    $DeathDay=$row['DeathDay'];
    $DeathYear=$row['DeathYear'];
    $IsVeteran=$row['IsVeteran'];
    $GraveStatus=$row['GraveStatus'];
}
 
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>



 <?php

 // check if form was submitted
 if($_POST){
      
     try{
      
         // write update query, =: allows a field to be replaced by its new representation in the form
         $query = "UPDATE grave 
                     SET FName=:FName, MName=:MName, LName=:LName,
                        PlotNum=:PlotNum, LotNum=:LotNum, Notes=:Notes,
                        GraveNum=:GraveNum, ContactInfo=:ContactInfo, 
                        BirthDay=:BirthDay, 
                        BirthMonth=:BirthMonth,
                        BirthYear=:BirthYear, DeathDay=:DeathDay, 
                         DeathMonth=:DeathMonth,
                        DeathYear=:DeathYear, IsVeteran=:IsVeteran, GraveStatus=:GraveStatus
                     WHERE GraveID =:GraveID";
  
         // prepare query for excecution
         $stmt = $con->prepare($query);
         
         // posted values
         $FName=htmlspecialchars(strip_tags($_POST['FName']));
         $MName=htmlspecialchars(strip_tags($_POST['MName']));
         $LName=htmlspecialchars(strip_tags($_POST['LName']));
         $PlotNum=htmlspecialchars(strip_tags($_POST['PlotNum']));
         $LotNum=htmlspecialchars(strip_tags($_POST['LotNum']));
         $GraveNum=htmlspecialchars(strip_tags($_POST['GraveNum']));
         $ContactInfo=htmlspecialchars(strip_tags($_POST['ContactInfo']));
         $Notes=htmlspecialchars(strip_tags($_POST['Notes']));

         $BirthDay=htmlspecialchars(strip_tags($_POST['BirthDay']));
         $BirthMonth=htmlspecialchars(strip_tags($_POST['BirthMonth']));
         $BirthYear=htmlspecialchars(strip_tags($_POST['BirthYear']));
         $DeathDay=htmlspecialchars(strip_tags($_POST['DeathDay']));
         $DeathMonth=htmlspecialchars(strip_tags($_POST['DeathMonth']));
         $DeathYear=htmlspecialchars(strip_tags($_POST['DeathYear']));
         $IsVeteran=htmlspecialchars(strip_tags($_POST['IsVeteran']));
         $GraveStatus=htmlspecialchars(strip_tags($_POST['GraveStatus']));
         // bind the parameters
         $stmt->bindParam(':FName', $FName);
         $stmt->bindParam(':MName', $MName);
         $stmt->bindParam(':LName', $LName);
         $stmt->bindParam(':PlotNum',$PlotNum);
         $stmt->bindParam(':LotNum',$LotNum);
         $stmt->bindParam(':GraveNum',$GraveNum);
         $stmt->bindParam(':ContactInfo', $ContactInfo);
         $stmt->bindParam(':GraveID', $id);
         $stmt->bindParam(':Notes',$Notes);
         $stmt->bindParam(':BirthDay',$BirthDay);
         $stmt->bindParam(':BirthMonth',$BirthMonth);
         $stmt->bindParam(':BirthYear',$BirthYear);
         $stmt->bindParam(':DeathDay',$DeathDay);
         $stmt->bindParam(':DeathMonth',$DeathMonth);
         $stmt->bindParam(':DeathYear',$DeathYear);
         $stmt->bindParam(':GraveStatus',$GraveStatus);
        
          $stmt->bindParam(':IsVeteran',$IsVeteran);

       
         // Execute the query
         if($stmt->execute()){
             echo "<div class='alert alert-success'>Record was updated.</div>";
         }else{
             echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
         }
          
     }
      
     // show errors
     catch(PDOException $exception){
         die('ERROR: ' . $exception->getMessage());
     }
 }
 ?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>First Name</td>
            <td><input type='text' name='FName' value="<?php echo htmlspecialchars($FName, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Middle Name</td>
            <td><input type='text' name='MName' value="<?php echo htmlspecialchars($MName, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Last Name</td>
            <td><input type='text' name='LName' value="<?php echo htmlspecialchars($LName, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>

        <tr>
            <td>
            <form action="/action_page.php">
                <label for="plots">Select Plot Number:</label></td>
                 <td><select name="PlotNum">
                    <option input type='int' value=0>-</option>
                    <option input type='int' value=1>1</option>
                    <option input type='int' value=2>2</option>
                    <option input type='int' value=3>3</option>
                    <option input type='int' value=4>4</option>
                </select></td>
        </tr>
        <tr>
            <td>Lot Number</td>
            <td><input type='text' name='LotNum' value="<?php echo htmlspecialchars($LotNum, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Grave Number</td>
            <td><input type='text' name='GraveNum' value="<?php echo htmlspecialchars($GraveNum, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>
            <form action="/action_page.php">
                <label for="GraveStatus">Grave Status:</label></td>
                 <td><select name="GraveStatus">
                    <option input type='int' value=1>Occupied</option>
                    <option input type='int' value=0>Available</option>
                </select></td>
        </tr>
        <tr>
            <td>Birth Month (mm)</td>
            <td><input type= 'int' name='BirthMonth' value="<?php echo htmlspecialchars($BirthMonth, ENT_QUOTES); ?>" class='form-control'/></td>
        </tr>

        <tr>
            <td>Birth Day (dd)</td>
            <td><input type= 'int' name='BirthDay' value="<?php echo htmlspecialchars($BirthDay, ENT_QUOTES); ?>" class='form-control'/></td>
        </tr>

        <tr>
            <td>Birth Year (yyyy)</td>
            <td><input type= 'int' name='BirthYear' value="<?php echo htmlspecialchars($BirthYear, ENT_QUOTES); ?>" class='form-control'/></td>
        </tr>

        <tr>
            <td>Death Month (mm)</td>
            <td><input type= 'int' name='DeathMonth' value="<?php echo htmlspecialchars($DeathMonth, ENT_QUOTES); ?>" class='form-control'/></td>
        </tr>

        <tr>
            <td>Death Day (dd)</td>
            <td><input type= 'int' name='DeathDay' value="<?php echo htmlspecialchars($DeathDay, ENT_QUOTES); ?>" class='form-control'/></td>
        </tr>

        <tr>
            <td>Death Year (yyyy)</td>
            <td><input type= 'int' name='DeathYear' value="<?php echo htmlspecialchars($DeathYear, ENT_QUOTES); ?>" class='form-control'/></td>
        </tr>
        <tr>
            <td>Veteran: (0=No, 1=Yes)</td>
            <td><input type= 'int' name='IsVeteran' value="<?php echo htmlspecialchars($IsVeteran, ENT_QUOTES); ?>" class='form-control'/></td>
        </tr>
        <tr>
            <td>Notes</td>
            <td><input type='text' name='Notes' value="<?php echo htmlspecialchars($Notes, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Contact Info</td>
            <td><input type='text' name='ContactInfo' value="<?php echo htmlspecialchars($ContactInfo, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <input type='submit' value='Save Changes' class='btn btn-primary' />
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