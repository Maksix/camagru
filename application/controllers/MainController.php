<?php


namespace application\controllers;

use application\core\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        date_default_timezone_set('Europe/Moscow');
        if (isset($_POST['search'])) {
            $this->model->searchUser($_POST['search']);
        }
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
        $page = intval($this->route['page']);
        if ($page === 0) {
            $page = 1;
        }
        if ($data = $this->model->getDataByPage($page)) {
            $this->view->render("Main page", $data);
            exit;
        }
        $this->view->render("Main page");
    }
}