<!DOCTYPE html>
<html lang="en">


<head>
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

    <div class="page-wrapper">

        <section class="page-header">
        <div class="page-header__bg" style="background-color: #1a2f24"></div>
            <!-- <div class="page-header__bg" style="background-image: url(assets/images/backgrounds/background1-1.jpg);"></div> -->
            <div class="container">
                <h2 class="page-header__title"><?= __('Blog')?></h2>
                <ul class="firdip-breadcrumb list-unstyled">
                    <li><a href="welcome"><?= __('Home')?></a></li>
                    <li><span><?= __('Blog')?></span></li>
                </ul>
            </div>
        </section>



        <!-- Blog Section Start -->
        <section class="blog-one blog-one--page">
            <div class="container">
          
          
            <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
        require 'propertyMgt/conn.php';
                    $selectAllUsers = $db->prepare("SELECT *FROM blog");
                    $selectAllUsers->execute();
                    if ($row = $selectAllUsers->fetch()) {
                        ?>
            <?php
            do{
              ?>
                    <div class="col">
                        <div class="card">
                            <img src="propertyMgt/blogImg/<?php echo $row['img']?>" 
                            class="card-img-top" alt="...">
                            <div class="card-body">
                                <h6 class="about-two__top__text"><?php echo $row['date']?></h6>
                                <a href="blog_details?id=<?php echo $row['id'];?>"><h5 class="feature-one__item__title"><?php echo $row['title']?></h5></a>    
                                <a href="blog_details?id=<?php echo $row['id'];?>"><button type="submit" name="submit" style="color: white; font-size: 12px;padding: 10px 40px 10px 40px; margin-top:10px;">Read More</button></a> 
                            </div>
                        </div>
                    </div>
                 

                    <?php
                }while($row = $selectAllUsers->fetch());
            ?>
                  <?php
                    }
                    else{ 
                    }
                ?>

                </div>
            </div>
        </section>
  
        <!-- Blog Section End -->


</body>

<?php 
require_once 'include/footer.php';
?>

</html>