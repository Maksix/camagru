<?php


namespace application\models;

use application\core\Model;

class Photo extends Model
{
    public function addPhoto($userId, $date, $time, $path)
    {
        $params = [
            'user_id' => $userId,
        ];
        $userlogin = $this->db->column('SELECT login FROM users WHERE id= :user_id', $params);
        $params = [
            'user_id' => $userId,
            'user_login' => $userlogin,
            'date' => $date,
            'time' => $time,
            'path' => $path,
        ];
        $this->db->query('INSERT INTO photos VALUES (NULL, :user_id, :user_login , :date, :time, 0, :path, 0)', $params);
    }

    public function savePhoto($userId)
    {
        $params = [
            'user_id' => $userId,
        ];
        $this->db->query('UPDATE photos SET saved = 1 WHERE user_id = :user_id ORDER BY time DESC LIMIT 1', $params);
        $path = $this->db->column('SELECT path FROM photos ORDER BY time DESC LIMIT 1');
        return ($path);
    }

    public function createLikeTable($userId)
    {
        $params = [
            'user_id' => $userId,
        ];
        $photoId = $this->db->column('SELECT id FROM photos WHERE saved = 1 AND user_id = :user_id ORDER BY time DESC LIMIT 1', $params);
        $params = [
            'photo_id' => "photo_" . $photoId,
        ];
        $this->db->query('CREATE TABLE `:photo_id` (
            `likedUserId` int(11),
             PRIMARY KEY (`likedUserId`)
            );', $params);
    }

    public function deleteUnsavedPhoto($userId)
    {
        $params = [
            'user_id' => $userId,
        ];
        $array = $this->db->row('SELECT path FROM photos WHERE user_id = :user_id AND saved = 0 AND time = (SELECT MIN(time) from photos) ', $params);
        foreach ($array as $key => $value) {
            foreach ($value as $string => $path) {
                shell_exec('cd /var/www/html/data && rm ' . substr($path, 6));
            }
        }
        $this->db->query('DELETE FROM photos WHERE user_id = :user_id AND saved = 0 ', $params);
    }

    public function applyFilter($filter, $image)
    {
        if ($filter == 'Negative') {
            imagefilter($image, IMG_FILTER_NEGATE);
        } elseif ($filter == 'GrayScale') {
            imagefilter($image, IMG_FILTER_GRAYSCALE);
        } elseif ($filter == 'Emboss') {
            imagefilter($image, IMG_FILTER_EMBOSS);
        } elseif ($filter == 'Pixel' && isset($_POST['pixel']) && preg_match("/^[0-9]{0,2}$/", $_POST['pixel']) && $_POST['pixel'] !== '1') {
            imagefilter($image, IMG_FILTER_PIXELATE, $_POST['pixel']);
        }
    }

    public function getLastUploadedImage($userId)
    {
        $params = [
            'user_id' => $userId,
        ];
        $path = $this->db->column('SELECT path FROM photos WHERE user_id = :user_id AND saved = 0 AND LENGTH(path) < 35 AND time = (SELECT MAX(time) from photos WHERE LENGTH(path) < 35)', $params);
        return $path;
    }

    public function getPathsByLogin($login)
    {
        $params = [
            'login' => $login,
        ];
        if ($paths = $this->db->row('SELECT path FROM photos WHERE saved = 1 AND user_id = (SELECT id FROM users WHERE login = :login) ORDER BY time DESC LIMIT 5', $params)) {
            $data = [
                'paths' => $paths,
            ];
            return $data;
        }
        return false;
    }

}