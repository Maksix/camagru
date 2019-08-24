<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;

class GalleryController extends Controller
{
    public function galleryAction()
    {
        date_default_timezone_set('Europe/Moscow');
        if (isset($this->route['login']) && $this->model->isLoginExists($this->route['login'])) {
            if (isset($_SESSION['login']) && $this->route['login'] === $_SESSION['login']) {
                $_SESSION['profile'] = '2';
            } elseif (isset($_SESSION['login']) && $_SESSION['login'] !== 0) {
                $_SESSION['profile'] = '1';
            } else {
                $_SESSION['profile'] = '0';
            }
            if (isset($_POST['name'])) {
                if ($_POST['name'] == "delete") {
                    $this->model->deletePhoto($_POST['path']);
                }
                if ($_POST['name'] == 'like') {
                    $this->model->likePhoto($_POST['path'], $_SESSION['authorized']['id']);
                    $this->model->getLikesByPath($_POST['path']);
                }
                if ($_POST['name'] == 'comment') {
                    $this->model->commentphoto($_POST['path'], $_POST['comment'], $_SESSION['authorized']['id'], date('j F H i'));
                }
                if ($_POST['name'] == 'show') {
                    $this->model->getCommentsByPath($_POST['path']);
                }
            }
            if ($data = $this->model->getDataByLogin($this->route['login'])) {
                $this->view->render("Gallery page", $data);
                exit;
            }
        } else {
            View::errorCode(404);
        }
        $this->view->render("Gallery page");
    }
}
