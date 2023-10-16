<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use \Firebase\JWT\JWT;
use App\Models\UserModel;

class Auth extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

    public function token()
    {
        try {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $user = (new UserModel())->checkUser($username, $password);

            if ($user) {
                $key = "gabriel";
                $payload = [
                    "id" => $user['id'],
                    "username" => $user['username'],
                    "iat" => time(),
                    "exp" => time() + (60 * 60)
                ];

                $jwt = JWT::encode($payload, $key, 'HS256');
                return $this->respond(['token' => $jwt]);
            } else {
                return $this->failUnauthorized('Invalid username or password');
            }
        } catch (\Exception $e) {
            // Isso irá capturar qualquer exceção e registrar a mensagem de erro
            log_message('error', $e->getMessage());
            return $this->failServerError('An unexpected error occurred');
        }
    }


    public function register()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'username' => 'required|min_length[5]|max_length[50]|is_unique[users.username]',
            'password' => 'required|min_length[8]|max_length[255]'
        ];

        $validation->setRules($rules);

        if ($validation->withRequest($this->request)->run()) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            if ((new UserModel())->register($username, $password)) {
                return $this->respondCreated('User registered successfully');
            } else {
                return $this->fail('User registration failed');
            }
        } else {
            return $this->failValidationErrors($validation->getErrors());
        }
    }
}
