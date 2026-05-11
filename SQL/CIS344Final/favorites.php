<?php
session_start();
require_once("RealEstateData.php");
$db = new RealEstateData();
include("header.php");

$userId = $_SESSION["userId"];
$favorites = $db->getFavorites($userId);
?>

<h2>Your Favorites</h2>

<?php if (empty($favorites)): ?>
    <p>You have no saved properties.</p>
<?php else: ?>
    <?php foreach ($favorites as $property): ?>
        <div class="card" style="display:flex; gap:20px;">

            <img src="<?= htmlspecialchars($property["image_url"]) ?>" width="250">

            <div>
                <h3><?= htmlspecialchars($property["title"]) ?></h3>
                <p><strong>City:</strong> <?= htmlspecialchars($property["city"]) ?></p>
                <p><strong>Price:</strong> $<?= htmlspecialchars($property["price"]) ?></p>

                <a class="btn" href="property_details.php?id=<?= $property["propertyId"] ?>">View</a>
                <a class="btn" href="remove_favorite.php?id=<?= $property["propertyId"] ?>">Remove</a>
            </div>

        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php include("footer.php"); ?>
