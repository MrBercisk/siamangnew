<?php

namespace App\Controllers;

use App\Models\PendaftaranModel;
use App\Models\BidangModel;
use App\Models\KategoriModel;
use App\Models\MentorModel;
use App\Models\UserModel;
use App\Models\JadwalModel;
use App\Models\DataPresensiModel;
use App\Models\MentorPresensiModel;
use App\Models\PresensiModel;
use Config\Services;
use CodeIgniter\Email\Email;

class MentorDataPresensi extends BaseController
{
    protected $session;
    protected $M_pendaftaran;
    protected $M_bidang;
    protected $M_kategori;
    protected $M_mentor;
    protected $M_jadwal;
    protected $M_presensi;
    protected $M_user;
    protected $M_datapresensi;
    protected $M_mentorpresensi;
    protected $form_validation;
    protected $request;
    protected $db;

    public function __construct()
    {
        $this->request = Services::request();
        $this->M_pendaftaran = new PendaftaranModel($this->request);
        $this->M_bidang = new BidangModel($this->request);
        $this->M_kategori = new KategoriModel($this->request);
        $this->M_jadwal = new JadwalModel($this->request);
        $this->M_mentor = new MentorModel($this->request);
        $this->M_user = new UserModel($this->request);
        $this->M_datapresensi = new DataPresensiModel($this->request);
        $this->M_mentorpresensi = new MentorPresensiModel($this->request);
        $this->M_presensi = new PresensiModel($this->request);
        $this->form_validation =  \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
        $this->session->start();


        // Set nama_peserta dari data pendaftaran
        $user_id = $this->session->get('id');
        $builder = $this->db->table('tbl_pendaftaran');
        $builder->select('tbl_pendaftaran.nama_peserta, tbl_pendaftaran.judul, tbl_pendaftaran.foto, tbl_user.nama');
        $builder->join('tbl_user', 'tbl_user.id = tbl_pendaftaran.user_id');
        $builder->where('tbl_pendaftaran.user_id', $user_id);
        $query = $builder->get();
        $data['presensi'] = $query->getRow();
    }

    private function _action($idPresensi)
    {
        $link = "
	      	<a href='" . base_url('mentordataPresensi/delete/' . $idPresensi) . "' class='btn-deletePresensi' data-toggle='tooltip' data-placement='top' title='Delete'>
	      		<button type='button' class='btn btn-outline-danger btn-xs'><i class='fa fa-trash'></i></button>
	      	</a>

              <a href='" . base_url('mentordataPresensi/ubah/' . $idPresensi) . "' class='btn-ubahPresensi' data-toggle='tooltip' data-placement='top' title='Ubah Presensi'>
              <button type='button' class='btn btn-outline-warning btn-xs'><i class='fas fa-edit'></i></button>
            </a>
	    ";
        return $link;
    }

    // Halaman Data Pendaftaran
    public function index()
    {
        $data['title']   = "SI AMANG | Data Presensi";
        $data['page']    = "mentordatapresensi";

        // periksa apakah session masih ada atau tidak
        if (!$this->session->has('nama') || !$this->session->has('email')) {
            return redirect()->to('/login');
        }

        $data['nama']   = $this->session->get('nama');
        $data['email']   = $this->session->get('email');

        //Cek pendaftaran berdasarkan user_id
        $user_id = $this->session->get('id');
        $pendaftaran = $this->M_pendaftaran->where('user_id', $user_id)->first();
        $user = $this->M_user->where('id', $user_id)->first();
        // join table pendaftaran berdasarkan user_id
        $builder = $this->db->table('tbl_user');
        $builder->select('tbl_pendaftaran.nama_peserta, tbl_pendaftaran.foto, tbl_pendaftaran.bidang_id, tbl_pendaftaran.kategori_id, tbl_user.nama, tbl_jadwal.tanggal_mulai, tbl_jadwal.tanggal_selesai, tbl_pendaftaran.keterangan');
        $builder->join('tbl_pendaftaran', 'tbl_user.id = tbl_pendaftaran.user_id', 'left');
        $builder->join('tbl_jadwal', 'tbl_jadwal.pendaftaran_id = tbl_pendaftaran.id', 'left');
        $builder->where('tbl_user.id', $user_id);
        $query = $builder->get();
        $data['pendaftaran'] = $query->getRow();

        // mengambil data id pada tbl_user
        $builder = $this->db->table('tbl_user');
        $builder->where('tbl_user.id', $user_id);
        $query = $builder->get();
        $data['user'] = $query->getRow();

        // ambil data chat yang terkait dengan user yang sedang login
        $builder = $this->db->table('chat');
        $builder->select('chat.*, tbl_user.role_id, tbl_user.nama as pengirim_nama');
        $builder->join('tbl_user', 'tbl_user.id = chat.pengirim');
        $builder->orderBy('waktu_kirim', 'DESC'); // Mengubah pengurutan menjadi DESC
        $builder->where('chat.kategori_id', $data['user']->kategori_id);
        $query = $builder->get();
        $data['chat'] = $query->getResult();


        $currentUser = $this->session->get('id');
        // Periksa apakah ada pesan baru yang belum dibaca
        $chatBaru = false;
        foreach ($data['chat'] as $chat) {
            if (!$chat->dibaca && $chat->pengirim !== $currentUser) {
                $chatBaru = true;
                break;
            }
        }

        // Jika chat dibuka atau halaman diskusiforum diakses oleh penerima pesan,
        // set nilai 'dibaca' menjadi true untuk pesan yang dikirim oleh pengirim.
        if ($chatBaru) {
            $this->db->table('chat')
                ->where('kategori_id', $data['user']->kategori_id)
                ->where('pengirim', $chat->pengirim); // Hanya untuk pesan yang dikirim oleh pengirim
        }

        // Filter chat yang belum dibaca oleh pengirim
        $filteredChat = array_filter($data['chat'], function ($chat) use ($currentUser) {
            // Memeriksa apakah chat belum dibaca dan bukan dikirim oleh pengirim
            return !$chat->dibaca && $chat->pengirim !== $currentUser;
        });
        $data['chat_baru'] = count($filteredChat);

        // Ambil data pendaftaran yang terbaru dan belum diterima
        $tbl_pendaftaran = $this->M_pendaftaran->where('status_verifikasi', 'Belum Verifikasi')
            ->orderBy('created_at', 'DESC')
            ->findAll();
        $data['tbl_pendaftaran'] = $tbl_pendaftaran;
        $data['jumlah_pendaftaran'] = count($tbl_pendaftaran);


        $data['events'] = $this->M_jadwal->getEvents();
        $userModel = new UserModel($this->request);
        $data['presensi'] = $this->M_pendaftaran->select('tbl_pendaftaran.user_id, tbl_pendaftaran.nama_peserta')
        ->where('status_verifikasi', 'Diterima')
        ->join('tbl_user', 'tbl_user.id = tbl_pendaftaran.user_id')
        ->where('tbl_user.kategori_id', $userModel->find($user_id)['kategori_id'])
        ->findAll();
    
        return view('v_mentor/presensi', $data);
    }
    public function ubah($id)
    {
        $data['title']   = "SI AMANG | Ubah Status Presensi";
        $data['page']    = "mentorubahpresensi";
        $data['nama']    = $this->session->get('nama');
        $data['email']   = $this->session->get('email');

        //Cek pendaftaran berdasarkan user_id
        $user_id = $this->session->get('id');
        $pendaftaran = $this->M_pendaftaran->where('user_id', $user_id)->first();
        $user = $this->M_user->where('id', $user_id)->first();
        // join table pendaftaran berdasarkan user_id
        $builder = $this->db->table('tbl_user');
        $builder->select('tbl_pendaftaran.nama_peserta, tbl_pendaftaran.foto, tbl_pendaftaran.bidang_id, tbl_pendaftaran.kategori_id, tbl_user.nama, tbl_jadwal.tanggal_mulai, tbl_jadwal.tanggal_selesai, tbl_pendaftaran.keterangan');
        $builder->join('tbl_pendaftaran', 'tbl_user.id = tbl_pendaftaran.user_id', 'left');
        $builder->join('tbl_jadwal', 'tbl_jadwal.pendaftaran_id = tbl_pendaftaran.id', 'left');
        $builder->where('tbl_user.id', $user_id);
        $query = $builder->get();
        $data['pendaftaran'] = $query->getRow();

        // mengambil data id pada tbl_user
        $builder = $this->db->table('tbl_user');
        $builder->where('tbl_user.id', $user_id);
        $query = $builder->get();
        $data['user'] = $query->getRow();

        // ambil data chat yang terkait dengan user yang sedang login
        $builder = $this->db->table('chat');
        $builder->select('chat.*, tbl_user.role_id, tbl_user.nama as pengirim_nama');
        $builder->join('tbl_user', 'tbl_user.id = chat.pengirim');
        $builder->orderBy('waktu_kirim', 'DESC'); // Mengubah pengurutan menjadi DESC
        $builder->where('chat.kategori_id', $data['user']->kategori_id);
        $query = $builder->get();
        $data['chat'] = $query->getResult();


        $currentUser = $this->session->get('id');
        // Periksa apakah ada pesan baru yang belum dibaca
        $chatBaru = false;
        foreach ($data['chat'] as $chat) {
            if (!$chat->dibaca && $chat->pengirim !== $currentUser) {
                $chatBaru = true;
                break;
            }
        }

        // Jika chat dibuka atau halaman diskusiforum diakses oleh penerima pesan,
        // set nilai 'dibaca' menjadi true untuk pesan yang dikirim oleh pengirim.
        if ($chatBaru) {
            $this->db->table('chat')
                ->where('kategori_id', $data['user']->kategori_id)
                ->where('pengirim', $chat->pengirim); // Hanya untuk pesan yang dikirim oleh pengirim
        }

        // Filter chat yang belum dibaca oleh pengirim
        $filteredChat = array_filter($data['chat'], function ($chat) use ($currentUser) {
            // Memeriksa apakah chat belum dibaca dan bukan dikirim oleh pengirim
            return !$chat->dibaca && $chat->pengirim !== $currentUser;
        });
        $data['chat_baru'] = count($filteredChat);
        // Ambil data pendaftaran yang terbaru dan belum diterima
        $data['tbl_pendaftaran'] = $this->M_pendaftaran->where('status_verifikasi', 'Diterima')
            ->orderBy('created_at', 'DESC')
            ->findAll();
        $data['jumlah_pendaftaran'] = count($data['tbl_pendaftaran']);
        $data['events'] = $this->M_jadwal->getEvents();
        $data['presensi'] = $this->M_datapresensi->find($id);
        if ($data['presensi']) {
            $user_id = $data['presensi']['user_id'];
            $M_pendaftaran = new PendaftaranModel($this->request);
            $pendaftaran = $M_pendaftaran->where('user_id', $user_id)->first();
            $data['presensi']['nama_peserta'] = $pendaftaran['nama_peserta'];
        }


        if (empty($data['presensi'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Presensi tidak ditemukan.');
        }

        if ($this->request->getMethod() == 'post' && $this->validate([
            'nama_peserta' => 'required',
            'status_presensi' => 'required',
            'keterangan_presensi' => 'required',
        ])) {
            $data = [
                'nama_peserta' => $this->request->getPost('nama_peserta'),
                'status_presensi' => $this->request->getPost('status_presensi'),
                'keterangan_presensi' => $this->request->getPost('keterangan_presensi')
            ];

            $this->M_datapresensi->update($id, $data);

            // Tambahkan notifikasi Sweet Alert
            session()->setFlashdata('success', 'Data berhasil diubah!');

            return redirect()->to(base_url('mentordatapresensi'));
        }

        return view('v_mentor/editpresensi', $data);
    }


    public function update($id)
    {
        if ($this->request->getMethod() == 'post' && $this->validate([
            'status_presensi' => 'required',
            'keterangan_presensi' => 'required'
        ])) {
            $data = [
                'status_presensi' => $this->request->getPost('status_presensi'),
                'keterangan_presensi' => $this->request->getPost('keterangan_presensi')
            ];

            $this->M_datapresensi->update($id, $data);

            // redirect ke halaman sebelumnya
            return redirect()->to(base_url('mentordatapresensi'));
        }
    }

    public function add()
    {
        $id = $this->request->getPost('user_id');
        $status_presensi = $this->request->getPost('status_presensi');
        $keterangan_presensi = $this->request->getPost('keterangan_presensi');
        $tanggal_presensi = $this->request->getPost('tanggal_presensi');
        $jam = $this->request->getPost('jam');

        $data = [
            'user_id' => $id,
            'status_presensi' => $status_presensi,
            'keterangan_presensi' => $keterangan_presensi,
            'tanggal_presensi' => $tanggal_presensi,
            'jam' => $jam,
        ];

        if ($this->form_validation->run($data, 'presensi') == FALSE) {
            $validasi = [
                'error' => true,
                'presensi_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        } else {
            $this->M_presensi->save($data);

            $validasi = [
                'success' => true,
                'link' => base_url('mentordatapresensi')
            ];
            echo json_encode($validasi);
        }
    }

    public function delete($id)
    {
        $this->M_mentorpresensi->delete($id);
    }

    // Datatable server side
    public function ajaxDataPresensi()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $lists = $this->M_mentorpresensi->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->nama_peserta;
                $row[] = tgl_indonesia($list->tanggal_presensi);
                $row[] = $list->status_presensi;
                $row[] = $list->keterangan_presensi;
                $row[] = $this->_action($list->id);
                $data[] = $row;
            }
            $output = [
                "draw" => $this->request->getPost('draw'),
                "recordsTotal" => $this->M_mentorpresensi->count_all(),
                "recordsFiltered" => $this->M_mentorpresensi->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}
