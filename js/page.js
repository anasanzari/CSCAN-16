var front = document.querySelector('.front');
var back = document.querySelector('.back');
var backUrls = ["url('./images/a1.jpg')", "url('./images/a3.jpg')", "url('./images/a5.jpg')"];
var frontUrls = ["url('./images/a2.jpg')", "url('./images/a4.jpg')", "url('./images/a6.jpg')"];
var b = 0, f = 0;
var transition = function (isFadeIn) {
    var opacity = (isFadeIn) ? 1 : 0;
    dynamics.animate(front, {opacity: opacity}, {
        type: dynamics.easeIn,
        delay: 2000,
        duration: 4000,
        friction: 600,
        complete: function () {
            if (isFadeIn) {
                b = (b + 1) % backUrls.length;

                dynamics.css(back, {backgroundImage: backUrls[b]});
            } else {
                f = (f + 1) % frontUrls.length;
                dynamics.css(front, {backgroundImage: frontUrls[f]});
            }
            transition(!isFadeIn);
        }
    });
}
transition(false);

$(".box .spk").hover(function () {
    //dynamics.css(this, {translateX: 40});
    var p = $(this).find("p")[0];
    dynamics.animate(p, {
        opacity: 1
    }, {
        type: dynamics.easeInOut,
        bounciness: 0,
        duration: 500,
        delay: 0
    });
}, function () {
    var p = $(this).find("p")[0];
    dynamics.animate(p, {
        opacity: 0
    }, {
        type: dynamics.easeInOut,
        bounciness: 0,
        duration: 500,
        delay: 0
    });
});

var $show = $(".spkdesc .show");
var h = $(".spkdesc .a").html();
$show.html(h);

$(".box .spk").click(function(){
    if($(this).hasClass("active")) return;
    $(".box .active").removeClass("active");
    $(this).addClass("active");
    var d = $(this).attr("data-val");
    $show.fadeOut(500,function(){
        $show.html($(".spkdesc ."+d).html()).fadeIn(500);
    })

});

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
