<?php
class Database
{
    private static $instance = null;

    public function __construct()
    {

    }
    private function __clone()
    {

    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new PDO(
                "sqlite:" . "database/database.db",
                "",
                "",
                array(
                    PDO::ATTR_PERSISTENT => true
                )
            );
        }
        self::initializeDatabase();
        return self::$instance;
    }

    private static function initializeDatabase()
    {
        //Prüfen ob Tabelle Existiert
        $result = self::$instance->query("PRAGMA table_info(sharing_post)");

        // Tabelle erstellen, wenn sie nicht existiert
        self::$instance->exec("
        CREATE TABLE IF NOT EXISTS sharing_address (
            adr_id INTEGER PRIMARY KEY,
            postcode VARCHAR(10) NOT NULL,
            city VARCHAR(100) NOT NULL,
            street VARCHAR(100) NOT NULL,
            house_number VARCHAR(10) NOT NULL
        )
        ");

        // Tabelle erstellen, wenn sie nicht existiert
        self::$instance->exec("
        CREATE TABLE IF NOT EXISTS sharing_post (
            post_id INTEGER PRIMARY KEY,
            title VARCHAR(100) NOT NULL,
            mhd DATE NOT NULL,
            img_path VARCHAR(255),
            description VARCHAR(65535),
            food_type VARCHAR(20) NOT NULL,
            adr_id INT NOT NULL,
            claimer_id INTEGER,
            creator_id INTEGER NOT NULL,
            FOREIGN KEY (claimer_id) REFERENCES sharing_user(usr_id),
            FOREIGN KEY (creator_id) REFERENCES sharing_user(usr_id),
            FOREIGN KEY (adr_id) REFERENCES sharing_address(adr_id)
        )
        ");

        // Tabelle erstellen, wenn sie nicht existiert
        self::$instance->exec("
        CREATE TABLE IF NOT EXISTS sharing_user (
            usr_id INTEGER PRIMARY KEY,
            email VARCHAR(100) NOT NULL,
            password VARCHAR(255) NOT NULL,
            validated INTEGER NOT NULL,
            consent INTEGER NOT NULL
        )
        ");

        //Wenn sie vorher nicht existiert hat, dann Testkarte und Testuser einfügen
        if (!$result->fetch()) {
            $stmt = self::$instance->prepare("INSERT INTO sharing_user (email, password, validated, consent) VALUES (?, ?, ?, ?)");
            $stmt->execute(["test@test.de", password_hash("123", PASSWORD_DEFAULT), 1, 1]);
            $usr_id = self::$instance->lastInsertId();

            $stmt1 = self::$instance->prepare("INSERT INTO sharing_address (postcode, city, street, house_number) VALUES (?, ?, ?, ?)");
            $stmt1->execute(["26203", "Ehrenburg", "Hauptstraße", "12"]);
            $adr_id = self::$instance->lastInsertId();
            $stmt1->execute(["26203", "Ehrenburg", "Schulstraße", "6"]);
            $adr_id2 = self::$instance->lastInsertId();
            $stmt2 = self::$instance->prepare("
            INSERT INTO sharing_post (title, mhd, img_path, description, food_type, adr_id, claimer_id, creator_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt2->execute([
                "Halber Döner",
                "01.10.2023",
                "assets/lecker.jpg",
                "Hier könnte deine Werbung stehen",
                "vegan",
                $adr_id,
                null,
                $usr_id
            ]);

            $stmt2->execute([
                "Lecker Essen",
                "01.10.2023",
                "assets/nopic.jpg",
                "Hier könntest du dein Essen anbieten",
                "veggi",
                $adr_id2,
                null,
                $usr_id
            ]);

            $stmt2->execute([
                "Camembert mit Kroketten",
                "01.10.2023",
                "assets/beispielbilder/kroketundcamem.jpg",
                "Lecker Camembert mit Kroketten",
                "veggi",
                $adr_id,
                null,
                $usr_id
            ]);

            $stmt2->execute([
                "Camembert ohne Kroketten",
                "01.10.2023",
                "assets/beispielbilder/camembert.jpg",
                "Lecker Camembert ohne Kroketten",
                "veggi",
                $adr_id2,
                null,
                $usr_id
            ]);

            $stmt2->execute([
                "Apfel",
                "01.10.2023",
                "assets/beispielbilder/apfel.jpg",
                "Lecker Apfel",
                "vegan",
                $adr_id2,
                null,
                $usr_id
            ]);

            $stmt2->execute([
                "Bananen",
                "01.10.2023",
                "assets/beispielbilder/bananen.jpg",
                "Bananen, wollen gerettet werden",
                "vegan",
                $adr_id2,
                null,
                $usr_id
            ]);

            $stmt2->execute([
                "Brot",
                "01.10.2023",
                "assets/beispielbilder/brot.jpg",
                "Brot, will gerettet werden",
                "vegan",
                $adr_id2,
                null,
                $usr_id
            ]);

            $stmt2->execute([
                "Ravioli",
                "01.10.2025",
                "assets/beispielbilder/ravioli.jpg",
                "Feinste Maggi Ravioli",
                "Fleisch",
                $adr_id2,
                null,
                $usr_id
            ]);

            $stmt2->execute([
                "Haferflocken",
                "01.10.2025",
                "assets/beispielbilder/haferflocken.jpg",
                "Beste gut und günstig Haferflocken",
                "vegetarisch",
                $adr_id,
                null,
                $usr_id
            ]);

            $stmt2->execute([
                "Nudeln",
                "01.10.2025",
                "assets/beispielbilder/nudeln.jpg",
                "Schmackhafte Barilla Marken Nudeln",
                "vegan",
                $adr_id2,
                null,
                $usr_id
            ]);
        }
    }
}
?>