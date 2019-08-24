<?php

namespace application\models;

use application\core\Model;

class Main extends Model
{
    public function getNamesByLetters($letters, $login)
    {
        $params = [
            'login' => $login,
        ];
        $string = "SELECT login FROM users WHERE login LIKE " . "\"" . $letters . "%\" AND login != :login LIMIT 5";
        $array = $this->db->row($string, $params);
        return $array;
    }

    public function searchUser($search)
    {
        if (!isset($_SESSION['login'])) {
            $_SESSION['login'] = 0;
        }
        $names = $this->getNamesByLetters($search, $_SESSION['login']);
        exit (json_encode($names));
    }

    public function getPathsByPage($page)
    {
        $sql = "SELECT path FROM photos WHERE saved = 1 ORDER BY time DESC LIMIT 10 OFFSET " . ($page - 1) * 10;
        if ($paths = $this->db->row($sql)) {
            return $paths;
        }
        return false;
    }

    public function getLikesByPage($page)
    {
        $sql = "SELECT likes FROM photos WHERE saved = 1 ORDER BY time DESC LIMIT 10 OFFSET " . ($page - 1) * 10;
        if ($likes = $this->db->row($sql)) {
            return $likes;
        }
        return false;
    }

    public function getLoginsByPage($page)
    {
        $sql = "SELECT user_login FROM photos WHERE saved = 1 ORDER BY time DESC LIMIT 10 OFFSET " . ($page - 1) * 10;
        if ($logins = $this->db->row($sql)) {
            return $logins;
        }
        return false;
    }

    public function getLikedPhotosByPage($page)
    {
        $sql = "SELECT id FROM photos WHERE saved = 1 ORDER BY time DESC LIMIT 10 OFFSET " . ($page - 1) * 10;
        $photoId = $this->db->row($sql);
        foreach ($photoId as $key => $value) {
            $sql = 'SELECT * FROM `\'' . 'photo_' . $value['id'] . "'`" . " WHERE likedUserId = " . $_SESSION['authorized']['id'];
            $array[] = $this->db->column($sql);
        }
        if (isset($array)){
            return $array;
        }
        return false;
    }

    public function getDateByPage($page)
    {
        $sql = "SELECT date FROM photos WHERE saved = 1 ORDER BY time DESC LIMIT 10 OFFSET " . ($page - 1) * 10;
        if ($dates = $this->db->row($sql)) {
            return $dates;
        }
        return false;
    }

    public function getLikesByPath($path)
    {
        $params = [
            'path' => $path,
        ];
        if ($likes = $this->db->row('SELECT likes FROM photos WHERE path =:path', $params)) {
            $array['likes'] = $likes[0]['likes'];
            $array['path'] = $path;
            exit(json_encode($array));
        }
        return false;
    }

    public function deletePhoto($photo)
    {
        if (file_exists("/var/www/html" . $photo)) {
            $params = [
                'path' => $photo,
            ];
            $photoId = $this->db->column('SELECT id FROM photos WHERE path = :path', $params);
            $this->db->query('DELETE FROM comments WHERE photo_id = \'' . $photoId . '\'');
            $sql = 'DROP TABLE `\'' . 'photo_' . $photoId . '\'`';
            $this->db->column('DELETE FROM photos WHERE path = :path', $params);
            shell_exec('cd /var/www/html/data && rm ' . substr($photo, 6));
            $this->db->query($sql);
            exit (json_encode("Deleted"));
        }
    }

    public function likePhoto($photo, $userId)
    {
        $params = [
            'path' => $photo,
        ];
        $photoId = $this->db->column('SELECT id FROM photos WHERE path = :path', $params);
        $sql = 'SELECT likedUserId FROM `\'' . 'photo_' . $photoId . '\'` ' . 'WHERE likedUserId = ' . $userId;
        $response = $this->db->row($sql);
        if (!$response) {
            $sql = 'INSERT INTO `\'' . 'photo_' . $photoId . '\'` ' . 'VALUES (' . $userId . ')';
        } else {
            $sql = 'DELETE FROM `\'' . 'photo_' . $photoId . '\'` ' . 'WHERE likedUserId = ' . $userId;
        }
        $this->db->query($sql);
        $sql = 'UPDATE photos SET `likes` = (SELECT COUNT(*) FROM `\'' . 'photo_' . $photoId . '\'`) WHERE path =:path';
        $this->db->query($sql, $params);
    }

    public function commentPhoto($photo, $comment, $id, $date)
    {
        $params = [
            'id' => $id,
        ];
        $userLogin = $this->db->column('SELECT login FROM users WHERE id =:id', $params);
        $params = [
            'path' => $photo,
        ];
        $photoOwnerLogin = $this->db->column('SELECT user_login FROM photos WHERE path = :path',$params);
        $login = [
            'login' => $photoOwnerLogin,
        ];
        if ($this->db->column('SELECT Notifications FROM users WHERE login = :login', $login) === "1" && $photoOwnerLogin !== $userLogin) {
            $photoOwnerEmail = $this->db->column('SELECT email FROM users WHERE login = :login', $login);
            mail($photoOwnerEmail, 'Your photo was commented', "Your photo was commented by " . $userLogin . ": " . $comment);
        }
        $comment = $this->replace($comment);
        $photo_id = $this->db->column('SELECT id FROM photos WHERE path =:path', $params);
        $sql = 'INSERT INTO comments VALUES (NULL, ' . $photo_id . ', \'' . $comment . '\', \'' . $userLogin . '\', \'' . $date . '\')';
        $this->db->query($sql);
        exit(json_encode("commented"));
    }

    public function replace($comment)
    {
        $comment = preg_replace("/\?amp;/", "&amp;", $comment);
        $comment = preg_replace("/\?lt;/", "&lt;", $comment);
        $comment = preg_replace("/\?gt;/", "&gt;", $comment);
        $comment = preg_replace("/\?quot;/", "&quot;", $comment);
        $comment = preg_replace("/\?#039;/", "&#039;", $comment);
        return html_entity_decode($comment);
    }

    public function getCommentsByPath($path)
    {
        $params = [
            'path' => $path,
        ];
        $photoId = $this->db->column('SELECT id FROM photos WHERE path =:path', $params);
        $params = [
            'photo_id' => $photoId,
        ];
        $comments = $this->db->row('SELECT user_login, comment_text, date FROM comments WHERE photo_id =:photo_id', $params);
        exit(json_encode($comments));
    }

    public function getDataByPage($page)
    {
        $paths = $this->getPathsByPage($page);
        $likes = $this->getLikesByPage($page);
        $logins = $this->getLoginsByPage($page);
        $date = $this->getDateByPage($page);
        $numberOfPages = $this->getNumberOfPages();
        $liked = $this->getLikedPhotosByPage($page);
        $pathss = [
            'isliked' => $liked,
            'page' => $page,
            'numberOfPages' => $numberOfPages,
            'paths' => $paths,
            'likes' => $likes,
            'logins' => $logins,
            'date' => $date,
        ];
        return $pathss;
    }

    public function getNumberOfPages()
    {
        return intval(ceil($this->db->column('SELECT COUNT(*) FROM photos') / 10));
    }
}