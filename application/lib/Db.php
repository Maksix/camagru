<?php

namespace application\lib;

use PDO;

class Db
{
    protected $db;

    public function __construct()
    {
        $config = require 'application/config/db.php';
        $this->db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'] . '', $config['user'], $config['password']);
        $isTableUsersExists = $this->column('SELECT 1 FROM users LIMIT 1');
        if (!$isTableUsersExists) {
            $sql = "
            CREATE TABLE `users` (
            `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `login` VARCHAR(16) NOT NULL,
            `email` VARCHAR(255) NOT NULL,
            `password` VARCHAR(255) NOT NULL,
            `token` VARCHAR(255) NOT NULL,
            `rights` INT(11) NOT NULL DEFAULT 0,
            `Notifications` INT(11) NOT NULL DEFAULT 1
            );";
            $this->db->query($sql);
        }
        $isTablePhotosExists = $this->column('SELECT 1 FROM photos LIMIT 1');
        if (!$isTablePhotosExists) {
            $sql = "
            CREATE TABLE `photos` (
            `id` INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_id` INT(20) NOT NULL,
            `user_login` VARCHAR(30) NOT NULL,
            `date` VARCHAR(25) NOT NULL,
            `time` INT(11) NOT NULL,
            `likes` INT(11) NOT NULL DEFAULT 0,
             `path` VARCHAR(50) NOT NULL,
            `saved` INT(1) NOT NULL
            );";
            $this->db->query($sql);
        }
        $isTableCommentsExists = $this->column('SELECT 1 FROM comments LIMIT 1');
        if (!$isTableCommentsExists) {
            $sql = "
            CREATE TABLE `comments_test` (
            `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `photo_id` INT(11) NOT NULL,
            `comment_text` VARCHAR(120) NOT NULL,
            `user_login` VARCHAR(30) NOT NULL,
            `date` VARCHAR(25) NOT NULL
            );";
            $this->db->query($sql);
        }

}

public
function query($sql, $params = [])
{
    $stmt = $this->db->prepare($sql);
    if (!empty($params)) {
        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
    }
    $stmt->execute();
    return $stmt;
}

public
function row($sql, $params = [])
{
    $result = $this->query($sql, $params);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

public
function column($sql, $params = [])
{
    $result = $this->query($sql, $params);
    return $result->fetchColumn();
}
}