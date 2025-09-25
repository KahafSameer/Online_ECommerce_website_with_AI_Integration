<?php
   if(isset($message)){
      foreach($message as $msg){
         echo '
         <div class="message" style="background:#f8d7da; color:#721c24; padding:10px 20px; border-radius:5px; margin:10px 15px; position:relative;">
            <span>'.$msg.'</span>
            <i class="fas fa-times" style="position:absolute; top:8px; right:12px; cursor:pointer;" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<header class="header">

   <section class="flex">

      <a href="home.php" class="logo">Momal<span>.Com</span></a>

      <nav class="navbar">
         <a href="home.php">Home</a>
         <a href="about.php">About Us</a>
         <a href="orders.php">Orders</a>
         <a href="shop.php">Shop Now</a>
         <a href="contact.php">Contact Us</a>
      </nav>

      <div class="icons" style="display: flex; align-items: center; gap: 15px;">
         <?php
            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wishlist_items->execute([$user_id]);
            $total_wishlist_counts = $count_wishlist_items->rowCount();

            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount();
         ?>
         <div id="menu-btn" class="fas fa-bars"></div>
         <a href="search_page.php"><i class="fas fa-search"></i> Search</a>
         <a href="wishlist.php"><i class="fas fa-heart"></i> <span>(<?= $total_wishlist_counts; ?>)</span></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i> <span>(<?= $total_cart_counts; ?>)</span></a>
         <a href="#" onclick="goToChatbot()" style="color: #007bff; font-weight: 500;"><i class="fas fa-robot"></i> AI</a>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile" style="margin-top: 20px;">
         <?php          
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p style="font-weight: bold; font-size: 16px;"><?= $fetch_profile["name"]; ?></p>
         <a href="update_user.php" class="btn">Update Profile</a>
         <div class="flex-btn" style="margin-top: 10px;">
            <a href="user_register.php" class="option-btn">Register</a>
            <a href="user_login.php" class="option-btn">Login</a>
         </div>
         <a href="components/user_logout.php" class="delete-btn" onclick="return confirm('Logout from the website?');" style="margin-top: 10px;">Logout</a> 
         <?php
            } else {
         ?>
         <p>Please login or register first to proceed!</p>
         <div class="flex-btn" style="margin-top: 10px;">
            <a href="user_register.php" class="option-btn">Register</a>
            <a href="user_login.php" class="option-btn">Login</a>
         </div>
         <?php
            }
         ?>      
      </div>

   </section>

<script>
function goToChatbot() {
    window.location.href = "/projectdone/AI-Chatbot-with-PHP/";
}
</script>
</header>
