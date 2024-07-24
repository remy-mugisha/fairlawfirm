<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="bracket-web">
    <meta name="description" content="Firdip is beautifully designed Figma template especially for the fire department, fireman, fire prevention, fire fighting, fire station, protection, firefighter and all other fire & safety business and websites.">

    <title>Fair Law Firm LTD</title>

    <?php 
    require_once 'include/header.php';
    ?>
</head>
<body>
        <!-- Hero Section Start -->
        <section class="main-slider-one">
            <div class="main-slider-one__carousel firdip-owl__carousel owl-carousel" data-owl-options='{
		"loop": true,
		"animateOut": "fadeOut",
		"animateIn": "fadeIn",
		"items": 1,
		"autoplay": true,
		"autoplayTimeout": 7000,
		"smartSpeed": 1000,
		"nav": false,
		"dots": true,
		"margin": 0
	    }'>
                <div class="item">
                    <div class="main-slider-one__item">
                        <div class="main-slider-one__bg" style="background-image: url(assets/images/backgrounds/flyer_fair_law_2.jpg);"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="main-slider-one__content">
                                        <h2 class="main-slider-one__title"><?= __('Propert Management & Legal Services')?></h2>
                                        <div class="main-slider-one__btn"><a href="contact" class="firdip-btn main-slider-one__btn__link"><?= __('Contact Us')?></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="main-slider-one__item">
                        <div class="main-slider-one__bg" style="background-image: url(assets/images/backgrounds/flyer_fair_law_3.jpg);"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="main-slider-one__content">
                                        <h2 class="main-slider-one__title"><?= __('Propert Management & Legal Services')?></h2>
                                        <div class="main-slider-one__btn"> <a href="contact" class="firdip-btn main-slider-one__btn__link"><?= __('Contact Us')?></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="main-slider-one__item">
                        <div class="main-slider-one__bg" style="background-image: url(assets/images/backgrounds/flyer_fair_law_1.jpg);"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="main-slider-one__content">
                                        <h2 class="main-slider-one__title"><?= __('Propert Management & Legal Services')?></h2>
                                        <div class="main-slider-one__btn"> <a href="contact" class="firdip-btn main-slider-one__btn__link"><?= __('Contact Us')?></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Hero Section Start -->
        <!-- About Section Start -->
        <section class="about-one">
            <div class="container">
                <div class="row gutter-y-30">
                    <div class="col-lg-6">
                        <div class="about-one__left">
                            <div class="about-one__thumb wow fadeInLeft" data-wow-duration='1500ms' data-wow-delay='300ms'>
                                <div class="about-one__thumb__item about-one__thumb__item--one">
                                    <img src="assets/images/about/nyirabyo-1-1.png" alt="firdip image">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-one__right" style="padding-top:30px;">
                            <div class="about-one__top">
                                <div class="sec-title  wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='000ms'>
                                    <h3 class="sec-title__title"><?= __('About Fair Law Firm LTD')?> </h3>
                                </div>
                                <p><?= __('Fair Law Firm Ltd, a Rwandan company founded in 2021, provides a full range of legal services and property management solutions. They offer court representation, mediation, business transaction facilitation, contract drafting, and legal advice across various fields.')?>  </p>
                                 <p> <?= __('In property management, they handle rental contracts, marketing, rental profit maximization, compliance with administrative directives, tax payments, rent recovery, and sales transactions. Their goal is to make accessible legal services and property management services to their clients.')?> </p>
                            </div>

                            <div class="about-one__list">
                                <div class="row gutter-y-30">
                                    <div class="col-md-7">
                                        <div class="about-one__list__left wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='300ms'>

                                            <div class="about-one__list__btn">
                                            <a href="about_us"><button type="submit" name="submit" style="color: white; font-size: 12px;padding: 10px 40px 10px 40px; margin-top:10px;"><?= __('Discover More')?></button></a> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About Section End -->

        <section class="feature-one">
            <div class="container">
<div class="row">
  <div class="col-sm-6 mb-3 mb-sm-0">
    <div class="card">
      <div class="card-body">
        <h5 class="feature-one__item__title"><?= __('Mission')?></h5>
        <p class="feature-one__item__text"><?= __('For legal services, we provide timely our services in professionalism. For property management, we ensure excellent maintenance and maximize profits.')?></p>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="feature-one__item__title"><?= __('Vision')?></h5>
        <p class="feature-one__item__text"><?= __('Our goal is to enable our clients to access professional and trustworthy services on a global scale.')?></p>
      </div>
    </div>
  </div>
</div>
</div>
    </section>

         <!-- Feature Section Start -->
        <section class="feature-one">
            <div class="service-page__bg" style="background-image: url(assets/images/shapes/service-1-1.png);"></div>
            <div class="container">
                <div class="sec-title  text-center wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='000ms'>
                    <h3 class="sec-title__title" style="color:white; padding-top:30px;"><?= __('Services')?> </h3>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="legal_services"><button type="submit" name="submit" style="color: white; font-size: 12px;padding: 10px 40px 10px 40px; margin-top:10px;"><?= __('All')?>&nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i></button></a> 
                    </div>
                </div>
                <div class="row gutter-y-30" style="padding-bottom: 30px">
                    <div class="col-lg-4 col-md-4">
                        <div class="feature-one__item wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='300ms'>
                            <div class="feature-one__item__icon">
                            </div>
                            <h4 class="feature-one__item__title"><?= __('MARKETING AND ADVISES')?></h4>
                            <p class="feature-one__item__text"><?= __('We help our partners to promote their products and services; to find customers and offer them services through our social and commercial media, so that they can maximize the profit.')?></p><br>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="feature-one__item wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='500ms'>
                            <div class="feature-one__item__icon">
                            </div>
                            <h4 class="feature-one__item__title"><?= __('legal Representation')?></h4>
                            <p class="feature-one__item__text"><?= __('In penal, civil, commercial, social and administrative litigations; we go through consultancy, advices, mandate of filing the case and representation or assistance before court or administrative entities.')?></p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="feature-one__item wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='700ms'>
                            <div class="feature-one__item__icon">
                            </div>
                            <h4 class="feature-one__item__title"><?= __('Legal advises in various professional fields')?> </h4>
                            <p class="feature-one__item__text"> <?= __('In this world governed by intricate laws and regulations, professional legal advice serves as a guiding light, protecting individual rights, resolving disputes and so on. We provide advice in civil and business field')?> </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--end of feature section-->
        

        <!--Cta Section Start -->
        <section class="cta-one">
            <div class="cta-one__bg jarallax" data-jarallax data-speed="0.3" data-imgPosition="50% -100%" style="background-image: url(assets/images/backgrounds/3-1.jpg);"></div>
            <div class="container">
                <div class="row align-items-center gutter-x-0">
                    <div class="col-lg-7">
                        <div class="cta-one__left">
                            <div class="cta-one__inner">
                                <div class="cta-one__content wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='300ms'>
                                    <h2 class="cta-one__content__title"><?= __('Talk to us')?>  </h2>
                                    <p class="cta-one__content__text"><?= __('Contact us for help with legal issues and efficient management of property rentals and sales.')?></p>
                                    <a href="contact"><button type="submit" name="submit" style="color: white; font-size: 12px;padding: 10px 40px 10px 40px; margin-top:10px;"><?= __('Get in Touch')?></button></a> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="cta-one__left">
                            <div class="cta-one__video">
                                <a href="" class="cta-one__video__icon video_play video-popup">
                                    <i class="icon-polygon"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Cta Section End -->

             <?php
        require 'propertyMgt/conn.php';
                    $selectAllUsers = $db->prepare("SELECT description_blog, img,date,id,title FROM blog LIMIT 3");
                    $selectAllUsers->execute();
                    if ($row = $selectAllUsers->fetch()) {
              
                        ?>

        <!-- Blog Section Start -->
        <!-- <section class="blog-one blog-one--page">
            <div class="container">
            <div class="sec-title  text-center wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='000ms'>
                    <h3 class="sec-title__title"><= __('Blog')?></h3>
                </div> 
                <div class="row row-cols-1 row-cols-md-3 g-4">
                <php
            do{
             ?>
                    <div class="col">
                        <div class="card">
                            <img src="propertyMgt/blogImg/<php echo $row['img']?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h6 class="about-two__top__text"><php echo $row['date']?></h6>
                                <a href="blog_details?id=<php echo $row['id'];?>"><h5 class="feature-one__item__title"><?php echo $row['title']?></h5></a>    
                                <p class="about-two__top__text"><php echo $row["description_blog"];?></p>
                                <a href="blog_details?id=<php echo $row['id'];?>"><button type="submit" name="submit" style="color: white; font-size: 12px;
                                padding: 10px 40px 10px 40px; margin-top:10px;"><= __('Read More')?></button></a> 
                            </div>
                        </div>
                    </div>
                    <php
                }while($row = $selectAllUsers->fetch());
            ?>
                </div>
             
            </div>
        </section> -->
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

       