<?php

namespace MyApp\Controller;

class Signup extends \MyApp\Controller {

  public function run() {
    if ($this->isLoggedIn()) {
      // login
      header('Location: ' . SITE_URL);
      exit;
    }
    // get users info
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->_postProcess();
    }
  }

  private function _postProcess() {
    // validate
    try {
      $this->_validate();
    } catch (\MyApp\Exception\InvalidEmail $e) {
      $this->setErrors('email', $e->getMessage());
    } catch (\MyApp\Exception\InvalidPassword $e) {
      $this->setErrors('password', $e->getMessage());
    }

    $this->setValues('email', $_POST['email']);

    if ($this->hasError()) {
      return;
    } else {
      // create users
      try {
        $userModel = new \MyApp\Model\User();
        $userModel->create([
          'email' => $_POST['email'],
          'password' => $_POST['password'],
        ]);
      } catch (\MyApp\Exception\DuplicateEmail $e) {
        $this->setErrors('email', $e->getMessage());
        return;
      }

      // redirect to login
      header('Location: ' . SITE_URL . '/login.php');
      exit;
    }

  }

  private function _validate() {
    if (
      !isset($_POST['token']) ||
      // !isset($_SESSION['token']) ||
      $_POST['token'] !== $_SESSION['token']
    ) {
      echo 'Invalid Token!';
      exit;
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      throw new \MyApp\Exception\InvalidEmail();
    }
    if (!preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['password'])) {
      throw new \MyApp\Exception\InvalidPassword();
    }
  }

}
