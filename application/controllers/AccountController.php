<?php

namespace application\controllers;

use application\core\Controller;

class AccountController extends Controller
{
    public function loginAction()
    {
        if (isset($_POST['submit'])) {
            $error = $this->model->validateLoginForm($_POST['email'], $_POST['password']);
            if ($error === "Success") {
                if ($info = $this->model->getInfoByEmailOrLogin($_POST['email'])) {
                    if ($info[0]['rights'] == 1) {
                        if (password_verify($_POST['password'], $info[0]['password'])) {
                            $_SESSION['authorized']['id'] = $info[0]['id'];
                            $_SESSION['login'] = $info[0]['login'];
                            exit("Success");
                        } else {
                            exit("Wrong password");
                        }
                    } else {
                        exit("Email is not verified");
                    }
                } else {
                    exit("Email or login does not exist");
                }
            } else {
                exit($error);
            }
        }
        $this->view->render('Login');
    }

    public function registerAction()
    {
        $errors = array();
        if (isset($_POST['submit'])) {
            if (!preg_match('/.+@.+\..+/i', $_POST['email'])) {
                $errors['invalidEmail'] = "Wrong email";
            }
            if (!$this->model->validatePassword($_POST['password'])) {
                $errors['invalidPassword'] = 'Password must contain 1 letter 1 number and at least 6 symbols long and be alphanumeric';
            }
            if (!$this->model->validateLogin($_POST['login'])) {
                $errors['invalidLogin'] = 'Login contains only letters and numbers at least 3 symbols and less than 15 symbols';
            }
            if (!$this->model->checkEmailNotExists($_POST['email'])) {
                $errors['usedEmail'] = 'Email already exists';
            }
            if (!$this->model->checkLoginNotExists($_POST['login'])) {
                $errors['usedLogin'] = 'Login already exists';
            }
            if (!$this->model->checkPassword($_POST['password'], $_POST['password2'])) {
                $errors['matchPasswords'] = 'Passwords do not match';
            }
            if (empty($errors)) {
                $this->model->register($_POST);
                exit('Success');
            } else {
                exit(json_encode($errors));
            }
        }
        $this->view->render('Register');
    }

    public function recoveryAction()
    {
        if (!empty($_POST)) {
            $errors = array();
            if ($this->model->checkEmailNotExists($_POST['email'])) {
                $errors['Email'] = 'Email is not registered';
                exit(json_encode($errors));
            } elseif (!$this->model->getRightsByEmail($_POST['email'])) {
                $errors['Email'] = 'Email is not verified';
                exit(json_encode($errors));
            } else {
                $this->model->sendMailRecovery($_POST['email']);
                exit('Success');
            }
        }
        $this->view->render('Recovery');
    }

    public function confirmAction()
    {
        if ($this->model->getIdByToken($this->route['token'])) {
            $this->model->confirmAccount($this->route['token']);
            $this->view->render('Registration complete');
        } else {
            $this->view->errorCode(404);
        }
    }

    public function logoutAction()
    {
        if (isset($_SESSION)) {
            session_unset();
        }
        $this->view->redirect('/camagru/');
    }

    public function resetAction()
    {
        if (isset($this->route['token'])) {
            $_SESSION['id'] = $this->model->getIdByToken($this->route['token']);
        }
        if (!empty($_POST) && isset($_POST['password'])) {
            $errors = array();

            if (!$this->model->validatePassword($_POST['password'])) {
                $errors['invalidPassword'] = 'Password must contain 1 letter 1 number and at least 6 symbols long';
            }
            if (!$this->model->checkPassword($_POST['password'], $_POST['password2'])) {
                $errors['matchPasswords'] = 'Passwords do not match';
            }
            if (empty($errors)) {
                $this->model->changePasswordById($_POST['password'], $_SESSION['id']);
                exit('Success');
            } else {
                exit(json_encode($errors));
            }
        }
        $this->view->render('Reset');
    }

    public function editAction()
    {
        if (isset($_SESSION['passwordConfirmed']) && isset($_POST['login'])) {
            $message = $this->model->updateLoginById($_POST['login'], $_SESSION['authorized']['id']);
            exit(json_encode($message));
        }
        if (isset($_SESSION['passwordConfirmed']) && isset($_POST['newPassword'])) {
            $message = $this->model->updatePasswordById($_POST['newPassword'], $_SESSION['authorized']['id']);
            exit(json_encode($message));
        }
        if (isset($_SESSION['passwordConfirmed']) && isset($_POST['email'])) {
            $message = $this->model->updateEmailById($_POST['email']);
            exit(json_encode($message));
        }
        if (isset($_SESSION['passwordConfirmed']) && isset($_POST['Notifications'])) {
            $message = $this->model->updateNotifications();
            exit(json_encode($message));
        }
        if (isset($_POST['password'])) {
            if ($this->model->checkPasswordById($_POST['password'], $_SESSION['authorized']['id'])) {
                $_SESSION['passwordConfirmed'] = 1;
                exit('Success');
            } else {
                $errors = array();
                $errors['passwordError'] = 'Wrong password';
                $_SESSION['wrongPassword'] = 1;
                exit(json_encode($errors));
            }
        }
        $this->view->render('Edit account');
    }
}
