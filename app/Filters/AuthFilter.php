<?php

namespace App\Filters;

use App\Models\User;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use DateTime;

class AuthFilter implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    $session = session();
    if (!isset($session->login_token)) {
      return redirect()->to(base_url('admin/auth/login'));
    }

    $userModel = new User;
    $user = $userModel->where('login_token', $session->login_token)->first();
    if (!isset($user)) {
      $session->destroy();
      return redirect()->to(base_url('admin/auth/login'));
    }
    $startDateTime = new DateTime(explode('_', $user->login_token)[1]);
    $endDateTime = new DateTime(date('Y-m-d H:i:s'));
    $diffDateTime = $startDateTime->diff($endDateTime);
    if ($diffDateTime->d > 0) {
      $session->destroy();
      return redirect()->to(base_url('admin/auth/login'));
    }
    // Do something here
  }

  //--------------------------------------------------------------------

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Do something here
  }
}
