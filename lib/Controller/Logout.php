<?php

namespace MyApp\Controller;

class Logout extends \MyApp\Controller {

  public function run() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->_postProcess();
    }
  }

  private function _postProcess() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // validate
      $this->_validate();

      // init Session/Cookie
      $_SESSION = [];
      if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 86400, '/');
      }
      session_destroy();
    }

    // redirect to home
    header('Location: ' . SITE_URL);
  }

  private function _validate() {
    if (
      !isset($_POST['token']) ||
      !isset($_SESSION['token']) ||
      $_POST['token'] !== $_SESSION['token']
    ) {
      echo 'Invalid Token!';
      exit;
    }
  }


}
