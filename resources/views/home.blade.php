@extends('depan.layout')

@section('content')
    <!-- About Section -->
    <section id="about" class="about section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row align-items-xl-center gy-5">

                <div class="col-xl-5 content">
                    <h3>Tracking</h3>
                    <h2>Silahkan Memilih layanan tracking</h2>
                    <!-- <p>Ipsa sint sit. Quis ducimus tempore dolores impedit et dolor cumque alias maxime. Enim reiciendis minus et rerum hic non. Dicta quas cum quia maiores iure. Quidem nulla qui assumenda incidunt voluptatem tempora deleniti soluta.</p> -->
                    <a href="#about" class="read-more"><span></span><i class="bi bi-arrow-right"></i></a>
                </div>

                <div class="col-xl-7">
                    <div class="row gy-4 icon-boxes">

                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon-box">
                                <i class="bi bi-credit-card"></i>
                                <a href="{{ route('track') }}">
                                    <h3>Tracking By NIP/NIK-</h3>
                                </a>
                                <p>tracking layanan berdasarkan usulan NIP/NIK</p>
                                <!-- <a href="#about" class="btn-get-started"><h4>pilih</h4></a> -->
                            </div>
                        </div>

                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                            <div class="icon-box">
                                <i class="bi bi-postcard"></i>
                                <a href="{{ route('track-surat') }}">
                                    <h3>Tracking By No. Surat</h3>
                                </a>
                                <p>tracking layanan berdasarkan usulan No. Surat</p>
                                <!-- <a href="#about" class="btn-get-started">pilih</a> -->
                            </div>
                        </div>

                        <!-- <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                                <div class="icon-box">
                                  <i class="bi bi-command"></i>
                                  <h3>Veniam omnis</h3>
                                  <p>Omnis perferendis molestias culpa sed. Recusandae quas possimus. Quod consequatur corrupti</p>
                                </div>
                              </div>

                              <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
                                <div class="icon-box">
                                  <i class="bi bi-graph-up-arrow"></i>
                                  <h3>Delares sapiente</h3>
                                  <p>Sint et dolor voluptas minus possimus nostrum. Reiciendis commodi eligendi omnis quideme lorenda</p>
                                </div>
                              </div> -->

                    </div>
                </div>

            </div>
        </div>

    </section><!-- /About Section -->
    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Contact</h2>
            <div><span>Check Our</span> <span class="description-title">Contact</span></div>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade" data-aos-delay="100">

            <div class="row gy-4">

                <div class="col-lg-4">
                    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                        <i class="bi bi-geo-alt flex-shrink-0"></i>
                        <div>
                            <h3>Address</h3>
                            <p>Jl. Jaksa Agung Suprapto No.2, Mojoroto</p>
                            <p>Kec. Mojoroto, Kabupaten Kediri, Jawa Timur 64112</p>
                        </div>
                    </div><!-- End Info Item -->

                    <!-- End Info Item -->

                    <!-- End Info Item -->

                </div>



            </div>

        </div>

    </section><!-- /Contact Section -->
@endsection
