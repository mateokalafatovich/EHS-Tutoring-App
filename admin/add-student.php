<?php 
  $corepage = explode('/', $_SERVER['PHP_SELF']);
    $corepage = end($corepage);
    if ($corepage!=='index.php') {
      if ($corepage==$corepage) {
        $corepage = explode('.', $corepage);
       header('Location: index.php?page='.$corepage[0]);
     }
    }

  if (isset($_POST['addstudent'])) {
  	$name = $_POST['name'];
  	$roll = $_POST['roll'];
  	$subject = $_POST['subject'];
  	$pcontact = $_POST['pcontact'];
  	$gradenumber = $_POST['gradenumber'];
  	
  	$photo = explode('.', $_FILES['photo']['name']);
  	$photo = end($photo); 
  	$photo = $roll.date('Y-m-d-m-s').'.'.$photo;

  	$query = "INSERT INTO `student_info`(`name`, `roll`, `subject`, `class`, `pcontact`, `photo`) VALUES ('$name', '$roll', '$subject', '$gradenumber', '$pcontact','$photo');";
  	if (mysqli_query($db_con,$query)) {
  		$datainsert['insertsucess'] = '<p style="color: green;">Tutor Successfully Added</p>';
  		move_uploaded_file($_FILES['photo']['tmp_name'], 'images/'.$photo);
  	}else{
  		$datainsert['inserterror']= '<p style="color: red;">Tutor not added, check your information.</p>';
  	}
  }
?>
<h1 class="text-primary"><i class="fas fa-user-plus"></i>  Add Tutor<small class="text-warning"> New Tutor</small></h1>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
     <li class="breadcrumb-item" aria-current="page"><a href="index.php">Control Panel </a></li>
     <li class="breadcrumb-item active" aria-current="page">Add Tutor</li>
  </ol>
</nav>

<div class="row">
	
<div class="col-sm-6">
		<?php if (isset($datainsert)) {?>
	<div role="alert" aria-live="assertive" aria-atomic="true" class="toast fade" data-autohide="true" data-animation="true" data-delay="2000">
	  <div class="toast-header">
	    <strong class="mr-auto">Student Insert Alert</strong>
	    <small><?php echo date('d-M-Y'); ?></small>
	    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
	      <span aria-hidden="true">&times;</span>
	    </button>
	  </div>
	  <div class="toast-body">
	    <?php 
	    	if (isset($datainsert['insertsucess'])) {
	    		echo $datainsert['insertsucess'];
	    	}
	    	if (isset($datainsert['inserterror'])) {
	    		echo $datainsert['inserterror'];
	    	}
	    ?>
	  </div>
	</div>
		<?php } ?>
	<form enctype="multipart/form-data" method="POST" action="">
		<div class="form-group">
		    <label for="name">Tutor Name</label>
		    <input name="name" type="text" class="form-control" id="name" value="<?= isset($name)? $name: '' ; ?>" required="">
	  	</div>
	  	<div class="form-group">
		    <label for="roll">Student ID</label>
		    <input name="roll" type="text" value="<?= isset($roll)? $roll: '' ; ?>" class="form-control" pattern="[0-9]{7}" id="roll" required="">
	  	</div>
	  	<div class="form-group">
		    <label for="subject">Subject</label>
			<select name="subject" class="form-control" id="subject" required="">
		    	<option>Select</option>
		    	<option value="Math">Math</option>
		    	<option value="Science">Science</option>
		    	<option value="History">History</option>
		    	<option value="English Language and Writing">English Language and Writing</option>
		    </select>
	  	</div>
	  	<div class="form-group">
		    <label for="pcontact">Phone Number</label>
		    <input name="pcontact" type="text" class="form-control" id="pcontact" pattern="[0-9]{10}" value="<?= isset($pcontact)? $pcontact: '' ; ?>" placeholder="+57........." required="">
	  	</div>
	  	<div class="form-group">
		    <label for="gradenumber">Grade Number</label>
		    <select name="gradenumber" class="form-control" id="gradenumber" required="">
		    	<option>Select</option>
		    	<option value="Ninth">Ninth</option>
		    	<option value="Tenth">Tenth</option>
		    	<option value="Eleventh">Eleventh</option>
		    	<option value="Twelfth">Twelfth</option>
		    </select>
	  	</div>
	  	<div class="form-group">
		    <label for="photo">Tutor's Picture</label>
		    <input name="photo" type="file" class="form-control" id="photo" required="">
	  	</div>
	  	<div class="form-group text-center">
		    <input name="addstudent" value="Add Tutor" type="submit" class="btn btn-danger">
	  	</div>
	 </form>
</div>
</div>