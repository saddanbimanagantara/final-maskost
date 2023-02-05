<?php
$filter['harga'] = $this->db->select_max('harga')->get('kamar_kost')->row_array();
$filter['umum'] = $this->kamar->getFilter('fasilitas_kamar', 'umum');
$filter['kamar'] = $this->kamar->getFilter('fasilitas_kamar', 'kamar');
$filter['kamar_mandi'] = $this->kamar->getFilter('fasilitas_kamar', 'kamar mandi');
$filter['parkiran'] = $this->kamar->getFilter('fasilitas_kamar', 'parkiran');
$filter['durasi_kamar'] = $this->kamar->getFilter('durasi_kamar', null);
$filter['kategori_kamar'] = $this->kamar->getFilter('kategori_kamar', null);
$filter['lokasi'] = $data = $this->db->select('kota')->from('kamar_kost')->group_by('kota')->get()->result_array();
?>

<!-- modal harga -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalharga">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Filter harga</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <price-range currency="Rp">
                        <div>
                            <div>
                                <input name="price-from" type="range" min="0" max="<?= $filter['harga']['harga']+100000 ?>" step="50000" value="10000" aria-label="From" />
                                <input name="price-to" type="range" min="0" max="<?= $filter['harga']['harga']+100000 ?>" step="50000" value="<?= $filter['harga']['harga']+100000 ?>" aria-label="To" />
                            </div>
                        </div>
                        <output>
                            output
                        </output>
                    </price-range>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-sm btn-primary apply-filter" data-dismiss="modal" aria-label="Close">Filter</button>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- modal fasilitas -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalfasilitas">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title  font-weight-bold">Fasilitas</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
                    echo '<label class="mt-2" style="font-size:18px">Fasilitas bersama</label>';
                    foreach ($filter['umum'] as $umum) {
                        echo '<div class="col-md-6 col-sm-6">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="uid_fasilitas' . $umum['uid_fasilitas'] . '" value="' . $umum['uid_fasilitas'] . '">
                                        <label class="form-check-label ml-1" for="inlineCheckbox1">' . $umum['nama'] . '</label>
                                    </div>
                                </div>';
                    }
                    echo '<label class="mt-2"  style="font-size:18px">Kamar</label>';
                    foreach ($filter['kamar'] as $kamar) {
                        echo '<div class="col-md-6 col-sm-6">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="uid_fasilitas' . $kamar['uid_fasilitas'] . '" value="' . $kamar['uid_fasilitas'] . '">
                                        <label class="form-check-label" for="inlineCheckbox1">' . $kamar['nama'] . '</label>
                                    </div>
                                </div>';
                    }
                    echo '<label  class="mt-2" style="font-size:18px">Kamar mandi</label>';
                    foreach ($filter['kamar_mandi'] as $kamar_mandi) {
                        echo '<div class="col-md-6 col-sm-6">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="uid_fasilitas' . $kamar_mandi['uid_fasilitas'] . '" value="' . $kamar_mandi['uid_fasilitas'] . '">
                                        <label class="form-check-label" for="inlineCheckbox1">' . $kamar_mandi['nama'] . '</label>
                                    </div>
                                </div>';
                    }
                    echo '<label class="mt-2" style="font-size:18px">Parkiran</label>';
                    foreach ($filter['parkiran'] as $parkiran) {
                        echo '<div class="col-md-6 col-sm-6">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="uid_fasilitas' . $parkiran['uid_fasilitas'] . '" value="' . $parkiran['uid_fasilitas'] . '">
                                        <label class="form-check-label" for="inlineCheckbox1">' . $parkiran['nama'] . '</label>
                                    </div>
                                </div>';
                    }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-sm btn-primary apply-filter" data-dismiss="modal" aria-label="Close">Filter</button>
            </div>
        </div>
    </div>
</div>
<!-- modal durasi -->
<div class="modal fade" tabindex="-1" role="dialog" id="modaldurasi">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Durasi</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
                    echo '<label>Durasi kamar</label>';
                    foreach ($filter['durasi_kamar'] as $durasi_kamar) {
                        echo '<div class="col-md-6 col-sm-6">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="uid_durasi' . $durasi_kamar['uid_durasi'] . '" value="' . $durasi_kamar['uid_durasi'] . '">
                                        <label class="form-check-label" for="inlineCheckbox1">' . $durasi_kamar['nama'] . '</label>
                                    </div>
                                </div>';
                    }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-sm btn-primary apply-filter" data-dismiss="modal" aria-label="Close">Filter</button>
            </div>
        </div>
    </div>
</div>
<!-- modal kategori -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalkategori">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Kategori</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-control" name="kategori_kamar" id="kategori_kamar">
                            <option value="">Pilih kategori kamar</option>
                            <?php
                            foreach ($filter['kategori_kamar'] as $kategori_kamar) {
                                echo '<option value="' . $kategori_kamar['uid_kategori'] . '">' . $kategori_kamar['nama_kategori'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Hapus filter</button>
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal" aria-label="Close">Simpan filter</button>
            </div>
        </div>
    </div>
</div>
<!-- modal tipe -->
<div class="modal fade" tabindex="-1" role="dialog" id="modaltipe">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Filter tipe kamar dan lokasi kost</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group">
                        <label>Tipe kamar</label>
                        <select class="form-control" name="tipe">
                            <option value="">Pilih tipe</option>
                            <option value="A">Tipe A Maks. 1 orang/ kamar</option>
                            <option value="B">Tipe B Maks. 2 orang/ kamar</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label>Lokasi kost</label>
                        <select class="form-control" name="kota">
                            <option value="">Pilih lokasi</option>
                            <?php
                            foreach ($filter['lokasi'] as $lokasi) {
                                echo '<option value="' . $lokasi['kota'] . '">' . $lokasi['kota'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Hapus filter</button>
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal" aria-label="Close">Simpan filter</button>
            </div>
        </div>
    </div>
</div>