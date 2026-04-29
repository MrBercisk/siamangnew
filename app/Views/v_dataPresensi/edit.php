<?= $this->extend('layouts_admin/template_admin') ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
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
        <!-- Content Header (Page header) -->
        <section class="content-header mt-4">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= base_url('datapresensi') ?>">Data Presensi</a></li>
                            <li class="breadcrumb-item active">Ubah Status Presensi</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>


        <!-- Main content -->
        <section class="content mt-2">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <!-- Default box -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Ubah Status Presensi</h3>
                            </div>
                            <div class="card-body ">
                                <?= form_open('dataPresensi/update/' . $presensi['id']); ?>
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama Peserta</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nama_peserta" name="nama_peserta" value="<?= $presensi['nama_peserta']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="status_presensi" class="col-sm-2 col-form-label">Status Presensi</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="status_presensi" name="status_presensi">
                                            <option value="Hadir" <?= ($presensi['status_presensi'] == 'Diterima') ? 'selected' : ''; ?>>Hadir</option>
                                            <option value="Tidak Hadir" <?= ($presensi['status_presensi'] == 'Tidak Diterima') ? 'selected' : ''; ?>>Tidak Hadir</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="keterangan_presensi" class="col-sm-2 col-form-label">Keterangan Presensi</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="keterangan_presensi" name="keterangan_presensi">
                                            <option value="Terlambat" <?= ($presensi['keterangan_presensi'] == 'Terlambat') ? 'selected' : ''; ?>>Terlambat</option>
                                            <option value="Tepat Waktu" <?= ($presensi['keterangan_presensi'] == 'Tepat Waktu') ? 'selected' : ''; ?>>Tepat Waktu</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan
                                    </button>
                                </div>
                                <?= form_close(); ?>
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

</div>


<?= $this->endSection(); ?>