<?php
ob_start();
require_once 'include/header.php';
require_once 'propertyMgt/config.php';

if (isset($_POST['add_blog'])) {
    $title = $_POST['title'];
    $description = $_POST['description_blog'];
    $details = $_POST['blog_description_details'];
    $status = $_POST['status'];
    $category = $_POST['category_blog'];

    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = array('jpg', 'jpeg', 'png', 'gif');
        $filename = $_FILES['image']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);

        if (in_array(strtolower($filetype), $allowed)) {
            $new_filename = uniqid() . '.' . $filetype;
            $upload_dir = 'propertyMgt/blogImg/';

            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_filename)) {
                $image = $new_filename;
            } else {
                $_SESSION['error_message'] = "Failed to upload image.";
                header("Location: add_blog.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
            header("Location: add_blog.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Please select an image.";
        header("Location: add_blog.php");
        exit();
    }

    $query = "INSERT INTO blog (title, description_blog, blog_description_details, image, status, category_blog, date) 
              VALUES (:title, :description, :details, :image, :status, :category, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':details' => $details,
        ':image' => $image,
        ':status' => $status,
        ':category' => $category
    ]);

    $_SESSION['success_message'] = "Blog added successfully!";
    header("Location: add_blog.php");
    exit();
}

$query = "SELECT * FROM blog WHERE status = 'active'";
$stmt = $conn->prepare($query);
$stmt->execute();
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blog</title>
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
                        <h2>Add Blog</h2>
                        <a href="display_blog" class="btn btn-info btn-sm">View All Blogs</a>
                    </div>
                </div>

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

                <div class="full progress_bar_inner">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="full padding_infor_info">
                                <form class="form-horizontal" action="add_blog.php" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Title</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="title" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Description</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="description_blog" rows="4" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Details</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="blog_description_details" rows="4" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Image</label>
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
                                        <label class="control-label col-sm-3">Category</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="category_blog" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Status</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="status" required>
                                                <option value="active">Active</option>
                                                <option value="pending">Pending</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button type="submit" name="add_blog" class="btn btn-info">Add Blog</button>
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
            }
        });
    });
    </script>
</body>
</html>