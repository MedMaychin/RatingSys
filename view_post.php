<?php
include 'components/connect.php';

if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location:all_posts.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIEW POST</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include 'components/header.php' ?>


    <!--  -->

    <section class="view-post">
        <div class="heading">
            <h1>Post Details</h1>
            <a href="all_posts.php" class="inline-option-btn" style="margin-top: 0;">All Posts</a>
        </div>


        <?php

        $select_post = $conn->prepare("SELECT * FROM `posts` WHERE id = ? LIMIT 1");
        $select_post->execute([$get_id]);


        if ($select_post->rowCount() > 0) {
            while ($fetch_post = $select_post->fetch(PDO::FETCH_ASSOC)) {

                $total_ratings = 0;
                $rating_1 = 0;
                $rating_2 = 0;
                $rating_3 = 0;
                $rating_4 = 0;
                $rating_5 = 0;

                $select_ratings = $conn->prepare("SELECT * FROM `reviews` WHERE post_id = ?  ");
                $select_ratings->execute([$fetch_post['id']]);
                $total_reviews = $select_ratings->rowCount();

                while ($fetch_rating = $select_ratings->fetch(PDO::FETCH_ASSOC)) {
                    $total_ratings += $fetch_rating['rating'];

                    if ($fetch_rating['rating'] == 1) {
                        $rating_1 += $fetch_rating['rating'];
                    }
                    if ($fetch_rating['rating'] == 2) {
                        $rating_2 += $fetch_rating['rating'];
                    }
                    if ($fetch_rating['rating'] == 3) {
                        $rating_3 += $fetch_rating['rating'];
                    }
                    if ($fetch_rating['rating'] == 4) {
                        $rating_4 += $fetch_rating['rating'];
                    }
                    if ($fetch_rating['rating'] == 5) {
                        $rating_5 += $fetch_rating['rating'];
                    }
                }


                if ($total_reviews != 0) {
                    $average = round($total_ratings / $total_reviews, 1);
                } else {
                    $average = 0;
                }
        ?>
                <div class="row">
                    <div class="col">
                        <img src="uploaded_files/<?= $fetch_post['image']; ?>" alt="" class="image">
                        <h3 class="title"><?= $fetch_post['title']; ?></h3>
                    </div>
                    <div class="col">
                        <div class="flex">
                            <div class="total-reviews">
                                <h3 class=" "><?= $average; ?>
                                    <i class="fas fa-star"></i>
                                </h3>
                                <p><?= $total_reviews; ?> average review</p>
                            </div>
                            <div class="total-ratings">
                                <p>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span><?= $rating_5; ?></span>
                                </p>
                                <p>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span><?= $rating_4; ?></span>
                                </p>
                                <p>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span><?= $rating_3; ?></span>
                                </p>
                                <p>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span><?= $rating_2; ?></span>
                                </p>
                                <p>
                                    <i class="fas fa-star"></i>
                                    <span><?= $rating_1; ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo '<p class="empty">No post found</p>';
        }


        ?>
    </section>


    <!--  -->

    <div class="reviews-container">
        <div class="heading">
            <h1>user's reviews</h1>
            <a href="add_review.php?get_id=<?= $get_id; ?>" class="inline-btn" style="margin-top: 0;">Add Reviews</a>
        </div>
    </div>





    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="js/script.js"></script>

    <?php
    include 'components/alers.php';
    ?>
</body>

</html>