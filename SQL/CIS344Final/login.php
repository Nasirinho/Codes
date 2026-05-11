<?php
require_once("RealEstateData.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = new RealEstateData();
    $userName = trim($_POST["userName"] ?? "");
    $password = $_POST["password"] ?? "";

    $user = $db->getUserByUsername($userName);

    if ($user && password_verify($password, $user["passwordHash"])) {

    $_SESSION["user"] = [
        "userId"   => $user["userId"], 
        "userName" => $user["userName"],
        "userType" => $user["userType"]
    ];

    header("Location: dashboard.php");
    exit;
}

}
?>

<?php include("header.php"); ?>

<div class="form-card">

    <h2>Login</h2>

    <?php if ($message): ?>
        <p class="form-message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST">

        <label>Username</label>
        <input type="text" name="userName" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" class="form-btn">Login</button>

    </form>

</div>

<?php include("footer.php"); ?>
