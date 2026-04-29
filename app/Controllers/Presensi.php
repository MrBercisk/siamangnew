<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PendaftaranModel;
use App\Models\JadwalModel;
use App\Models\BidangModel;
use App\Models\KategoriModel;
use App\Models\InformasiModel;
use App\Models\LaporanModel;
use App\Models\ProgresMagangModel;
use App\Models\SosialMediaModel;
use App\Models\PresensiModel;
use Config\Services;
use App\Models\ProfileModel;


class Presensi extends BaseController
{

    protected $encrypter;
    protected $form_validation;
    protected $M_user;
    protected $M_jadwal;
    protected $M_pendaftaran;
    protected $M_bidang;
    protected $M_kategori;
    protected $M_informasi;
    protected $M_laporan;
    protected $M_progres;
    protected $M_profile;
    protected $M_sosmed;
    protected $M_presensi;
    protected $session;
    protected $request;
    protected $ProfileModel;
    protected $db;


    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->request = Services::request();
        $this->encrypter = \Config\Services::encrypter();
        $this->form_validation =  \Config\Services::validation();
        $this->M_user = new UserModel();
        $this->M_pendaftaran = new PendaftaranModel($this->request);
        $this->M_jadwal = new JadwalModel($this->request);
        $this->M_bidang = new BidangModel($this->request);
        $this->M_kategori = new KategoriModel($this->request);
        $this->M_informasi = new InformasiModel($this->request);
        $this->M_laporan = new LaporanModel($this->request);
        $this->M_sosmed = new SosialMediaModel();
        $this->M_presensi = new PresensiModel();
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
        $this->session->start();
    }
    public function index()
    {
        // periksa apakah session masih ada atau tidak
        if (!$this->session->has('nama') || !$this->session->has('email')) {
            return redirect()->to('/login');
        }

        // menampilkan data title, link dan view
        $data['title'] = "SI AMANG | Presensi";
        $data['judul'] = "Silahkan Perbarui Foto Profile Anda Kemudian, Demi kemanan dimohon untuk selalu ganti password secara berkala";
        $data['page'] = "presensi";
        $data['events'] = $this->M_jadwal->getEvents();
        $data['nama'] = $this->session->get('nama');
        $data['email'] = $this->session->get('email');

        // Cek pendaftaran berdasarkan user_id
        $user_id = $this->session->get('id');
        $pendaftaran = $this->M_pendaftaran->where('user_id', $user_id)->first();

        // megambil data dari tbl_pendaftaran, tbl_jadwal, tbl_user, dan tbl_kategori
        $builder = $this->db->table('tbl_pendaftaran');
        $builder->select('tbl_pendaftaran.nama_peserta, tbl_pendaftaran.id, tbl_pendaftaran.bidang_id, tbl_pendaftaran.kategori_id, tbl_pendaftaran.nim, tbl_pendaftaran.alamat_peserta, tbl_pendaftaran.judul, tbl_pendaftaran.keahlian, tbl_pendaftaran.nomor_pendaftaran, tbl_pendaftaran.nama_kampus, tbl_pendaftaran.no_hp, tbl_pendaftaran.foto, tbl_pendaftaran.status_permohonan, tbl_pendaftaran.nama_anggota_1, tbl_pendaftaran.nama_anggota_2, tbl_user.nama, tbl_jadwal.tanggal_mulai, tbl_jadwal.tanggal_selesai, tbl_jadwal.tanggal_bimbingan, tbl_jadwal.jam_bimbingan, tbl_kategori.nama_kategori, tbl_bidang.nama_bidang');
        $builder->join('tbl_user', 'tbl_user.id = tbl_pendaftaran.user_id');
        $builder->join('tbl_jadwal', 'tbl_jadwal.pendaftaran_id = tbl_pendaftaran.id', 'left');
        $builder->join('tbl_bidang', 'tbl_bidang.id = tbl_pendaftaran.bidang_id', 'left'); // Menambahkan join dengan tbl_kategori
        $builder->join('tbl_kategori', 'tbl_kategori.id = tbl_pendaftaran.kategori_id', 'left'); // Menambahkan join dengan tbl_kategori
        $builder->orderBy('tbl_jadwal.tanggal_bimbingan', 'asc');
        $builder->where('tbl_pendaftaran.user_id', $user_id);
        $query = $builder->get();
        $data['pendaftaran'] = $query->getResult();

        // var_dump($data['pendaftaran']);
        // die;

        $jadwal = $this->db->table('tbl_jadwal');
        $jadwal->where('pendaftaran_id', $data['pendaftaran'][0]->id);
        $jadwal->where('tanggal_bimbingan', date('Y-m-d'));
        $query = $jadwal->get();
        $data['jadwal'] = $query->getResult();


        // pengambilan data dari tbl_pendaftaran, tbl_user, dan tbl_kategori
        $data['nama_peserta'] = $data['pendaftaran'][0]->nama_peserta;
        $data['nim'] = $data['pendaftaran'][0]->nim;
        $data['keahlian'] = $data['pendaftaran'][0]->keahlian;
        $data['foto'] = $data['pendaftaran'][0]->foto;
        $data['no_hp'] = $data['pendaftaran'][0]->no_hp;
        $data['judul'] = $data['pendaftaran'][0]->judul;
        $data['alamat_peserta'] = $data['pendaftaran'][0]->alamat_peserta;
        $data['nama_kampus'] = $data['pendaftaran'][0]->nama_kampus;
        $data['tanggal_mulai'] = $data['pendaftaran'][0]->tanggal_mulai;
        $data['tanggal_selesai'] = $data['pendaftaran'][0]->tanggal_selesai;
        // $data['tanggal_bimbingan'] = $data['pendaftaran'][0]->tanggal_bimbingan;
        $data['tanggal_bimbingan'] = $data['jadwal'];
        $data['jam_bimbingan'] = $data['pendaftaran'][0]->jam_bimbingan;
        $data['status_permohonan'] = $data['pendaftaran'][0]->status_permohonan;
        $data['nama_anggota_1'] = $data['pendaftaran'][0]->nama_anggota_1;
        $data['nama_anggota_2'] = $data['pendaftaran'][0]->nama_anggota_2;
        $data['nama_kategori'] = $data['pendaftaran'][0]->nama_kategori;
        $data['nama_bidang'] = $data['pendaftaran'][0]->nama_bidang;
        $kategori_id = $pendaftaran['kategori_id'];
        $data['mentor'] = $this->M_user->where('role_id', 2)->where('kategori_id', $kategori_id)->findAll();


        $laporan = new LaporanModel();
        $where = ['user_id' => $user_id];
        $data['laporan'] = $laporan->where($where)->first();
        // Mengambil data progres magang dari tabel tbl_progresmagang
        $progresMagangModel = new ProgresMagangModel();
        $progresMagang = $progresMagangModel->where('user_id', $user_id)->countAllResults();
        $progressMagang = $progresMagang * 20;
        $progressMagang = min($progressMagang, 80); // Maksimal 80%

        $data['progressMagang'] = $progressMagang;

        // Periksa apakah laporan sudah diupload atau belum
        if ($data['laporan']) {
            $data['keterangan_laporan'] = "Anda Sudah Upload Laporan";
            $data['status_magang'] = "Selesai";
            $data['progressLaporan'] = 100; // Set progress laporan ke 100 jika laporan sudah diupload
            $data['progressMagang'] = 100; // Set progress magang ke 100 jika laporan sudah diupload
        } else {
            $data['keterangan_laporan'] = "Anda Belum Upload Laporan";
            // Periksa apakah tanggal saat ini sudah melewati batas_waktu_upload
            $tanggal_sekarang = date('Y-m-d');
            $batas_waktu_upload = date('Y-m-d', strtotime('+3 days', strtotime($data['tanggal_selesai'])));
            if ($tanggal_sekarang > $batas_waktu_upload) {
                $data['status_magang'] = "Tidak Selesai (Tidak Upload Laporan Melebihi Batas Waktu Upload Laporan)"; // Ubah status_magang menjadi "Tidak Selesai" jika melebihi batas_waktu_upload
            } else {
                $data['status_magang'] = "Belum Selesai";
                $data['progressLaporan'] = ($progressMagang >= 100) ? 100 : 0; // Set progress laporan ke 80% jika laporan belum diupload, kecuali jika progress magang sudah mencapai 100%
            }
        }
        $tanggal_sekarang = date('Y-m-d');
        $ubah_tanggal = tgl_indonesia($tanggal_sekarang);
        $hari_sekarang = date('l', strtotime($tanggal_sekarang));
        
        $data['ubah_tanggal'] = $ubah_tanggal;
        $data['hari_sekarang'] = ubah_hari_ke_indonesia($hari_sekarang);
        

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

        // Periksa apakah tanggal saat ini sudah melewati tanggal_mulai atau belum
        $tanggal_sekarang = date('Y-m-d');
        if ($tanggal_sekarang < $data['tanggal_mulai']) {
            $pesan = "Maaf, Halaman ini hanya dapat diakses setelah waktu magang dimulai. Silahkan cek jadwal magang untuk mengetahui waktu mulai magang Anda.";
            $this->session->setFlashdata('pesan_error', $pesan);
            return redirect()->back();
        }
        // Periksa apakah tanggal saat ini sudah melewati tanggal_selesai atau belum
        if ($tanggal_sekarang > $data['tanggal_selesai']) {
            $pesan = "Waktu magang Anda telah selesai. Terima kasih telah mengikuti program magang.";
            $this->session->setFlashdata('pesan_info', $pesan);
            return redirect()->back();
        }
        // Ambil data presensi berdasarkan user_id
        $data['data_presensi'] = $this->M_presensi->where('user_id', $user_id)->findAll();
        // Hitung jumlah data presensi
        $data['jumlah_presensi'] = count($data['data_presensi']);

        // Mendapatkan tanggal bimbingan sesuai dengan user_id
        $M_jadwal = new JadwalModel();
        $tanggal_bimbingan = $M_jadwal->getTanggalBimbingan($user_id);

        // Periksa apakah tanggal_bimbingan valid
        if (!is_array($tanggal_bimbingan) || empty($tanggal_bimbingan)) {
            return redirect()->to('/presensi')->with('error', 'Tidak ada tanggal bimbingan yang tersedia');
        }
        return view('v_magang/presensi', $data);
    }
    public function inputPresensi()
    {
        // Periksa apakah session masih ada atau tidak
        if (!$this->session->has('nama') || !$this->session->has('email')) {
            return redirect()->to('/login');
        }

        $user_id = $this->session->get('id');
        $nama_peserta = $this->request->getPost('nama_peserta');

        // Mendapatkan tanggal bimbingan sesuai dengan user_id
        $M_presensi = new PresensiModel();
        $tanggal_bimbingan = $M_presensi->getTanggalBimbingan($user_id);
        // Periksa apakah tanggal_bimbingan valid
        if (!is_array($tanggal_bimbingan) || empty($tanggal_bimbingan)) {
            return redirect()->to('/presensi')->with('error', 'Tidak ada tanggal bimbingan yang tersedia');
        }

        $jam = date("H:i:s");
        $tanggal_sekarang = date("Y-m-d");

        if ($jam > "09:00:00") {
            $keterangan_presensi = "Terlambat";
            $status_presensi = "Hadir";
        } else {
            $keterangan_presensi = "Tepat Waktu";
            $status_presensi = "Hadir";
        }

        if (!in_array($tanggal_sekarang, $tanggal_bimbingan)) {
            return redirect()->to('/presensi')->with('error', 'Anda Tidak Dapat Melakukan Presensi Karena Hari Ini Bukan Tanggal Bimbingan Anda');
        }

        $M_presensi = new PresensiModel();

        // Periksa apakah presensi sudah ada untuk user dan tanggal yang sama
        $existingPresensi = $M_presensi->where('user_id', $user_id)
            ->where('DATE(tanggal_presensi)', $tanggal_sekarang)
            ->first();

        if ($existingPresensi) {
            // Jika presensi sudah ada, kembalikan ke halaman presensi dengan pesan error
            return redirect()->to('/presensi')->with('error', 'Anda Sudah Melakukan Presensi');
        }

        $data = [
            'user_id' => $user_id,
            'nama_peserta' => $nama_peserta,
            'tanggal_presensi' => $tanggal_sekarang,
            'keterangan_presensi' => $keterangan_presensi,
            'jam' => $jam,
            'status_presensi' => $status_presensi,
        ];

        $M_presensi->save($data);

        return redirect()->to('/presensi')->with('success', 'Anda Berhasil Presensi Kehadiran Pada Pukul ' . $jam . ', Anda ' . $keterangan_presensi);
    }
}
