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

    <!-- Custom Cursor -->
    
        <section class="page-header">
        <div class="page-header__bg" style="background-color: #1a2f24"></div>
            <!-- <div class="page-header__bg" style="background-image: url(assets/images/backgrounds/background1-1.jpg);"></div> -->
            <div class="container">
                <h2 class="page-header__title"><?= __('REAL ESTATE PROPERTIES')?></h2>
                <ul class="firdip-breadcrumb list-unstyled">
                    <li><a href="welcome"><?= __('Home')?></a></li>
                    <li><span><?= __('service')?></span></li>
                </ul>   
            </div>
        </section>

             <?php
        require 'propertyMgt/conn.php';
                    $selectAllUsers = $db->prepare("SELECT *FROM manage_property ");
                    $selectAllUsers->execute();
                    if ($row = $selectAllUsers->fetch()) {
                        ?>
        <section class="blog-one blog-one--page">
            <div class="container">
                <div class="row gutter-y-30">

                <?php
            do{
              ?>

            
                    <div class="col-md-6 col-lg-4">
                        <div class="blog-card wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='000ms'>
                            <a href="property_detail?id=<?php echo $row['id'];?>" class="blog-card__image">
                                <img src="propertyMgt/propertyImg/<?php echo $row['image'];?>" alt="Elevating Heroism Apeium Eques in the Fire Service">
                            </a>

                            <div class="blog-card__three__content">
                                <ul class="list-unstyled blog-card__three__meta">
                                    <li class="blog-card__three__meta__item">
                                    <i class="icon-pin2" style="color: #198754;"></i>
                                    <a href="property_detail?id=<?php echo $row['id'];?>"><?php echo $row["title"]?></a> 
                                    </li>
                                    <p class="blog-card__date"><?php echo $row["property_status"];?></p>

                                </ul>
                                <ul class="list-unstyled blog-card__three__meta">
                                    <li class="blog-card__three__meta__item"><?php echo $row["price"];?>/ Month &nbsp;&nbsp;&nbsp; || &nbsp;&nbsp;&nbsp; <?php echo $row["bedroom"];?> Beds / <?php echo $row["bathroom"];?> Bathrooms</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php
                }while($row = $selectAllUsers->fetch());
            ?>

                </div>
            </div>

        </section>
        <?php
                    }
                    else{ 
                    }
                ?>

 

</body>

<?php 
        require_once 'include/footer.php';
        ?>

</html>