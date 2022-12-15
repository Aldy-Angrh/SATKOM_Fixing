<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Auth extends BaseController
{
  public function login()
  {
    $session = session();
    if (isset($session->login_token)) {
      return redirect()->to(base_url('admin/v2/dashboard'));
    }
    if ($this->request->getPost()) {
      if (!$this->validate([
        'username' => "required",
        'password' => "required",
      ])) {
        return redirect()->to(base_url('admin/auth/login'))->with('errors', $this->validator->getErrors());
      }

      $userModel = new User;
      $user = $userModel->where('username', $this->request->getPost('username'))->first();
      if (!isset($user)) {
        return redirect()->to(base_url('admin/auth/login'))->with('errors', [
          'username' => 'Username not found!'
        ])->withInput();
      }

      if (!password_verify($this->request->getPost('password'), $user->password)) {
        return redirect()->to(base_url('admin/auth/login'))->with('errors', [
          'password' => 'Wrong password!'
        ])->withInput();
      }

      helper('text');

      $loginToken = $user->id . '_' . date('Y-m-d H:i:s') . '_' . random_string('alnum', 20);

      $userModel->update($user->id, [
        'login_token' => $loginToken
      ]);

      $session->set([
        'login_token' => $loginToken,
        'role_id' => $user->role_id,
      ]);

      return redirect()->to(base_url('admin/v2/dashboard'));
    } else {
      return view('admin/auth/login');
    }
  }

  public function logout()
  {
    $session = session();
    $userModel = new User;
    $user = $userModel->getLoginUser();
    if (isset($user)) {
      $userModel->update($user->id, [
        'login_token' => null
      ]);
    }
    $session->destroy();

    return redirect()->to(base_url('admin/auth/login'));
  }
}
