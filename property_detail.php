
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
     <?php
        require 'data/propertyMgt/config.php'; 
        $selectAllUsers = $conn->prepare("SELECT * FROM properties  WHERE id = '".$_GET['id']."' ");
        $selectAllUsers->execute();
        if ($row = $selectAllUsers->fetch()) {
        ?> 
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url(data/propertyMgt/propertyImg/<?php echo $row['image'];?>);"></div>
            <div class="container">
                <h2 class="page-header__title"><?php echo $row['title'];?></h2>
                <ul class="firdip-breadcrumb list-unstyled">
                    <li><a href="welcome">Home</a></li>
                    <li><span>Service</span></li>
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
                                    <img src="data/propertyMgt/propertyImg/<?php echo $row['image']?>" alt="firdip image" height="460px" width="100%">
                                </div>

                                <div class="blog-card-two__content">
                                    <ul class="list-unstyled blog-card-two__meta">
                                    </ul>
                                    <h3 class="blog-card-two__title">Description</h3>
                                    <p class="blog-card__two__text"><?php echo $row['description']?> </p>
                                </div>
                                <table class="table caption-top">
  <h5>Details</h5>
  <tbody>
    <tr>
      <th scope="row" >Property Id:</th>
      <td><p class="feature-one__item__text"><?php echo $row['property_id']?></p></td>
      
    </tr>
    <tr>
      <th scope="row">Property Status:</th>
      <td><p class="feature-one__item__text"><?php echo $row['property_status']?></p></td>
      
    </tr>
    <tr>
      <th scope="row">Property type:</th>
      <td><p class="feature-one__item__text"><?php echo $row['property_type']?></p></td>
      
    </tr>
    <tr>
      <th scope="row">Price:</th>
      <td><p class="feature-one__item__text"><?php echo $row['price']?></p></td>
     
    </tr>
    <tr>
      <th scope="row">Property Size:</th>
      <td><p class="feature-one__item__text"><?php echo $row['property_size']?></p></td>
      
    </tr>
    <tr>
      <th scope="row">Bedrooms:</th>
      <td><p class="feature-one__item__text"><?php echo $row['bedroom']?></p></td>
      
    </tr>
    <tr>
      <th scope="row">Bathrooms:</th>
      <td><p class="feature-one__item__text"><?php echo $row['bathroom']?></p></td>
      
    </tr>
  </tbody>
</table><br>
<table class="table caption-top">
  <h5>Address</h5>
  <tbody>
    <tr>
      <th scope="row" >Street:</th>
      <td><p class="feature-one__item__text"><?php echo $row['street']?></p></td>
      
    </tr>
    <tr>
      <th scope="row">Sector:</th>
      <td><p class="feature-one__item__text"><?php echo $row['sector']?></p></td>
      
    </tr>
    <tr>
      <th scope="row">District:</th>
      <td><p class="feature-one__item__text"><?php echo $row['district']?></p></td>
      
    </tr>
    <tr>
      <th scope="row">Country:</th>
      <td><p class="feature-one__item__text"><?php echo $row['country']?></p></td>
      
    </tr>
  </tbody>
</table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="sidebar">


                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5>Help Center</h5><br>
                                <li class="sidebar__comments__item">
                                     <div class="sidebar__comments__icon"> <i class="icon-pin2"></i> </div>
                                         <h6 class="sidebar__comments__title">
                                         <p class="footer-widget__contact__text">KG 194 St, Kigali <br> Kimironko Near bpr Branch</p>
                                         </h6>
                                </li>
                                <li class="sidebar__comments__item">
                                    <div class="sidebar__comments__icon"> <i class="icon-telephone-call-1"></i></div>
                                          <h6 class="sidebar__comments__title">
                                          <a href="https:/wa.me/+250788411095" class="footer-widget__contact__text">+250 788 411 095</a>
                                           </h6>
                                </li>
                             </div>
                        </div><br>



                        <div class="container1">
        <h1>Contact for Booking</h1>
        <form method="POST" action="bookingEmail.php">
            
            <div class="form-group">
                <input class="feature-one__item__text" type="text" id="name" name="name" placeholder="Full name" required>
            </div>
            <div class="form-group">
                <input class="feature-one__item__text" type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input class="feature-one__item__text" type="tel" id="phone" name="phone" placeholder="Phone" required>
            </div>
            <div class="form-group">
                <input class="feature-one__item__text" type="number" id="guests" name="guests" min="1" placeholder="Number of Property Id" required>
            </div>
            <div class="form-group">
                <textarea class="feature-one__item__text" id="comments" name="comments" rows="4" placeholder="Write a Message"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" name="submit" style="color: white; font-size: 12px;padding: 10px 40px 10px 40px">Sent Now</button>
            </div>
        </form>
    </div>
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