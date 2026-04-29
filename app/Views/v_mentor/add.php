<div class="modal fade" id="modalAdd">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Input Data Presensi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('MentorDataPresensi/add', ['id' => 'formTambahPresensi']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="nama_peserta">Nama Peserta</label><span style="color:red"> *</span></label>
                    <select name="user_id" id="nama_peserta" class="form-control" required>
                        <option value="">-- Pilih Nama Peserta --</option>
                        <?php foreach ($presensi as $p) : ?>
                            <option value="<?= $p['user_id'] ?>"><?= $p['nama_peserta'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small id="nama_peserta_error" class="text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="tanggal_presensi">Tanggal Presensi</label><span style="color:red"> *</span></label>
                    <input type="date" class="form-control" name="tanggal_presensi" value="<?= set_value('tanggal_presensi') ?>">
                    <small id="tanggal_presensi_error" class="text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="jam">Jam Presensi</label><span style="color:red"> *</span></label>
                    <input type="time" class="form-control" name="jam" value="<?= set_value('jam') ?>">
                    <small id="jam_error" class="text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="status_presensi">Status Presensi</label><span style="color:red"> *</span></label>
                    <select class="form-control" id="status_presensi" name="status_presensi">
                        <option value="">--Status Presensi--</option>
                        <option value="Hadir">Hadir</option>
                        <option value="Tidak Hadir">Tidak Hadir</option>
                    </select>
                    <small id="status_presensi_error" class="text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="keterangan_presensi">Keterangan Presensi</label><span style="color:red"> *</span></label>
                    <select class="form-control" id="keterangan_presensi" name="keterangan_presensi">
                        <option value="">--Keterangan Presensi--</option>
                        <option value="Terlambat">Terlambat</option>
                        <option value="Tepat Waktu">Tepat Waktu</option>
                    </select>
                    <small id="keterangan_presensi_error" class="text-danger"></small>
                </div>
            </div>
            <?= form_close() ?>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="btn-tambah" class="btn btn-primary">Save</button>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>