<?php
ob_start();
require_once 'include/header.php';
require_once 'propertyMgt/config.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "Blog ID is missing.";
    header("Location: display_blog.php");
    exit();
}

$id = $_GET['id'];

$query = "SELECT * FROM blog WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    $_SESSION['error_message'] = "Blog not found.";
    header("Location: display_blog.php");
    exit();
}

if (isset($_POST['update_blog'])) {
    $title = $_POST['title'];
    $description = $_POST['description_blog'];
    $details = $_POST['blog_description_details'];
    $status = $_POST['status'];
    $category = $_POST['category_blog'];

    $image = $blog['image'];
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
                if ($blog['image'] && file_exists($upload_dir . $blog['image'])) {
                    unlink($upload_dir . $blog['image']);
                }
                $image = $new_filename;
            } else {
                $_SESSION['error_message'] = "Failed to upload image.";
                header("Location: edit_blog.php?id=$id");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
            header("Location: edit_blog.php?id=$id");
            exit();
        }
    }

    $query = "UPDATE blog SET 
              title = :title,
              description_blog = :description,
              blog_description_details = :details,
              image = :image,
              status = :status,
              category_blog = :category
              WHERE id = :id";

    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':details' => $details,
        ':image' => $image,
        ':status' => $status,
        ':category' => $category,
        ':id' => $id
    ]);

    $_SESSION['success_message'] = "Blog updated successfully!";
    header("Location: display_blog.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog</title>
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
                        <h2>Edit Blog</h2>
                        <a href="display_blog.php" class="btn btn-info btn-sm">View All Blogs</a>
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
                                <form class="form-horizontal" action="edit_blog.php?id=<?php echo htmlspecialchars($id); ?>" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Title</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($blog['title']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Description</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="description_blog" rows="4" required><?php echo htmlspecialchars($blog['description_blog']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Details</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="blog_description_details" rows="4" required><?php echo htmlspecialchars($blog['blog_description_details']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Image</label>
                                        <div class="col-sm-9">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="image" id="imageUpload" accept="image/*">
                                                <label class="custom-file-label" for="imageUpload">Choose file</label>
                                            </div>
                                            <div class="mt-3" id="imagePreview">
                                                <img src="propertyMgt/blogImg/<?php echo htmlspecialchars($blog['image']); ?>" alt="Current Image" class="img-fluid" style="max-height: 200px;">
                                                <p class="mt-2 text-muted">Current image shown. Upload a new one to replace it.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Category</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="category_blog" value="<?php echo htmlspecialchars($blog['category_blog']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Status</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="status" required>
                                                <option value="active" <?php echo ($blog['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                                <option value="pending" <?php echo ($blog['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button type="submit" name="update_blog" class="btn btn-info">Update Blog</button>
                                            <a href="view_blog.php?id=<?php echo htmlspecialchars($id); ?>" class="btn btn-secondary ml-2">Cancel</a>
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