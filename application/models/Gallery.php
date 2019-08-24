<?php


namespace application\models;

use application\core\Model;

class Gallery extends Model
{
    public function isLoginExists($login)
    {
        $params = [
            'login' => $login,
        ];

        if ($this->db->column('SELECT id FROM users WHERE login = :login', $params)) {
            return true;
        }
        return false;
    }

    public function getPathsByLogin($login)
    {
        $params = [
            'login' => $login,
        ];
        if ($paths = $this->db->row('SELECT path FROM photos WHERE saved = 1 AND user_id = (SELECT id FROM users WHERE login = :login) ORDER BY time DESC', $params)) {
            return $paths;
        }
        return false;
    }

    public function getLikesByLogin($login)
    {
        $params = [
            'login' => $login,
        ];
        if ($likes = $this->db->row('SELECT likes FROM photos WHERE saved = 1 AND user_id = (SELECT id FROM users WHERE login = :login) ORDER BY time DESC', $params)) {
            return $likes;
        }
        return false;
    }

    public function getDateByLogin($login)
    {
        $params = [
            'login' => $login,
        ];
        if ($date = $this->db->row('SELECT date FROM photos WHERE saved = 1 AND user_id = (SELECT id FROM users WHERE login = :login) ORDER BY time DESC', $params)) {
            return $date;
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

    public function getLikedPhotos()
    {
        $params = [
            'user_id' => $_SESSION['authorized']['id'],
        ];
        $photoId = $this->db->row('SELECT id FROM photos WHERE user_id = :user_id ORDER BY time DESC', $params);
        foreach ($photoId as $key => $value) {
            $sql = 'SELECT * FROM `\'' . 'photo_' . $value['id'] . "'`" . " WHERE likedUserId = " . $_SESSION['authorized']['id'];
            $array[] = $this->db->column($sql);
        }
        if (isset($array)){
            return $array;
        }
        return false;
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

    public function getDataByLogin($login)
    {
        $paths = $this->getPathsByLogin($login);
        $likes = $this->getLikesByLogin($login);
        $date = $this->getDateByLogin($login);
        $liked = $this->getLikedPhotos();
        if ($_SESSION['login'] === $login) {
            $login = "Your";
        }
        $data = [
            'isliked' => $liked,
            'paths' => $paths,
            'likes' => $likes,
            'date' => $date,
            'login' => $login,
        ];
        return $data;
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
        $comments = $this->db->row('SELECT user_login, comment_text, date FROM comments WHERE photo_id =:photo_id',$params);
        exit(json_encode($comments));
    }
}