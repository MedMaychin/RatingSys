<header class="header">

   <section class="flex">

      <a href="all_posts.php" class="logo">Logo.</a>

      <nav class="navbar">

         <?php
         if ($user_id != '') {
         ?>
            <a href="all_posts.php" class="far fa-eye"></a>
            <div id="user-btn" class="far fa-user"></div>
         <?php } else { ?>
            <a href="login.php" class="fas fa-arrow-right-to-bracket"></a>
            <a href="register.php" class="far fa-registered"></a>
         <?php }; ?>
      </nav>

      <?php
      if ($user_id != '') {
      ?>
         <div class="profile">
            <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
            $select_profile->execute([$user_id]);
            if ($select_profile->rowCount() > 0) {
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>

               <?php if ($fetch_profile['name'] != '') { ?>
                  <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="" class="image">
               <?php }; ?> <p><?= $fetch_profile['name']; ?></p>

               <a href="update.php" class="btn">update profile</a>

               <a href="components/logout.php" class="delete-btn" onclick="return confirm('logout from this website?');">logout</a>
            <?php } else { ?>
               <div class="flex-btn">
                  <p>please login or register!</p>
                  <a href="login.php" class="inline-option-btn">login</a>
                  <a href="register.php" class="inline-option-btn">register</a>
               </div>
            <?php }; ?>
         </div>
      <?php }; ?>

   </section>

</header>