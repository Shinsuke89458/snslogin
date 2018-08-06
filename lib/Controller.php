<?php

namespace MyApp;

class Controller {

      private $_errors;
      private $_values;

      public function __construct() {
        if (!isset($_SESSION['token'])) {
          $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
        }
        $this->_errors = new \stdClass();
        $this->_values = new \stdClass();
      }

      /******************************
     * フォームの入力値に対する処理
     *  setValues(): 入力値をセット {$key: キー, $value : 入力値}
     *  getValues(): 入力値を取得  return $this->_value : 入力値
    *******************************/
      protected function setValues($key, $value) {
        $this->_values->$key = $value;
      }
      public function getValues() {
        return $this->_values;
      }

      /******************************
     * フォームの入力エラーに対する処理
     *  setErrors(): エラーをセット {$key: キー, $error : }
     *  getErrors(): エラーを取得  {$key: } return $this->_errors->$key / ''
     *  hasErrors(): エラーが発生しているかどうか
    *******************************/
      protected function setErrors($key, $error) {
        $this->_errors->$key = $error;
      }
      public function getErrors($key) {
        return isset($this->_errors->$key)? $this->_errors->$key: '';
      }
      protected function hasError() {
        return !empty(get_object_vars($this->_errors));
      }

      /******************************
     * ログイン状態に関する処理
     *  isLoggedIn(): ログインしているかどうか
     *  me():
    *******************************/
      protected function isLoggedIn() {
        // $_SESSION['me']
        return isset($_SESSION['me']) && !empty($_SESSION['me']);
      }
      public function me() {
        return $this->isLoggedIn()? $_SESSION['me']: NULL;
      }



}
