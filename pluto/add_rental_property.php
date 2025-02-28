<?php
session_start();
require_once 'include/header.php';
require_once 'propertyMgt/config.php';

if (isset($_POST['submit'])) {
    $location = $_POST['location'];
    $description = $_POST['description'];
    $title = $_POST['title'];
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

    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = array('jpg', 'jpeg', 'png', 'gif');
        $filename = $_FILES['image']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);

        if (in_array(strtolower($filetype), $allowed)) {
            $new_filename = uniqid() . '.' . $filetype;
            $upload_dir = 'propertyMgt/propertyImg/';

            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_filename)) {
                $image = $new_filename;
            } else {
                $_SESSION['error_message'] = "Failed to upload image.";
                header("Location: add_rental_property.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
            header("Location: add_rental_property.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Please select an image.";
        header("Location: add_rental_property.php");
        exit();
    }
    $query = "INSERT INTO properties (image, title, description, property_status, property_type, price, property_size, bedroom, bathroom, street, sector, district, country) 
              VALUES (:image, :title, :description, :property_status, :property_type, :price, :property_size, :bedroom, :bathroom, :street, :sector, :district, :country)";

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

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Property added successfully!";
        echo "<script>window.location.href = 'add_rental_property.php';</script>";
        // header("Location: display_rental.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error adding property.";
        header("Location: add_rental_property.php");
        exit();
    }
}


?>

<div class="row column1">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0 d-flex justify-content-between align-items-center">
                    <h2>Add Rental Property</h2>
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
                            <form class="form-horizontal" action="add_rental_property.php" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Upload Image</label>
                                    <div class="col-sm-9">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image" id="imageUpload" accept="image/*" required>
                                            <label class="custom-file-label" for="imageUpload">Choose file</label>
                                        </div>
                                        <div class="mt-3" id="imagePreview" style="display: none;">
                                            <img src="" alt="Preview" class="img-fluid" style="max-height: 200px;">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Title</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="title" placeholder="Enter property title" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Location</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="location" placeholder="Enter location" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label col-sm-3" for="description">Description</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="description" rows="4" placeholder="Enter property description" required></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Property Status</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="property_status" required>
                                            <option value="">Select Status</option>
                                            <option value="For Rent">For Rent</option>
                                            <option value="Not Available">Not Available</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Property Type</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="property_type" required>
                                            <option value="">Select Type</option>
                                            <option value="Apartment">Apartment</option>
                                            <option value="House">House</option>
                                            <option value="Villa">Villa</option>
                                            <option value="Studio">Studio</option>
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
                                            <input type="text" class="form-control" name="price" placeholder="Enter price" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Property Size</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="property_size" placeholder="Enter size (sq ft)" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">sq ft</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Bedrooms</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" name="bedroom" min="0" placeholder="Number of bedrooms" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Bathrooms</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" name="bathroom" min="0" placeholder="Number of bathrooms" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Street</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="street" placeholder="Enter street" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Sector</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="sector" placeholder="Enter sector">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">District</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="district" placeholder="Enter district">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Country</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="country" placeholder="Enter country" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" name="submit" class="btn btn-info">Add Property</button>
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
                imagePreview.style.display = 'block';
                imagePreview.querySelector('img').src = e.target.result;
            }
            reader.readAsDataURL(file);            
            const fileName = file.name;
            const label = this.nextElementSibling;
            label.textContent = fileName;
        }
    });
});
</script>