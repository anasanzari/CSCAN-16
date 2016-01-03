<?php
/* bootstrap */
namespace App;
require __DIR__.'/./vendor/autoload.php';
require './classes/boot.php';
require './classes/Student.php';
require './classes/Faculty.php';
require_once './config.php';

if(isset($_POST['password'])&&$_POST['password']==$password){
  $logged = true;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="./css/styles.css" rel="stylesheet">
  <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/dynamics.min.js"></script>
</head>

<body>

  <?php
     if(isset($logged)&&$logged){
       ?>

       <div class="container-fluid">
         <div class="row">
           <div class="col-md-12">
             <h2>Student Reg</h2>
             <table class="table">
               <thead>
                 <tr>
                   <td>No</td>
                   <td>RegId</td>
                   <td>College</td>
                   <td>Faculty</td>
                   <td>Name</td>
                   <td>Email</td>
                   <td>Phone</td>
                   <td>Course</td>
                   <td>Semester</td>
                   <td>Gender</td>
                   <td>Food</td>
                 </tr>
               </thead>
               <tbody>
             <?php
              $s = Student::with('colg')->orderBy('college', 'asc')->get();
              foreach ($s as $key => $student) {
                $regid = $student->colg->abbr."S".str_pad($student->regid, 3, '0', STR_PAD_LEFT);
                ?>
                <tr>
                  <td><?=$key+1?></td>
                  <td><?=$regid?></td>
                  <td><?=$student->colg->name?></td>
                  <td><?=$student->faculty?></td>
                  <td><?=$student->name?></td>
                  <td><?=$student->email?></td>
                  <td><?=$student->phone?></td>
                  <td><?=$student->course?></td>
                  <td><?=$student->semester?></td>
                  <td><?=$student->gender?></td>
                  <td><?=$student->food?></td>
                <?php
              }
              ?>
            </tbody>
          </table>


           </div>
         </div>
         <div class="row">
           <div class="col-md-12">
             <h2>Faculty Reg</h2>
             <table class="table">
               <thead>
                 <tr>
                   <td>No</td>
                   <td>Reg ID</td>
                   <td>College</td>
                   <td>Name</td>
                   <td>Email</td>
                   <td>Phone</td>
                   <td>Designation</td>
                   <td>Interest</td>
                   <td>Gender</td>
                   <td>Food</td>
                 </tr>
               </thead>
               <tbody>
             <?php
              $s = Faculty::with('colg')->orderBy('college', 'asc')->get();
              foreach ($s as $key => $student) {
                $regid = $student->colg->abbr."F".str_pad($student->regid, 3, '0', STR_PAD_LEFT);
                ?>
                <tr>
                  <td><?=$key+1?></td>
                  <td><?=$regid?></td>
                  <td><?=$student->colg->name?></td>
                  <td><?=$student->name?></td>
                  <td><?=$student->email?></td>
                  <td><?=$student->phone?></td>
                  <td><?=$student->designation?></td>
                  <td><?=$student->interest?></td>
                  <td><?=$student->gender?></td>
                  <td><?=$student->food?></td>
                <?php
              }
              ?>
            </tbody>
          </table>
<a class="btn btn-danger" href="javascript:window.print()">Print</a>

           </div>
         </div>
       </div>

  <?php
  }else{
     ?>
     <div class="container-fluid">
       <div class="row">
         <div class="col-md-12">
           <form action="" method="POST">
             <h2>Password Please</h2>
             <div class="form-group">
               <input type="password" name="password" class="form-control" value="" required>
             </div>
             <div class="form-group">
               <input type="submit" class="btn btn-default" value="Authenticate">
             </div>
             </form

           </div>
         </div>
       </div>



  <?php
    }
  ?>

</body>
