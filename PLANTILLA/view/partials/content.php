<style>
.dash-home .contenedortext {
    overflow: hidden;
    position: relative;
}

.dash-home .contenedortext .fa-map-marked-alt {
    filter: drop-shadow(0 4px 8px rgba(0,0,0,.15));
}

.dash-home .card-stats {
    border: 0;
    box-shadow: 0 4px 16px rgba(0,0,0,.07);
    transition: transform .15s ease, box-shadow .15s ease;
    overflow: hidden;
}

.dash-home .card-stats:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 22px rgba(0,0,0,.10);
}

.dash-home .card-stats .card-body {
    padding: 1.25rem;
}

.dash-home .card-stats .row {
    flex-wrap: nowrap;
}

.dash-home .col-icon {
    flex: 0 0 auto;
}

.dash-home .icon-big {
    width: clamp(42px, 8vw, 56px);
    height: clamp(42px, 8vw, 56px);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    flex-shrink: 0;
}

.dash-home .icon-big i {
    font-size: clamp(1.1rem, 3vw, 1.5rem);
}

.dash-home .col-stats {
    min-width: 0;
    flex: 1 1 auto;
}

.dash-home .card-category {
    font-size: .78rem;
    text-transform: uppercase;
    letter-spacing: .03em;
    color: #6c757d;
    margin-bottom: .15rem;
    white-space: normal;
    line-height: 1.25;
}

.dash-home .card-title {
    font-size: clamp(1.15rem, 2.5vw, 1.5rem);
    font-weight: 700;
    margin-bottom: 0;
    white-space: nowrap;
}
</style>

<div class="dash-home">

<h1 class="mb-3">
  <?php
  echo "!Bienvenido {$_SESSION['primer_nombre']}!";
  ?>
</h1>
<div class="contenedortext p-4 p-md-5 mb-4 rounded-5">
  <div class="row align-items-center">
    <div class="col-lg-8">
      <h6 class="txt text-uppercase fw-bold mb-2" style="letter-spacing: 1px; opacity: 0.85;">
        Secretaría de Salud de Cali
      </h6>
      <h2 class="txt fw-bold mb-3">
        Sistema de Geolocalización ETV
      </h2>
      <p class="txt mb-0" style="max-width: 620px; opacity: 0.9;">
        Bienvenido al sistema de control y seguimiento del programa de
        prevención del dengue mediante la distribución de peces guppy
        (<em>Poecilia reticulata</em>) en tanques de agua domiciliarios,
        como método de control biológico del mosquito
        <em>Aedes aegypti</em> en la ciudad de Cali.
      </p>
    </div>
    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
      <i class="fas fa-map-marked-alt" style="font-size: 5rem; color: #fff; opacity: 0.7;"></i>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-sm-6 col-md-3 d-flex">
    <div class="card card-stats card-round h-100 w-100">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-icon">
            <div class="icon-big text-center icon-primary bubble-shadow-small">
              <i class="fas fa-tint"></i>
            </div>
          </div>
          <div class="col col-stats ms-3 ms-sm-0">
            <div class="numbers">
              <p class="card-category">Tanques registrados</p>
              <h4 class="card-title">1,294</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-3 d-flex">
    <div class="card card-stats card-round h-100 w-100">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-icon">
            <div class="icon-big text-center icon-info bubble-shadow-small">
              <i class="fas fa-fish"></i>
            </div>
          </div>
          <div class="col col-stats ms-3 ms-sm-0">
            <div class="numbers">
              <p class="card-category">Peces guppy distribuidos</p>
              <h4 class="card-title">1,303</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-3 d-flex">
    <div class="card card-stats card-round h-100 w-100">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-icon">
            <div class="icon-big text-center icon-success bubble-shadow-small">
              <i class="fas fa-map-marker-alt"></i>
            </div>
          </div>
          <div class="col col-stats ms-3 ms-sm-0">
            <div class="numbers">
              <p class="card-category">Zonas cubiertas</p>
              <h4 class="card-title">576</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-3 d-flex">
    <div class="card card-stats card-round h-100 w-100">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-icon">
            <div class="icon-big text-center icon-secondary bubble-shadow-small">
              <i class="fas fa-shield-alt"></i>
            </div>
          </div>
          <div class="col col-stats ms-3 ms-sm-0">
            <div class="numbers">
              <p class="card-category">Visitas de seguimiento</p>
              <h4 class="card-title">345</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</div>