<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = ['username', 'password', 'created_at'];

    public function checkUser($username, $password)
    {
        $user = $this->asArray()
            ->where(['username' => $username])
            ->first();

        if (!$user) return false;

        return password_verify($password, $user['password']) ? $user : false;
    }

    public function register($username, $password)
    {
        $data = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        return $this->insert($data);
    }
}
