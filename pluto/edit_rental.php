<?php
session_start();
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

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $property_status = $_POST['property_status'];
    $property_type = $_POST['property_type'];
    $price = preg_replace('/[^0-9.]/', '', $_POST['price']); 
    $property_size = $_POST['property_size'];
    $bedroom = $_POST['bedroom'];
    $bathroom = $_POST['bathroom'];
    $street = $_POST['street'];
    $sector = $_POST['sector'];
    $district = $_POST['district'];
    $country = $_POST['country'];

    $image = $property['image']; 
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['image']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (in_array(strtolower($filetype), $allowed)) {
            $new_filename = uniqid() . '.' . $filetype;
            $upload_dir = 'propertyMgt/propertyImg/';

            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_filename)) {
                if ($property['image'] && file_exists($upload_dir . $property['image'])) {
                    unlink($upload_dir . $property['image']);
                }
                $image = $new_filename;
            } else {
                $_SESSION['error_message'] = "Failed to upload image.";
                header("Location: edit_rental.php?id=$id");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
            header("Location: edit_rental.php?id=$id");
            exit();
        }
    }

    $query = "UPDATE properties SET 
              image = :image,
              title = :title,
              description = :description,
              property_status = :property_status,
              property_type = :property_type,
              price = :price,
              property_size = :property_size,
              bedroom = :bedroom,
              bathroom = :bathroom,
              street = :street,
              sector = :sector,
              district = :district,
              country = :country
              WHERE id = :id";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':property_status', $property_status);
    $stmt->bindParam(':property_type', $property_type);
    $stmt->bindParam(':price', $price, PDO::PARAM_STR);
    $stmt->bindParam(':property_size', $property_size);
    $stmt->bindParam(':bedroom', $bedroom);
    $stmt->bindParam(':bathroom', $bathroom);
    $stmt->bindParam(':street', $street);
    $stmt->bindParam(':sector', $sector);
    $stmt->bindParam(':district', $district);
    $stmt->bindParam(':country', $country);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Property updated successfully!";
        echo "<script>window.location.href = 'display_rental.php';</script>";
        // header("Location: display_rental.php?id=$id");
        exit();
    } else {
        $_SESSION['error_message'] = "Error updating property.";
        header("Location: edit_rental.php?id=$id");
        exit();
    }
}
?>

<div class="row column1">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0 d-flex justify-content-between align-items-center">
                    <h2>Edit Rental Property</h2>
                    <a href="display_rental.php" class="btn btn-info btn-sm">View All Properties</a>
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
                            <form class="form-horizontal" action="edit_rental.php?id=<?php echo htmlspecialchars($id); ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Upload New Image</label>
                                    <div class="col-sm-9">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image" id="imageUpload" accept="image/*">
                                            <label class="custom-file-label" for="imageUpload">Choose file</label>
                                        </div>
                                        <div class="mt-3" id="imagePreview">
                                            <img src="propertyMgt/propertyImg/<?php echo htmlspecialchars($property['image']); ?>" alt="Current Image" class="img-fluid" style="max-height: 200px;">
                                            <p class="mt-2 text-muted">Current image shown. Upload a new one to replace it.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Title</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($property['title']); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label col-sm-3" for="description">Description</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="description" rows="4" required><?php echo htmlspecialchars($property['description']); ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Property Status</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="property_status" required>
                                            <option value="For Rent" <?php echo ($property['property_status'] == 'For Rent') ? 'selected' : ''; ?>>For Rent</option>
                                            <option value="Not Available" <?php echo ($property['property_status'] == 'Not Available') ? 'selected' : ''; ?>>Not Available</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Property Type</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="property_type" required>
                                            <option value="Apartment" <?php echo ($property['property_type'] == 'Apartment') ? 'selected' : ''; ?>>Apartment</option>
                                            <option value="House" <?php echo ($property['property_type'] == 'House') ? 'selected' : ''; ?>>House</option>
                                            <option value="Villa" <?php echo ($property['property_type'] == 'Villa') ? 'selected' : ''; ?>>Villa</option>
                                            <option value="Studio" <?php echo ($property['property_type'] == 'Studio') ? 'selected' : ''; ?>>Studio</option>
                                            <option value="<?php echo htmlspecialchars($property['property_type']); ?>" <?php echo (!in_array($property['property_type'], ['Apartment', 'House', 'Villa', 'Studio'])) ? 'selected' : ''; ?>><?php echo htmlspecialchars($property['property_type']); ?></option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Price</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="text" class="form-control" name="price" value="<?php echo htmlspecialchars($property['price']); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Property Size</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="property_size" value="<?php echo htmlspecialchars($property['property_size']); ?>" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">sq ft</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Bedrooms</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" name="bedroom" min="0" value="<?php echo htmlspecialchars($property['bedroom']); ?>" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Bathrooms</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" name="bathroom" min="0" value="<?php echo htmlspecialchars($property['bathroom']); ?>" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Street</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="street" value="<?php echo htmlspecialchars($property['street']); ?>" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Sector</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="sector" value="<?php echo htmlspecialchars($property['sector']); ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">District</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="district" value="<?php echo htmlspecialchars($property['district']); ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Country</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="country" value="<?php echo htmlspecialchars($property['country']); ?>" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" name="submit" class="btn btn-info">Update Property</button>
                                        <a href="property_details.php?id=<?php echo htmlspecialchars($id); ?>" class="btn btn-secondary ml-2">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.custom-file-label::after {
    content: "Browse";
}

.form-group {
    margin-bottom: 1.5rem;
}

.control-label {
    font-weight: 500;
    padding-top: 7px;
}

.padding_infor_info {
    padding: 30px;
}

#imagePreview img {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
}

@media (max-width: 768px) {
    .control-label {
        margin-bottom: 10px;
    }
    
    .form-group {
        margin-bottom: 2rem;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 10px;
    }
    
    .ml-2 {
        margin-left: 0;
    }
}
</style>
              
<?php
require_once 'include/footer.php';
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageUpload = document.getElementById('imageUpload');
    const imagePreview = document.getElementById('imagePreview');
    
    imageUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.querySelector('img').src = e.target.result;
                imagePreview.querySelector('p').textContent = "New image selected.";
            }
            reader.readAsDataURL(file);           
            const fileName = file.name;
            const label = this.nextElementSibling;
            label.textContent = fileName;
        }
    });
});
</script>