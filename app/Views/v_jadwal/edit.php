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
                            <li class="breadcrumb-item"><a href="<?= base_url('jadwalpeserta') ?>">Jadwal Peserta</a></li>
                            <li class="breadcrumb-item active">Ubah Jadwal Peserta</li>
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
                                <h3 class="card-title">Ubah Jadwal Peserta</h3>
                            </div>
                            <div class="card-body ">
                                <?= form_open('jadwalpeserta/update/' . $event['id']); ?>
                                <div class="form-group row">
                                    <label for="nama_peserta" class="col-sm-2 col-form-label">Nama Peserta</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nama_peserta" name="nama_peserta" value="<?= $event['nama_peserta']; ?>" readonly>
                                    </div>
                                    <small id="nama_peserta_error" class="text-danger"></small>
                                </div>
                                <div class="form-group row">
                                    <label for="tanggal_mulai" class="col-sm-2 col-form-label">Tanggal Mulai</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?= $event['tanggal_mulai']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tanggal_selesai" class="col-sm-2 col-form-label">Tanggal Selesai</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="<?= $event['tanggal_selesai']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tanggal_bimbingan" class="col-sm-2 col-form-label">Tanggal Bimbingan</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="tanggal_bimbingan" name="tanggal_bimbingan" value="<?= $event['tanggal_bimbingan']; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="jam_bimbingan" class="col-sm-2 col-form-label">Jam Bimbingan</label>
                                    <div class="col-sm-10">
                                        <input type="time" class="form-control" id="jam_bimbingan" name="jam_bimbingan" value="<?= $event['jam_bimbingan']; ?>">
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