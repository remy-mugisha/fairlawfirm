<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="bracket-web">
    <meta name="description" content="Firdip is beautifully designed Figma template especially for the fire department, fireman, fire prevention, fire fighting, fire station, protection, firefighter and all other fire & safety business and websites.">

    <?php require_once 'include/header.php'; ?>
</head>

<body class="custom-cursor">
    <?php 
    require 'data/propertyMgt/config.php';

    // Validate and sanitize ID
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

    if ($id > 0) {
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM blog WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $blog = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($blog) {
    ?>
            <!-- Page Header Section -->
            <section class="page-header">
                <div class="page-header__bg" style="background-image: url(data/propertyMgt/blogImg/<?php echo htmlspecialchars($blog['image']); ?>);"></div>
                <div class="container">
                    <h2 class="page-header__title"><?php echo htmlspecialchars($blog['title']); ?></h2>
                    <ul class="firdip-breadcrumb list-unstyled">
                        <li><a href="welcome"><?= __('Home') ?></a></li>
                        <li><span><?= __('Blog') ?></span></li>
                    </ul>
                </div>
            </section>

            <!-- Blog Content Section -->
            <section class="blog-one blog-one--page">
                <div class="container">
                    <div class="row gutter-y-60">
                        <div class="col-lg-12">
                            <div class="blog-details">
                                <div class="blog-card__two">
                                    <div class="blog-card__two__image">
                                        <img src="data/propertyMgt/blogImg/<?php echo htmlspecialchars($blog['image']); ?>" alt="Blog Image" height="450px" width="100%">
                                        <p class="blog-card-two__date"><?php echo htmlspecialchars($blog['date']); ?></p>
                                    </div>
                                    <div class="blog-card-two__content">
                                        <p class="blog-card__two__text"><?php echo nl2br(htmlspecialchars($blog['blog_description_details'])); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="sidebar">
                                <aside class="widget-area">
                                    <div class="sidebar__single wow fadeInUp" data-wow-delay="300ms">
                                        <h4 class="sidebar__title">Category</h4>
                                        <ul class="sidebar__categories list-unstyled">
                                            <li class="sidebar__categories__item">
                                                <a><?php echo htmlspecialchars($blog['category_blog']); ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </aside>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    <?php
        } else {
            echo "<p style='text-align: center; color: red;'>No blog post found!</p>";
        }
    } else {
        echo "<p style='text-align: center; color: red;'>Invalid blog ID!</p>";
    }
    ?>

    <?php require_once 'include/footer.php'; ?>
</body>

</html>