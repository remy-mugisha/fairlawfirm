<!DOCTYPE html>
<!-- language -->
<html lang="en">


<!-- Mirrored from bracketweb.com/firdip-html/contact.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 01 Jun 2024 09:53:13 GMT -->
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

<body>
    
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url(assets/images/backgrounds/background1-1.jpg);"></div>
            <div class="container">
                <h2 class="page-header__title">Contact</h2>
                <ul class="firdip-breadcrumb list-unstyled">
                    <li><a href="welcome">Home</a></li>
                    <li><span>Contact</span></li>
                </ul>
            </div>
        </section>

        <!-- Contact Section Start -->
        <section class="contact-one">
            <div class="container">
                <div class="col-12">
                    <div class="contact-one__top">
                        <div class="sec-title text-center wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='000ms'>
                            <h3 class="sec-title__title">Feel Free to Write <br> us Anytime</h3>
                        </div>
                    </div>
                    <form class="contact-one__form contact-form-validated form-one wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='300ms' action="https://bracketweb.com/firdip-html/inc/sendemail.php">
                        <div class="form-one__group">
                            <div class="form-one__control">
                                <input type="text" name="name" placeholder="Your Name">
                            </div>
                            <div class="form-one__control">
                                <input type="email" name="email" placeholder="Email Address">
                            </div>
                            <div class="form-one__control">
                                <input type="text" name="phone" placeholder="Phone">
                            </div>
                            <div class="form-one__control">
                                <input type="text" name="subject" placeholder="Subject">
                            </div>
                            <div class="form-one__control form-one__control--full">
                                <textarea name="message" placeholder="Write a Message"></textarea>
                            </div>
                            <div class="form-one__control text-center form-one__control--full">
                                <button type="submit" class="firdip-btn firdip-btn--base">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- Contact Section end -->
        



</body>
<?php 
        require_once 'include/footer.php';
        ?>
</html>