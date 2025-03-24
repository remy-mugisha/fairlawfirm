<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="bracket-web">
    <meta name="description" content="Firdip is beautifully designed Figma template especially for the fire department, fireman, fire prevention, fire fighting, fire station, protection, firefighter and all other fire & safety business and websites.">
    <style>
        /* Pagination Styling */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .pagination {
            display: inline-block;
        }

        .pagination-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 10px;
        }

        .pagination-list li {
            display: inline;
        }

        .pagination-list li a {
            text-decoration: none;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            color: #198754;
            transition: background-color 0.3s, color 0.3s;
            font-size: 14px;
            font-weight: 500;
        }

        .pagination-list li a:hover {
            background-color: #198754;
            color: white;
            border-color: #198754;
        }

        .pagination-list li.active a {
            background-color: #198754;
            color: white;
            border-color: #198754;
        }
    </style>
    <?php 
    require_once 'include/header.php';
    ?>
</head>

<body class="custom-cursor">

    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header__bg" style="background-color: #1a2f24"></div>
        <div class="container">
            <h2 class="page-header__title"><?= __('REAL ESTATE PROPERTIES') ?></h2>
            <ul class="firdip-breadcrumb list-unstyled">
                <li><a href="welcome"><?= __('Home') ?></a></li>
                <li><span><?= __('service') ?></span></li>
            </ul>   
        </div>
    </section>

    <?php
    require_once 'data/propertyMgt/config.php';

    $propertiesPerPage = 9;

    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $offset = ($currentPage - 1) * $propertiesPerPage;

    // Updated query to order by created_at in descending order
    $selectActiveProperties = $conn->prepare("SELECT * FROM properties WHERE status = 'Active' ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
    $selectActiveProperties->bindValue(':limit', $propertiesPerPage, PDO::PARAM_INT);
    $selectActiveProperties->bindValue(':offset', $offset, PDO::PARAM_INT);
    $selectActiveProperties->execute();

    $totalProperties = $conn->query("SELECT COUNT(*) FROM properties WHERE status = 'Active'")->fetchColumn();
    $totalPages = ceil($totalProperties / $propertiesPerPage);

    if ($selectActiveProperties->rowCount() > 0) {
    ?>
        <section class="blog-one blog-one--page">
            <div class="container">
                <div class="row gutter-y-30">
                    <?php
                    while ($row = $selectActiveProperties->fetch()) {
                    ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="blog-card wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='000ms'>
                                <a href="property_detail?id=<?php echo $row['id']; ?>" class="blog-card__image">
                                    <img src="data/propertyMgt/propertyImg/<?php echo $row['image']; ?>" alt="Property Image">
                                </a>

                                <div class="blog-card__three__content">
                                    <ul class="list-unstyled blog-card__three__meta">
                                        <li class="blog-card__three__meta__item">
                                            <a href="property_detail?id=<?php echo $row['id']; ?>"><?php echo $row["title"]; ?></a> 
                                        </li>
                                        <p class="blog-card__date"><?php echo $row["property_status"]; ?></p>
                                    </ul>
                                    <ul class="list-unstyled blog-card__three__meta">
                                        <li class="blog-card__three__meta__item">
                                            <?php echo $row["price"]; ?>&nbsp;Rwf/
                                            <?php if ($row["property_status"] !== 'For Sale'): ?> 
                                            <?php endif; ?>
                                            <?php if ($row['property_status'] !== 'For Sale' && !empty($row['months'])): ?>
                                        <li class="blog-card__three__meta__item">
                                            <?php echo $row['months']; ?> Months
                                        </li>
                                        <?php endif; ?>    
                                        </li>
                                        <li class="blog-card__three__meta__item">
                                            <?php
                                            if ($row["property_type"] === "Commercial Building") {
                                                echo "Floor: " . $row["floor"];
                                            } else {
                                                echo $row["bedroom"] . " Beds / " . $row["bathroom"] . " Bathrooms";
                                            }
                                            ?>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </section>

        <!-- Pagination -->
        <div class="pagination-container">
            <div class="pagination">
                <ul class="pagination-list">
                    <?php if ($currentPage > 1): ?>
                        <li><a href="?page=<?php echo $currentPage - 1; ?>">Previous</a></li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="<?php echo $i == $currentPage ? 'active' : ''; ?>">
                            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <li><a href="?page=<?php echo $currentPage + 1; ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        
    <?php
    } else {
        // No active properties found
        echo "<div class='container'><p>No active properties available.</p></div>";
    }
    ?>

</body>

<?php 
require_once 'include/footer.php';
?>

</html>