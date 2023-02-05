<!-- market kost section -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<div class="container mt-2">

    <form id="filterkamar" action="<?= base_url('kost/filter') ?>" method="post">
        <div class="">
            <div id="btn-filter">
                <button class="btn btn-sm btn-outline-dark modalButton" type="button" data-toggle="modal" data-target="#modalharga">Harga</button>
                <button class="btn btn-sm btn-outline-dark modalButton" type="button" data-toggle="modal" data-target="#modalfasilitas">Fasilitas</button>
                <button class="btn btn-sm btn-outline-dark modalButton" type="button" data-toggle="modal" data-target="#modaldurasi">Durasi</button>
                <button class="btn btn-sm btn-outline-dark modalButton" type="button" data-toggle="modal" data-target="#modalkategori">Kategori</button>
                <button class="btn btn-sm btn-outline-dark modalButton" type="button" data-toggle="modal" data-target="#modaltipe">Tipe dan Lokasi</button>
            </div>
            <div class="filter mt-1">
                <button class="btn btn-sm btn-primary float-left apply-filter" type="button">Apply filter</i>
                </button>
                <button class="btn btn-sm btn-danger ml-1 reset" type="button">Reset filter</button>
            </div>
        </div>
        <?php $this->load->view('dist/filter.php') ?>
    </form>
</div>

<div class="container">
<section>
        <div class="pro-container">
            <div class="not-found"></div>
        </div>
    </section>
</div>
<div class="section-p1">
    <div id="pagination"></div>
</div>

</div>
<input type="text" value="" id="terjual" hidden>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    $(document).ready(() => {
        loadPagination(0);

        $('.apply-filter').click(function(e) {
            console.log($('#filterkamar').serializeArray())
            loadPagination(0);
        })

        $('#pagination').on('click', 'a', function(e) {
            e.preventDefault();
            var pageno = $(this).attr('data-ci-pagination-page');
            loadPagination(pageno);
        });

        $('.reset').click(function() {
            location.reload();
        })
        // Load pagination
        function loadPagination(pagno) {
            $.ajax({
                url: '<?= base_url() ?>kost/jsonKamar/' + pagno,
                type: 'POST',
                data: $('#filterkamar').serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $('#pagination').html(response.pagination);
                    var kamar = response.kamar;
                    console.log(response);
                    if (kamar.length > 0) {
                        createCardKamar(response.kamar, response.row, response.fasilitaskamar);
                    } else {
                        $('.pro-container').empty();
                        $('.pro-container').append('<h4>Data kamar tidak ada!</h4>');
                    }
                }
            });
        }


        function createCardKamar(result, sno, fasilitaskamar) {
            sno = Number(sno);
            $('.pro-container').empty();
            var url = '<?= base_url('public/images/kamar/') ?>';
            for (index in result) {
                // set rating
                var rating = result[index].limabintang + result[index].empatbintang + result[index].tigabintang + result[index].duabintang + result[index].satubintang;
                var jumlahpenghuni = result[index].testicount;
                var totalbintang = '';
                if (jumlahpenghuni == 0) {
                    rating = 0
                } else {
                    temp = rating / jumlahpenghuni;
                }
                var rating = parseInt(rating) / parseInt(jumlahpenghuni);
                // set fasilitas
                var fasilitas = result[index].uid_fasilitas.split(',');
                var string = '';
                for (f in fasilitas) {
                    for (fk in fasilitaskamar) {
                        if (fasilitas[f] == fasilitaskamar[fk].uid_fasilitas) {
                            string += fasilitaskamar[fk].nama + `·`;
                        }
                    }
                }
                fasilitas = string.substr(0, 50) + " ...";
                // set bintang
                var bintang = '';
                var b = 1;
                while (b <= rating) {
                    bintang += '<i class="fas fa-star"></i>';
                    b++;
                }
                var sisaKamar = result[index].jumlah_kamar - result[index].terjual;
                // set harga
                var diskon = (result[index].diskon / 100) * result[index].harga;
                var hargaRp = rupiah(result[index].harga);
                var hargaDiskonRp = rupiah(result[index].harga - diskon);
                var sisaKamar = result[index].jumlah_kamar - result[index].terjual;
                var content = `
                <div class="pro" kost-id="${result[index].uid_kamar}" onclick='detail(this)'>
                        <img src="${url}${result[index].gambar_satu}">
                        <small class="btn kategori btn-sm btn-primary font-weight-ligth text-white">
                            ${result[index].nama_kategori} 
                        </small>
                        <div class="des">
                            <div class="des1 d-flex justify-content-between mt-1 mb-1">
                                <small><i class="fa-solid fa-location-dot"></i> ${result[index].kota}</small>
                                <small>
                                Sisa kamar: ${sisaKamar}
                                </small>
                            </div>
                            
                            <div class="nama-kamar">
                                <h6 class="font-weight-bold">${result[index].nama}</h6>
                            </div>
                            <small>
                            ${fasilitas}
                            </small>
                            <div class="harga">
                                <small>${result[index].diskon} % <del> ${hargaRp}</small>
                                <h6 class="font-weight-bold mt-1">${hargaDiskonRp}</h6>
                            </div>
                            <div class="star">
                                <small>${bintang} (${result[index].testicount} total reviews) </smal>
                            </div>
                        </div>
                </div>`;
                $('.pro-container').append(content);
            }
        }
    })

    function detail(data) {
        var uid_kamar = $(data).attr('kost-id');
        $.ajax({
            'url': '<?= base_url('kost/getKamar/') ?>',
            'type': 'POST',
            'dataType': 'JSON',
            'data': {
                uid_kamar: uid_kamar
            },
            'success': function(data) {
                window.location = "<?= base_url('kost/kamar/') ?>" + data.kamar['url_title'];
            }
        })
    }
    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR"
        }).format(number);
    }

    class PriceRange extends HTMLElement {
        constructor() {
            super();
        }

        connectedCallback() {
            // Elements
            this.elements = {
                container: this.querySelector('div'),
                track: this.querySelector('div > div'),
                from: this.querySelector('input:first-of-type'),
                to: this.querySelector('input:last-of-type'),
                output: this.querySelector('output')
            }

            // Event listeners
            this.elements.from.addEventListener('input', this.handleInput.bind(this));
            this.elements.to.addEventListener('input', this.handleInput.bind(this));

            // Properties
            this.currency = (this.hasAttribute('currency') &&
                this.getAttribute('currency') !== undefined &&
                this.getAttribute('currency') !== '') ? this.getAttribute('currency') : '£';

            // Update the DOM
            this.updateDom();
        }

        disconnectedCallback() {
            delete this.elements;
            delete this.currency;
        }

        get from() {
            return parseInt(this.elements.from.value);
        }
        get to() {
            return parseInt(this.elements.to.value);
        }

        handleInput(event) {
            if (parseInt(this.elements.to.value) - parseInt(this.elements.from.value) <= 1) {
                if (event.target === this.elements.from) {
                    this.elements.from.value = (parseInt(this.elements.to.value) - 1);
                } else if (event.target === this.elements.to) {
                    this.elements.to.value = (parseInt(this.elements.from.value) + 1);
                }
            }

            // Update the DOM
            this.updateDom();
        }

        updateDom() {
            this.drawFill();
            this.drawOutput();
        }

        drawFill() {
            const percent1 = (this.elements.from.value / this.elements.from.max) * 100,
                percent2 = (this.elements.to.value / this.elements.to.max) * 100;

            this.elements.track.style.background = `linear-gradient(to right, var(--track-color) ${percent1}%, var(--track-highlight-color) ${percent1}%, var(--track-highlight-color) ${percent2}%, var(--track-color) ${percent2}%)`;
        }

        drawOutput() {
            this.elements.output.textContent = rupiah(this.elements.from.value) +
                ` - ` + rupiah(this.elements.to.value);
        }
    }

    customElements.define('price-range', PriceRange);
</script>