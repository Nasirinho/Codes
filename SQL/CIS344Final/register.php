<?php
require_once("RealEstateData.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = new RealEstateData();

    $userName = trim($_POST["userName"] ?? "");
    $contactInfo = trim($_POST["contactInfo"] ?? "");
    $password = $_POST["password"] ?? "";
    $userType = $_POST["userType"] ?? "";

    if ($userName && $contactInfo && $password && $userType) {

        $existingUser = $db->getUserByUserName($userName);

        if ($existingUser) {
            $message = "Username already exists. Please choose another.";
        } else {

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            try {
                $db->addUser($userName, $contactInfo, $passwordHash, $userType);
                $message = "Registration successful. You may now log in.";
            } catch (Throwable $e) {
                $message = "Error: " . $e->getMessage();
            }
        }

    } else {
        $message = "Please fill in all fields.";
    }
}
?>

<?php include("header.php"); ?>

<div class="form-card">

    <h2>Create an Account</h2>

    <?php if ($message): ?>
        <p class="form-message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST">

        <label>Username</label>
        <input type="text" name="userName" required>

        <label>Contact Info</label>
        <input type="text" name="contactInfo" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>User Type</label>
        <select name="userType" required>
            <option value="">Select role</option>
            <option value="agent">Agent</option>
            <option value="buyer">Buyer</option>
            <option value="renter">Renter</option>
        </select>

        <button type="submit" class="form-btn">Register</button>

    </form>

</div>

<?php include("footer.php"); ?>
