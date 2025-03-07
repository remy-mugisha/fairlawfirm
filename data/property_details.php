<?php
// session_start();
require_once 'include/header.php';
require_once 'propertyMgt/config.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "Property ID is missing.";
    header("Location: display_properties.php");
    exit();
}

$id = $_GET['id'];

$query = "SELECT * FROM properties WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$property = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$property) {
    $_SESSION['error_message'] = "Property not found.";
    header("Location: display_properties.php");
    exit();
}
?>

<div class="row column1">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0 d-flex justify-content-between align-items-center">
                    <h2>Property Details</h2>
                    <div>
                        <a href="edit_rental.php?id=<?php echo htmlspecialchars($property['id']); ?>" class="btn btn-info btn-sm mr-2">Edit Property</a>
                        <a href="display_rental.php" class="btn btn-info btn-sm">Back to Properties</a>
                    </div>
                </div>
            </div>
            
            <div class="full progress_bar_inner">
                <div class="row">
                    <div class="col-md-12">
                        <div class="full padding_infor_info">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="property-image">
                                        <img src="propertyMgt/propertyImg/<?php echo htmlspecialchars($property['image']); ?>" alt="<?php echo htmlspecialchars($property['title']); ?>" class="img-fluid rounded">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="property-info">
                                        <h3 class="property-title"><?php echo htmlspecialchars($property['title']); ?></h3>
                                        
                                        <div class="property-meta mb-4">
                                            <span class="badge <?php echo ($property['property_status'] == 'For Rent') ? 'badge-success' : 'badge-secondary'; ?> mr-2">
                                                <?php echo htmlspecialchars($property['property_status']); ?>
                                            </span>
                                            <span class="property-type mr-2"><?php echo htmlspecialchars($property['property_type']); ?></span>
                                            <span class="property-price">$<?php echo number_format($property['price'], 2); ?></span>
                                        </div>
                                        
                                        <div class="property-features mb-4">
                                            <div class="row">
                                                <div class="col-6">
                                                    <p><i class="fa fa-bed mr-2"></i> <strong>Bedrooms:</strong> <?php echo htmlspecialchars($property['bedroom']); ?></p>
                                                </div>
                                                <div class="col-6">
                                                    <p><i class="fa fa-bath mr-2"></i> <strong>Bathrooms:</strong> <?php echo htmlspecialchars($property['bathroom']); ?></p>
                                                </div>
                                                <div class="col-12">
                                                    <p><i class="fa fa-ruler-combined mr-2"></i> <strong>Size:</strong> <?php echo htmlspecialchars($property['property_size']); ?> sq ft</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="property-address mb-4">
                                            <h5>Location</h5>
                                            <p>
                                                <i class="fa fa-map-marker-alt mr-2"></i>
                                                <?php 
                                                echo htmlspecialchars($property['street']);
                                                if (!empty($property['sector'])) echo ', ' . htmlspecialchars($property['sector']);
                                                if (!empty($property['district'])) echo ', ' . htmlspecialchars($property['district']);
                                                if (!empty($property['country'])) echo ', ' . htmlspecialchars($property['country']);
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mt-4">
                                    <div class="property-description">
                                        <h5>Description</h5>
                                        <p><?php echo nl2br(htmlspecialchars($property['description'])); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.property-image img {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
}

.property-title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 15px;
}

.property-meta .badge {
    font-size: 14px;
    padding: 5px 10px;
}

.property-price {
    font-size: 18px;
    font-weight: 600;
    color: #28a745;
}

.property-features p {
    margin-bottom: 10px;
}

.property-address p {
    color: #666;
}

@media (max-width: 768px) {
    .property-image {
        margin-bottom: 20px;
    }
}
</style>
              
<?php
require_once 'include/footer.php';
?>
