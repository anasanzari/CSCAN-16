<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <meta property="og:title" content="C-SCAN'16" />
  <meta property="og:site_name" content="cscan.org.in"/>
  <meta property="og:url" content="http://cscan.org.in"/>
  <meta property="og:description" content="C-SCAN 2016, the first of it's kind, is a conference aimed at bringing in student-teacher fraternity of CS Departments of reputed NIT's across the nation under a single umbrella for exchange of ideas spark innovation." />
  <meta property="og:image" content="http://cscan.org.in/logo.png">
  <title>C-SCAN'16</title>
  <link href="./css/styles.css" rel="stylesheet">
  <link href="./css/gallery.css" rel="stylesheet">
  <link rel="icon" href="./logo.png" type="image/png">
  <link rel="shortcut icon" href="./logo.png" type="image/png">

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
            </div>
            <img src="images/logo.png" />
            <div>
              <h1>C-SCAN '16</h1>
              <h2>Computer Science Conference of All NITs
                <br/>Feb 19 - 21, 2016, NIT Calicut.</h2>
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
              <li><a href="./">Home</a></li>
            </ul>

      </nav>
    </div>
  </nav>

  <div class="committe" style="min-height:300px">
    <div class="container">
      <div class="row">
        <!--div class="col-md-8 col-md-offset-2 col-xs-12">
          <h1>Hotels Nearby</h1>
            <ul>
              <li>
                <p>The Renai Cochin, Hill Side Mukkam</p>
                <p>Phone: 0495 3244150</p>
                <p>Mail: mail@hillside.com</p>
              </li>
              <li>
                <p>A R Residency, Plaza Junction, Kunnamangalam</p>
                <p>Phone:  +91 495 2800169 </p>
                <p>Mail: arplazaresidency@gmail.com</p>
              </li>
            </ul>
        </div-->
        <div class="col-md-12 col-xs-12">
          <h1>Gallery</h1>
          <div id="tabContent" class="tab-content">
            <div role="tabpanel" class="tab-pane fade active in" id="pics1" aria-labelledby="pics-tab" style="text-align:center">
              <div class="pictures">
                <a href="#">
                  <img src="images\pic.jpg" alt="Not Found!" data-toggle="modal" data-target="#myModal">
                </a>
              </div>
              <div class="pictures">
                <a href="#">
                  <img src="images\pic.jpg" alt="Not Found!" data-toggle="modal" data-target="#myModal">
                </a>
              </div>
              <div class="pictures">
                <a href="#">
                  <img src="images\pic.jpg" alt="Not Found!" data-toggle="modal" data-target="#myModal">
                </a>
              </div>
              <div class="pictures">
                <a href="#">
                  <img src="images\pic.jpg" alt="Not Found!" data-toggle="modal" data-target="#myModal">
                </a>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="pics2" aria-labelledby="pics-tab2">
              <div class="pictures">
                <a href="#">
                  <img src="images\pic.jpg" alt="Not Found!" data-toggle="modal" data-target="#myModal">
                </a>
              </div>
              <div class="pictures">
                <a href="#">
                  <img src="images\pic.jpg" alt="Not Found!" data-toggle="modal" data-target="#myModal">
                </a>
              </div>
              <div class="pictures">
                <a href="#">
                  <img src="images\pic.jpg" alt="Not Found!" data-toggle="modal" data-target="#myModal">
                </a>
              </div>
              <div class="pictures">
                <a href="#">
                  <img src="images\pic.jpg" alt="Not Found!" data-toggle="modal" data-target="#myModal">
                </a>
              </div>
            </div>
          </div>
          <nav class="pages" style="text-align:center">
            <ul class="pagination">
              <li style="cursor:pointer">
                <a id="prev">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <li class="active"><a href="#pics1" id="p1" role="tab" data-toggle="tab" aria-controls="pics" aria-expanded="true">1</a></li>
              <li><a href="#pics2" id="p2" role="tab" data-toggle="tab" aria-controls="pics2" aria-expanded="true">2</a></li>
              <li style="cursor:pointer">
                <a id="next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <div class="footer">
    <p> © Creative and Intellectual minds of NIT Calicut </p>
  </div>
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <!--div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel" style="color:black">The Swiss Maestro</h4>
        </div-->
        <div class="modal-body">
          <div style="text-align:center">
            <img id="img" src=""  alt="Not Found" style="display:inline;height:100%;width:100%">
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
  $(document).ready(function(){
    $('.pages').on('click','#prev',function(){
      $('#p1').click();
    });
    $('.pages').on('click','#next',function(){
      $('#p2').click();
    });
    $('.pictures').on('click', 'img', function(){
      var src = $(this).attr('src');
      $("#img").attr("src", src);
    });
  });
  </script>
