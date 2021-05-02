<!DOCTYPE HTML>
<html>
<head>
    <title>Generate Plot Report</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./stylesheet2.css"/>
    <!-- custom css -->
   <!--Based on tutorial: https://makitweb.com/how-to-export-mysql-table-data-as-csv-file-in-php/ -->
</head>
<body>
<?php 
//different connection method in order to use mysqli_query
include "./config.php";
?>
<div class="container">
<div class="page-header">
            <h1>Generate Veteran Report</h1>
        </div>
<!-- reference where to execute the file download from-->
 <form method='post' action='DownloadVeterans.php'>
    
  <table class='table table-hover table-responsive table-bordered'>
     <tr>  
     <a href='./index.php' class='btn btn-primary m-b-1em'>Home</a>
     <input type='submit' class='btn btn-success m=b-1em' value='Export' name='Export'>
     </tr>
     <tr>
     <th>Plot</th>
     <th>Lot</th>
     <th>Row</th>
     <th>Column</th>
     <th>Grave</th>
     <th>FName</th>
     <th>MName</th>
     <th>LName</th>
     <th>BirthMonth</th>
     <th>BirthDay</th>
     <th>BirthYear</th>
     <th>DeathMonth</th>
     <th>DeathDay</th>
     <th>DeathYear</th>
     <th>IsVeteran</th>
     <th>Notes</th>
     <th>Contact Info</th>
    </tr>
    <!-- pull relavent information for this page (find all veteran graves)-->
    <?php 
       $query = "SELECT GraveID, FName, MName, LName, grave.PlotNum, GraveNum, 
      grave.LotNum, ContactInfo, Notes, BirthMonth, BirthDay, BirthYear,
       DeathMonth, DeathDay, DeathYear,IsVeteran,
       lot.RowNum, lot.ColumnNum
      FROM grave JOIN lot ON grave.LotNum=Lot.LotNum AND grave.PlotNum=lot.PlotNum
      WHERE grave.IsVeteran=1 ORDER BY grave.PlotNum, grave.LotNum, GraveNum asc";
   $result = mysqli_query($con,$query);
      //creates array that will be filled with information from the query
     $user_arr = array();
     $user_arr[0] = array("PlotNum","LotNum","RowNum","ColumnNum","GraveNum","FName","MName","LName","BirthMonth","BirthDay", "BirthYear","DeathMonth", "DeathDay","DeathYear", "IsVeteran","Notes","ContactInfo");
     while($row = mysqli_fetch_array($result)){
      $FName = $row['FName'];
      $MName = $row['MName'];
      $LName = $row['LName'];
      $PlotNum = $row['PlotNum'];
      $GraveNum = $row['GraveNum'];
      $LotNum=$row['LotNum'];
      $ContactInfo=$row['ContactInfo'];
      $Notes=$row['Notes'];
      $BirthMonth=$row['BirthMonth'];
      $BirthDay=$row['BirthDay'];
      $BirthYear=$row['BirthYear'];
      $DeathMonth=$row['DeathMonth'];
      $DeathDay=$row['DeathDay'];
      $DeathYear=$row['DeathYear'];
      $IsVeteran=$row['IsVeteran'];
      $RowNum=$row['RowNum'];
      $ColumnNum=$row['ColumnNum'];
      $user_arr[] = array($PlotNum,$LotNum,$RowNum, $ColumnNum, $GraveNum, $FName,$MName,$LName,$BirthMonth,$BirthDay,$BirthYear,$DeathMonth, $DeathDay, $DeathYear,$IsVeteran,$Notes,$ContactInfo);
      ?>
      <tr>
       <td><?php echo $PlotNum; ?></td>
       <td><?php echo $LotNum; ?></td>
       <td><?php echo $RowNum; ?></td>
       <td><?php echo $ColumnNum; ?></td>
       <td><?php echo $GraveNum; ?></td>
       <td><?php echo $FName; ?></td>
       <td><?php echo $MName; ?></td>
       <td><?php echo $LName; ?></td>
       <td><?php echo $BirthMonth; ?></td>
       <td><?php echo $BirthDay; ?></td>
       <td><?php echo $BirthYear; ?></td>
       <td><?php echo $DeathMonth; ?></td>
       <td><?php echo $DeathDay; ?></td>
       <td><?php echo $DeathYear; ?></td>
       <td><?php echo $IsVeteran; ?></td>
       <td><?php echo $Notes; ?></td>
       <td><?php echo $ContactInfo; ?></td>
      </tr>
   <?php
    }
   ?>
   </table>
   <?php 
          //prepare query table for export
    $serialize_user_arr = serialize($user_arr);
   ?>
  <textarea name='export_data' style='display: none;'><?php echo $serialize_user_arr; ?></textarea>
 </form>
</div>
</body>
</html>

