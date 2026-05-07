<?php
require_once("Database.php");

class RealEstateData {

    private PDO $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function userCreate(string $userName, string $contactInfo, string $passwordHash, string $userType): bool {
        $stmt = $this->conn->prepare("
            CALL AddOrUpdateUser(NULL, :userName, :contactInfo, :passwordHash, :userType)
        ");

        return $stmt->execute([
            ":userName"     => $userName,
            ":contactInfo"  => $contactInfo,
            ":passwordHash" => $passwordHash,
            ":userType"     => $userType
        ]);
    }

    public function userFetchByName(string $userName) {
        $stmt = $this->conn->prepare("
            SELECT * FROM Users WHERE userName = :userName LIMIT 1
        ");
        $stmt->execute([":userName" => $userName]);
        return $stmt->fetch();
    }

    public function propertyCreate($title, $propertyType, $address, $city, $price, $status, $agentId, $image1, $image2) {
        $stmt = $this->conn->prepare("
            INSERT INTO Properties (title, propertyType, address, city, price, status, agentId, image_url, image_url2)
            VALUES (:title, :propertyType, :address, :city, :price, :status, :agentId, :image1, :image2)
        ");

        return $stmt->execute([
            ":title"        => $title,
            ":propertyType" => $propertyType,
            ":address"      => $address,
            ":city"         => $city,
            ":price"        => $price,
            ":status"       => $status,
            ":agentId"      => $agentId,
            ":image1"       => $image1,
            ":image2"       => $image2
        ]);
    }

    public function propertyCatalog(): array {
        $stmt = $this->conn->query("
            SELECT * FROM PropertyListingView ORDER BY propertyId DESC
        ");
        return $stmt->fetchAll();
    }

    public function propertyFetchOne(int $propertyId) {
        $stmt = $this->conn->prepare("
            SELECT * FROM PropertyListingView WHERE propertyId = :id
        ");
        $stmt->execute([":id" => $propertyId]);
        return $stmt->fetch();
    }

    public function propertyUpdate($id, $title, $propertyType, $address, $city, $price, $status) {
        $stmt = $this->conn->prepare("
            UPDATE Properties
            SET title = :title, propertyType = :propertyType, address = :address,
                city = :city, price = :price, status = :status
            WHERE propertyId = :id
        ");

        return $stmt->execute([
            ":title"        => $title,
            ":propertyType" => $propertyType,
            ":address"      => $address,
            ":city"         => $city,
            ":price"        => $price,
            ":status"       => $status,
            ":id"           => $id
        ]);
    }

    public function propertyRemove($propertyId) {

        $this->conn->prepare("DELETE FROM Transactions WHERE propertyId = :id")
            ->execute([":id" => $propertyId]);

        $this->conn->prepare("DELETE FROM Inquiries WHERE propertyId = :id")
            ->execute([":id" => $propertyId]);

        $this->conn->prepare("DELETE FROM Favorites WHERE propertyId = :id")
            ->execute([":id" => $propertyId]);

        $stmt = $this->conn->prepare("
            DELETE FROM Properties WHERE propertyId = :id
        ");

        return $stmt->execute([":id" => $propertyId]);
    }

    public function propertySearchEngine($city = "", $minPrice = 0, $maxPrice = 0) {
        $sql = "SELECT * FROM PropertyListingView WHERE 1=1";
        $params = [];

        if ($city !== "") {
            $sql .= " AND city = :city";
            $params[":city"] = $city;
        }

        if ($minPrice > 0) {
            $sql .= " AND price >= :minPrice";
            $params[":minPrice"] = $minPrice;
        }

        if ($maxPrice > 0) {
            $sql .= " AND price <= :maxPrice";
            $params[":maxPrice"] = $maxPrice;
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }


    public function inquirySubmitRecord(int $userId, int $propertyId, string $message): bool {
        $stmt = $this->conn->prepare("
            INSERT INTO Inquiries (userId, propertyId, message, inquiryDate)
            VALUES (:userId, :propertyId, :message, NOW())
        ");

        return $stmt->execute([
            ":userId"     => $userId,
            ":propertyId" => $propertyId,
            ":message"    => $message
        ]);
    }

    public function inquiryListForAgent($agentId) {
        $stmt = $this->conn->prepare("
            SELECT i.*, p.title, u.userName
            FROM Inquiries i
            JOIN Properties p ON i.propertyId = p.propertyId
            JOIN Users u ON i.userId = u.userId
            WHERE p.agentId = :agentId
        ");

        $stmt->execute([":agentId" => $agentId]);
        return $stmt->fetchAll();
    }


    public function favoriteAddEntry($userId, $propertyId) {
        $stmt = $this->conn->prepare("
            INSERT INTO Favorites (userId, propertyId, savedDate)
            VALUES (:userId, :propertyId, NOW())
        ");

        return $stmt->execute([
            ":userId"     => $userId,
            ":propertyId" => $propertyId
        ]);
    }

    public function favoriteDropEntry($userId, $propertyId) {
        $stmt = $this->conn->prepare("
            DELETE FROM Favorites
            WHERE userId = :userId AND propertyId = :propertyId
        ");

        return $stmt->execute([
            ":userId"     => $userId,
            ":propertyId" => $propertyId
        ]);
    }

    public function favoriteListForUser($userId) {
        $stmt = $this->conn->prepare("
            SELECT p.*, u.userName AS agentName
            FROM Favorites f
            JOIN Properties p ON f.propertyId = p.propertyId
            JOIN Users u ON p.agentId = u.userId
            WHERE f.userId = :userId
        ");

        $stmt->execute([":userId" => $userId]);
        return $stmt->fetchAll();
    }


    public function transactionExecuteFlow(int $propertyId, int $userId, string $type, float $amount): bool {
        $stmt = $this->conn->prepare("
            CALL ProcessTransaction(:propertyId, :userId, :type, :amount)
        ");

        return $stmt->execute([
            ":propertyId" => $propertyId,
            ":userId"     => $userId,
            ":type"       => $type,
            ":amount"     => $amount
        ]);
    }
}
?>
