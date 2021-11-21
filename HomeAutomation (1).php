<?php
header("refresh: 3");

ob_start();
 date_default_timezone_set("Asia/Calcutta");
	require('config.php');
	
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cmd="";
       
	    if (isset($_POST['backward']))
	        $cmd = "T";
	    else if (isset($_POST['forward']))
	        $cmd = "F";
	    else if (isset($_POST['left']))
	        $cmd = "H";
	    else if (isset($_POST['stop']))
	        $cmd = "M";
 
    	$insertdata = mysqli_query($link,"UPDATE `HomeAuto` SET cmd='$cmd' WHERE `id`= 1") or die(mysql_error("ERROR".$link));
    	if($insertdata)
    	{
    	    //echo json_encode(array("cmd"=>$cmd,));
    	}
    }

    
    

?>

<!doctype html>
<html lang="en">
<head>
<title>Home Automation</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

<style>
.error {color: #FF0000;}
b { font-weight: 500;}
</style>

</head>
<body>
<div class="container container-sm container-md container-lg container-xl container-xxl border" style="width:500px; margin-top:20px; margin-bottom:20px; padding-bottom: 20px;">

<form  name="robotform" method="post" enctype="multipart/form-data">

<div class="col-xs col-sm col-md col-lg col-xl col-xxl"><h2 class="text-center"><i class="fas fa-home" style="color: #ff081a;"></i> Home Automation</h2></div>


<div class="col-xs col-sm col-md col-lg col-xl col-xxl">
    
    <?php    

	
	$sqlquery = mysqli_query($link,"SELECT * FROM `HomeAuto` where id = 1;") or die(mysql_error("ERROR".$link));
	$fetch = mysqli_fetch_array($sqlquery);

?>

<table class="table table-bordered table-striped table-hover table-sm">



<tbody>

<tr>
<td><b>Light Intensity(%) </b> </td> <td><?php echo $fetch['Light']; ?></td>
</tr>

<tr>
<td><b>Temperature(C)</b>  </td> <td><?php echo $fetch['Temp']; ?></td>
</tr>

<tr>
<td><b>GAS(%)</b>  </td> <td><?php echo $fetch['Gas']; ?></td>
</tr>

<?php  ?>


</table>

</div>

<div class="container mx-auto" style="">

<div class="d-flex justify-content-center">
<div class="d-grid gap-2 d-md-block">
  <button class="btn btn-primary btn-lg" name="forward" type="submit"> <i class="fas"></i> FAN</button>
</div>
</div>

<div class="container">&nbsp;</div>

<div class="container">
<div class="d-flex justify-content-between">
<div class="d-grid gap-2 d-md-block">
  <button class="btn btn-warning btn-lg" name="left" type="submit"> <i class="fas "></i> HEATER</button>
</div>



<div class="d-grid gap-2 d-md-block">
  <button class="btn btn-success btn-lg" name="stop" type="submit"> <i class="far "></i> MACHINE</button>
</div>


</div>

</div>

<div class="container">&nbsp;</div>

<div class="d-flex justify-content-center">
<div class="d-grid gap-2 d-md-block">
  <button class="btn btn-primary btn-lg" name="backward"  type="submit"> <i class="fas "></i> TUBELIGHT</button>
</div>
</div>

</div>



</form>

</div>

</body>
</html>