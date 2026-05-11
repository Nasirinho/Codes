<?php
session_start();
require_once("RealEstateData.php");
$db = new RealEstateData();
include("header.php");

$agentId = $_SESSION["user"]["userId"];
$inquiries = $db->getAgentInquiries($agentId);
?>

<h2>Client Inquiries</h2>

<?php if (empty($inquiries)): ?>
    <p>No inquiries yet.</p>
<?php else: ?>
    <?php foreach ($inquiries as $inq): ?>
        <div class="card">
            <h3><?= htmlspecialchars($inq["title"]) ?></h3>
            <p><strong>From:</strong> <?= htmlspecialchars($inq["userName"]) ?></p>
            <p><strong>Message:</strong> <?= htmlspecialchars($inq["message"]) ?></p>
            <p><strong>Date:</strong> <?= htmlspecialchars($inq["inquiryDate"]) ?></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php include("footer.php"); ?>
