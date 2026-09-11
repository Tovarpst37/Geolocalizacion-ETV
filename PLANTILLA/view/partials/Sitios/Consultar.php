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