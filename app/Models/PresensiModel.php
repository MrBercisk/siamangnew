<?php

namespace App\Models;

use CodeIgniter\Model;

class PresensiModel extends Model
{
    protected $table = 'tbl_presensi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'bidang_id', 'kategori_id', 'status_presensi', 'tbl_jadwal.tanggal_bimbingan', 'tanggal_presensi', 'keterangan_presensi', 'jam', 'updated_at'];
    protected $useTimestamps = true;
    protected $request;
    protected $session;
    protected $dt;
    protected $db;

    function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();
        $this->dt = $this->db->table($this->table);
        $this->dt->select('tbl_presensi.*, tbl_jadwal.tanggal_bimbingan'); // Menambahkan kolom tanggal_bimbingan dari tabel tbl_jadwal
        $this->dt->join('tbl_pendaftaran', 'tbl_pendaftaran.user_id = tbl_presensi.user_id', 'left');
        $this->dt->join('tbl_jadwal', 'tbl_jadwal.pendaftaran_id = tbl_pendaftaran.id', 'left'); // Menambahkan join dengan tbl_jadwal
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getVar('length'), $this->request->getVar('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    private function _get_datatables_query()
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getVar('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getVar('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getVar('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }


        if ($this->request->getVar('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getVar('order')['0']['column']], $this->request->getVar('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->dt->countAllResults();
    }

    public function count_all()
    {
        $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }

    // Method untuk mendapatkan data presensi berdasarkan ID
    public function getPresensiByID($id)
    {
        return $this->find($id);
    }
    public function getTanggalBimbingan($user_id)
    {
        $db = db_connect();
        $builder = $db->table('tbl_jadwal');
        $builder->select('tanggal_bimbingan');
        $builder->join('tbl_pendaftaran', 'tbl_pendaftaran.id = tbl_jadwal.pendaftaran_id');
        $builder->where('tbl_pendaftaran.user_id', $user_id);
        $query = $builder->get();
        $results = $query->getResult();

        $tanggal_bimbingan = [];
        foreach ($results as $row) {
            $tanggal_bimbingan[] = $row->tanggal_bimbingan;
        }

        return $tanggal_bimbingan;
    }
}
