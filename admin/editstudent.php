<?php 
  $corepage = explode('/', $_SERVER['PHP_SELF']);
    $corepage = end($corepage);
    if ($corepage!=='index.php') {
      if ($corepage==$corepage) {
        $corepage = explode('.', $corepage);
       header('Location: index.php?page='.$corepage[0]);
     }
    }
    
    $id = base64_decode($_GET['id']);
    $oldPhoto = base64_decode($_GET['photo']);

  if (isset($_POST['updatestudent'])) {
  	$name = $_POST['name'];
  	$roll = $_POST['roll'];
  	$subject = $_POST['subject'];
  	$pcontact = $_POST['pcontact'];
  	$class = $_POST['class'];
  	
  	if (!empty($_FILES['photo']['name'])) {
  		 $photo = $_FILES['photo']['name'];
	  	 $photo = explode('.', $photo);
		 $photo = end($photo); 
		 $photo = $roll.date('Y-m-d-m-s').'.'.$photo;
  	}else{
  		$photo = $oldPhoto;
  	}
  	

  	$query = "UPDATE `student_info` SET `name`='$name',`roll`='$roll',`class`='$class',`subject`='$subject',`pcontact`='$pcontact',`photo`='$photo' WHERE `id`= $id";
  	if (mysqli_query($db_con,$query)) {
  		$datainsert['insertsucess'] = '<p style="color: green;">Student Updated!</p>';
		if (!empty($_FILES['photo']['name'])) {
			move_uploaded_file($_FILES['photo']['tmp_name'], 'images/'.$photo);
			unlink('images/'.$oldPhoto);
		}	
  		header('Location: index.php?page=all-student&edit=success');
  	}else{
  		header('Location: index.php?page=all-student&edit=error');
  	}
  }
?>
<h1 class="text-primary"><i class="fas fa-user-plus"></i>  Edit Tutor Information<small class="text-warning"> Edit</small></h1>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
     <li class="breadcrumb-item" aria-current="page"><a href="index.php">Control Panel </a></li>
     <li class="breadcrumb-item" aria-current="page"><a href="index.php?page=all-student">All Tutors </a></li>
     <li class="breadcrumb-item active" aria-current="page">Add Tutors</li>
  </ol>
</nav>

	<?php
		if (isset($id)) {
			$query = "SELECT `name`, `roll`, `class`, `subject`, `pcontact`, `photo` FROM `student_info` WHERE `id`=$id";
			$result = mysqli_query($db_con,$query);
			$row = mysqli_fetch_array($result);
		}
	 ?>
<div class="row">
<div class="col-sm-6">
	<form enctype="multipart/form-data" method="POST" action="">
		<div class="form-group">
		    <label for="name">Tutor Name</label>
		    <input name="name" type="text" class="form-control" id="name" value="<?php echo $row['name']; ?>" required="">
	  	</div>
	  	<div class="form-group">
		    <label for="roll">Student ID</label>
		    <input name="roll" type="text" class="form-control" pattern="[0-9]{7}" id="roll" value="<?php echo $row['roll']; ?>" required="">
	  	</div>
	  	<div class="form-group">
		    <label for="subject">Subject</label>
		    <select name="subject" class="form-control" id="subject" required="" value="">
		    	<option>Select</option>
		    	<option value="Math" <?= $row['subject']=='Math'? 'selected':'' ?>>Math</option>
		    	<option value="Science" <?= $row['subject']=='Science'? 'selected':'' ?>>Science</option>
		    	<option value="History" <?= $row['subject']=='History'? 'selected':'' ?>>History</option>
		    	<option value="English Language and Writing" <?= $row['subject']=='English Language and Writing'? 'selected':'' ?>>English Language and Writing</option>
		    </select>
	  	</div>
	  	<div class="form-group">
		    <label for="pcontact">Phone Number</label>
		    <input name="pcontact" type="text" class="form-control" id="pcontact" value="<?php echo $row['pcontact']; ?>" pattern="[0-9]{10}" placeholder="+57..." required="">
	  	</div>
	  	<div class="form-group">
		    <label for="class">Grade</label>
		    <select name="class" class="form-control" id="class" required="" value="">
		    	<option>Select</option>
		    	<option value="Ninth" <?= $row['class']=='Ninth'? 'selected':'' ?>>Ninth</option>
		    	<option value="Tenth" <?= $row['class']=='Tenth'? 'selected':'' ?>>Tenth</option>
		    	<option value="Eleventh" <?= $row['class']=='Eleventh'? 'selected':'' ?>>Eleventh</option>
		    	<option value="Twelfth" <?= $row['class']=='Twelfth'? 'selected':'' ?>>Twelfth</option>
		    </select>
	  	</div>
	  	<div class="form-group">
		    <label for="photo">Photo</label>
		    <input name="photo" type="file" class="form-control" id="photo">
	  	</div>
	  	<div class="form-group text-center">
		    <input name="updatestudent" value="Edit Tutor" type="submit" class="btn btn-danger">
	  	</div>
	 </form>
</div>
</div>