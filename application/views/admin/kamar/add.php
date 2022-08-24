<?php $this->load->view('dist/_partials/header') ?>

<div class="main-content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">
                        <a href="<?= base_url('admin/kamar/master') ?>"><i class="fa-solid fa-circle-arrow-left"></i> </a> Tambah Kamar
                    </h4>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/kamar/master/addproccess') ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="nama">Nama kamar</label>
                            <input type="text" class="form-control nama" id="nama" name="nama" required>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label for="nama">Juragan</label>
                                    <select class="form-control juragan select2" id="uid_member" name="uid_member" required>
                                        <option value="">pilih juragan</option>
                                        <?php foreach ($juragan as $juragan) : ?>
                                            <option value="<?= $juragan['uid_member'] ?>"><?= $juragan['fnama'] . ' ' . $juragan['lnama'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label for="nama">Harga kamar</label>
                                    <input type="text" class="form-control harga" id="harga" name="harga" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label for="nama">Diskon kamar</label>
                                    <input type="text" class="form-control diskon" id="diskon" name="diskon">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Fasilitas</label>
                                    <select class="form-control select2 fasilitas" multiple name="fasilitas[]" id="fasilitas" required>
                                        <option value="0" default>Pilih Fasilitas</option>
                                        <?php foreach ($fasilitas as $fasilitas) : ?>
                                            <option value="<?= $fasilitas['uid_fasilitas'] ?>"><?= $fasilitas['nama'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Durasi</label>
                                    <select class="form-control select2 durasi" multiple name="durasi[]" id="durasi">
                                        <option value="0" default>Pilih durasi</option>
                                        <?php foreach ($durasi as $durasi) : ?>
                                            <option value="<?= $durasi['uid_durasi'] ?>"><?= $durasi['durasi'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Kategori kamar</label>
                                    <select class="form-control select2 kategori" multiple name="kategori[]" id="kategori" required>
                                        <?php foreach ($kategori as $kategori) : ?>
                                            <option value="<?= $kategori['uid_kategori'] ?>"><?= $kategori['nama_kategori'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="luaskamar">Luas kamar</label>
                                    <input type="text" class="form-control luaskamar" name="luaskamar" id="luaskamar" required>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label class="d-block">Status</label>
                                    <select name="status" id="status" class="status form-control" required>
                                        <option value="">Pilih status kamar</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi kamar</label>
                                    <textarea name="deskripsi" class="deskripsi" id="deskripsi" style="height: 200px;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="Alamat">Alamat</label>
                                    <input type="text" class="form-control alamat" name="alamat" id="alamat" style="height: 80px;" placeholder="Masukan alamat lengkap" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="Provinsi">Provinsi</label>
                                    <select class="form-control provinsi select2" name="provinsi" id="provinsi" required>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="Kota">Kota</label>
                                    <select class="form-control kota select2" name="kota" id="kota" required>
                                        <option value="">Pilih Kota/Kabupaten</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="Kota">Lokasi Maps embed</label><br>
                                    <small>Tutorial mengambil embed maps? <a href="">Cara Embed</a></small>
                                    <input type="text" class="form-control maps" id="maps" name="maps" placeholder="Masukan iframe dari embed maps jika ingin menggunakan maps pada lokasi kost anda">
                                    <input type="text" hidden name="hidden_maps" id="hidden_maps">
                                    <small>Maps lokasi kost anda:</small>
                                    <div class="maps-frame" style="height: 250px; width:250px">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h6>Gambar kamar</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="gambar_satu">Gambar 1</label>
                                            <input class="form-control" type="file" name="gambar_satu" id="gambar_satu" accept="img/*" require>
                                            <input class="form-control" type="text" name="gambar_satu_hidden" id="gambar_satu_hidden" hidden>
                                            <img class="gambar_satu_pre" id="gambar_satu_pre" src=""></img>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="gambar_dua">Gambar 2</label>
                                            <input class="form-control" type="file" name="gambar_dua" id="gambar_dua" accept="img/*">
                                            <input class="form-control" type="text" name="gambar_dua_hidden" id="gambar_dua_hidden" hidden>
                                            <img class="gambar_dua_pre" id="gambar_dua_pre"></img>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="gambar_tiga">Gambar 3</label>
                                            <input class="form-control" type="file" name="gambar_tiga" id="gambar_tiga" accept="img/*">
                                            <input class="form-control" type="text" name="gambar_tiga_hidden" id="gambar_tiga_hidden" hidden>
                                            <img class="gambar_tiga_pre" id="gambar_tiga_pre"></img>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="gambar_empat">Gambar 4</label>
                                            <input class="form-control" type="file" name="gambar_empat" id="gambar_empat" accept="img/*">
                                            <input class="form-control" type="text" name="gambar_empat_hidden" id="gambar_empat_hidden" hidden>
                                            <img class="gambar_empat_pre" id="gambar_empat_pre"></img>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="gambar_lima">Gambar 5</label>
                                            <input class="form-control" type="file" name="gambar_lima" id="gambar_lima" accept="img/*">
                                            <input class="form-control" type="text" name="gambar_lima_hidden" id="gambar_lima_hidden" hidden>
                                            <img class="gambar_lima_pre" id="gambar_lima_pre"></img>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary simpan" id="simpan">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('dist/_partials/footer') ?>
<script>
    var headers = {}
    $(document).ready(function() {
        // deskripsi kamar
        $('#deskripsi').summernote({
            height: 300,
            minHeight: null,
            maxHeight: null,
            focus: true,
        });

        var app = {
            show: function() {
                $.ajax({
                    url: "<?= base_url('api/provinsi') ?>",
                    method: "GET",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    success: function(data) {
                        var html = '';
                        var provinsi = JSON.parse(data);
                        for (var i = 0; i < provinsi.length; i++) {
                            html += '<option value="' + provinsi[i].name + '" kota-id="' + provinsi[i].id + '">' + provinsi[i].name + '</option>';

                        }
                        $("#provinsi").html(html);
                    }
                })
            },
            tampil: function() {
                var provinsi_id = $(this);
                var kotaId = $('option:selected', this).attr('kota-id');
                $.ajax({
                    url: "<?= base_url('api/kabupaten/') ?>" + kotaId,
                    method: "GET",
                    type: 'JSON',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    success: function(data) {
                        var html = '';
                        var kabupaten = JSON.parse(data);
                        for (var i = 0; i < kabupaten.length; i++) {
                            html += '<option value="' + kabupaten[i].name + '">' + kabupaten[i].name + '</option>';
                        }
                        $("#kota").html(html);
                    }
                })
            }
        };
        app.show();
        $(document).on("change", "#provinsi", app.tampil);
        gambar();
        $('#maps').on('change', function() {
            $('.maps-frame').html($(this).val());
        })
    })
    // function gambar
    function gambar() {
        // section gambar
        gambar_satu = document.getElementById('gambar_satu');
        gambar_satu_pre = document.getElementById('gambar_satu_pre');
        gambar_dua = document.getElementById('gambar_dua');
        gambar_dua_pre = document.getElementById('gambar_dua_pre');
        gambar_tiga = document.getElementById('gambar_tiga');
        gambar_tiga_pre = document.getElementById('gambar_tiga_pre');
        gambar_empat = document.getElementById('gambar_empat');
        gambar_empat_pre = document.getElementById('gambar_empat_pre');
        gambar_lima = document.getElementById('gambar_lima');
        gambar_lima_pre = document.getElementById('gambar_lima_pre');
        gambar_satu.onchange = evt => {
            const [file] = gambar_satu.files;
            if (file) {
                gambar_satu_pre.src = URL.createObjectURL(file);
                document.getElementById('gambar_satu_pre').classList.add('image-upload');
            }
        }
        gambar_dua.onchange = evt => {
            const [file] = gambar_dua.files;
            if (file) {
                gambar_dua_pre.src = URL.createObjectURL(file);
                document.getElementById('gambar_dua_pre').classList.add('image-upload');
            }
        }
        gambar_tiga.onchange = evt => {
            const [file] = gambar_tiga.files;
            if (file) {
                gambar_tiga_pre.src = URL.createObjectURL(file);
                document.getElementById('gambar_tiga_pre').classList.add('image-upload');
            }
        }
        gambar_empat.onchange = evt => {
            const [file] = gambar_empat.files;
            if (file) {
                gambar_empat_pre.src = URL.createObjectURL(file);
                document.getElementById('gambar_empat_pre').classList.add('image-upload');
            }
        }
        gambar_lima.onchange = evt => {
            const [file] = gambar_lima.files;
            if (file) {
                gambar_lima_pre.src = URL.createObjectURL(file);
                document.getElementById('gambar_lima_pre').classList.add('image-upload');
            }
        }
    }
</script>