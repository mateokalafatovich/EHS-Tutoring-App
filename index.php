<?php require_once 'admin/db_con.php'; ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>EHS Tutoring App</title>
  </head>
  <body>
    <div class="container"><br>
      <a class="btn btn-primary float-right" href="admin/login.php">Administrative Login</a>
          <h1 class="text-center">Tutor Search</h1><br>

          <div class="row">
            <div class="col-md-4 offset-md-4">
              <form method="POST">
                <table class="text-center infotable">
                  <tr>
                    <th colspan="2">
                      <p class="text-center">Tutor's Information</p>
                    </th>
                  </tr>
                  <tr>
                    <td>
                      <p>Select your grade number</p>
                    </td>
                    <td>
                      <select class="form-control" name="gradenumber">
                        <option value="Ninth">
                          Ninth
                        </option>
                        <option value="Tenth">
                          Tenth
                        </option>
                        <option value="Eleventh">
                          Eleventh
                        </option>
                        <option value="Twelfth">
                          Twelfth
                        </option>
                      </select>
                    </td>
                  </tr>

                  <tr>
                    <td>
                      <p><label for="roll">Select the subject</label></p>
                    </td>
                    <td>
                      <select class="form-control" name="subject" placeholder="School subject">
                      <option value="Math">
                          Math
                        </option>
                        <option value="Science">
                          Science
                        </option>
                        <option value="History">
                          History
                        </option>
                        <option value="English Language and Writing">
                          English Language and Writing
                        </option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" class="text-center">
                      <input class="btn btn-danger" type="submit" name="showinfo">
                    </td>
                  </tr>
                </table>
              </form>
            </div>
          </div>
        <br>
        <?php if (isset($_POST['showinfo'])) {
          $gradenumber= $_POST['gradenumber'];
          $subject = $_POST['subject'];
          if (!empty($gradenumber && $subject)) {
            $query = mysqli_query($db_con,"SELECT * FROM `student_info` WHERE `subject`='$subject' AND `class`='$gradenumber'");
            if (!empty($row=mysqli_fetch_array($query))) {
              // if ($row['roll']==$roll && $choose==$row['class']) {
                $stsubject= $row['subject'];
                $stname= $row['name'];
                $stclass= $row['class'];
                $city= $row['city'];
                $photo= $row['photo'];
                $pcontact= $row['pcontact'];
              ?>
        <div class="row">
          <div class="col-sm-6 offset-sm-3">
            <table class="table table-bordered">
              <tr>
                <td rowspan="5"><h3>Tutor Information</h3><img class="img-thumbnail" src="admin/images/<?= isset($photo)?$photo:'';?>" width="250px"></td>
                <td>Name</td>
                <td><?= isset($stname)?$stname:'';?></td>
              </tr>
              <tr>
                <td>Subject</td>
                <td><?= isset($stsubject)?$stsubject:'';?></td>
              </tr>
              <tr>
                <td>Grade</td>
                <td><?= isset($stclass)?$stclass:'';?></td>
              </tr>
              <tr>
                <td>Phone Number</td>
                <td><?= isset($pcontact)?$pcontact:'';?></td>
              </tr>
            </table>
          </div>
        </div>  
      <?php 
          // }else{
          //       echo '<p style="color:red;">Por favor ingrese un número válido de matricula y grado</p>';
          //     }
            }else{
              echo '<p style="color:red;">Tu información ingresada no coincide</p>';
            }
            }else{?>
              <script type="text/javascript">alert("Datos no encontrados");</script>
            <?php }
          }; ?>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>