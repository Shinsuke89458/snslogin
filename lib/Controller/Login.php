<?php

/*****************************************************************************************
  ログインに関するコントローラー
*****************************************************************************************/

namespace MyApp\Controller;

class Login extends \MyApp\Controller {

        /******************************
       * ログイン メインメソッド
      *******************************/
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


      /******************************/
      private function _postProcess() {
        // validate
        try {
          $this->_validate();
        } catch (\MyApp\Exception\EmptyPost $e) {
          $this->setErrors('login', $e->getMessage());
        }

        $this->setValues('email', $_POST['email']);

        if ($this->hasError()) {
          return;
        } else {
          try {
            $userModel = new \MyApp\Model\User();
            $user = $userModel->login([
              'email' => $_POST['email'],
              'password' => $_POST['password'],
            ]);
          } catch (\MyApp\Exception\UnmatchEmailOrPassword $e) {
            $this->setErrors('login', $e->getMessage());
            return;
          }

          // Login
          session_regenerate_id(true); // Session hijacking measures
          $_SESSION['me'] = $user;

          // redirect to home
          header('Location: ' . SITE_URL);
          exit;
        }

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

        if (!isset($_POST['email']) || !isset($_POST['password'])) {
          echo 'Invalid Form!';
          exit;
        }

        if ($_POST['email'] === '' || $_POST['password'] === '') {
          throw new \MyApp\Exception\EmptyPost();
        }

      }

}
