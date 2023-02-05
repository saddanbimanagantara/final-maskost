<?php $this->load->view('dist/_partials/header.php'); ?>
<div class="main-content">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            Daftar Chat
            <button href="" class="btn btn-primary mb-2 btn-new float-right text-white btn-cari" data-toggle="modal" data-target="#pesanbaru" id="btn-cari">Kirim Pesan Baru</button>
        </div>
        <div class="card-body">
            <div class="align-items-center">
                <div class="form-group">
                    <input type="text" class="form-control mb-1" id="search" class="search" name="search" placeholder="Masukan nama penghuni" style="width: 30%;">
                    <?php if ($user['otoritas'] == "juragan") { ?>
                        <label class="custom-switch">
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Penghuni</span>
                        </label>
                    <?php } else {
                    } ?>
                </div>
            </div>
            <ul class="list-unstyled list-unstyled-border chat" id="chat">

            </ul>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="pesanbaru" tabindex="-1" role="dialog" aria-labelledby="pesanbaru" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cari penghuni</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select name="penghuni" id="penghuni" class="penghuni form-control">

                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary kirimpesan" id="kirimpesan">Kirim pesan</button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('dist/_partials/footer.php'); ?>
<script>
    $('document').ready(function() {
        load();
        $(".custom-switch-input").change(function() {
            if ($(this).prop("checked") == true) {
                $.ajax({
                    url: "<?= base_url($user['otoritas'] . '/chat/getPengirim') ?>",
                    type: "POST",
                    data: {
                        penghuni: "on"
                    },
                    success: function(data) {
                        chatContent.innerHTML = data;
                    }
                })
            } else {
                load();
            }
        });
        chatContent = document.querySelector('.chat');
        $('#search').on('input', function() {
            var search = $(this).val();
            if (search === "") {
                load();
            } else {
                $.ajax({
                    url: "<?= base_url($user['otoritas'] . '/chat/getPengirim') ?>",
                    type: "POST",
                    data: {
                        search: search
                    },
                    success: function(data) {
                        chatContent.innerHTML = data;
                    }
                })
            }
        })

        $('.btn-cari').click(function() {
            var select = document.querySelector('.penghuni');
            $.ajax({
                url: "<?= base_url($user['otoritas'] . '/chat/getPenghuni') ?>",
                type: "GET",
                dataType: "JSON",
                success: function(response) {
                    console.log(response);
                    response.forEach(function(value) {
                        var option = document.createElement('option');
                        option.value = value.uid_member;
                        option.text = value.fnama + ' ' + value.lnama;
                        select.appendChild(option);
                    })
                }
            })
        })

        $('.kirimpesan').click(function() {
            var uid_penghuni = $('#penghuni').find(":selected").val();
            url = "<?= base_url($user['otoritas'] . '/chat/area/') ?>" + uid_penghuni;
            window.location.href = url;
        })
    })

    function load() {
        $.ajax({
            url: "<?= base_url($user['otoritas'] . '/chat/getPengirim') ?>",
            type: "GET",
            success: function(data) {
                chatContent.innerHTML = data;
            }
        })
    }
</script>