<?php
namespace App\Controllers;
use App\Models\UserModel;

class Login extends BaseController
{
    protected $encrypter;
    protected $form_validation;
    protected $M_user;
    protected $session;

    public function __construct()
    {
        $this->encrypter        = \Config\Services::encrypter();
        $this->form_validation  = \Config\Services::validation();
        $this->M_user           = new UserModel();
        $this->session          = \Config\Services::session();
    }

    // Halaman Login
    public function index()
    {
        $data['title'] = "SI AMANG | Login";
        return view('v_login/index', $data);
    }

    // Pengecekan User
   public function cekUser()
{
    $email    = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    // ✅ Set rules + pass data request secara eksplisit
    $this->form_validation->setRules([
        'email'    => 'required|valid_email',
        'password' => 'required|min_length[8]',
    ]);

    // ✅ Run dengan data yang di-pass manual
    if (!$this->form_validation->run(['email' => $email, 'password' => $password])) {
        echo json_encode([
            'error'       => true,
            'login_error' => $this->form_validation->getErrors()
        ]);
        return;
    }

    // Cek user di database
    $cekUser = $this->M_user->where('email', $email)->first();

    if (!$cekUser) {
        echo json_encode([
            'error'       => true,
            'login_error' => ['email' => 'Email Tidak Terdaftar!']
        ]);
        return;
    }

    // Cek password
    $p = $this->encrypter->decrypt(base64_decode($cekUser['password']));

    if ($password != $p) {
        echo json_encode([
            'error'       => true,
            'login_error' => ['password' => 'Password Salah!']
        ]);
        return;
    }

    // Login berhasil
    $this->session->set([
        'id'      => $cekUser['id'],
        'role_id' => $cekUser['role_id'],
        'nama'    => $cekUser['nama'],
        'email'   => $cekUser['email'],
    ]);

    if ($cekUser['role_id'] == 1) {
        echo json_encode(['success' => true, 'link' => base_url('dashboard')]);
    } elseif ($cekUser['role_id'] == 2) {
        echo json_encode(['success' => true, 'link' => base_url('mentor')]);
    } else {
        echo json_encode(['success' => true, 'link' => base_url('pendaftaran/cekStatusPendaftaran')]);
    }
}
}