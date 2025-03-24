<?php
ob_start(); // Start output buffering
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

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $property_status = trim($_POST['property_status']);
    $property_type = $_POST['property_type'];
    $price = preg_replace('/[^0-9.]/', '', $_POST['price']);
    $property_size = $_POST['property_size']; // Always include property size
    $bedroom = ($property_type === 'Commercial Building') ? 0 : $_POST['bedroom']; // Default to 0 for Commercial Building
    $bathroom = ($property_type === 'Commercial Building') ? 0 : $_POST['bathroom']; // Default to 0 for Commercial Building
    $street = $_POST['street'];
    $sector = $_POST['sector'];
    $district = $_POST['district'];
    $country = $_POST['country'];
    $status = $_POST['status'];
    $floor = ($property_type === 'Commercial Building') ? $_POST['floor'] : null;

    $image = $property['image'];
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

    try {
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
                  country = :country,
                  status = :status,
                  floor = :floor
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
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':floor', $floor);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Property updated successfully!";
            header("Location: display_rental.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Error updating property.";
            header("Location: edit_rental.php?id=$id");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Database error: " . $e->getMessage();
        header("Location: edit_rental.php?id=$id");
        exit();
    }
}
?>

<!-- Rest of your HTML and JavaScript code -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Rental Property</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    </style>
</head>
<body>
    <div class="row column1">
        <div class="col-md-12">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0 d-flex justify-content-between align-items-center">
                        <h2>Edit Rental Property</h2>
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
                                <form class="form-horizontal" action="edit_rental.php?id=<?php echo htmlspecialchars($id); ?>" method="post" enctype="multipart/form-data">
                                    <!-- Image Upload -->
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

                                    <!-- Title -->
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Title</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($property['title']); ?>" required>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Description</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="description" rows="4" required><?php echo htmlspecialchars($property['description']); ?></textarea>
                                        </div>
                                    </div>

                                    <!-- Property Status -->
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Property Status</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="property_status" required>
                                                <option value="For Rent" <?php echo ($property['property_status'] == 'For Rent') ? 'selected' : ''; ?>>For Rent</option>
                                                <option value="For Sale" <?php echo ($property['property_status'] == 'For Sale') ? 'selected' : ''; ?>>For Sale</option>
                                                <option value="Not Available" <?php echo ($property['property_status'] == 'Not Available') ? 'selected' : ''; ?>>Not Available</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Property Type -->
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Property Type</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="property_type" id="property_type" required>
                                                <option value="Apartment" <?php echo ($property['property_type'] == 'Apartment') ? 'selected' : ''; ?>>Apartment</option>
                                                <option value="House" <?php echo ($property['property_type'] == 'House') ? 'selected' : ''; ?>>House</option>
                                                <option value="Commercial Building" <?php echo ($property['property_type'] == 'Commercial Building') ? 'selected' : ''; ?>>Commercial Building</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Floor (Only for Commercial Building) -->
                                    <div class="form-group row" id="floorField" style="<?php echo ($property['property_type'] == 'Commercial Building') ? 'display: block;' : 'display: none;'; ?>">
                                        <label class="control-label col-sm-3">Floor</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="floor">
                                                <option value="">Select Floor</option>
                                                <option value="Ground Floor" <?php echo ($property['floor'] == 'Ground Floor') ? 'selected' : ''; ?>>Ground Floor</option>
                                                <option value="1st Floor" <?php echo ($property['floor'] == '1st Floor') ? 'selected' : ''; ?>>1st Floor</option>
                                                <option value="2nd Floor" <?php echo ($property['floor'] == '2nd Floor') ? 'selected' : ''; ?>>2nd Floor</option>
                                                <option value="3rd Floor" <?php echo ($property['floor'] == '3rd Floor') ? 'selected' : ''; ?>>3rd Floor</option>
                                                <option value="4th Floor" <?php echo ($property['floor'] == '4th Floor') ? 'selected' : ''; ?>>4th Floor</option>
                                                <option value="5th Floor" <?php echo ($property['floor'] == '5th Floor') ? 'selected' : ''; ?>>5th Floor</option>
                                                <option value="6th Floor" <?php echo ($property['floor'] == '6th Floor') ? 'selected' : ''; ?>>6th Floor</option>
                                                <option value="7th Floor" <?php echo ($property['floor'] == '7th Floor') ? 'selected' : ''; ?>>7th Floor</option>
                                                <option value="8th Floor" <?php echo ($property['floor'] == '8th Floor') ? 'selected' : ''; ?>>8th Floor</option>
                                                <option value="9th Floor" <?php echo ($property['floor'] == '9th Floor') ? 'selected' : ''; ?>>9th Floor</option>
                                                <option value="10th Floor" <?php echo ($property['floor'] == '10th Floor') ? 'selected' : ''; ?>>10th Floor</option>
                                                <option value="11th Floor" <?php echo ($property['floor'] == '11th Floor') ? 'selected' : ''; ?>>11th Floor</option>
                                                <option value="12th Floor" <?php echo ($property['floor'] == '12th Floor') ? 'selected' : ''; ?>>12th Floor</option>
                                                <option value="13th Floor" <?php echo ($property['floor'] == '13th Floor') ? 'selected' : ''; ?>>13th Floor</option>
                                                <option value="14th Floor" <?php echo ($property['floor'] == '14th Floor') ? 'selected' : ''; ?>>14th Floor</option>
                                                <option value="15th Floor" <?php echo ($property['floor'] == '15th Floor') ? 'selected' : ''; ?>>15th Floor</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Price</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="price" value="<?php echo htmlspecialchars($property['price']); ?>" required>
                                        </div>
                                    </div>

                                    <!-- Property Size -->
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

                                    <!-- Bedroom (Hidden for Commercial Building) -->
                                    <div class="form-group row" id="bedroomField" style="<?php echo ($property['property_type'] == 'Commercial Building') ? 'display: none;' : 'display: block;'; ?>">
                                        <label class="control-label col-sm-3">Bedrooms</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" name="bedroom" min="0" value="<?php echo htmlspecialchars($property['bedroom']); ?>" required>
                                        </div>
                                    </div>

                                    <!-- Bathroom (Hidden for Commercial Building) -->
                                    <div class="form-group row" id="bathroomField" style="<?php echo ($property['property_type'] == 'Commercial Building') ? 'display: none;' : 'display: block;'; ?>">
                                        <label class="control-label col-sm-3">Bathrooms</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" name="bathroom" min="0" value="<?php echo htmlspecialchars($property['bathroom']); ?>" required>
                                        </div>
                                    </div>

                                    <!-- Street -->
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Street</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="street" value="<?php echo htmlspecialchars($property['street']); ?>" required>
                                        </div>
                                    </div>

                                    <!-- Sector -->
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Sector</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="sector" value="<?php echo htmlspecialchars($property['sector']); ?>">
                                        </div>
                                    </div>

                                    <!-- District -->
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">District</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="district" value="<?php echo htmlspecialchars($property['district']); ?>">
                                        </div>
                                    </div>

                                    <!-- Country -->
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Country</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="country" value="<?php echo htmlspecialchars($property['country']); ?>" required>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Status</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="status" required>
                                                <option value="Active" <?php echo ($property['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                                                <option value="Inactive" <?php echo ($property['status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                                                <option value="Pending" <?php echo ($property['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
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

    <!-- JavaScript to Handle Field Visibility -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const propertyType = document.getElementById('property_type');
        const bedroomField = document.getElementById('bedroomField');
        const bathroomField = document.getElementById('bathroomField');
        const floorField = document.getElementById('floorField');

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
            }
        });
    });
    </script>
</body>
</html>