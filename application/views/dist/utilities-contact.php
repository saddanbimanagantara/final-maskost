<body>
  <?php $this->load->view('dist/_partials/notif'); ?>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-md-10 offset-md-1 col-lg-10 offset-lg-1">
            <div class="card card-primary">
              <div class="row m-0">
                <div class="col-12 col-md-12 col-lg-12 p-0">
                  <div class="card-header text-center">
                    <h4>Contact Us</h4>
                  </div>
                  <div class="card-body">
                    <form method="POST" action="<?= base_url('page/contactProccess') ?>">
                      <div class="form-group floating-addon">
                        <label>Name</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="far fa-user"></i>
                            </div>
                          </div>
                          <input id="name" type="text" class="form-control" name="name" autofocus placeholder="Name">
                        </div>
                      </div>

                      <div class="form-group floating-addon">
                        <label>Email</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="fas fa-envelope"></i>
                            </div>
                          </div>
                          <input id="email" type="email" class="form-control" name="email" placeholder="Email">
                        </div>
                      </div>

                      <div class="form-group">
                        <label>Message</label>
                        <textarea class="form-control" placeholder="Type your message" data-height="150" name="message"></textarea>
                      </div>

                      <div class="form-group text-right">
                        <button type="submit" class="btn btn-round btn-md btn-primary">
                          Send Message
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="col-12 col-md-12 col-lg-7 p-0">
                  <div id="map" class="contact-map"></div>
                </div>
              </div>
            </div>
            <div class="simple-footer">
              Mas Kost
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>