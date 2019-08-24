<?php


namespace application\models;

use application\core\Model;

class Account extends Model
{
    public function validate($input, $post)
    {
        $rules = [
            'email' => [
                'pattern' => '/.+@.+\..+/i',
                'message' => 'wrong email<br>'
            ],
            'login' => [
                'pattern' => '/^[a-z0-9]{3,15}$/i',
                'message' => 'wrong login<br>'
            ],
            'password' => [
                'pattern' => '/^(?=.*[0-9]+.*)(?=.*[a-zA-Z]+.*)[0-9a-zA-Z]{6,50}$/',
                'message' => 'password must contain 1 letter 1 number and at least 6 symbols long'
            ],
        ];
        foreach ($input as $value) {
            if (!isset($post[$value]) || empty($post[$value]) || !preg_match($rules[$value]['pattern'], $post[$value])) {
                echo $rules[$value]['message'];
                if ($value == 'password')
                    return false;
            }
        }
        return true;
    }

    public function checkEmailNotExists($email)
    {
        $params = [
            'email' => $email,
        ];
        if ($this->db->column('SELECT id FROM users WHERE email = :email', $params)) {
            return false;
        }
        return true;
    }

    public function validateLoginForm($login, $password)
    {
        if (preg_match('/^[a-z0-9]{3,15}$/i', $login) || preg_match('/.+@.+\..+/i', $login)) {
            if ($this->validatePassword($password)) {
                return "Success";
            } else {
                return ("Wrong password");
            }
        } else {
            return ("Email or login does not exist");
        }
    }

    public function checkLoginNotExists($login)
    {
        $params = [
            'login' => $login,
        ];
        if ($this->db->column('SELECT id FROM users WHERE login = :login', $params)) {
            return false;
        }
        return true;
    }

    public function validatePassword($password)
    {
        if (preg_match('/^(?=.*[0-9]+.*)(?=.*[a-zA-Z]+.*)[0-9a-zA-Z]{6,50}$/', $password)) {
            return true;
        }
        return false;
    }

    public function validateLogin($login)
    {
        if (preg_match('/^[a-z0-9]{3,15}$/i', $login)) {
            if ($this->checkLoginNotExists($login)) {
                return true;
            }
        }
        return false;
    }

    public function validateEmail($email)
    {
        if ($this->checkEmailNotExists($email)) {
            if (preg_match('/.+@.+\..+/i', $email)) {
                return true;
            }
        }
        return false;
    }

    public function checkPasswordById($password, $id)
    {
        $params = [
            'id' => $id,
        ];
        $password = $this->db->column('SELECT password FROM users WHERE id = :id', $params);
        return password_verify($_POST['password'], $password);
    }


    public function checkPassword($password, $password2)
    {
        if ($password === $password2) {
            return true;
        }
        return false;
    }

    public function createToken()
    {
        return bin2hex(openssl_random_pseudo_bytes(48));
    }

    public function register($post)
    {
        $token = $this->createToken();
        $params = [
            'email' => $post['email'],
            'login' => $post['login'],
            'password' => password_hash($post['password'], PASSWORD_BCRYPT),
            'rights' => 0,
            'token' => $token,
        ];
        $this->db->query('INSERT INTO users VALUES (NULL, :login, :email, :password, :token ,:rights, 1)', $params);
        mail($post['email'], 'Register', 'Camagru: confirm your email: https://192.168.21.14:8001/camagru/account/confirm/' . $token);
    }

    public function getIdByToken($token)
    {
        $params = [
            'token' => $token,
        ];
        return ($this->db->column(' SELECT id FROM users WHERE token = :token', $params));
    }

    public function getRightsByEmail($email)
    {
        $params = [
            'email' => $email,
        ];
        return ($this->db->column(' SELECT rights FROM users WHERE email = :email', $params));
    }

    public function confirmAccount($token)
    {
        $params = [
            'token' => $token,
        ];
        $this->db->query('UPDATE users SET rights = 1 WHERE token = :token', $params);
    }

    public function getInfoByEmailOrLogin($email)
    {
        $params = [
            'email' => $email,
        ];
        $array = $this->db->row('SELECT id, login, password, rights FROM users WHERE email = :email', $params);
        if ($array)
            return $array;
        $params = [
            'login' => $email,
        ];
        $login = $this->db->row('SELECT id, login, password, rights FROM users WHERE login = :login', $params);
        return $login;
    }

    public function sendMailRecovery($email)
    {
        $token = $this->createToken();
        $params = [
            'token' => $token,
            'email' => $email,
        ];
        $this->db->query('UPDATE users SET token = :token WHERE email = :email', $params);
        mail($email, 'Password recovery', 'Camagru: To recover your password follow this link. If it was not you, just ignore it: https://192.168.21.14:8001/camagru/account/reset/' . $token);
    }

    public function reset($token)
    {
        $params = [
            'token' => $token,
        ];
        $this->db->query('UPDATE users SET rights = 1 WHERE token = :token', $params);
    }

    public function changePasswordById($password, $id)
    {
        $params = [
            'id' => $id,
            'password' => password_hash($password, PASSWORD_BCRYPT, ["cost" => 15]),
        ];
        $this->db->query('UPDATE users SET password = :password WHERE id = :id', $params);
    }

    public function changeLoginById($login, $id)
    {
        $params = [
            'id' => $id,
            'login' => $login,
        ];
        $this->db->query('UPDATE users SET login = :login WHERE id = :id', $params);
    }

    public function updateLoginById($login, $id)
    {
        $message = array();
        if (preg_match('/^[a-z0-9]{3,15}$/i', $login)) {
            if ($this->checkLoginNotExists($login)) {
                $this->changeLoginById($login, $id);
                $message['login'] = 'Login has been successfully updated';
                $_SESSION['login'] = $login;
            } else {
                $message['login'] = 'Login is currently used';
            }
        } else {
            $message['login'] = 'Wrong login';
        }
        return ($message);
    }

    public function updatePasswordById($password, $id)
    {
        $message = array();
        if ($this->validatePassword($password)) {
            $this->changePasswordById($password, $id);
            $message['password'] = "Password successfully changed";
        } else {
            $message['password'] = "Password must contain 1 letter 1 number and at least 6 symbols long";
        }
        return $message;
    }

    public function updateNotifications()
    {
        $message = array();
        $id = $_SESSION['authorized']['id'];
        $params = [
            'id' => $id,
        ];
        $notifications = $this->db->column('SELECT Notifications FROM users WHERE id= :id', $params);
        if ($notifications === "1") {
            $this->db->query('UPDATE users SET Notifications = 0 WHERE id = :id', $params);
            $message['Notifications'] = "You won't get notifications on your email";
        } else if ($notifications === "0") {
            $this->db->query('UPDATE users SET Notifications = 1 WHERE id = :id', $params);
            $message['Notifications'] = "Subscribed to notifications on your email";
        }
        return $message;
    }

    public function changeTokenById($token, $id)
    {
        $params = [
            'id' => $id,
            'token' => $token,
        ];
        $this->db->query('UPDATE users SET token = :token WHERE id = :id', $params);
    }

    public function changeEmailById($email, $id)
    {
        $params = [
            'id' => $id,
            'email' => $email,
        ];
        $this->db->query('UPDATE users SET email = :email WHERE id = :id', $params);
    }

    public function resetRightsById($id)
    {
        $params = [
            'id' => $id,
            'rights' => 0,
        ];
        $this->db->query('UPDATE users SET rights = :rights WHERE id = :id', $params);
    }

    public function checkSameEmail($email)
    {
        $params = [
            'id' => $_SESSION['authorized']['id'],
        ];
        $currentEmail = $this->db->column('SELECT email FROM users WHERE id = :id', $params);
        if ($email === $currentEmail) {
            exit(json_encode("You already use this email"));
        } else {
            return true;
        }
    }

    public function updateEmailById($email)
    {
        $message = array();
        $this->checkSameEmail($email);
        if ($this->validateEmail($email)) {
            $this->changeEmailById($email, $_SESSION['authorized']['id']);
            $this->resetRightsById($_SESSION['authorized']['id']);
            $token = $this->createToken();
            $this->changeTokenById($token, $_SESSION['authorized']['id']);
            mail($email, 'Change email', 'Camagru: change your email: https://192.168.21.14:8001/camagru/account/confirm/' . $token);
            $message['email'] = "Success";
            session_unset();
            return $message;
        } else {
            $message['email'] = 'Wrong email';
            return $message;
        }
    }
}