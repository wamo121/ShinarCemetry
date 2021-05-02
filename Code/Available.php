<!DOCTYPE HTML>
<html>
<head>
    <title>Generate Available Grave Report</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./stylesheet2.css"/>
    <!-- custom css -->
   <!--Based on tutorial: https://makitweb.com/how-to-export-mysql-table-data-as-csv-file-in-php/ -->
</head>
<body>
<?php 
include "./config.php";
?>
<div class="container">
<div class="page-header">
            <h1>Grave Availability</h1>
        </div>
 <form method='post' action='DownloadAvailable.php'>
    <!--Table is much shorter than plot pages as there is less data to represent-->
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
     <th>Status</th>
     <th>Notes</th>     
    </tr>
    <?php 
       $query = "SELECT GraveID, grave.PlotNum, GraveNum, 
      grave.LotNum, Notes, GraveStatus,
       lot.RowNum, lot.ColumnNum
      FROM grave JOIN lot ON grave.LotNum=Lot.LotNum AND grave.PlotNum=lot.PlotNum
      WHERE grave.GraveStatus=0 ORDER BY grave.PlotNum, grave.LotNum, GraveNum asc";
   $result = mysqli_query($con,$query);
     $user_arr = array();
     $user_arr[0] = array("PlotNum","LotNum","RowNum","ColumnNum","GraveNum","GraveStatus","Notes");
     while($row = mysqli_fetch_array($result)){
      $PlotNum = $row['PlotNum'];
      $GraveNum = $row['GraveNum'];
      $GraveStatus=$row['GraveStatus'];
      $LotNum=$row['LotNum'];
      $Notes=$row['Notes'];
      $RowNum=$row['RowNum'];
      $ColumnNum=$row['ColumnNum'];
      $user_arr[] = array($PlotNum,$LotNum,$RowNum, $ColumnNum, $GraveNum, $GraveStatus,$Notes);
      ?>
      <tr>
       <td><?php echo $PlotNum; ?></td>
       <td><?php echo $LotNum; ?></td>
       <td><?php echo $RowNum; ?></td>
       <td><?php echo $ColumnNum; ?></td>
       <td><?php echo $GraveNum; ?></td>
       <td><?php echo $GraveStatus;?></td>
       <td><?php echo $Notes; ?></td>
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