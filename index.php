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
      $mail->setFrom("CSCAN'16 <noreply@cscan.org>")
      ->addTo($_POST['email'])
      ->setSubject("CSAN'16 Registration");

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
            $mail->setBody("You have successfully registered for CSCAN'16. Your registration id is ".$regid.".");
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
            $mail->setBody("You have successfully registered for CSCAN'16. Your registration id is ".$regid);
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
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta property="og:title" content="CSCAN'16" />
    <meta property="og:site_name" content="cscan.org.in"/>
    <meta property="og:url" content="http://cscan.org.in"/>
    <meta property="og:description" content="CSCAN 2016, the first of it's kind, is a conference aimed at bringing in student-teacher fraternity of CS Departments of reputed NIT's across the nation under a single umbrella for exchange of ideas spark innovation." />
    <meta property="og:image" content="http://athena.nitc.ac.in/anas_b130705cs/cscan/logo.png">

    <link href="./css/styles.css" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/dynamics.min.js"></script>
  </head>

  <body>

    <div class="header" id="home">
      <div class="over"></div>
      <div class="bg"></div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-md-offset-0 col-xs-12">
            <div class="sub">
              <div class="thefloat">
                <a class="brochure" href="#">Download Brochure</a>
                <a class="brochure" href="#">Call for participation</a>
              </div>
              <img src="images/logo.png" />
              <div>
                <h1>C-SCAN '16</h1>
                <h2>Computer Science Conference of All NITs
                 <br/>Feb 19 - Feb 20, 2016, NIT Calicut.</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <nav class="navsection navbar navbar-default hidden-xs">
      <div class="container-fluid">
        <nav id="sac-navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li><a class="hashmenu" href="#register">Register</a></li>
                <li><a class="hashmenu" href="#accommodation">Accommodation</a></li>
                <li><a class="hashmenu" href="#faq">FAQ</a></li>
                <li><a class="hashmenu" href="#contact">Contact Us</a></li>
                <li><a href="./committee.php">Committee</a></li>
                <li><a href="./news.php">Latest News</a></li>
              </ul>

        </nav>
      </div>
    </nav>

    <div class="about" id="about">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-5 col-md-offset-1">
            <h1 class="center">About CSCAN</h1>
            <p class="justify">
              CSCAN 2016, the first of it's kind, is a conference aimed at bringing in student-teacher fraternity of CS Departments of reputed NIT's across the nation under a single umbrella for exchange of ideas spark innovation. The conference would serve as
              a platform to improve interaction and bridge the gap between faculty and students of different NITs. This would help identify patrons of similiar research areas and help initiate collaboration in research projects to subsequently publish
              research papers. This conference presents excellent opportunity for students among various NITs to collaborate and form strong ties of technical expertise. This year's edition of CSCAN will be hosted by National Institute of Technology
              Calicut.
            </p>
          </div>
          <div class="col-md-5">
            <h1 class="center">Sponsors</h1>
            <div class="sponsors">
              <img src="images/tata.png" />
              <img src="images/teqip.png" />
              <p>in association with</p>
              <div class="assoc">
                <img src="images/nitc.png" />
                <img src="images/csea.png" />
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="registration" id="register">

      <div class="container-fluid">
        <div class="row">
          <h1 class="center">Registration</h1>
          <div class="col-md-5 col-md-offset-1">
            <h3 class="center">Important Dates</h3>
            <ul class="datemenu">
              <li>
                <img src="images/icons/icon_calendar.png" /> Registrations open : 11<sup>th</sup> JAN 2016</li>
              <li>
                <img src="images/icons/icon_calendar.png" /> Last date for Registration: 31<sup>st</sup> JAN 2016</li>
              <li>
                <img src="images/icons/icon_calendar.png" /> Confirmation: 1<sup>st</sup> FEB 2016</li>
            </ul>
          </div>
          <div class="col-md-4 col-md-offset-1">
            <h3 class="center">Eligibility</h3>
            <p class="justify">A team of 5 members will be representing each NIT. HOD/Senior faculty from CS Department, 2 B.Tech students(preferably second years), 1 M.Tech student and a Ph.D scholar will be part of the 5 member team. Additionally, if the institute offers
              an MCA course, then a final year MCA student can also be a part of the team as well. There are no restrictions on the selection team from the host, it is purely the participating institute's decision.</p>
          </div>
          <!--div class="col-md-4">
            <h3 class="center">Accomodation</h3>
            <p class="justify">Arrangements will be made for the accommodation of the students from the participating NITs at the NIT Calicut hostels at the hosting institute's expense. Sufficient assistance will be provided for the faculty members for their stay in hostels
              in and around the city. The faculty will have to meet the expenses towards accomodation on their own.</p>
          </div-->
        </div>

        <div class="btncont">
          <a class="brochure hashmenu" href="#reg" id="register">Register</a>
        </div>
      </div>
    </div>

    <div class="reg" id="reg">
      <?php
      if($post){
        if($error == 0){
      ?>
          <div class="mesg">
            <img src="images/logo.png" />
            <h2>You've successfully registered for CSCAN'16.</h2>
            <h3>Your registration id is <?=$regid?>. You'll receive a confirmation mail from us.</h3>
            <a class="brochure hashmenu" href="#reg" id="another">Register Another</a>
            <a class="brochure hashmenu" href="#home">Home</a>
          </div>
      <?php
        }else if($error == ERROR_DB){
      ?>
          <div class="mesg">
            <h2>Sorry.Unknown error occured.Please try again</h2>
            <a class="brochure hashmenu" href="#reg" id="another">Try Again</a>
          </div>
     <?php
        }else if($error == ERROR_CAPTCHA){
          ?>
              <div class="mesg">
                <h2>Registration failed.</h2>
                <ul>
                  <li>Captcha Verification required.</li>
                </ul>
                <a class="brochure hashmenu" href="#reg" id="another">Try Again</a>
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
             <a class="brochure hashmenu" href="#reg" id="another">Try Again</a>
           </div>
        <?php }
      }
      ?>

          <div class="wrap">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-6 col-md-offset-3">
                  <form id="studentform" action="#reg" method="POST">
                    <h2>Student Registration <a id="facultybtn" class="btn btn-danger">Faculty Form</a></h2>
                    <div class="form-group">
                      <select name="college" class="form-control" required>
                        <option value="" disabled  selected>Select College</option>
                         <?php
                           $colleges = College::all();
                           foreach ($colleges as $key => $op) {
                             ?>
                             <option value="<?=$op->id?>"><?=$op->name?></option>
                        <?php
                           }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <!--label>Password</label-->
                      <input type="text" name="faculty" class="form-control" placeholder="Accompanying Faculty" required>
                    </div>
                    <div class="form-group">
                      <input type="text" name="name" class="form-control" placeholder="Participant Name" required>
                    </div>
                    <div class="form-group">
                      <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                      <input type="number" name="phone" class="form-control" placeholder="Phone" required>
                    </div>
                    <div class="form-group">
                      <input type="text" name="course" class="form-control" placeholder="Course" required>
                    </div>
                    <div class="form-group">
                      <input type="text" name="semester" class="form-control" placeholder="Current Semester" required>
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
                    <div class="form-group">
                      <div id="Recap1" class="recaptcha"></div>
                    </div>

                    <input type="hidden" name="type" value="student" />
                    <input type="submit" class="fbtn btn btn-default" value="Register" />
                  </form>

                  <form id="facultyform" action="#reg" method="POST">
                    <h2>Faculty Registration <a id="studentbtn" class="btn btn-danger">Student Form</a></h2>
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
                      <input type="text" name="name" class="form-control" placeholder="Participant Name" required>
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
                    <div class="form-group">
                      <div id="Recap2" class="recaptcha"></div>
                    </div>

                    <input type="hidden" name="type" value="faculty" />
                    <input type="submit" class="fbtn btn btn-default" value="Register" />
                  </form>

                </div>
              </div>
            </div>
          </div>
    </div>

    <div class="accomodation" id="accommodation">

      <div class="container-fluid">
        <div class="row">

          <div class="col-md-5 col-md-offset-1 col-xs-12">
            <h1 class="center">Accommodation</h3>
            <p class="justify">Arrangements will be made for the free accommodation and food for the students from the participating NITs at the NIT Calicut hostels. Sufficient assistance will be provided for the faculty members for their stay in hostels
            NIT Calicut campus. Around 15 rooms are reserved for the faculty participants in NITC guest house which can be booked in advance on FCFS.
            The workshop is sponsored by TEQIP-II at NIT Calicut. It is expected that the faculty participants would avail the funding from TEQIP in their respective institutions or any other sources like PDA to meet the expenses towards their travel and accommodation.
            Local hospitality including pickup and drop will be taken care by the organizing team. Please visit the workshop site for the details on hostels near NIT Calicut.
            </p>

          </div>
          <div class="col-md-5">
            <h1 class="center">Travel</h3>
            <p class="justify">NITC is well connected by railway, air and road facilities.
              The Calicut Railway station(CLT) has trains to all major stations in India. The Kozhikode International Airport(CCJ) provides daily flights to and from major cities in India. Once you reach the Railway Station or the Airport just take an Auto-rickshaw, cab or bus to NITC by asking for REC or NIT Calicut.
              Nearby area is Kattangal.Buses leave every 10-15 minutes from the main bus stand Palayam Bus stand to REC. </p>
          </div>

        </div>
      </div>
    </div>

    <div class="faq" id="faq">
      <h1 class="center">FAQ</h1>
      <div class="container-fluid">
        <div class="row">
          <div class="spkdesc col-md-10 col-md-offset-1">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel">
                <a class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    1. How to reach NIT Calicut?
                </a>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel">
                  <div class="panel-body">
                      NITC is well connected by railway,air and road facilities. The Calicut Railway station has trains to all major stations in India. The Kozhikode International Airport provides daily flights to and from major cities in India. Once you reach the Railway Station or the Airport just take an Auto-rickshaw, cab or bus to NITC by asking for REC or NIT Calicut. Nearby area is Kattangal.Buses leave every 10-15 minutes from the main bus stand Palayam Bus stand to REC.
                  </div>
                </div>
              </div>
              <div class="panel">
                <a class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                    2. Where will we stay?
                </a>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" >
                  <div class="panel-body">
                    Accommodation will be provided in the NITC hostels and food services will also be taken care of.  Also Kattangal has various places to indulge in good Malabar food.
                  </div>
                </div>
              </div>
              <div class="panel">
                <a class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                    3. What is expected from the programme?
                </a>
                <div id="collapseThree" class="panel-collapse collapse" >
                  <div class="panel-body">
                    A wide exposure to students from different NIT's all over India. More internship opportunities for students from faculty in different NIT’s. Exchange of ideas and views.
                  </div>
                </div>
              </div>
              <div class="panel">
                <a class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                    4. What if we have discrepancies while choosing the visiting team?
                </a>
                <div id="collapseFour" class="panel-collapse collapse" >
                  <div class="panel-body">
                    Team selection is entirely the visiting institute’s decision. If you still have issues then do contact our team relations coordinator at “ADD EMAIL”.
                  </div>
                </div>
              </div>
              <div class="panel">
                <a class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                  5. What if there are issues with the dates of the event?
                </a>
                <div id="collapseFive" class="panel-collapse collapse" >
                  <div class="panel-body">
                    The dates have been chosen with regard of no clashing with any exams with most NIT’s. If there are issues then do contact our team relations coordinator at “ADD EMAIL”.
                  </div>
                </div>
              </div>

              <div class="panel">
                <a class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
                    6. How do I know that I’ve been registered or not?
                </a>
                <div id="collapseSix" class="panel-collapse collapse" >
                  <div class="panel-body">
                    You’ll recieve a confirmation mail from us stating that you have been registered and it would contain your team details.
                  </div>
                </div>
              </div>

              <div class="panel">
                <a class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">
                      7. Is it necessary for each participant to register?
                </a>
                <div id="collapseSeven" class="panel-collapse collapse" >
                  <div class="panel-body">
                    Yes, each participant has to register seperately in the website.This it to keep track of your food preference and providing hostel accomadation.
                  </div>
                </div>
              </div>

              <div class="panel">
                <a class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseEight">
                    8. Who all are eligible to register?
                </a>
                <div id="collapseEight" class="panel-collapse collapse" >
                  <div class="panel-body">
                    Students pursuing a course in the Computer Science Department of any of the National Institute of Technology across India are eligible to register for the meet.
                  </div>
                </div>
              </div>

              <div class="panel">
                <a class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseNine">
                      9. Is Institute Identification Card necessary during the meet?
                </a>
                <div id="collapseNine" class="panel-collapse collapse" >
                  <div class="panel-body">
                    Yes. The institute identification card provides us a medium to confirm that you are a student of an NIT. Incase of absence of an ID card, please present a bonafide certificate from your department stating that “You are a bondafide student of the department for the particular course”. Do include your Roll Number in the certificate too.
                  </div>
                </div>
              </div>

              <div class="panel">
                <a class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen">
                      10. Is it necessary for the accompanying faculty to register too?
                </a>
                <div id="collapseTen" class="panel-collapse collapse" >
                  <div class="panel-body">
                    Yes. The accompanying faculty has to register for the meet too.
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

    </div>



    <div class="contactus" id="contact">

      <h1 class="center">Contact Us</h1>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <p class="center">For enquiries/details, please mail to <a href="mailto:cscan16@nitc.ac.in">cscan16@nitc.ac.in</a></p>
            <p class="center"> Mobile no: <a href="tel:+919497788940">+91 9497788940</a>,
              <a href="tel:+919562847026">+91 9562847026</a></p>

          </div>

        </div>
        <div class="row" style="min-height: 250px">
          <div class="col-md-6">
            <h2 class="center">Faculty Conveners</h2>
            <div class="center">
              <div class="p">
                <h3>Dr. S D Madhu Kumar</h3>
                <h4><a href="tel:0495 2286806">0495 2286806</a></h4>
              </div>
              <div class="p">
                <h3>Lijiya A</h3>
                <h4><a href="tel:0495 2286806">0495 2286815</a></h4>
              </div>
            </div>


          </div>
          <div class="col-md-6">
            <h2 class="center">Coordinators</h2>
            <div class="center">
              <div class="p">
                <h3>Prasad Krishnan</h3>
                <h4><a href="mailto:prasad_b120128cs@nitc.ac.in">prasad_b120128cs@nitc.ac.in</a></h4>
                <h4><a href="tel:+919497788940">+91 9497788940</a></h4>
              </div>
              <div class="p">
                <h3>Hemant Pugaliya</h3>
                <h4><a href="mailto:hemant_b120787cs@nitc.ac.in">hemant_b120787cs@nitc.ac.in</a></h4>
                <h4><a href="tel:+919562847026">+91 9562847026</a></h4>
              </div>

            </div>
          </div>
        </div>

        <div class="row" style="padding-top: 10px">
          <div class="socialbuttons col-md-6 col-md-offset-3">
            <a class="social" href="https://www.facebook.com/" target="_blank">
              <img src="./images/social/facebook.png" />
            </a>
            <a class="social" href="https://instagram.com/" target="_blank">
              <img src="./images/social/Instagram.png" />
            </a>
            <a class="social" href="https://twitter.com/" target="_blank">
              <img src="./images/social/twitter.png" />
            </a>
            <a class="social" href="https://www.youtube.com/" target="_blank">
              <img src="./images/social/youtube.png" />
            </a>
          </div>
        </div>


      </div>
    </div>
    <div class="footer">
      <p> © Creative and Intellectual minds of NIT Calicut </p>
    </div>

    <script src="./js/page.js"></script>
    <script>
      <?php if($post){
      ?>
      $studentform.hide();
      $regSection.css('height', autoHeight);
      visible = true;
      <?php
    }else {
    ?>
      $regSection.css('height', '0px');
      <?php
      }
    ?>

    var CaptchaCallback = function(){
      grecaptcha.render('Recap1',{
        'sitekey' : '6Lew1BMTAAAAABO4bm79an2x7n7Ix7mQfCGd44S2'
      });
      grecaptcha.render('Recap2',{
        'sitekey' : '6Lew1BMTAAAAABO4bm79an2x7n7Ix7mQfCGd44S2'
      });
    }

    </script>
    <script src='https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit'></script>

  </body>

  </html>
