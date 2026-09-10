<div class="container-fluid text-center px-2">

  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">

    <?php



    $bj = [];


    foreach ($resul as $j) {
      $sitios = new SitiosController();
      $sitios->setId((int)($j['id_sitio']));
      $sitios->setNombre_sitio($j['nombre_sitio']);
      $sitios->setDireccion($j['direccion']);
      $sitios->setBarrio($j['barrio']);
      $sitios->setEstado($j['estado']);




      $bj[] = $sitios;
    }


    foreach ($bj as $i) {
      echo $i->getCreate();
    }

    ?>
  </div>
</div>