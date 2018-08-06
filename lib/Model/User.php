<?php

namespace MyApp\Model;

class User extends \MyApp\Model {

        /******************************
       * ユーザー新規登録処理
       *  create(): {$value : ユーザー情報}
      *******************************/
      public function create($values) {
        $stmt = $this->db->prepare('insert into users(email, password, created, modified) values(:email, :password, now(), now())');
        $res = $stmt->execute([
          ':email' => $values['email'],
          ':password' => password_hash($values['password'], PASSWORD_DEFAULT)
        ]);
        if ($res === FALSE) {
          throw new \MyApp\Exception\DuplicateEmail();
          exit;
        }
      }

      /******************************
     * ログイン処理
     *  login():  {$value : ユーザー情報}
    *******************************/
      public function login($values) {
        $stmt = $this->db->prepare('select * from users where email = :email');
        $stmt->execute([
          ':email' => $values['email']
        ]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        $user = $stmt->fetch();

        if (empty($user)) {
          throw new \MyApp\Exception\UnmatchEmailOrPassword();
        }
        if (!password_verify($values['password'], $user->password)) {
          throw new \MyApp\Exception\UnmatchEmailOrPassword();
        }

        return $user;
      }

      /******************************
     * 登録済みユーザー一覧を取得
     *  findAll():  return 登録済みユーザー一覧
    *******************************/
      public function findAll() {
        $stmt = $this->db->query('select * from users order by id');
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetchAll();
      }


}
