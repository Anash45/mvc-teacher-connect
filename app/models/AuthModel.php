<?php

class AuthModel extends Model
{
    public function getUserByEmail($email)
    {
        $db = $this->db;
        $stmt = $db->prepare("SELECT * FROM Users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function isEmailTaken($email)
    {
        $db = $this->db;
        $stmt = $db->prepare("SELECT COUNT(*) FROM Users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public function createUser($name, $email, $password, $role)
    {
        $db = $this->db;
        $stmt = $db->prepare("INSERT INTO Users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $role]);
    }
}
