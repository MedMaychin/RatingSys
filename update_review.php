<?php
include 'components/connect.php';

if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location:all_posts.php');
}

if (isset($_POST['submit']) !=  '') {
    if ($user_id !=  '') {
        $id = create_unique_id();
        $title = $_POST['title'];
        $title = filter_var($title,  FILTER_SANITIZE_STRING);
        $description = $_POST['description'];
        $description = filter_var($description,  FILTER_SANITIZE_STRING);
        $rating = $_POST['rating'];
        $rating = filter_var($rating,  FILTER_SANITIZE_STRING);

        $verify_review = $conn->prepare("SELECT * FROM `reviews` WHERE post_id = ? AND user_id = ?");
        $verify_review->execute([$get_id, $user_id]);

        if ($verify_review->rowCount() > 0) {
            $warning_msg[] = 'Your review already Added!';
        } else {
            $add_review = $conn->prepare("INSERT INTO `reviews`(id,post_id,user_id,rating,title,description) VALUES(?,?,?,?,?,?)");
            $add_review->execute([$id, $get_id, $user_id, $rating, $title, $description]);

            $success_msg[] = 'Review Added!';
        }
    } else {
        $warning_msg[] = 'Please Login First!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPDATE REVIEW</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include 'components/header.php' ?>


    <?php

    $select_review = $conn->prepare("SELECT * FROM `reviews` WHERE id = ? LIMIT 1");
    $select_review->execute([$get_id]);

    if ($select_review->rowCount() > 0) {
        while ($fetch_review = $select_review->fetch(PDO::FETCH_ASSOC)) {
    ?>
            <section class="account-form">
                <form action="" method="post">
                    <h3>Edit your review</h3>
                    <p class="palceholder">Review Title <span>*</span> </p>
                    <input type="text" name="title" class="box" maxlength="50" placeholder="entre review title" required value="<?= $fetch_review['title']; ?>">
                    <p class="placeholder">Review description</p>
                    <textarea name="description" cols="30" rows="10" class="box" maxlength="1000" placeholder="entre review description">
                        <?= $fetch_review['description']; ?> 
                    </textarea>
                    <p class="placeholder">Review rating <span>*</span></p>
                    <input type="text" class="box" readonly value="<?= $fetch_review['rating']; ?>">
                    <select name="rating" class="box" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <input type="submit" value="update review" name="submit" class="btn">
                    <a href="view_post.php?get_id=<?= $fetch_review['post_id']; ?>" class="option-btn">Go Back</a>
                </form>
            </section>

    <?php
        }
    } else {
        echo '<p class="empty">somthing wrong!!!!</p>';
    }
    ?>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="js/script.js"></script>

    <?php
    include 'components/alers.php';
    ?>
</body>

</html>