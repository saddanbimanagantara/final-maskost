<?php $this->load->view('dist/_partials/header'); ?>
<div class="main-content">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah data kamar</h4>
                </div>
                <div class="card-body">
                    <form id="tambah_kamar" action="<?= base_url('juragan/kamar/save') ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate="">
                        <div class="row">
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <label for="nama">Nama kamar</label>
                                    <input type="text" name="status" value="validasi" hidden>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Contoh: Kamar 1A Lantai 2 Kost Mawar" required>
                                    <div class="invalid-feedback">
                                        Nama harus diisi!
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="tipekamar">Tipe Kamar</label>
                                    <select name="tipe" id="tipe" class="form-control" required>
                                        <option value="">Pilih tipe kamar</option>
                                        <option value="A">Tipe A Maks. 1 orang/ kamar</option>
                                        <option value="B">Tipe B Maks. 2 orang/ kamar</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Tipe kamar harus dipilih!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="harga">Jumlah kamar</label>
                                    <input class="form-control" type="number" name="jumlah_kamar" id="jumlah_kamar" required>
                                    <div class="invalid-feedback">
                                        Jumlah kamar harus diisi!
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input class="form-control" min="100000" max="20000000" type="number" name="harga" id="harga" required>
                                    <div class="invalid-feedback">
                                        Harga harus diisi! minimal Rp 100.000
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="diskon">Diskon</label>
                                    <input class="form-control" type="number" name="diskon" id="diskon" required>
                                    <div class="invalid-feedback">
                                        Diskon harus diisi!
                                    </div>
                                    <span class="text-warning">Masukan diskon dalam bentuk persen bukan nominal potongan</span>

                                </div>
                            </div>
                        </div>
                        <p class="font-weight-bold">FASILITAS:</p>
                        <div class="row mb-2">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Fasilitas Umum</label>
                                    <select class="form-control select2" multiple name="f_umum[]" id="fasilitas" style="width: 100%">
                                        <?php foreach ($f_umum as $f_umum) : ?>
                                            <option value="<?= $f_umum['uid_fasilitas'] ?>"><?= $f_umum['nama'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Fasilitas Kamar</label>
                                    <select class="form-control select2" multiple name="f_kamar[]" id="fasilitas" style="width: 100%">
                                        <?php foreach ($f_kamar as $f_kamar) : ?>
                                            <option value="<?= $f_kamar['uid_fasilitas'] ?>"><?= $f_kamar['nama'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Fasilitas Kamar harus dipilih!
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Fasilitas Kamar Mandi</label>
                                    <select class="form-control select2" multiple name="f_kamar_mandi[]" id="fasilitas" style="width: 100%">
                                        <?php foreach ($f_kamar_mandi as $f_kamar_mandi) : ?>
                                            <option value="<?= $f_kamar_mandi['uid_fasilitas'] ?>"><?= $f_kamar_mandi['nama'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Fasilitas Kamar Mandi harus dipilih!
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Fasilitas Parkiran</label>
                                    <select class="form-control select2" multiple name="f_parkiran[]" id="fasilitas" style="width: 100%">
                                        <?php foreach ($f_parkiran as $f_parkiran) : ?>
                                            <option value="<?= $f_parkiran['uid_fasilitas'] ?>"><?= $f_parkiran['nama'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <p class="font-weight-bold">DURASI DAN KATEGORI KAMAR:</p>
                        <div class="row mb-2">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Durasi</label>
                                    <select class="form-control select2" multiple name="durasi[]" id="durasi" style="width: 100%;" required>
                                        <?php foreach ($durasi as $durasi) : ?>
                                            <option value="<?= $durasi['uid_durasi'] ?>"><?= $durasi['durasi'] ?> Bulan</option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Durasi harus dipilih!
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Kategori kamar</label>
                                    <select class="form-control" name="kategori" id="kategori" style="width:100%;" required>
                                        <option value="">pilih kategori</option>
                                        <?php foreach ($kategori as $kategori) : ?>
                                            <option value="<?= $kategori['uid_kategori'] ?>"><?= $kategori['nama_kategori'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Kategori harus dipilih!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="luaskamar">Luas kamar</label>
                            <input type="text" class="form-control luaskamar" name="luaskamar" id="luaskamar" placeholder="3x2 / 3x3 ..." required>
                            <div class="invalid-feedback">
                                Luas kamar harus diisi!
                            </div>
                        </div>
                        <p class="font-weight-bold">LOKASI:</p>
                        <div class="form-group">
                            <label for="Alamat">Alamat</label>
                            <input type="text" class="form-control alamat" name="alamat" id="alamat" style="height: 80px;" placeholder="Masukan alamat lengkap" required>
                            <div class="invalid-feedback">
                                Alamat harus diisi!
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Provinsi">Provinsi</label>
                            <select class="form-control provinsi select2" name="provinsi" id="provinsi" style="width: 100%;" required>
                            </select>
                            <div class="invalid-feedback">
                                Provinsi harus dipilih!
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Kota">Kota</label>
                            <select class="form-control kota select2" name="kota" id="kota" style="width: 100%;" required>
                                <option value="">Pilih Kota/Kabupaten</option>
                            </select>
                            <div class="invalid-feedback">
                                Kota/kabupaten harus dipilih!
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Kota">Lokasi Maps embed</label><br>
                            <small>Tutorial mengambil embed maps? <a href="<?= base_url('page/tutorialmaps') ?>">Cara Embed</a></small>
                            <input type="text" class="form-control maps" id="maps" name="maps" placeholder="Masukan iframe dari embed maps jika ingin menggunakan maps pada lokasi kost anda">
                            <input type="text" hidden name="hidden_maps" id="hidden_maps">
                            <small>Maps lokasi kost anda:</small>
                            <div class="maps-frame" style="height: 250px; width:250px">
                            </div>
                        </div>
                        <p class="font-weight-bold" for="deskripsi">Deskripsi kamar</p>
                        <div class="form-group">
                            <textarea name="deskripsi" class="deskripsi" id="deskripsi" style="height: 200px;"></textarea>
                            <div class="invalid-feedback">
                                Diskripsi harus diisi!
                            </div>
                        </div>
                        <p class="font-weight-bold">GAMBAR</p>
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="gambar_satu">Gambar 1</label>
                                    <input class="form-control" type="file" name="gambar_satu" id="gambar_satu" accept="img/*" required>
                                    <div class="invalid-feedback">
                                        Wajib upload 1 gambar!
                                    </div>
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
                        <input type="submit" name="submit" class="next btn btn-info" value="simpan" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('dist/_partials/footer'); ?>
<script>
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
    });
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