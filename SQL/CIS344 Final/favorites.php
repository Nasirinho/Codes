<?php
require_once("config.php");
require_once("auth.php");
require_once("RealEstateData.php");

requireRole(["buyer", "renter"]);

$db = new RealEstateData();
$userId = $_SESSION["user"]["userId"];

$favorites = $db->favoriteListForUser($userId);
?>

<?php include("header.php"); ?>

<h2>Saved Listings</h2>

<?php if (empty($favorites)): ?>
    <p>You haven’t saved any listings yet.</p>
<?php else: ?>
    <?php foreach ($favorites as $property): ?>
        <div class="card">

            <div style="display:flex; gap:10px;">
                <?php if (!empty($property["image_url"])): ?>
                    <img src="<?= htmlspecialchars($property["image_url"]) ?>" width="200">
                <?php endif; ?>

                <?php if (!empty($property["image_url2"])): ?>
                    <img src="<?= htmlspecialchars($property["image_url2"]) ?>" width="200">
                <?php endif; ?>
            </div>

            <h3><?= htmlspecialchars($property["title"]) ?></h3>
            <p><strong>City:</strong> <?= htmlspecialchars($property["city"]) ?></p>
            <p><strong>Price:</strong> $<?= htmlspecialchars($property["price"]) ?></p>
            <p><strong>Agent:</strong> <?= htmlspecialchars($property["agentName"]) ?></p>

            <a href="property_details.php?id=<?= (int)$property["propertyId"] ?>">View Details</a>
            <br>

            <a href="remove_favorite.php?id=<?= (int)$property["propertyId"] ?>"
               onclick="return confirm('Remove this listing from your saved items?')">
               Remove
            </a>

        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php include("footer.php"); ?>
