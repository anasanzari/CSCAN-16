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


