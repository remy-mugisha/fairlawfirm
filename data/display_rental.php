<?php
require_once 'include/header.php';
require_once 'propertyMgt/config.php';

if (isset($_GET['delete_id']) && !empty($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    
    try {
        $check_query = "SELECT image FROM properties WHERE id = :id";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);
        $check_stmt->execute();
        $property = $check_stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($property) {
            $delete_query = "DELETE FROM properties WHERE id = :id";
            $delete_stmt = $conn->prepare($delete_query);
            $delete_stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);
            
            if ($delete_stmt->execute()) {
                if (!empty($property['image'])) {
                    $image_path = 'propertyMgt/propertyImg/' . $property['image'];
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }
                }
                
                $_SESSION['success_message'] = "Property deleted successfully!";
            } else {
                $_SESSION['error_message'] = "Failed to delete property.";
            }
        } else {
            $_SESSION['error_message'] = "Property not found.";
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
    }
    echo "<script>window.location.href = 'display_rental.php';</script>";
    exit();
}

require_once 'include/header.php';

$query = "SELECT * FROM properties ORDER BY id DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
.table .thead-dark th {
    color: #fff;
    background-color: #15283c;
    border-color: #32383e;
}
</style>

<div class="row column1">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0 d-flex justify-content-between align-items-center">
                    <h2>All Rental Properties</h2>
                    <a href="add_rental_property.php" class="btn btn-info btn-sm">Add New Property</a>
                </div>
            </div>

            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php 
                    echo $_SESSION['success_message']; 
                    unset($_SESSION['success_message']);
                    ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php 
                    echo $_SESSION['error_message']; 
                    unset($_SESSION['error_message']);
                    ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <div class="full progress_bar_inner">
                <div class="row">
                    <div class="col-md-12">
                        <div class="full padding_infor_info">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Property Status</th>
                                            <th>Price</th>
                                            <th>Bed/Bath</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($properties) > 0): ?>
                                            <?php foreach ($properties as $row): ?>
                                                <tr>
                                                    <td>
                                                        <img src="propertyMgt/propertyImg/<?php echo htmlspecialchars($row['image']); ?>" alt="Property" class="img-thumbnail" style="max-width: 100px;">
                                                    </td>
                                                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['property_type']); ?></td>
                                                    <td>
                                                    <span class="badge <?php echo ($row['property_status'] == 'For Rent') ? 'badge-success' : (($row['property_status'] == 'For Sale') ? 'badge-warning' : 'badge-secondary'); ?>">
                                                            <?php echo htmlspecialchars($row['property_status']); ?>
                                                        </span>
                                                    </td>
                                                    <td>$<?php echo number_format($row['price'], 2); ?></td>
                                                    <td>
                                                        <?php if ($row['property_type'] !== 'Commercial Building'): ?>
                                                            <?php echo htmlspecialchars($row['bedroom']); ?> / <?php echo htmlspecialchars($row['bathroom']); ?>
                                                        <?php else: ?>
                                                            <?php echo htmlspecialchars($row['floor']); ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <a href="property_details.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm" title="View Details">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="edit_rental.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="display_rental.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" 
                                                           onclick="return confirm('Are you sure you want to delete this property?')" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="text-center">No properties found</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'include/footer.php'; ?>