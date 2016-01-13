
$(".hashmenu").click(function(event){
   // alert("hey");
   event.preventDefault();
   $('html,body').stop().animate({scrollTop:$(this.hash).offset().top+1},1000);
});

/* form scripts */

var $studentform = $("#studentform");
var studentform = document.querySelector('#studentform');
var $facultyform = $("#facultyform");
var $error = $("#error");

var facultyform = document.querySelector('#facultyform');
$facultyform.hide();

var close = function(obj) {
    $(obj).hide();
};
var show = function(obj) {
    $(obj).show();
    dynamics.css(obj, {opacity: 0, translateX: -400});
    dynamics.animate(obj, {opacity: 1, translateX: 0}, {
        type: dynamics.spring,
        duration: 2000,
        friction: 600,
        complete: function () {

        }
    });
};

$("#facultybtn").click(function () {
    close(studentform);
    show(facultyform);
    $error.hide();

});
$("#studentbtn").click(function () {
    close(facultyform);
    show(studentform);
    $error.hide();

});

var $another = $('#another');
var $mesg = $('.mesg');
var mesg = document.querySelector('.mesg');
$another.click(function(){
  close(mesg);
  show(studentform);
})

var regSection = document.querySelector('.reg');
var $regSection =  $(".reg");
var autoHeight = $regSection.height();
var visible = false;
$("#register").click(function(){
  if(visible){
    dynamics.animate(regSection, {height:'0px'}, {
        type: dynamics.easeIn,
        duration: 500,
        friction: 0,
        complete: function () {

        }
    });
    visible = false;
  }else{
    dynamics.animate(regSection, {height:autoHeight}, {
        type: dynamics.easeOut,
        duration: 500,
        friction: 0,
        complete: function () {

        }
    });
    visible = true;
  }

});
