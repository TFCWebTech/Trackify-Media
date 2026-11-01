<!-- footer -->
<footer class="w3l-footer-29-main">
   <div class="footer-29-w3l py-5">
      <div class="container py-4">
         <div class="row footer-top-29">
            <div class="col-lg-9 col-md-6 col-sm-7 footer-list-29 footer-1 pr-lg-5">
               <div class="footer-logo mb-3">
                  <a class="footer-brand-logo" href="<?php print site_url('Home'); ?>">
                     <i class="fa fa-rocket mr-1" aria-hidden="true"></i>StartUp0km
                  </a>
               </div>
               <!-- <p>Lorem ipsum viverra feugiat. Pellen tesque libero ut justo, ultrices in ligula.
                  Semper at
                  tempufddfel. Lorem ipsum dolor sit amet Semper at elit.
               </p> -->
               <!-- <div class="main-social-footer-29 mt-4">
                  <a href="#facebook" class="facebook"><span class="fab fa-facebook-f"></span></a>
                  <a href="#twitter" class="twitter"><span class="fab fa-twitter"></span></a>
                  <a href="#instagram" class="instagram"><span class="fab fa-instagram"></span></a>
                  <a href="#linkedin" class="linkedin"><span class="fab fa-linkedin-in"></span></a>
               </div> -->
            </div>
            <div class="col-lg-2 col-md-6 col-sm-5 col-6 footer-list-29 footer-2 mt-sm-0 mt-5" style="display: flex;justify-content:;">
               <ul>
                  <h6 class="footer-title-29">Usefull Links</h6>
                  <li><a href="<?php print site_url('Home'); ?>">Home</a></li>
                  <li><a href="<?php print site_url('About'); ?>">Company</a></li>
                  <!-- <li><a href="<?php print site_url('Services'); ?>">Services</a></li> -->
                  <!-- <li><a href="#blog">Blog Posts</a></li> -->
                  <li class="mb-0"><a href="<?php print site_url('Contact'); ?>">Contact us</a></li>
               </ul>
            </div>
            <!-- <div class="col-lg-3 col-md-6 col-sm-5 col-6 footer-list-29 footer-3 mt-lg-0 mt-5 pl-lg-4" style="display: flex;justify-content: right">
               <ul>
                  <h6 class="footer-title-29">More Info</h6>
                  <li><a href="#support">Support</a></li>
                  <li><a href="#privacy">Privacy Policy</a></li>
                  <li><a href="#terms">Terms & conditions</a></li>
                  <li><a href="#help">Help</a></li>
               </ul>
            </div> -->
            <!-- <div class="col-lg-4 col-md-6 col-sm-7 footer-list-29 footer-4 mt-lg-0 mt-5 pl-lg-5">
               <h6 class="footer-title-29">Newsletter </h6>
               <form action="#" class="subscribe d-flex align-items-center" method="post">
                  <input type="email" name="email" placeholder="Email Address" required="">
                  <button><span class="fa fa-paper-plane" aria-hidden="true"></span></button>
               </form>
               <h6 class="footer-title-29 pt-2 mt-4 mb-3">Give us a free call: </h6>
               <a href="tel:+12 23456790">+12 23456790</a>
            </div> -->
         </div>
      </div>
   </div>
   <!-- copyright -->
   <div class="w3l-copyright">
      <div class="container">
         <div class="row bottom-copies align-items-center">
            <p class="col-lg-8 copy-footer-29">@ <?php echo $year = date("Y");  ?> All rights reserved. Design by 
              <a href="<?php print site_url('Home'); ?>" target="_blank"> Startup  0km</a>
            </p>
            <div class="col-lg-4 footer-list-29 footer-copy-list">
               <ul class="text-lg-right">
                  <li><a href="<?php print site_url('Contact'); ?>"> Careers</a></li>
                  <li class="mx-lg-5 mx-md-4 mx-3"><a href="#">FAQ</a></li>
                  <li><a href="<?php print site_url('Contact'); ?>">Contact us</a></li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</footer>
<!-- //copyright -->
<!-- //footer -->
<!-- Js scripts -->
<!-- move top -->
<button onclick="topFunction()" id="movetop" title="Go to top">
<span class="fas fa-level-up-alt" aria-hidden="true"></span>
</button>
<script>
   // When the user scrolls down 20px from the top of the document, show the button
   window.onscroll = function () {
       scrollFunction()
   };
   
   function scrollFunction() {
       if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
           document.getElementById("movetop").style.display = "block";
       } else {
           document.getElementById("movetop").style.display = "none";
       }
   }
   
   // When the user clicks on the button, scroll to the top of the document
   function topFunction() {
       document.body.scrollTop = 0;
       document.documentElement.scrollTop = 0;
   }
</script>
<!-- //move top -->
<!-- common jquery plugin -->
<script src="<?php print base_url('assets/js/jquery-3.3.1.min.js'); ?>"></script>
<!-- //common jquery plugin -->
<!-- banner image moving effect -->
<script>
   var lFollowX = 0,
       lFollowY = 0,
       x = 0,
       y = 0,
       friction = 1 / 30;
   
   function animate() {
       x += (lFollowX - x) * friction;
       y += (lFollowY - y) * friction;
   
       translate = 'translate(' + x + 'px, ' + y + 'px) scale(1.1)';
   
       $('.banner-image').css({
           '-webit-transform': translate,
           '-moz-transform': translate,
           'transform': translate
       });
   
       window.requestAnimationFrame(animate);
   }
   
   $(window).on('mousemove click', function (e) {
   
       var lMouseX = Math.max(-100, Math.min(100, $(window).width() / 2 - e.clientX));
       var lMouseY = Math.max(-100, Math.min(100, $(window).height() / 2 - e.clientY));
       lFollowX = (20 * lMouseX) / 100; // 100 : 12 = lMouxeX : lFollow
       lFollowY = (10 * lMouseY) / 100;
   
   });
   
   animate();
</script>
<!-- //banner image moving effect -->
<!-- counter for stats -->
<script src="<?php print base_url('assets/js/counter.js'); ?>"></script>
<!-- //counter for stats -->
<!-- magnific popup -->
<script src="<?php print base_url('assets/js/jquery.magnific-popup.min.js'); ?>"></script>
<script>
   $(document).ready(function () {
       $('.popup-with-zoom-anim').magnificPopup({
           type: 'inline',
   
           fixedContentPos: false,
           fixedBgPos: true,
   
           overflowY: 'auto',
   
           closeBtnInside: true,
           preloader: false,
   
           midClick: true,
           removalDelay: 300,
           mainClass: 'my-mfp-zoom-in'
       });
   
       $('.popup-with-move-anim').magnificPopup({
           type: 'inline',
   
           fixedContentPos: false,
           fixedBgPos: true,
   
           overflowY: 'auto',
   
           closeBtnInside: true,
           preloader: false,
   
           midClick: true,
           removalDelay: 300,
           mainClass: 'my-mfp-slide-bottom'
       });
   });
</script>
<!-- //magnific popup -->
<!-- owl carousel -->
<script src="<?php print base_url('assets/js/owl.carousel.js'); ?>"></script>
<!-- script for tesimonials carousel slider -->
<script>
   $(document).ready(function () {
       $("#owl-demo2").owlCarousel({
           loop: true,
           nav: false,
           margin: 50,
           responsiveClass: true,
           responsive: {
               0: {
                   items: 1,
                   nav: false
               },
               736: {
                   items: 1,
                   nav: false
               },
               991: {
                   items: 2,
                   margin: 30,
                   nav: false
               },
               1080: {
                   items: 2,
                   nav: false
               }
           }
       })
   })
</script>
<!-- //script for tesimonials carousel slider -->
<!-- owl carousel -->
<!-- theme switch js (light and dark)-->
<script src="<?php print base_url('assets/js/theme-change.js'); ?>"></script>
<script>
   function autoType(elementClass, typingSpeed) {
       var thhis = $(elementClass);
       thhis.css({
           "position": "relative",
           "display": "inline-block"
       });
       thhis.prepend('<div class="cursor" style="right: initial; left:0;"></div>');
       thhis = thhis.find(".text-js");
       var text = thhis.text().trim().split('');
       var amntOfChars = text.length;
       var newString = "";
       thhis.text("|");
       setTimeout(function () {
           thhis.css("opacity", 1);
           thhis.prev().removeAttr("style");
           thhis.text("");
           for (var i = 0; i < amntOfChars; i++) {
               (function (i, char) {
                   setTimeout(function () {
                       newString += char;
                       thhis.text(newString);
                   }, i * typingSpeed);
               })(i + 1, text[i]);
           }
       }, 1500);
   }
   
   $(document).ready(function () {
       // Now to start autoTyping just call the autoType function with the 
       // class of outer div
       // The second paramter is the speed between each letter is typed.   
       autoType(".type-js", 200);
   });
</script>
<!-- //theme switch js (light and dark)-->
<!-- MENU-JS -->
<script>
   $(window).on("scroll", function () {
       var scroll = $(window).scrollTop();
   
       if (scroll >= 80) {
           $("#site-header").addClass("nav-fixed");
       } else {
           $("#site-header").removeClass("nav-fixed");
       }
   });
   
   //Main navigation Active Class Add Remove
   $(".navbar-toggler").on("click", function () {
       $("header").toggleClass("active");
   });
   $(document).on("ready", function () {
       if ($(window).width() > 991) {
           $("header").removeClass("active");
       }
       $(window).on("resize", function () {
           if ($(window).width() > 991) {
               $("header").removeClass("active");
           }
       });
   });
</script>
<!-- //MENU-JS -->
<!-- disable body scroll which navbar is in active -->
<script>
   $(function () {
       $('.navbar-toggler').click(function () {
           $('body').toggleClass('noscroll');
       })
   });
</script>
<!-- //disable body scroll which navbar is in active -->
<!--bootstrap-->
<script src="<?php print base_url('assets/js/bootstrap.min.js'); ?>"></script>
<!-- //bootstrap-->
<!-- //Js scripts -->

<script type="text/javascript">
  $(function(){
    // this will get the full URL at the address bar
    var url = window.location.href; 

    // passes on every "a" tag 
    $("#navbar-nav a").each(function() {
            // checks if its the same on the address bar
        if(url == (this.href)) { 
            $(this).closest("li").addClass("active");
        }
    });
});
</script>
</body>
</html>