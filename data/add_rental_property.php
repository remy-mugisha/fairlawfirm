<?php
ob_start(); // Start output buffering
// session_start();
require_once 'include/header.php';
require_once 'propertyMgt/config.php';

if (isset($_POST['submit'])) {
    // Retrieve form data
    $description = $_POST['description'];
    $title = $_POST['title'];
    $property_status = $_POST['property_status'];
    $property_type = $_POST['property_type'];
    $price = preg_replace('/[^0-9.]/', '', $_POST['price']);
    $property_size = $_POST['property_size'];
    $bedroom = ($property_type === 'Commercial Building') ? 0 : $_POST['bedroom'];
    $bathroom = ($property_type === 'Commercial Building') ? 0 : $_POST['bathroom'];
    $street = $_POST['street'];
    $sector = $_POST['sector'];
    $district = $_POST['district'];
    $country = $_POST['country'];
    $floor = ($property_type === 'Commercial Building') ? $_POST['floor'] : null;
    $months = ($property_status === 'For Sale') ? null : $_POST['months']; // Handle months selection

    // Handle image upload
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

    // Insert data into the database
    $query = "INSERT INTO properties (image, title, description, property_status, property_type, price, property_size, bedroom, bathroom, street, sector, district, country, floor, months) 
              VALUES (:image, :title, :description, :property_status, :property_type, :price, :property_size, :bedroom, :bathroom, :street, :sector, :district, :country, :floor, :months)";

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
    $stmt->bindParam(':floor', $floor);
    $stmt->bindParam(':months', $months);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Property added successfully!";
        header("Location: add_rental_property.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error adding property: " . $stmt->errorInfo()[2];
        header("Location: add_rental_property.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Rental Property</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .custom-file-label::after { content: "Browse"; }
        .form-group { margin-bottom: 1.5rem; }
        .control-label { font-weight: 500; padding-top: 7px; }
        .padding_infor_info { padding: 30px; }
        #imagePreview img { border: 1px solid #ddd; border-radius: 4px; padding: 5px; }
    </style>
</head>
<body>
    <div class="row column1">
        <div class="col-md-12">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0 d-flex justify-content-between align-items-center">
                        <h2>Add Rental Property</h2>
                        <a href="display_rental.php" class="btn btn-info btn-sm">View All Properties</a>
                    </div>
                </div>

                <!-- Success/Error Messages -->
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Form -->
                <div class="full progress_bar_inner">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="full padding_infor_info">
                                <form class="form-horizontal" action="add_rental_property.php" method="post" enctype="multipart/form-data">
                                    <!-- Image Upload -->
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

                                    <!-- Title -->
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Title</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="title" placeholder="Enter property title" required>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Description</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="description" rows="4" placeholder="Enter property description" required></textarea>
                                        </div>
                                    </div>

                                    <!-- Property Status -->
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Property Status</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="property_status" id="property_status" required>
                                                <option value="">Select Status</option>
                                                <option value="For Rent">For Rent</option>
                                                <option value="For Sale">For Sale</option>
                                                <option value="Not Available">Not Available</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Months Dropdown -->
                                    <div class="form-group row" id="monthsField">
                                        <label class="control-label col-sm-3">Select Months</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="months">
                                                <option value="">Select Months</option>
                                                <option value="1">1 Month</option>
                                                <option value="2">2 Months</option>
                                                <option value="3">3 Months</option>
                                                <option value="4">4 Months</option>
                                                <option value="5">5 Months</option>
                                                <option value="6">6 Months</option>
                                                <option value="7">7 Months</option>
                                                <option value="8">8 Months</option>
                                                <option value="9">9 Months</option>
                                                <option value="10">10 Months</option>
                                                <option value="11">11 Months</option>
                                                <option value="12">12 Months</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Property Type -->
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Property Type</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="property_type" id="property_type" required>
                                                <option value="">Select Type</option>
                                                <option value="Apartment">Apartment</option>
                                                <option value="House">House</option>
                                                <option value="Commercial Building">Commercial Building</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Floor (Only for Commercial Building) -->
                                    <div class="form-group row" id="floorField" style="display: none;">
                                        <label class="control-label col-sm-3">Floor</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="floor">
                                                <option value="">Select Floor</option>
                                                <option value="Ground Floor">Ground Floor</option>
                                                <option value="1st Floor">1st Floor</option>
                                                <option value="2nd Floor">2nd Floor</option>
                                                <option value="3rd Floor">3rd Floor</option>
                                                <option value="4th Floor">4th Floor</option>
                                                <option value="5th Floor">5th Floor</option>
                                                <option value="6th Floor">6th Floor</option>
                                                <option value="7th Floor">7th Floor</option>
                                                <option value="8th Floor">8th Floor</option>
                                                <option value="9th Floor">9th Floor</option>
                                                <option value="10th Floor">10th Floor</option>
                                                <option value="11th Floor">11th Floor</option>
                                                <option value="12th Floor">12th Floor</option>
                                                <option value="13th Floor">13th Floor</option>
                                                <option value="14th Floor">14th Floor</option>
                                                <option value="15th Floor">15th Floor</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Price</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="price" placeholder="Enter price" required>
                                        </div>
                                    </div>

                                    <!-- Property Size -->
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

                                    <!-- Bedroom (Hidden for Commercial Building) -->
                                    <div class="form-group row" id="bedroomField">
                                        <label class="control-label col-sm-3">Bedrooms</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" name="bedroom" min="0" placeholder="Number of bedrooms" required>
                                        </div>
                                    </div>

                                    <!-- Bathroom (Hidden for Commercial Building) -->
                                    <div class="form-group row" id="bathroomField">
                                        <label class="control-label col-sm-3">Bathrooms</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" name="bathroom" min="0" placeholder="Number of bathrooms" required>
                                        </div>
                                    </div>

                                    <!-- Street -->
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Street</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="street" placeholder="Enter street" required>
                                        </div>
                                    </div>

                                    <!-- Sector -->
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Sector</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="sector" placeholder="Enter sector">
                                        </div>
                                    </div>

                                    <!-- District -->
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">District</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="district" placeholder="Enter district">
                                        </div>
                                    </div>

                                    <!-- Country -->
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Country</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="country" placeholder="Enter country" required>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
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

    <!-- JavaScript to Handle Field Visibility -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const propertyType = document.getElementById('property_type');
        const propertyStatus = document.getElementById('property_status');
        const bedroomField = document.getElementById('bedroomField');
        const bathroomField = document.getElementById('bathroomField');
        const floorField = document.getElementById('floorField');
        const monthsField = document.getElementById('monthsField');

        // Handle Property Type Change
        propertyType.addEventListener('change', function() {
            if (this.value === 'Commercial Building') {
                bedroomField.style.display = 'none';
                bathroomField.style.display = 'none';
                floorField.style.display = 'block';
            } else {
                bedroomField.style.display = 'block';
                bathroomField.style.display = 'block';
                floorField.style.display = 'none';
            }
        });

        // Handle Property Status Change
        propertyStatus.addEventListener('change', function() {
            if (this.value === 'For Sale') {
                monthsField.style.display = 'none';
            } else {
                monthsField.style.display = 'block';
            }
        });

        // Handle Image Preview
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
            }
        });
    });
    </script>
</body>
</html>