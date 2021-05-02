<!DOCTYPE HTML>
<html>
<head>
    <!--Section 1: Header-->
    <!--Based off of the tutorial at 
    https://codeofaninja.com/2011/12/php-and-mysql-crud-tutorial.html#disqus_thread-->
    <title>Shinar Cemetery Homepage</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./stylesheet2.css"/>
    <!-- custom css margins -->
    <style>
    .m-r-1em{ margin-right:1em; }
    .m-b-1em{ margin-bottom:1em; }
    .m-l-1em{ margin-left:1em; }
    .mt0{ margin-top:0; }
    </style>
</head>
<!--Section 2: Database Connection-->
<body>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Home Directory</h1>
        </div>
        <?php
// establish database connection
include 'database.php'; 

//Section 3: Pagination
// PAGINATION VARIABLES
// page is the current page, if there's nothing set, default is page 1
$page = isset($_GET['page']) ? $_GET['page'] : 1;
// set records or rows of data per page
$records_per_page = 20;
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
$action = isset($_GET['action']) ? $_GET['action'] : "";
// if user was redirected from delete.php after deleting a record:

//Section 4: Action
if($action=='deleted'){
    echo "<div class='alert alert-success'>Record was deleted.</div>";
}

//Section 5: Query
// select data from DB.grave table and sort it by PLotNum/LotNum/GraveNum
$query = "SELECT DISTINCT grave.GraveID, plot.PlotNum, grave.FName, lot.LotNum, grave.MName, 
            grave.LName, grave.GraveNum, grave.Notes, grave.IsVeteran, 
            grave.GraveStatus, #status is only used with WHERE to show only occupied graves in this query
#combine birth and death elements into single date, returns '0' per element null
#use a function that turns the string into a date in the background to do the age maths down the line
     CASE
        WHEN grave.BirthMonth =0 AND grave.BirthDay = 0 AND grave.BirthYear = 0 THEN null
        WHEN grave.BirthMonth =0 AND grave.BirthDay =0 AND grave.BirthYear =0 THEN null
        WHEN grave.BirthMonth =0 AND grave.BirthDay =0 AND grave.BirthYear!=0 THEN grave.BirthYear
        WHEN grave.BirthMonth !=0 AND grave.BirthDay !=0 AND grave.BirthYear !=0 THEN CONCAT(grave.BirthMonth, '-', grave.BirthDay, '-', grave.BirthYear) 
        WHEN grave.BirthMonth !=0 AND grave.BirthDay =0 AND grave.BirthYear !=0 THEN CONCAT(grave.BirthMonth, '-', grave.BirthYear)
        END AS Born, 

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

    FLOOR(DATEDIFF(CAST(CONCAT(grave.DeathYear,'-', grave.DeathMonth,'-', grave.DeathDay) AS DATE), 
    CAST(CONCAT(grave.BirthYear, '-', grave.BirthMonth, '-', grave.BirthDay) AS DATE))/365) AS Age

    FROM grave
    JOIN lot ON grave.LotNum=lot.LotNum 
    JOIN plot ON grave.PlotNum=plot.PlotNum
    WHERE grave.GraveStatus=1
    ORDER BY plot.PlotNum, lot.LotNum, grave.GraveNum ASC
    LIMIT :from_record_num, :records_per_page";

//Section 6: Query + Pagination
$stmt = $con->prepare($query);
$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// this is how to get number of rows returned in the table
$num = $stmt->rowCount();

//Section 7: Buttons
// buttons that link to create.php and downloadable query pages
echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New Record</a>";
echo "<a href='./plots/plot1.php' class='btn btn-info m-b-1em'>Plots</a><span>";
echo "<a href='AllGraves.php' class='btn btn-info m-b-1em'>Download All Page</a>";
echo "<a href='Veterans.php' class='btn btn-info m-b-1em'>Veterans</a>";
echo "<a href='Available.php' class='btn btn-info m-b-1em'>Available</a>";

//Section 8: Create the table
//check if more than 0 record found. If records exist, creates table using html
if($num>0){
    echo "<table class='table table-hover table-responsive table-bordered'>";//start table
    //creating  table heading
    //number of columns must match number of colums below or it will skew table
    echo "<tr>";
        echo "<th>Plot #</th>";
        echo "<th>Lot #</th>";
        echo "<th>Grave #</th>";
        echo "<th>Name</th>"; //created from concat of name strings, not from database
        echo "<th>Born</th>"; //created from concat of birthday/month/year information
        echo "<th>Died</th>"; //created from concat of death information
        echo "<th>Age</th>";
        echo"<th>Veteran</th>";
        echo "<th>Notes</th>";
        echo "<th>Action</th>"; //place for read/edit/delete options
    echo "</tr>";
    // retrieve grave table contents
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    // extract row
    // this will make $row['FName'] to
    // just $FName only
    extract($row);
    // creating new table row per record
    echo "<tr>";
        echo "<td>{$PlotNum}</td>";
        echo "<td>{$LotNum}</td>";
        echo "<td>{$GraveNum}</td>";
        echo "<td>{$FName} "; echo " {$MName} "; echo "{$LName}</td>";
        echo "<td>{$Born}</td>";
        echo "<td>{$Death}</td>";
        echo "<td>{$Age}</td>";
        echo"<td>{$IsVeteran}</td>";
        echo "<td> <div class=row>{$Notes}</div></td>";
        echo "<td>";
            // read one record 
            echo "<a href='read_one.php?id={$GraveID}' class='btn btn-success m-r-1em'>Read</a>";
             
            // edit record
            echo "<a href='update.php?id={$GraveID}' class='btn btn-warning m-r-1em'>Edit</a>";
 
            // delete record
            echo "<a href='#' onclick='delete_user({$GraveID});'  class='btn btn-danger'>Delete</a>";
        echo "</td>";
    echo "</tr>";
}
// end table
echo "</table>";
     // PAGINATION
// count total number of rows
$query = "SELECT COUNT(*) as total_rows FROM grave";
$stmt = $con->prepare($query);
// execute query
$stmt->execute();
// get total rows
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_rows = $row['total_rows'];
// paginate records
$page_url="index.php?";
include_once "paging.php";
}
// if no records found
else{
    echo "<div class='alert alert-danger'>No records found.</div>";
}
?>    
    </div> <!-- end .container -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--Section 9: Footer-->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type='text/javascript'>
// confirm record deletion
function delete_user( GraveID ){
    var answer = confirm('Are you sure?');
    if (answer){
        // if user clicked ok, 
        // pass the id to delete.php and execute the delete query
        window.location = 'delete.php?id=' + GraveID;
    } 
}
</script>
</body>
</html>