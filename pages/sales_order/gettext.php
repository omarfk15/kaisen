<?php
require_once('configuration/server_connect.php');
require_once('configuration/all_function.php');

 $dataId = $_REQUEST['id'];

//echo $dataId;

 $sql="SELECT * FROM acc_sub_class  WHERE id='".$dataId."'";
$data = find_all_field_sql($conn,$sql);

?>

<select id="acc_class" name="acc_class" required class="form-select">
			
				
				
				
			<?php 
				
			$sql = "select id, class_name 
            from acc_class 
            where id='".$data->acc_class."' order by class_name ";
   
	 		$query = mysqli_query($conn,$sql);

  		 echo '<option value="">Select Customer</option>';
    		while($row = mysqli_fetch_assoc($query)){
        echo '<option value="'.$row['id'].'">'.$row['class_name'].'</option>';
    }
				?>
		
		
        	</select>