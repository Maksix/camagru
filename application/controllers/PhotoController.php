<?php

namespace application\controllers;

use application\core\Controller;

class PhotoController extends Controller
{
    public function photoAction()
    {
        date_default_timezone_set('Europe/Moscow');
        if (isset($_FILES['file'])) {
            if (strlen($_FILES['file']['name']) > 0) {
                if ($_FILES['file']['size'] < 5000000 && $_FILES['file']['size'] > 25000) {
                    $random_name = bin2hex(random_bytes(10));
                    $name = basename($_FILES['file']['name']);
                    $extension = (strtolower(pathinfo($name, PATHINFO_EXTENSION)));
                    $path = '/var/www/html/data/' . $random_name . "." . $extension;
                    if ($extension === 'jpg' || $extension === 'png' || $extension === 'jpeg') {
                        if (move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
                            $this->model->addPhoto($_SESSION['authorized']['id'], date('j F H : i'), time(), substr($path, 13));
                            exit(json_encode(substr($path, 13)));
                        } else {
                            exit(json_encode("Could not upload file"));
                        }
                    } else {
                        exit(json_encode("Wrong extension of file. Allowed extensions are .PNG, .JPEG AND .JPG"));
                    }
                } else {
                    exit (json_encode("Image size can't be more than 5Mb and less than 100Kb"));
                }
            } else {
                exit (json_encode("No file chosen"));
            }
        }

        if (isset($_POST['image']) && $_POST['image']) {
            if (strlen($_POST['image']) * 0.775 < 5000000) {
                $data = explode(',', $_POST['image']);
                $var = str_replace(' ', '+', $data[1]);
                $string = base64_decode($var);
                $image = imagecreatefromstring($string);
                if (isset($_POST['sticker']) && $_POST['sticker'] !== 'noSticker' && imagesx($image) > 256 && imagesy($image) > 256) {
                    $sticker = imagecreatefrompng('/var/www/html/camagru/application/views/images/' . $_POST['sticker'] . ".png");
                    imagecopymerge($image, $sticker, 10, 10, 0, 0, imagesx($sticker), imagesy($sticker), 100);
                }
                if (isset($_POST['filter']) && $_POST['filter'] !== 'noFilter') {
                    $this->model->applyFilter($_POST['filter'], $image);
                }
                $name = bin2hex(random_bytes(15));
                $path = '/var/www/html/data/' . $name . '.png';
                imagepng($image, $path);
                $this->model->deleteUnsavedPhoto($_SESSION['authorized']['id']);
                $this->model->addPhoto($_SESSION['authorized']['id'], date('j F H:i'), time(), substr($path, 13));
                exit(json_encode(substr($path, 13)));
            } else {
                exit (json_encode("SizeError"));
            }
        }

        if (isset($_POST['apply'])) {
            $path = $this->model->getLastUploadedImage($_SESSION['authorized']['id']);
            $extension = substr($path, -3);
            if ($extension === "jpg" || $extension === "jpeg") {
                $image = imagecreatefromjpeg('/var/www/html' . $path);
            } elseif ($extension === "png") {
                $image = imagecreatefrompng('/var/www/html' . $path);
            } else {
                exit(json_encode("Wrong extension" . $extension));
            }
            if (isset($_POST['sticker']) && $_POST['sticker'] !== 'noSticker' && imagesx($image) > 256 && imagesy($image) > 256) {
                $sticker = imagecreatefrompng('/var/www/html/camagru/application/views/images/' . $_POST['sticker'] . ".png");
                imagecopymerge($image, $sticker, 10, 10, 0, 0, imagesx($sticker), imagesy($sticker), 100);
            }
            if (isset($_POST['filter']) && $_POST['filter'] !== 'noFilter') {
                $this->model->applyFilter($_POST['filter'], $image);
            }
            $name = bin2hex(random_bytes(15));
            $newPath = '/var/www/html/data/' . $name . ".png";
            imagepng($image, $newPath);
            $this->model->addPhoto($_SESSION['authorized']['id'], date('j F H:i'), time(), substr($newPath, 13));
            exit(json_encode(substr($newPath, 13)));
        }

        if (isset($_POST['save'])) {
            $path = $this->model->savePhoto($_SESSION['authorized']['id']);
            $this->model->createLikeTable($_SESSION['authorized']['id']);
            exit (json_encode($path));
        }

        $this->model->deleteUnsavedPhoto($_SESSION['authorized']['id']);

        if ($data = $this->model->getPathsByLogin($_SESSION['login'])) {
            $this->view->render("Photo page", $data);
        } else {
            $this->view->render("Photo page");
        }
    }
}
