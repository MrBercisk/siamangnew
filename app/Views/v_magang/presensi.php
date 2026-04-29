<?= $this->extend('layouts_magang/template_magang') ?>

<?= $this->section('content') ?>
<?php if (session()->has('pesan_error')) : ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Akses ditolak!',
            text: '<?= session()->getFlashdata('pesan_error') ?>',
            footer: '<a href="<?= base_url('kalender'); ?>">Klik disini untuk cek jadwal magang Anda</a>',
            customClass: {
                confirmButton: 'btn btn-danger'
            },
            buttonsStyling: false
            // matikan styling default tombol Swal
        })
    </script>
<?php elseif (session()->has('pesan_info')) : ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Akses ditolak!',
            text: '<?= session()->getFlashdata('pesan_info') ?>',
            customClass: {
                confirmButton: 'btn btn-primary'
            },
            buttonsStyling: false
            // matikan styling default tombol Swal
        })
    </script>
<?php endif; ?>
<?php if (session()->has('error')) : ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal Presensi!',
            text: '<?= session()->getFlashdata('error') ?>',
            footer: '<a href="<?= base_url('kalender'); ?>">Klik disini untuk cek jadwal magang Anda</a>',
            customClass: {
                confirmButton: 'btn btn-danger'
            },
            buttonsStyling: false
            // matikan styling default tombol Swal
        })
    </script>
<?php elseif (session()->has('success')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Presensi',
            text: '<?= session()->getFlashdata('success') ?>',
            customClass: {
                confirmButton: 'btn btn-success'
            },
            buttonsStyling: false
            // matikan styling default tombol Swal
        })
    </script>
<?php endif; ?>

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
    <section class="content mt-5" id="presensi">
        <div class="row">
            <div class="col-md-12 mb-2">
                <div class="card">
                    <div class="card-header">
                        <p><b>Panduan Presensi Kehadiran:</b></p>
                    </div>
                    <div class="card-body">
                        <ol>
                            <li>Halaman bisa diakses jika anda telah mendapatkan jadwal bimbingan</li>
                            <li>Anda hanya dapat melakukan presensi pada hari bimbingan dan presensi dapat dilakukan mulai jam 07.00 s/d jam 09.00</li>
                            <li>Klik tombol "Presensi Kehadiran" pada kolom sebelah kanan.</li>
                            <li>Jika presensi berhasil maka akan muncul pesan anda berhasil presensi</li>
                            <li>Anda dapat melihat histori presensi kehadiran tiap bimbingan pada kolom sebelah kiri</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title col-lg-3 mb-2">Histori Presensi</h3><button class="btn btn-danger col-lg-9 btn-md btn-block"><i class="fas fa-exclamation-circle"></i> Waktu Presensi Jam 07.00 - 09.00 (Hari Bimbingan)</button>
                    </div>
                    <div class="card-body table-responsive">
                        <p>Jumlah Kehadiran Anda: <?= $jumlah_presensi ?> <?php if ($jumlah_presensi > 0) {
                                                                                echo 'Kali';
                                                                            } ?></p>
                        <table class="table table-bordered table-hover">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal Presensi</th>
                                    <th>Jam Presensi</th>
                                    <th>Status Presensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                $absen = false; ?>
                                <?php foreach ($data_presensi as $presensi) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $presensi['tanggal_presensi'] ?></td>
                                        <td><?= $presensi['jam'] ?></td>
                                        <td><?= $presensi['status_presensi'] ?></td>
                                    </tr>
                                    <?php
                                    if ($presensi['tanggal_presensi'] == date('Y-m-d')) {
                                        $absen = true;
                                    } ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Presensi Kehadiran Mahasiswa Setiap Pertemuan</h3>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="clock" class="card bg-danger text-white">
                                    <div class="card-body">
                                        <i class="fas fa-clock fa-3x"></i>
                                    </div>
                                    <div class="card-footer">
                                        <h5 class="card-text"><?= $hari_sekarang ?>, <?= $ubah_tanggal ?></h5>
                                        <p id="clock-text" class="card-text"></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <script>
                            function updateClock() {
                                var now = new Date();
                                var hours = now.getHours();
                                var minutes = now.getMinutes();
                                var seconds = now.getSeconds();

                                hours = hours < 10 ? '0' + hours : hours;
                                minutes = minutes < 10 ? '0' + minutes : minutes;
                                seconds = seconds < 10 ? '0' + seconds : seconds;

                                var time = hours + ':' + minutes + ':' + seconds;

                                document.getElementById('clock-text').textContent = time;
                            }

                            setInterval(updateClock, 1000);
                        </script>
                        <style>
                            #clock {
                                background-color: #333;
                                color: #fff;
                                text-align: center;
                                padding: 15px;
                                border-radius: 10px;
                                box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);

                            }

                            #clock .card-body {
                                padding: 10px;
                            }

                            #clock .card-body i {
                                color: #fff;
                                font-size: 3rem;
                                animation: rotate 60s infinite linear;
                            }

                            #clock .card-footer {
                                padding: 10px;
                            }

                            #clock .card-text {
                                margin: 0;
                                font-size: 1.5rem;
                                font-weight: bold;
                            }


                            @keyframes rotate {
                                from {
                                    transform: rotate(0deg);
                                }

                                to {
                                    transform: rotate(360deg);
                                }
                            }

                            @keyframes pulse {
                                0% {
                                    transform: scale(1);
                                }

                                50% {
                                    transform: scale(1.1);
                                }

                                100% {
                                    transform: scale(1);
                                }
                            }

                            @media (max-width: 992px) {
                                #presensi .row {
                                    flex-direction: column-reverse;
                                }
                            }
                        </style>

                        <div class="row text-center">

                            <div class="col-md-4">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <i class="fas fa-school fa-3x"></i>
                                    </div>
                                    <div class="card-footer">
                                        <h5 class="card-text">Kategori</h5>
                                        <p class="card-text"><?= $nama_kategori ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">

                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <i class="fas fa-university fa-3x"></i>
                                    </div>
                                    <div class="card-footer">
                                        <h5 class="card-text">Universitas</h5>
                                        <p class="card-text"><?= $nama_kampus ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <i class="fas fa-user fa-3x"></i>
                                    </div>
                                    <div class="card-footer">
                                        <h5 class="card-text">Mentor</h5>
                                        <p class="card-text"><?php foreach ($mentor as $m) : ?>
                                                <?= $m['nama'] ?>
                                            <?php endforeach ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                         if ($absen) {
                            echo '<i class="fas fa-exclamation-circle mb-2"></i> Status Presensi : Anda Sudah Presensi Hari Ini
                            ';
                        }
                        foreach ($jadwal as $tb) {
                            $tanggal_bimbingan = date("N", strtotime($tb->tanggal_bimbingan));
                            $jam_sekarang = date("H:i:s");
                            $tanggal_sekarang = date("Y-m-d");
                            $hari_sekarang = date("N");

                            if (($hari_sekarang == $tanggal_bimbingan) && ($jam_sekarang >= "07:00:00" && $jam_sekarang <= "14:00:00")) {
                                if (!$absen) {
                        ?>
                                    <i class="fas fa-exclamation-circle mb-3"></i> Status Presensi : Belum presensi
                                    <form action="<?= base_url('presensi/inputPresensi'); ?>" method="post">
                                        <input type="hidden" name="nama_peserta" value="<?= $nama_peserta ?>" />
                                        <input type="hidden" name="tanggal_presensi" value="<?= $tanggal_sekarang ?>" />
                                        <button type="submit" class="btn btn-success btn-md btn-block"><i class="fas fa-check"></i> Presensi Kehadiran</button>
                                    </form>

                                <?php
                                }
                            } elseif ($jam_sekarang < "07:00:00" && $hari_sekarang == $tanggal_bimbingan) {
                                ?>
                                <i class="fas fa-exclamation-circle mb-3"></i> Status Presensi : Belum presensi
                                <button type="submit" class="btn btn-danger btn-md btn-block" disabled><i class="fas fa-ban"></i> Waktu Presensi Belum Dimulai</button>
                            <?php
                            } elseif ($jam_sekarang >= "14:00:00" && $hari_sekarang == $tanggal_bimbingan) {
                            ?>
                                <button type="submit" class="btn btn-danger btn-md btn-block" disabled><i class="fas fa-ban"></i> Waktu Presensi Telah Berakhir</button>
                        <?php
                            }
                        };
                        if (!$jadwal) {
                            echo '<button type="submit" class="btn btn-danger btn-md btn-block" disabled><i class="fas fa-ban"></i> Presensi hanya dapat dilakukan pada hari bimbingan.</button>
                            ';
                        }
                       
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <?= $this->endSection() ?>