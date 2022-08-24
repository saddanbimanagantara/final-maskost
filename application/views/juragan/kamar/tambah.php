<?php $this->load->view('dist/_partials/header'); ?>
<style type="text/css">
    #tambah_kamar fieldset:not(:first-of-type) {
        display: none;
    }
</style>
<div class="main-content">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah data kamar</h4>
                </div>
                <div class="card-body">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <form id="tambah_kamar" novalidate action="<?= base_url('juragan/kamar/save') ?>" method="post" enctype="multipart/form-data">
                        <fieldset>
                            <h6 class="mt-3">Nama</h6>
                            <div class="form-group">
                                <label for="nama">Nama kamar</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Contoh: Kamar 1A Lantai 2 Kost Mawar">
                            </div>
                            <input type="button" name="next" class="next btn btn-info" value="selanjutnya" />
                        </fieldset>
                        <fieldset>
                            <h6 class="mt-3"> Harga dan Diskon Kamar</h6>
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input class="form-control" type="text" name="harga" id="harga">
                            </div>
                            <div class="form-group">
                                <label for="diskon">Diskon</label>
                                <input class="form-control" type="text" name="diskon" id="diskon">
                                <span class="text-danger">Masukan diskon dalam bentuk persen bukan nominal potongan</span>
                            </div>
                            <input type="button" name="previous" class="previous btn btn-default" value="sebelumnya" />
                            <input type="button" name="next" class="next btn btn-info" value="selanjutnya" />
                        </fieldset>
                        <fieldset>
                            <h6 class="mt-3">Fasilitas, Durasi dan Kategori</h6>
                            <div class="form-group">
                                <label>Fasilitas</label>
                                <select class="form-control select2" multiple name="fasilitas[]" id="fasilitas" style="width: 100%">
                                    <option value="0" default>Pilih Fasilitas</option>
                                    <?php foreach ($fasilitas as $fasilitas) : ?>
                                        <option value="<?= $fasilitas['uid_fasilitas'] ?>"><?= $fasilitas['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Durasi</label>
                                <select class="form-control select2" multiple name="durasi[]" id="durasi" style="width: 100%;">
                                    <option value="0" default>Pilih durasi</option>
                                    <?php foreach ($durasi as $durasi) : ?>
                                        <option value="<?= $durasi['uid_durasi'] ?>"><?= $durasi['durasi'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kategori kamar</label>
                                <select class="form-control select2" multiple name="kategori[]" id="kategori" style="width:100%;">
                                    <?php foreach ($kategori as $kategori) : ?>
                                        <option value="<?= $kategori['uid_kategori'] ?>"><?= $kategori['nama_kategori'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="luaskamar">Luas kamar</label>
                                <input type="text" class="form-control luaskamar" name="luaskamar" id="luaskamar" placeholder="3x2 / 3x3 ..." required>
                            </div>
                            <input type="text" name="status" id="status" value="1" hidden>
                            <input type="button" name="previous" class="previous btn btn-default" value="sebelumnya" />
                            <input type="button" name="next" class="next btn btn-info" value="selanjutnya" />
                        </fieldset>
                        <fieldset>
                            <h6 class="mt-3">Lokasi kamar kost</h6>
                            <div class="form-group">
                                <label for="Alamat">Alamat</label>
                                <input type="text" class="form-control alamat" name="alamat" id="alamat" style="height: 80px;" placeholder="Masukan alamat lengkap" required>
                            </div>
                            <div class="form-group">
                                <label for="Provinsi">Provinsi</label>
                                <select class="form-control provinsi select2" name="provinsi" id="provinsi" style="width: 100%;" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="Kota">Kota</label>
                                <select class="form-control kota select2" name="kota" id="kota" style="width: 100%;" required>
                                    <option value="">Pilih Kota/Kabupaten</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="Kota">Lokasi Maps embed</label><br>
                                <small>Tutorial mengambil embed maps? <a href="">Cara Embed</a></small>
                                <input type="text" class="form-control maps" id="maps" name="maps" placeholder="Masukan iframe dari embed maps jika ingin menggunakan maps pada lokasi kost anda">
                                <input type="text" hidden name="hidden_maps" id="hidden_maps">
                                <small>Maps lokasi kost anda:</small>
                                <div class="maps-frame" style="height: 250px; width:250px">
                                </div>
                            </div>
                            <input type="button" name="previous" class="previous btn btn-default" value="sebelumnya" />
                            <input type="button" name="next" class="next btn btn-info" value="selanjutnya" />
                        </fieldset>
                        <fieldset>
                            <h6 class="mt-3">Deskripsi</h6>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi kamar</label>
                                <textarea name="deskripsi" class="deskripsi" id="deskripsi" style="height: 200px;"></textarea>
                            </div>
                            <input type="button" name="previous" class="previous btn btn-default" value="sebelumnya" />
                            <input type="button" name="next" class="next btn btn-info" value="selanjutnya" />
                        </fieldset>
                        <fieldset>
                            <h6 class="mt-3">Gambar</h6>
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
                            <input type="button" name="previous" class="previous btn btn-default" value="sebelumnya" />
                            <input type="submit" name="submit" class="next btn btn-info" value="simpan" />
                        </fieldset>
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

        var current = 1,
            current_step, next_step, steps;
        steps = $("fieldset").length;
        $(".next").click(function() {
            current_step = $(this).parent();
            next_step = $(this).parent().next();
            next_step.show();
            current_step.hide();
            setProgressBar(++current);
        });
        $(".previous").click(function() {
            current_step = $(this).parent();
            next_step = $(this).parent().prev();
            next_step.show();
            current_step.hide();
            setProgressBar(--current);
        });
        setProgressBar(current);
        // Change progress bar action
        function setProgressBar(curStep) {
            var percent = parseFloat(100 / steps) * curStep;
            percent = percent.toFixed();
            $(".progress-bar")
                .css("width", percent + "%")
                .html(percent + "%");
        }
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