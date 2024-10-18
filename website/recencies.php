<?php
// Start session and include database connection
session_start();
include 'connect.php';

// Check if the user is an admin and if the website is in maintenance mode
controleerAdmin();
onderhoudsModus();

// Display and manage reviews based on the user's actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle review submission by customers
    if (isset($_POST['submit_review']) && isset($_SESSION['klant'])) {
        $artikel_id = intval($_POST['artikel_id']);
        $klant_id = $_SESSION['klant_id'];
        $commentaar = mysqli_real_escape_string($mysqli, $_POST['commentaar']);
        $rating = intval($_POST['rating']);
        $approved = false; // Default status as unapproved

        // Insert review into the database
        $sql = "INSERT INTO tblrecensies (artikel_id, klant_id, commentaar, rating, approved) 
                VALUES ($artikel_id, $klant_id, '$commentaar', $rating, $approved)";
        mysqli_query($mysqli, $sql);

        header('Location: reviews.php?artikel_id=' . $artikel_id . '&success=review_submitted');
        exit();
    }

    // Handle admin actions (approve/delete reviews)
    if ($is_admin) {
        if (isset($_POST['approve_review'])) {
            $recensie_id = intval($_POST['recensie_id']);
            $sql = "UPDATE tblrecensies SET approved = 1 WHERE recensie_id = $recensie_id";
            mysqli_query($mysqli, $sql);
        } elseif (isset($_POST['delete_review'])) {
            $recensie_id = intval($_POST['recensie_id']);
            $sql = "DELETE FROM tblrecensies WHERE recensie_id = $recensie_id";
            mysqli_query($mysqli, $sql);
        }

        header('Location: reviews.php?admin_view=1');
        exit();
    }
}

// Fetch reviews for the product (visible to customers) or pending reviews for moderation (visible to admins)
if (isset($_GET['artikel_id'])) {
    $artikel_id = intval($_GET['artikel_id']);
    $sql_reviews = "SELECT * FROM tblrecensies WHERE artikel_id = $artikel_id AND approved = 1";
    $result_reviews = mysqli_query($mysqli, $sql_reviews);
} elseif ($is_admin && isset($_GET['admin_view'])) {
    $sql_reviews = "SELECT * FROM tblrecensies WHERE approved = 0";
    $result_reviews = mysqli_query($mysqli, $sql_reviews);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reviews</title>
</head>
<body>

<?php if (isset($_GET['success']) && $_GET['success'] == 'review_submitted') : ?>
    <p>Your review has been submitted and is awaiting approval!</p>
<?php endif; ?>

<?php if (isset($artikel_id)) : ?>
    <!-- Display approved reviews for the specific product -->
    <h2>Customer Reviews</h2>
    <?php
    if (mysqli_num_rows($result_reviews) > 0) {
        while ($review = mysqli_fetch_assoc($result_reviews)) {
            echo '<div class="review">';
            echo '<h4>' . htmlspecialchars($review['klantnaam']) . '</h4>';
            echo '<p>' . htmlspecialchars($review['commentaar']) . '</p>';
            echo '<p>Rating: ' . htmlspecialchars($review['rating']) . '/5</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No reviews yet. Be the first to write a review!</p>';
    }
    ?>

    <!-- Review submission form for logged-in customers -->
    <?php if (isset($_SESSION['klant'])) : ?>
        <h3>Leave a Review:</h3>
        <form action="reviews.php" method="POST">
            <input type="hidden" name="artikel_id" value="<?php echo $artikel_id; ?>">
            <textarea name="commentaar" required placeholder="Write your review..."></textarea><br>
            <label for="rating">Rating:</label>
            <select name="rating" id="rating" required>
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Very Good</option>
                <option value="3">3 - Good</option>
                <option value="2">2 - Fair</option>
                <option value="1">1 - Poor</option>
            </select><br>
            <input type="submit" name="submit_review" value="Submit Review">
        </form>
    <?php else : ?>
        <p><a href="login.php">Log in</a> to leave a review.</p>
    <?php endif; ?>

<?php elseif ($is_admin && isset($_GET['admin_view'])) : ?>
    <!-- Display pending reviews for moderation (admin view) -->
    <h2>Pending Reviews for Moderation</h2>
    <?php
    if (mysqli_num_rows($result_reviews) > 0) {
        if (mysqli_num_rows($result_reviews) > 0) {
            while ($review = mysqli_fetch_assoc($result_reviews)) {
                echo '<div class="review">';
                echo '<h4>' . $review['klantnaam'] . '</h4>';
                echo '<p>' . $review['commentaar'] . '</p>';
                echo '<p>Rating: ' . $review['rating'] . '/5</p>';
                echo '<form method="POST" action="reviews.php">';
                echo '<input type="hidden" name="recensie_id" value="' . $review['recensie_id'] . '">';
                echo '<input type="submit" name="approve_review" value="Approve">';
                echo '<input type="submit" name="delete_review" value="Delete">';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo '<p>No pending reviews to moderate.</p>';
        }
    }
    ?>
<?php endif; ?>

</body>
</html>
