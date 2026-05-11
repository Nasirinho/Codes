<?php
require_once("config.php");
require_once("auth.php");
requireLogin();

$user = $_SESSION["user"];
?>

<?php include("header.php"); ?>

<div class="dashboard-card">

    <h2>Dashboard</h2>

    <div class="dash-info">
        <p><strong>Welcome:</strong> <?= htmlspecialchars($user["userName"]) ?></p>
        <p><strong>Role:</strong> <?= htmlspecialchars($user["userType"]) ?></p>
    </div>

</div>

<?php if ($user["userType"] === "agent"): ?>
    <div class="dashboard-section">
        <h3>Agent Actions</h3>

        <div class="dash-links">
            <a class="dash-btn" href="add_property.php">Add Property</a>
            <a class="dash-btn" href="inquiries.php">View Inquiries</a>
        </div>
    </div>
<?php endif; ?>

<div class="dashboard-section">
    <h3>Common Actions</h3>

    <div class="dash-links">
        <a class="dash-btn" href="properties.php">Browse Properties</a>

        <?php if (in_array($user["userType"], ["buyer", "renter"])): ?>
            <a class="dash-btn" href="favorites.php">My Favorites</a>
        <?php endif; ?>
    </div>
</div>

<?php include("footer.php"); ?>
