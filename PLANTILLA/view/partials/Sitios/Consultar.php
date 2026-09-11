<?php if (!empty($_SESSION['mensaje_exito'])): ?>
  <div id="alertaExito" class="alert d-flex align-items-center border-0 shadow-sm" role="alert" style="border-left: 5px solid #198754 !important; background-color: #fff;">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" style="color:#198754;" role="img" aria-label="Success:">
      <use xlink:href="#check-circle-fill" />
    </svg>
    <div>
      <?php echo $_SESSION['mensaje_exito']; ?>
    </div>
  </div>
  <?php unset($_SESSION['mensaje_exito']); ?>

  <script>
    setTimeout(function() {
      var alerta = document.getElementById('alertaExito');
      if (alerta) {
        alerta.style.transition = "opacity 0.5s ease";
        alerta.style.opacity = "0";
        setTimeout(function() {
          alerta.remove();
        }, 500); // espera a que termine el fade antes de quitarlo del DOM
      }
    }, 5000); // 5 segundos visible
  </script>
<?php endif; ?>

<div class="container-fluid text-center px-2">

  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">

    <?php
    include_once '../controller/Sitios/SitiosController.php';
    include_once '../model/Sitios/Sitios.php';


    $bj = [];
    $ob2 =  new SitiosController();
    $resul = $ob2->data();


    foreach ($resul as $j) {
      $sitios = new Sitios($j['id_sitio'], $j['nombre_sitio'], $j['direccion'], $j['barrio'], $j['estado']);
      $bj[] = $sitios;
    }


    foreach ($bj as $i) {
      echo $i->getCreate();
    }

    ?>
  </div>
</div>