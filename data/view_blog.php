<?php
ob_start(); // Start output buffering to fix header issues
require_once 'include/header.php';
require_once 'propertyMgt/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM blog WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->execute([':id' => $id]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$blog) {
        echo "Blog not found!";
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}
?>

<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <h1><?php echo htmlspecialchars($blog['title']); ?></h1>
        <img src="propertyMgt/blogImg/<?php echo htmlspecialchars($blog['image']); ?>" class="img-fluid mb-3">
        <p><strong>Description:</strong> <?php echo htmlspecialchars($blog['description_blog']); ?></p>
        <p><strong>Details:</strong> <?php echo htmlspecialchars($blog['blog_description_details']); ?></p>
        <p><strong>Category:</strong> <?php echo htmlspecialchars($blog['category_blog']); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($blog['status']); ?></p>
        <p><strong>Date:</strong> <?php echo htmlspecialchars($blog['date']); ?></p>
        <a href="add_blog.php" class="btn btn-primary">Back to Blog List</a>
    </div>
</div>

<?php require_once 'include/footer.php'; ?>