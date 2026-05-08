<?php
require_once("config.php");
require_once("auth.php");
require_once("RealEstateData.php");

requireRole(["buyer", "renter"]);

$db = new RealEstateData();

$userId     = $_SESSION["user"]["userId"];
$propertyId = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

if ($propertyId > 0) {
    $db->favoriteDropEntry($userId, $propertyId);
}

header("Location: favorites.php");
exit;
