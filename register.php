<?php

/* bootstrap */
require __DIR__.'/./vendor/autoload.php';
require './config.php';
require './classes/boot.php';
require_once './classes/Student.php';
require_once './classes/Faculty.php';
require_once './classes/College.php';
require_once './classes/CaptchaVerify.php';

use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;
use Illuminate\Validation\Factory as ValidatorFactory;
use Symfony\Component\Translation\Translator;
use App\College;
use App\Student;
use App\Faculty;

$post = false;
$error = 0;
const ERROR_DB = 1;
const ERROR_CAPTCHA = 2;
const ERROR_INVALID = 3;

if (isset($_POST['type'])) {
    $post = true;
    $verify = CaptchaVerify::verify($_POST["g-recaptcha-response"]);
    if (!$verify) {
        $error = ERROR_CAPTCHA;
    }else{

      $mail = new Message;
      $mail->setFrom("C-SCAN'16 <$mailer_username>")
      ->addTo($_POST['email'])
      ->setSubject("C-SCAN'16 Registration");

      $mailer = new Nette\Mail\SmtpMailer(array(
        'host' => 'smtp.gmail.com',
        'username' => $mailer_username,
        'password' => $mailer_password,
        'secure' => 'ssl',
      ));

      $factory = new ValidatorFactory(new Translator('en'));
      $messages = array(
          'required' => 'The :attribute field is required.',
          'max' => 'Please enter a valid :attribute number.',
          'min' => 'Please enter a valid :attribute field.',
          'email' => 'Please enter a valid email address.',
          'numberic' => 'The :attribute field should consist only of digits.',
          'integer' => 'The :attribute field should be selected.',
          'digits_between' => 'The :attribute field should be contain minimum of 10 digits.'
      );

      if ($_POST['type'] == "student") {
        $rules = array(
          'college' => 'required|integer',
          'faculty' => 'required',
          'name' => 'required',
          'email' => 'required|email',
          'phone' => 'required|numeric|digits_between:10,15',
          'course'=>'required',
          'semester'=>'required',
          'gender'=>'required',
          'food'=>'required'
        );
        $validator = $factory->make($_POST, $rules,$messages);
        if ($validator->passes()) {

          $num = Student::where('college',$_POST['college'])->count();
          $_POST['regid'] = $num+1;

          if($v=Student::create($_POST)){
            $regid = $v->colg->abbr."S".str_pad($_POST['regid'], 3, '0', STR_PAD_LEFT);
            $name = $_POST['name'];
            $mail->setHTMLBody("Hi $name,<br/>You have successfully registered for C-SCAN 2016. Your registration ID is ".$regid.". The confirmation regarding the same will be done via email on or before 1st February.<br/>For more details and updates, please visit our <a href='http://www.cscan.org.in'>website</a>.<br/><br/>Thank you.<br/><br/>Yours Sincerely,<br/>Organising Team,<br/>C-SCAN 2016.");
            $mailer->send($mail);
          }else{
            $error = ERROR_DB;
          }
        }else{
          $error = ERROR_INVALID;
        }
      }else if($_POST['type'] == "faculty"){
        $rules = array(
          'college' => 'required|integer',
          'name' => 'required',
          'email' => 'required|email',
          'phone' => 'required|numeric|digits_between:10,15',
          'designation' => 'required',
          'interest' => 'required',
          'gender'=>'required',
          'food'=>'required'
        );
        $validator = $factory->make($_POST, $rules,$messages);
        if ($validator->passes()) {

          $num = Faculty::where('college',$_POST['college'])->count();
          $_POST['regid'] = $num+1;

          if($v = Faculty::create($_POST)){
            $regid = $v->colg->abbr."F".str_pad($_POST['regid'], 3, '0', STR_PAD_LEFT);
            $name = $_POST['name'];
            $mail->setHTMLBody("Hi $name,<br/>You have successfully registered for C-SCAN 2016. Your registration id is ".$regid.". The confirmation regarding the same will be done via email on or before 1st February.<br/>For more details and updates, please visit our <a href='http://www.cscan.org.in'>website</a>.<br/><br/>Thank you.<br/>Yours Sincerely,<br/>Organising Team,<br/>C-SCAN 2016.");
            $mailer->send($mail);
          }else{
            $error = ERROR_DB;
          }
        }else{
          $error = ERROR_INVALID;
        }

      }
    }
}

?>
<?php include_once './header.php'; ?>

  <nav class="navsection navbar navbar-default hidden-xs">
    <div class="container-fluid">
      <nav id="sac-navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="./">Home</a></li>
            </ul>

      </nav>
    </div>
  </nav>


  <div class="reg" id="reg">
    <?php

    if(isset($_GET['type'])&&$_GET['type']=="faculty"){
      $opt = "?type=faculty";
    }else{
      $opt = "";
    }


    if($post){
      if($error == 0){
    ?>
        <div class="mesg">
          <img src="images/logo.png" />
          <h2>You've successfully registered for C-SCAN'16.</h2>
          <h3>Your registration id is <?=$regid?>. You'll receive a confirmation mail from us.</h3>
          <a class="brochure hashmenu" href="./register.php<?=$opt?>" id="another">Register Another</a>
          <a class="brochure hashmenu" href="./index.php">Home</a>
        </div>
    <?php
      }else if($error == ERROR_DB){
    ?>
        <div class="mesg">
          <h2>Sorry.Unknown error occured.Please try again</h2>
          <a class="brochure hashmenu" href="./register.php<?=$opt?>" id="another">Try Again</a>
        </div>
   <?php
      }else if($error == ERROR_CAPTCHA){
        ?>
            <div class="mesg">
              <h2>Registration failed.</h2>
              <ul>
                <li>Captcha Verification required.</li>
              </ul><br>
              <a class="brochure hashmenu" href="./register.php$opt" id="another">Try Again</a>
            </div>
   <?php }else if($error == ERROR_INVALID){
     ?>
         <div class="mesg">
           <h2>Registration failed.</h2>
           <ul>
          <?php
            $messages = $validator->messages();
            foreach ($messages->all() as $message)
            {
                echo "<li>".$message."</li>";
            }
          ?>
          </ul>
          <br/>
           <a class="brochure hashmenu" href="./register.php<?=$opt?>" id="another">Try Again</a>
         </div>
      <?php }
    }else{

    ?>

        <div class="wrap">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 col-md-offset-3">

              <?php
              $colleges = College::all();

              if(isset($_GET['type'])&&$_GET['type']=="faculty"){ ?>
                <form id="facultyform" action="register.php<?=$opt?>" method="POST">
                  <h2>Faculty Registration</h2>
                  <div class="form-group">
                    <select name="college" class="form-control" required>
                      <option value="" disabled  selected>Select College</option>
                       <?php

                         foreach ($colleges as $key => $op) {
                           ?>
                           <option value="<?=$op->id?>"><?=$op->name?></option>
                      <?php
                         }
                         ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                  </div>
                  <div class="form-group">
                    <input type="text" name="designation" class="form-control" placeholder="Designation" required>
                  </div>
                  <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                  </div>
                  <div class="form-group">
                    <input type="number" name="phone" class="form-control" placeholder="Phone" required>
                  </div>
                  <div class="form-group">
                    <input type="text" name="interest" class="form-control" placeholder="Area of Interest" required>
                  </div>
                  <div class="form-group">
                    <label>Gender :&nbsp;&nbsp;
                      <label class="radio-inline">
                        <input type="radio" name="gender" value="male" checked> Male
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="gender" value="female"> Female
                      </label>
                    </label>
                  </div>
                  <div class="form-group">
                    <label>Food Preference :&nbsp;&nbsp;
                      <label class="radio-inline">
                        <input type="radio" name="food" value="veg" checked> Veg
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="food" value="nonveg"> Non-Veg
                      </label>
                    </label>
                  </div>
                  <div class="g-recaptcha" data-sitekey="6Lew1BMTAAAAABO4bm79an2x7n7Ix7mQfCGd44S2"></div>


                  <input type="hidden" name="type" value="faculty" />
                  <input type="submit" class="fbtn btn btn-default" value="Register" />
                </form>


              <?php }else{ ?>

                <form id="studentform" action="register.php<?=$opt?>" method="POST">
                  <h2>Student Registration</h2>
                  <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Participant Name" required>
                  </div>
                  <div class="form-group">
                    <select name="college" class="form-control" required>
                      <option value="" disabled  selected>Select Institute</option>
                       <?php
                         foreach ($colleges as $key => $op) {
                           ?>
                           <option value="<?=$op->id?>"><?=$op->name?></option>
                      <?php
                         }
                      ?>
                    </select>
                  </div>


                  <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                  </div>
                  <div class="form-group">
                    <input type="number" name="phone" class="form-control" placeholder="Phone" required>
                  </div>

                  <div class="form-group">
                    <select name="course" class="form-control" required>
                      <option value="" disabled  selected>Select Programme</option>
                      <option value="B.Tech">B.Tech</option>
                      <option value="M.Tech">M.Tech</option>
                      <option value="Ph.D">Ph.D</option>
                      <option value="MCA">MCA</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <input type="text" name="semester" class="form-control" placeholder="Current Semester" required>
                  </div>
                  <div class="form-group">
                    <input type="text" name="faculty" class="form-control" placeholder="Accompanying Faculty" required>
                  </div>
                  <div class="form-group">
                    <label>Gender :&nbsp;&nbsp;
                      <label class="radio-inline">
                        <input type="radio" name="gender" value="male" checked> Male
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="gender" value="female"> Female
                      </label>
                    </label>
                  </div>
                  <div class="form-group">
                    <label>Food Preference :&nbsp;&nbsp;
                      <label class="radio-inline">
                        <input type="radio" name="food" value="veg" checked> Veg
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="food" value="nonveg"> Non-Veg
                      </label>
                    </label>
                  </div>
                  <div class="g-recaptcha" data-sitekey="6Lew1BMTAAAAABO4bm79an2x7n7Ix7mQfCGd44S2"></div>

                  <input type="hidden" name="type" value="student" />
                  <input type="submit" class="fbtn btn btn-default" value="Register" />
                </form>


              <?php } ?>
              </div>
            </div>
          </div>
        </div>

    <?php } ?>

  </div>
  <script src='https://www.google.com/recaptcha/api.js'></script>

  <div class="footer">
    <p> © Creative and Intellectual minds of NIT Calicut </p>
  </div>
