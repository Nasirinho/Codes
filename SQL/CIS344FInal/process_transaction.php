<?php
require_once("config.php");
require_once("auth.php");
require_once("RealEstateData.php");

requireRole(["buyer", "renter"]);

$db = new RealEstateData();

$propertyId = isset($_POST["propertyId"]) ? (int)$_POST["propertyId"] : 0;
$userId     = (int)$_SESSION["user"]["userId"];
$type       = $_POST["type"]   ?? "sale";
$amount     = isset($_POST["amount"]) ? (float)$_POST["amount"] : 0;

if ($propertyId > 0 && $amount > 0) {

    $success = $db->transactionExecuteFlow($propertyId, $userId, $type, $amount);

    if ($success) {
        echo "<p>Transaction successful!</p>";
        echo '<a href="properties.php">Back to Properties</a>';
    } else {
        echo "<p>Transaction failed.</p>";
    }

} else {
    echo "<p>Invalid transaction data.</p>";
}
