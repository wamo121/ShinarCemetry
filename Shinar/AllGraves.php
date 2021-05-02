<!DOCTYPE HTML>
<html>
<head>
    <title>Download All Data</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./stylesheet2.css"/>
    <!-- custom css -->
   <!--Based on tutorial: https://makitweb.com/how-to-export-mysql-table-data-as-csv-file-in-php/ -->
</head>
<body>
<?php 
include "config.php";
?>
<div class="container">
<div class="page-header">
            <h1>Download All Data</h1>
        </div>
 <form method='post' action='DownloadAllGraves.php'>
  <table class='table table-hover table-responsive table-bordered'>
     <tr>
     <a href='index.php' class='btn btn-primary m-b-1em'>Home</a>
     <input type='submit' class='btn btn-success m=b-1em' value='Export' name='Export'>
     </tr>
     <tr>
     <th>GraveID</th>
     <th>PlotNum</th>
     <th>LotNum</th>
     <th>GraveNum</th>
     <th>GraveStatus</th>
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
     <th>ContactInfo</th>
    </tr>
    <?php 
     $query = "SELECT GraveID, FName, MName, LName, PlotNum, GraveNum, 
    LotNum, ContactInfo, Notes, BirthMonth, BirthDay, BirthYear,
     DeathMonth, DeathDay, DeathYear,IsVeteran, GraveStatus
    FROM grave ORDER BY PlotNum, LotNum, GraveNum asc";
     $result = mysqli_query($con,$query);
     $user_arr = array();
     $user_arr[0] = array("GraveID","PlotNum","LotNum","GraveNum","GraveStatus","FName","MName","LName","BirthMonth","BirthDay", "BirthYear","DeathMonth", "DeathDay","DeathYear", "IsVeteran","Notes","ContactInfo");
     while($row = mysqli_fetch_array($result)){
      $GraveID = $row['GraveID'];
      $FName = $row['FName'];
      $MName = $row['MName'];
      $LName = $row['LName'];
      $PlotNum = $row['PlotNum'];
      $GraveNum = $row['GraveNum'];
      $GraveStatus=$row['GraveStatus'];
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
      $user_arr[] = array($GraveID, $PlotNum,$LotNum,$GraveNum, $GraveStatus, $FName,$MName,$LName,$BirthMonth,$BirthDay,$BirthYear,$DeathMonth, $DeathDay, $DeathYear,$IsVeteran,$Notes,$ContactInfo);
   ?>
      <tr>
       <td><?php echo $GraveID; ?></td>
       <td><?php echo $PlotNum; ?></td>
       <td><?php echo $LotNum; ?></td>
       <td><?php echo $GraveNum; ?></td>
       <td><?php echo $GraveStatus;?></td>
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
    $serialize_user_arr = serialize($user_arr);
   ?>
  <textarea name='export_data' style='display: none;'><?php echo $serialize_user_arr; ?></textarea>
 </form>
</div>
</body>
</html>