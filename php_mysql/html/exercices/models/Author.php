<?php
require_once dirname(__FILE__) . '/../config/db.php';

class Author
{
    private $id;
    private $name;

    public function __construct($name = null)
    {
        if (!empty($name)) {
            $this->setName($name);
        }
    }

    public function setName($name)
    {
        if (strlen($name) < 2) {
            throw new Exception("Nom trop court.");
        }
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public static function getList()
    {
        global $dsn, $db_user, $db_pass;
        $dbh = new PDO($dsn, $db_user, $db_pass);

        $stmt = $dbh->prepare("SELECT id, name FROM author");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function get($author_id) {
        global $dsn, $db_user, $db_pass;
        $dbh = new PDO($dsn, $db_user, $db_pass);

        try {
            $stmt = $dbh->prepare("SELECT id, name FROM author WHERE id = :author_id");
            $stmt->bindParam(':author_id', $author_id);

            $stmt->execute();
            return $stmt->fetchObject(__CLASS__);
        } catch (PDOException $e) {
            throw new Error($e);
        }
    }
}
