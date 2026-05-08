<?php
session_start();
require_once("RealEstateData.php");

$db = new RealEstateData();


if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("Invalid property.");
}

$propertyId = (int)$_GET["id"];
$property   = $db->getPropertyById($propertyId);

if (!$property) {
    die("Property not found.");
}

$userId   = $_SESSION["userId"] ?? null;
$userType = $_SESSION["userType"] ?? null;
?>

<?php include("header.php"); ?>

<div class="card">

    <h2><?= htmlspecialchars($property["title"]) ?></h2>

    <div style="display:flex; gap:25px; margin-top:20px;">

        <div>
            <?php if (!empty($property["image_url"])): ?>
                <img src="<?= htmlspecialchars($property["image_url"]) ?>" width="350">
            <?php endif; ?>

            <?php if (!empty($property["image_url2"])): ?>
                <img src="<?= htmlspecialchars($property["image_url2"]) ?>" width="350" style="margin-top:10px;">
            <?php endif; ?>
        </div>

        <div>
            <p><strong>Type:</strong> <?= htmlspecialchars($property["propertyType"]) ?></p>
            <p><strong>Address:</strong> <?= htmlspecialchars($property["address"]) ?></p>
            <p><strong>City:</strong> <?= htmlspecialchars($property["city"]) ?></p>
            <p><strong>Price:</strong> $<?= htmlspecialchars($property["price"]) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($property["status"]) ?></p>
            <p><strong>Agent:</strong> <?= htmlspecialchars($property["agentName"]) ?></p>

            <?php if ($userId && $userType === "buyer"): ?>
                <a class="btn" href="add_favorite.php?id=<?= $propertyId ?>">Add to Favorites</a>
            <?php endif; ?>

            <?php if ($userId && $userType === "buyer"): ?>
                <a class="btn" href="#inquiryForm">Send Inquiry</a>
            <?php endif; ?>

            <?php if ($userId && $userType === "buyer" && $property["status"] === "available"): ?>
                <form action="process_transaction.php" method="POST" style="margin-top:15px;">
                    <input type="hidden" name="propertyId" value="<?= $propertyId ?>">
                    <input type="hidden" name="type" value="buy">
                    <input type="hidden" name="amount" value="<?= $property["price"] ?>">
                    <button class="btn" type="submit">Buy Property</button>
                </form>

                <form action="process_transaction.php" method="POST" style="margin-top:10px;">
                    <input type="hidden" name="propertyId" value="<?= $propertyId ?>">
                    <input type="hidden" name="type" value="rent">
                    <input type="hidden" name="amount" value="<?= $property["price"] ?>">
                    <button class="btn" type="submit">Rent Property</button>
                </form>
            <?php endif; ?>

            <?php if ($userId && $userType === "agent" && $property["agentId"] == $userId): ?>
                <a class="btn" href="edit_property.php?id=<?= $propertyId ?>">Edit Property</a>
                <a class="btn" href="delete_property.php?id=<?= $propertyId ?>" 
                   onclick="return confirm('Are you sure you want to delete this property?');">
                   Delete Property
                </a>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php if ($userId && $userType === "buyer"): ?>
<div class="card" id="inquiryForm">
    <h3>Send Inquiry</h3>

    <form method="POST" action="submit_inquiry.php">
        <input type="hidden" name="propertyId" value="<?= $propertyId ?>">

        <label>Your Message</label>
        <textarea name="message" rows="4" required></textarea>

        <button class="btn" type="submit">Submit Inquiry</button>
    </form>
</div>
<?php endif; ?>

<?php include("footer.php"); ?>
