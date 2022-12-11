<!DOCTYPE html>
<html lang="en">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <link rel="stylesheet" href="./assets/css/index-nav-slider.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </head>
</head>
<body>
  <div  class="nav-first">    
    <ul class="ul-log">
        <li class="login-btn"><a href="login.php"> Login</a> </li>
        <li class="login-btn"><a href="Register.php"> Register</a> </li>
    </ul>     
</div>

 <header class="header">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="logo">
               <a>
                <img src="#" alt=""class="log1">
                ayurHub</a>
            </div>
            <button type="button" class="nav-toggler">
               <span></span>
            </button>
            <nav class="nav">
               <ul>
                  <li><a href="#" class="active">home</a></li>
                  <li><a href="#">treatment</a></li>
                  <li><a href="package.php">packages</a></li>
                  <li><a href="about doctor.html">about doctor</a></li>
                  <li><a href="#">about ayurveda</a></li>
                  <li><a href="#">about panchakarama</a></li>
                  <li class="mi"><a href="#">book appointment</a></li>
               </ul>
            </nav> 
        </div>
    </div>
 </header>
 <center>
   <div class="slider">
       <div class="imgs_slides">

           <!-- Radio buttons start -->
           <input type="radio" name="radio-btn" id="radio1" />

           <input type="radio" name="radio-btn" id="radio2" />

           <input type="radio" name="radio-btn" id="radio3" />

           <input type="radio" name="radio-btn" id="radio4" />

           <!-- Radio buttons end -->
           <!-- Embedding  images start -->
           <div class="first slide">
               <img src="img7.jpg" />
           </div>
           <div class="slide">
               <img src="img7.jpg" />
           </div>
           <div class="slide">
               <img src="img7.jpg" />
           </div>
           <div class="slide">
               <img src="img7.jpg" />
           </div>
           <script type="text/javascript">
               var counter = 1;
               setInterval(function(){
                 document.getElementById('radio' + counter).checked = true;
                 counter++;
                 if(counter > 4){
                   counter = 1;
                 }
               }, 5000);
               </script>
           <!-- Embedding images end -->
       </div>

       <!-- Navigation start -->
       <div class="navigation">
           <label for="radio1" class="navigation-btn">
           </label>
           <label for="radio2" class="navigation-btn">
           </label>
           <label for="radio3" class="navigation-btn">
           </label>
           <label for="radio4" class="navigation-btn">
           </label>
       </div>
       <!-- Navigation end -->
   </div>
</center>
 <footer>
   <div class="main-content">
     <div class="left box">
       <h2>About us</h2>
       <div class="content">
         <p>my name is gawas. yow how many hto hanwl nahjs hskskbhx ajhskk hhskxks. jbsj jhabsjb shbhsbk jsnjsnkl jnjnd hbsefc janwddkna jndjnaej janwjnd  jwdnajwndw jwndkwndknw jawndjnwj.</p>
         <div class="social">
           <a href="https://facebook.com/coding.np"><span class="fab fa-facebook-f"></span></a>
           <a href="#"><span class="fa fa-map-marker-alt"></span></a>
           <a href="https://instagram.com/coding.np"><span class="fab fa-instagram"></span></a>
           <a href="https://youtube.com/c/codingnepal"><span class="fab fa-youtube"></span></a>
         </div>
       </div>
     </div>

     <div class="center box">
       <h2>Address</h2>
       <div class="content">
         <div class="place">
           <span class="fas fa-map-marker-alt"><a href="#"></a></span>
           <span class="text">Sidhivinayak Apartment, Shivajinagar,Kudal    </span>
         </div>
         <div class="phone">
           <span class="fas fa-phone-alt"></span>
           <span class="text">+91-8254325805</span>
         </div>
         <div class="email">
           <span class="fas fa-envelope"></span>
           <span class="text">avirajgawas@gmail.com</span>
         </div>
       </div>
     </div>

     <div class="right box">
       <h2>Contact us</h2>
       <div class="content">
        <a class="avi">
          <span class="fa fa-envelope"> </span>
        </a>
         
  
 </footer>
</body>
</html>
 
 
<script src="script.js"></script>
</body>
</html>
