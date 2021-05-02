<!DOCTYPE HTML>
<html>
<head>
    <!--Based off of the tutorial at 
    https://codeofaninja.com/2011/12/php-and-mysql-crud-tutorial.html#disqus_thread-->
    <title>PDO - Read One Record</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>
<body>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Read Entry</h1>
        </div>
        <?php
// get passed parameter value, in this case, the record ID
// isset() is a PHP function used to verify if a value is there or not
$id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
//include database connection
include 'database.php';
// read current record's data
try {
    // prepare select query. The Case statements account for entries missing day/month/year informaiton for birth and death dates
    //Case statements for status and isveteran change output based on if entry is 0 (false) or 1 (true)
    $query = "SELECT GraveID, FName, MName, LName, PlotNum, GraveNum, 
     LotNum, ContactInfo, Notes,
     CASE
        WHEN grave.BirthMonth =0 AND grave.BirthDay = 0 AND grave.BirthYear = 0 THEN null
        WHEN grave.BirthMonth =0 AND grave.BirthDay =0 AND grave.BirthYear =0 THEN null
        WHEN grave.BirthMonth =0 AND grave.BirthDay =0 AND grave.BirthYear!=0 THEN grave.BirthYear
        WHEN grave.BirthMonth !=0 AND grave.BirthDay !=0 AND grave.BirthYear !=0 THEN CONCAT(grave.BirthMonth, '-', grave.BirthDay, '-', grave.BirthYear) 
        WHEN grave.BirthMonth !=0 AND grave.BirthDay =0 AND grave.BirthYear !=0 THEN CONCAT(grave.BirthMonth, '-', grave.BirthYear)
        END AS Birth, 
        CASE
        WHEN grave.DeathMonth =0 AND grave.DeathDay = 0 AND grave.DeathYear = 0 THEN null
        WHEN grave.DeathMonth =0 AND grave.DeathDay =0 AND grave.DeathYear =0 THEN null
        WHEN grave.DeathMonth !=0 AND grave.DeathDay !=0 AND grave.DeathYear !=0 THEN CONCAT(grave.DeathMonth, '-', grave.DeathDay, '-', grave.DeathYear) 
        WHEN grave.DeathMonth !=0 AND grave.DeathDay =0 AND grave.DeathYear !=0 THEN CONCAT(grave.DeathMonth, '-', grave.DeathYear)
        END AS Death,
        CASE
        WHEN grave.ISVeteran = 0 THEN 'No'
        WHEN grave.ISVeteran = 1 THEN 'Yes'
        END AS IsVeteran,
        CASE
        WHEN grave.GraveStatus = 0 THEN 'Available'
        WHEN grave.GraveStatus = 1 THEN 'Occupied'
        END AS GraveStatus
    FROM grave WHERE GraveID = ? LIMIT 0,1";
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
    $GraveNum = $row['GraveNum'];
    $LotNum=$row['LotNum'];
    $ContactInfo=$row['ContactInfo'];
    $Notes=$row['Notes'];
    $Birth=$row['Birth'];
    $Death=$row['Death'];
    $IsVeteran=$row['IsVeteran'];
    $GraveStatus=$row['GraveStatus'];
}
// show error. useful for troubleshooting how something goes wrong
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>
        <!--we have our html table here where the record will be displayed-->
<table class='table table-hover table-responsive table-bordered'>
    <tr>
        <td>Name</td>
        <td><?php echo htmlspecialchars($FName, ENT_QUOTES); echo(' ');
                    echo htmlspecialchars($MName, ENT_QUOTES); echo(' ');
                    echo htmlspecialchars($LName, ENT_QUOTES);  ?></td>
    </tr>
    
    <tr>
        <td>Plot Number</td>
        <td><?php echo htmlspecialchars($PlotNum, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Lot Number</td>
        <td><?php echo htmlspecialchars($LotNum, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Grave Number</td>
        <td><?php echo htmlspecialchars($GraveNum, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Grave Status</td>
        <td><?php echo htmlspecialchars($GraveStatus, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Born</td>
        <td><?php echo htmlspecialchars($Birth, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Died</td>
        <td><?php echo htmlspecialchars($Death, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Veteran:</td>
        <td><?php echo htmlspecialchars($IsVeteran, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Contact Info</td>
        <td><?php echo htmlspecialchars($ContactInfo, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Notes</td>
        <td><?php echo htmlspecialchars($Notes, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <a href='index.php' class='btn btn-danger'>Back to read products</a>
        </td>
    </tr>
</table>
    </div> <!-- end .container -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>