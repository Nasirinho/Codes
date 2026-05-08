<?php
require_once("RealEstateData.php");

$db = new RealEstateData();

$city     = $_GET["city"]     ?? "";
$minPrice = isset($_GET["minPrice"]) ? (float)$_GET["minPrice"] : 0;
$maxPrice = isset($_GET["maxPrice"]) ? (float)$_GET["maxPrice"] : 0;

if ($city || $minPrice || $maxPrice) {
    $properties = $db->searchProperties($city, $minPrice, $maxPrice);
} else {
    $properties = $db->getAllProperties();
}
?>

<?php include("header.php"); ?>

<div class="card" style="padding:25px;">

    <h2 style="text-align:center; margin-bottom:20px;">Search Properties</h2>

    <form method="GET" style="display:flex; gap:15px; flex-wrap:wrap; justify-content:center;">
        <input type="text" name="city" placeholder="City" value="<?= htmlspecialchars($city) ?>">
        <input type="number" name="minPrice" placeholder="Min Price" value="<?= htmlspecialchars($minPrice) ?>">
        <input type="number" name="maxPrice" placeholder="Max Price" value="<?= htmlspecialchars($maxPrice) ?>">
        <button type="submit" class="btn">Search</button>
    </form>

</div>

<h2 style="margin-top:30px;">Property Listings</h2>

<?php if (empty($properties)): ?>
    <p>No properties found.</p>
<?php else: ?>
    <?php foreach ($properties as $property): ?>
        <div class="card" style="display:flex; gap:20px; align-items:flex-start;">

            <div>
                <?php if (!empty($property["image_url"])): ?>
                    <img src="<?= htmlspecialchars($property["image_url"]) ?>" width="350">
                <?php endif; ?>

                <?php if (!empty($property["image_url2"])): ?>
                    <img src="<?= htmlspecialchars($property["image_url2"]) ?>" width="350" style="margin-top:10px;">
                <?php endif; ?>
            </div>

            <div>
                <h3><?= htmlspecialchars($property["title"]) ?></h3>
                <p><strong>Type:</strong> <?= htmlspecialchars($property["propertyType"]) ?></p>
                <p><strong>Address:</strong> <?= htmlspecialchars($property["address"]) ?></p>
                <p><strong>City:</strong> <?= htmlspecialchars($property["city"]) ?></p>
                <p><strong>Price:</strong> $<?= htmlspecialchars($property["price"]) ?></p>
                <p><strong>Status:</strong> <?= htmlspecialchars($property["status"]) ?></p>
                <p><strong>Agent:</strong> <?= htmlspecialchars($property["agentName"]) ?></p>

                <a class="btn" href="property_details.php?id=<?= (int)$property["propertyId"] ?>">
                    View Details
                </a>
            </div>

        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php include("footer.php"); ?>
