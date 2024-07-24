<!DOCTYPE html>
<!-- language -->
<html lang="en">


<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="bracket-web">
    <meta name="description" content="Firdip is beautifully designed Figma template especially for the fire department, fireman, fire prevention, fire fighting, fire station, protection, firefighter and all other fire & safety business and websites.">
<?php
require_once 'include/header.php';
?>
   
</head>

<body class="custom-cursor">
<?php
        require 'propertyMgt/conn.php'; 
        $selectAllUsers = $db->prepare("SELECT * FROM blog  WHERE id = '".$_GET['id']."' ");
        $selectAllUsers->execute();
        if ($row = $selectAllUsers->fetch()) {
        ?>

        <section class="page-header">
            <div class="page-header__bg" style="background-image: url(propertyMgt/blogImg/<?php echo $row['img'];?>);"></div>
            <div class="container">
                <h2 class="page-header__title"><?php echo $row['title'];?></h2>
                <ul class="firdip-breadcrumb list-unstyled">
                    <li><a href="welcome"><?= __('Home')?></a></li>
                    <li><span><?= __('Blog')?></span></li>
                </ul>
            </div>
        </section>
<?php }
        ?>

        <section class="blog-one blog-one--page">
            <div class="container">
                <div class="row gutter-y-60">
                    <div class="col-lg-8">
                        <div class="blog-details">
                            <div class="blog-card__two">
                                <div class="blog-card__two__image">
                                    <img src="propertyMgt/blogImg/<?php echo $row['img'];?>" 
                                    alt="firdip image" height="450px" width="100%">
                                    <p class="blog-card-two__date"><?php echo $row['date'];?></p>
                                </div>
                                <div class="blog-card-two__content">
                                    <ul class="list-unstyled blog-card-two__meta">
                                    </ul>
                                    <p class="blog-card__two__text"><?php echo $row['blog_description_details'];?></p>
                                    <p class="blog-card__two__text"><?php echo $row['blog_description_details'];?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="sidebar">
                            <aside class="widget-area">
                                <div class="sidebar__single wow fadeInUp" data-wow-delay='300ms'>
                                    <h4 class="sidebar__title">Category</h4>
                                    <ul class="sidebar__categories list-unstyled">
                                        <li class="sidebar__categories__item"><a ><?php echo $row['category_blog'];?></a></li>
                                    </ul>
                                </div>
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
        </section>

</body>
<?php
require_once 'include/footer.php';
?>

</html>