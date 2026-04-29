<?php
namespace App\Controllers;

use App\Models\UserModel;

class ResetPass extends BaseController
{
    public function index()
    {
        $encrypter = \Config\Services::encrypter();
        $M_user    = new UserModel();

        // Ganti 'passwordbaru123' dengan password yang kamu mau
        $password  = '12345678';
        $encrypted = base64_encode($encrypter->encrypt($password));

        // Update user admin (role_id = 1)
        $M_user->where('role_id', 1)->set(['password' => $encrypted])->update();

        echo "Password berhasil direset! Password baru: <b>$password</b>";
    }
}