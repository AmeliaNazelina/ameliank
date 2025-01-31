<?php
$pageTitle = "VAMOUS";
require 'navbar.php';
?>

<style>
    body{
        overflow: scroll;
    }
@media (orientation: landscape) {
}
.btn {
    background-color: white;
    color: black;
    margin-top: -300px;
    border-radius: 0px;
    padding: 15px 50px;
    font-size: 15px;
    z-index: 10;
    margin-bottom: -500px;
    font-weight: 600;
  }
  .content {
    margin-top: -240px;
  }
   .carousel-container {
    width: 100%; /* Menyesuaikan lebar parent */
    max-width: 500px; /* Contoh lebar maksimum */
    margin: auto; /* Tengah secara horizontal */
    aspect-ratio: 1 / 1; /* Rasio 1:1 */
    position: relative; /* Mengatur posisi relatif untuk tombol */
    overflow: hidden;
  }
  #carouselExample {
    width: 100%;
    height: 100%;
  }

  .carousel-inner,
  .carousel-item {
    width: 100%;
    height: 100%;
  }

  .carousel-item img {
    object-fit: cover; /* Foto akan menyesuaikan tanpa merusak rasio */
    width: 100%;
    height: 100%;
  }

  /* Menentukan posisi button navigasi */
  .carousel-control-prev,
  .carousel-control-next {
    position: absolute;
    top: 50%; /* Tombol berada di tengah vertikal */
    transform: translateY(-50%);
  }
</style>

<body>
<div class="carousel-container">
<div id="carouselExample" class="carousel slide" style="margin: auto; max-width: 100%; height: 100%;">
  <div class="carousel-inner" style="width: 100%; height: 100%; overflow: hidden;">
    <div class="carousel-item active">
      <img src="img/1.jpg" class="d-block w-100" alt="Slide 1" style="object-fit: cover; width: 100%; height: 100%;">
    </div>
    <div class="carousel-item">
      <img src="img/2.jpg" class="d-block w-100" alt="Slide 2" style="object-fit: cover; width: 100%; height: 100%;">
    </div>
    <div class="carousel-item">
      <img src="img/3.jpg" class="d-block w-100" alt="Slide 3" style="object-fit: cover; width: 100%; height: 100%;">
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
</div>
</div>

<?php require 'footer.php'; ?>

<div class="content">
<center><a href="login.php" class="btn" style="position: relative;">CHECKOUT</a></center>
</div>
</body>