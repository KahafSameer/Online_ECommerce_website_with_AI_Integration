<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About | Momal eCommerce</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/23.png" alt="">
      </div>

      <div class="content">
         <h3>Developer's Message:</h3>

         <p class="lead">Hey There! I'm <strong>Wajeeha Batool</strong>, a BSCS student at University of Sahiwal (Batch: 2021-25). I love designing web apps and exploring new things. Learning is my hobby!</p>
      <p>I would like to thank <a href="https://www.facebook.com/er.ashokbasnet" target="_blank" class="text-decoration-underline text-warning">Umer Daraz</a> Sir for guiding me and making me able to develop projects like this.</p>
      <a href="contact.php" class="btn btn-custom mt-3"><i class="fas fa-envelope"></i> Contact Us</a>
      </div>

   </div>

</section>

<section class="reviews">
   
   <h1 class="heading">Client's Reviews.</h1>

   <div class="swiper reviews-slider">

   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <img src="images/pic-5.jpg" alt="">
          <p>Been using their services for quite a bit and have never had an issue with the quality of their products. Online e-products working great as well. Only issue I have is they usually deliver when I'm a little caught up, though I've set a preferred delivery time. Everything else has been good.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3> <a href="https://www.facebook.com/profile.php?id=100083292714419" target="_blank">Tayyaba Fatima</a></h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-1.jpg" alt="">
         <p>IIt is the first online service in Sahiwal which we can trust completely. I always unbox making a video and instantly complain if there's anything wrong. Sometimes even don't need to return the item and they process the refund. Momal do heavy fine to sellers who send wrong products, that's why its platform is getting better day by day.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3><a href="https://www.facebook.com/share/1BAi1UmDU7/?mibextid=wwXIfr" target="_blank">Ahmad Raza</a></h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-3.jpg" alt="">
         <p>Momal is great if you choose good sellers. A variety of required items available. Customers can return and refund full amount within 7 days easily. Momal is boosting eCommerce business in Punjab. It provides great opportunity to sell items online with ease.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3><a href="https://www.facebook.com/kaushalsah135790" target="_blank">Kaushal Shah</a></h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-7.jpg" alt="">
         <p>Using Momal for online shopping from almost 3 years. Outstanding experience with them. Game vouchers and pick up point as delivery with 0 shipping charges are super saving services.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3><a href="https://www.facebook.com/fuccheekta.moh.1" target="_blank">Mubashir Shahmeer</a></h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-2.jpg" alt="">
         <p>have been using their services for the last 2 years and I have found them extremely reliable. Their return policy gives you an extra layer of reliance and peace of mind. If the product doesn't meet your expectations or if there is any fault, you can return the product within seven days from the date of delivery.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3><a href="https://www.facebook.com/ranjitchaudhary159" target="_blank">Chaudhary Bilawal</a></h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-6.jpg" alt="">
         <p>Momal is cool! I have ordered hundreds of products from it and never got any scam. It delivers products in time without delay. Packaging of products is strong and delivery rates are too low. Just amazing website, will keep shopping from Momal.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3><a href="https://www.facebook.com/pra.x.nil"  target="_blank">Mirza Afham</a></h3>
      </div>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>









<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
        slidesPerView:1,
      },
      768: {
        slidesPerView: 2,
      },
      991: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>