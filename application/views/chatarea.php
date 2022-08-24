<?php $this->load->view('dist/_partials/header.php'); ?>
<div class="main-content">
    <div class="card chat-box" id="mychatbox">
        <div class="card-header">
            <h4>Chat with <?= $penerima['fnama'] . ' ' . $penerima['lnama'] ?></h4>
        </div>
        <div class="card-body chat-content">
        </div>
        <div class="card-footer chat-form">
            <form id="chat-form">
                <input type="text" class="form-control" placeholder="Type a message">
                <button class="btn btn-primary">
                    <i class="far fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view('dist/_partials/footer.php'); ?>
<script>
    chatcontent = document.querySelector('.chat-content');
    setInterval(function() {
        $.ajax({
            url: "<?= base_url() . $this->uri->segment(1) . '/chat/getChat/' . $this->uri->segment(4) ?>",
            type: "GET",
            success: function(data) {
                chatcontent.innerHTML = "<div class='mychatbox' id='mychatbox'>" + data + "</div>";
            }
        })
    }, 500);

    $("#chat-form").submit(function() {
        var me = $(this);

        if (me.find('input').val().trim().length > 0) {
            $.chatCtrl('#mychatbox', {
                text: me.find('input').val(),
                picture: '<?= base_url() ?>assets/img/profile/<?= $this->uri->segment(1); ?>/<?= $user['image'] ?>',
            });
            $.ajax({
                type: "POST",
                url: "<?= base_url($user['otoritas'] . '/chat/kirimpesan/') ?>",
                data: {
                    uid_penerima: "<?= $penerima['uid_member'] ?>",
                    uid_pengirim: "<?= $user['member_id'] ?>",
                    message: me.find('input').val(),
                    email: "<?= $penerima['email'] ?>"
                },
                success: function(data) {
                    console.log(data);
                }

            })
            me.find('input').val('');
        }
        return false;
    });
</script>