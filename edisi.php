<?php
$pageTitle = "VAMOUS";
require 'navbar-user.php';
?>

<style>
    .background {
      background-color: black;
      padding: 70px;
    }
    .svg {
      margin-top: -10px;
    }
    .input-group {
      padding: 0px 30px;
      z-index: 2;
      margin-top: -200px;
    }
    input {
      border-color: white !important;
      border-radius: 50px 0px 0px 50px !important;
      background-color: white !important;
      font-size: 12px;
    }
    input::after {
      outline: none;
      box-shadow: none;
    }
    .btn {
      background-color: white;
      border-radius: 0px 50px 50px 0px;
      border-color: white;
      color: black;
    }
    .btn:hover {
      background-color: white;
      color: gray;
    }
    .carousel-inner {
      aspect-ratio: 1 / 1; /* Menjadikan rasio gambar 1:1 */
      overflow: hidden;
    }
    .carousel-inner img {
      object-fit: cover; /* Gambar memenuhi kotak tanpa distorsi */
      height: 100%;
      width: 100%;
    }
    .content {
      padding: 0px 30px;
      margin-top: 70px;
    }
    .card {
      border-radius: 0px;
    }
    .card-title {
      font-weight: 700;
    }
</style>

<body>
    <div class="background"></div>
    
    <div class="svg">
        <svg id="wave" style="transform:rotate(180deg); transition: 0.3s" viewBox="0 0 1440 490" version="1.1" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0"><stop stop-color="rgba(0, 0, 0, 1)" offset="0%"></stop><stop stop-color="rgba(52.686, 52.686, 52.686, 1)" offset="100%"></stop></linearGradient></defs><path style="transform:translate(0, 0px); opacity:1" fill="url(#sw-gradient-0)" d="M0,98L17.1,98C34.3,98,69,98,103,114.3C137.1,131,171,163,206,155.2C240,147,274,98,309,106.2C342.9,114,377,180,411,220.5C445.7,261,480,278,514,277.7C548.6,278,583,261,617,269.5C651.4,278,686,310,720,343C754.3,376,789,408,823,383.8C857.1,359,891,278,926,236.8C960,196,994,196,1029,204.2C1062.9,212,1097,229,1131,212.3C1165.7,196,1200,147,1234,122.5C1268.6,98,1303,98,1337,89.8C1371.4,82,1406,65,1440,98C1474.3,131,1509,212,1543,220.5C1577.1,229,1611,163,1646,179.7C1680,196,1714,294,1749,285.8C1782.9,278,1817,163,1851,147C1885.7,131,1920,212,1954,277.7C1988.6,343,2023,392,2057,343C2091.4,294,2126,147,2160,130.7C2194.3,114,2229,229,2263,269.5C2297.1,310,2331,278,2366,261.3C2400,245,2434,245,2451,245L2468.6,245L2468.6,490L2451.4,490C2434.3,490,2400,490,2366,490C2331.4,490,2297,490,2263,490C2228.6,490,2194,490,2160,490C2125.7,490,2091,490,2057,490C2022.9,490,1989,490,1954,490C1920,490,1886,490,1851,490C1817.1,490,1783,490,1749,490C1714.3,490,1680,490,1646,490C1611.4,490,1577,490,1543,490C1508.6,490,1474,490,1440,490C1405.7,490,1371,490,1337,490C1302.9,490,1269,490,1234,490C1200,490,1166,490,1131,490C1097.1,490,1063,490,1029,490C994.3,490,960,490,926,490C891.4,490,857,490,823,490C788.6,490,754,490,720,490C685.7,490,651,490,617,490C582.9,490,549,490,514,490C480,490,446,490,411,490C377.1,490,343,490,309,490C274.3,490,240,490,206,490C171.4,490,137,490,103,490C68.6,490,34,490,17,490L0,490Z"></path></svg>
    </div>

    <div class="container">
        <div class="input-group">
            <input type="text" class="form-control border-end-0" placeholder="Cari..." aria-label="Cari" aria-describedby="button-addon" style="font-size: 10px; color: black;">
            <button class="btn border-start-0" type="button" id="button-addon">
                <i class="bi bi-search-heart-fill"></i>
            </button>
        </div>

        <div class="content">
          <div class="card mb-3" style="max-width: 540px;">
            <div class="row g-0">
              <div class="col-md-4">
                <!-- Carousel -->
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                  <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                  </div>
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <img src="img/a.jpg" class="d-block w-100" alt="Slide 1" width="150" height="auto">
                    </div>
                    <div class="carousel-item">
                      <img src="img/a.jpg" class="d-block w-100" alt="Slide 2" width="150" height="auto">
                    </div>
                  </div>
                  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
                </div>
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">VAMOUS - "REVERS!" Statement T-Shirt (WHITE)</h5>
                  <p class="card-text">Produk ini keluar pada bulan <strong>Desember</strong></p>
                  <p class="card-text"><small class="text-body-secondary">IDR <strong>Rp 300.000,00</strong></small></p>
                </div>
              </div>
            </div>
          </div>
      </div>

    </div>
</body>