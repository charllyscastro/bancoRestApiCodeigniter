<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Config\Services;
use Firebase\JWT\JWT;

class Auth extends ResourceController
{
    use ResponseTrait;
    public function login()
    {
        try {
            $post = $this->request->getJSON();

            $username = $post['username'];
            $password = $post['password'];

            $usuarioModel = new UsuarioModel();

            $usuario = $usuarioModel->where('username', $username)->first();

            if ($usuario == null) {
                return $this->failNotFound('Usuario ou Senha incorretos');
            }

            if (verifyPassword($password, $usuario['password'])) {
                $jwt = $this->generateJWT($usuario);
                return $this->respond(['token' => $jwt], 201);
            } else {
                return $this->failNotFound('Usuario ou Senha incorretos');
            }
        } catch (\Exception $e) {
            return $this->failServerError('Ocorreu um erro no servidor');
        }
    }

    protected function generateJWT($usuario)
    {
        $key = Services::getSecretKey();
        $time = time();
        $payload = [
            'aud' => base_url(),
            'iat' => $time,
            'exp' => $time + 60
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');

        return $jwt;
    }
}
