<?= $this->extend('layouts_mentor/template_mentor') ?>

<?= $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header bg-white" style="height: 50px; max-height: 100px;">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <p class="text-muted">SI AMANG (Sistem Informasi Aplikasi Magang)</p>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content mt-5">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Modal Add -->
                    <?php include 'add.php';  ?>
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" style=" color:#17A2B8;"><i class="fas fa-list"></i> Tabel Data Presensi Mahasiswa</h3>

                            <div class="card-tools">
                                <a data-toggle="tooltip" data-placement="top" title="Add">
                                    <button id="addBankSoal" type="button" class="btn btn-outline-primary btn-sm" type="button" data-toggle="modal" data-target="#modalAdd">
                                        <i class="fas fa-plus"> Tambah Data</i>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="card-body table-responsive">

                            <?php if (session()->getFlashdata('success')) { ?>
                                <div class="alert alert-success">
                                    <?= session()->getFlashdata('success') ?>
                                </div>
                            <?php } ?>
                            <?php if (session()->getFlashdata('error')) { ?>
                                <div class="alert alert-danger">
                                    <?= session()->getFlashdata('error') ?>
                                </div>
                            <?php } ?>
                            <a href="<?php echo site_url('mentordatapresensi/cetakPDF'); ?>" class="btn btn-danger mb-3">
                                <span class="icon"><i class="fas fa-file-pdf"></i></span>
                                Cetak PDF
                            </a>
                            <table id="example1" class="table table-bordered table-striped">

                                <thead style="background-color: #17A2B8; color:#fff;">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Peserta</th>
                                        <th>Tanggal Presensi</th>
                                        <th>Status Presensi</th>
                                        <th>Keterangan Presensi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

<!-- /.content-wrapper -->
<style>
    .circle-img {
        width: 100px;
        height: 120px;
        object-fit: cover;
    }


    .dataTables_wrapper {
        text-align: justify;
        /* untuk meletakkan teks di tengah */
        font-size: 14px;
        /* ukuran font */
        line-height: 1.5;
        /* jarak antar baris */
        font-family: Arial, Helvetica, sans-serif;
        /* jenis font */
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        var table = $('#example1').DataTable({
            "responsive": false,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "order": [],

            "ajax": {
                "url": "<?= base_url('MentorDataPresensi/AjaxDataPresensi') ?>",
                "type": "POST"
            },

            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }, ],

            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ditemukan data yang sesuai",
                "info": "_START_ sampai _END_ dari _MAX_ entri",
                "infoEmpty": "Data tidak tersedia",
                "search": "Cari:",
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya"
                }
            }
        });
        //Submit presensi
        $('#btn-tambah').on('click', function() {
            const formTambahPresensi = $('#formTambahPresensi');

            $.ajax({
                url: "MentorDataPresensi/add",
                method: "POST",
                data: formTambahPresensi.serialize(),
                dataType: "JSON",
                success: function(data) {
                      // Data Error
                      if (data.error) {
                        if (data.presensi_error['nama_peserta'] != '') $('#nama_peserta_error').html(data.presensi_error['nama_peserta']);
                        else $('#nama_peserta_error').html('');

                        if (data.presensi_error['status_presensi'] != '') $('#status_presensi_error').html(data.presensi_error['status_presensi']);
                        else $('#status_presensi_error').html('');

                        if (data.presensi_error['keterangan_presensi'] != '') $('#keterangan_presensi_error').html(data.presensi_error['keterangan_presensi']);
                        else $('#keterangan_presensi_error').html('');

                        if (data.presensi_error['tanggal_presensi'] != '') $('#tanggal_presensi_error').html(data.presensi_error['tanggal_presensi']);
                        else $('#tanggal_presensi_error').html('');
                        
                        if (data.presensi_error['jam'] != '') $('#jam_error').html(data.presensi_error['jam']);
                        else $('#jam_error').html('');
                    } else {
                        // Pendaftaran Sukses
                        formTambahPresensi.trigger('reset');
                        $('#nama_peserta_error').html('');
                        $('#status_presensi_error').html('');
                        $('#keterangan_presensi_error').html('');
                        $('#tanggal_presensi_error').html('');
                        $('#jam_error').html('');
                        Swal.fire({
                            icon: 'success',
                            title: 'Tambah Data Presensi Berhasil',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function() {
                            window.location.replace(data.link); 
                        });
                    }
                }
            });
        });
        //Hapus data formasi jabatan
        $('body').on('click', '.btn-deletePresensi', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');

            Swal.fire({
                title: 'Hapus Data?',
                text: "Anda ingin menghapus data presensi ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        method: "POST",
                        success: function(response) {
                            $('#example1').DataTable().ajax.reload()
                            toastr.info('Data presensi berhasil dihapus.');
                        }
                    });
                }
            });

        });
    });
</script>
<?= $this->endSection() ?>