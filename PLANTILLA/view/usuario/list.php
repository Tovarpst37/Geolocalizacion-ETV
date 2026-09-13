<div class="mt-5">
    <h1 class="display-4">
        Usuarios
    </h1>
</div>
<div class="mt-5">
    <table calss = "table table-striped table-hover">
    <thead>
        <th>
            Id
        </th>
        <th>
            Primer Nombre
        </th>
        <th>
            Segundo Nombre
        </th>
        <th>
            Primer Apellio
        </th>
        <th>
            Segundo Apellido
        </th>
        <th>
            Tipo Documento
        </th>
        <th>
            Documento
        </th>
    </thead>
    <tbody>
        <?php 
            foreach($usu=pg_fetch_assoc($usuarios)){
               echo "<tr>"; 
                echo "<td>$sus['id_usuario']</td>";
                echo "<td>$sus['primer_nombre']</td>";
                echo "<td>$usu['segundo_nombre']</td>";
                echo "<td>$sus['primer_apellido']</td>";
                echo "<td>$usu['segundo_apellido']</td>";
                echo "<td>$sus['tipo_documento']</td>";
                echo "<td>$usu['documento']</td>";
                echo "<td>$sus['fecha_nacimiento']</td>";
                echo "<td>$usu['correo']</td>";
                echo "<td>$usu['password']</td>";
                echo "<td>$usu['genero']</td>";
                echo "<td>$usu['rol']</td>";
                echo "<td>$usu['rh']</td>";
                echo "<td>$usu['id_estado']</td>";
               echo "</tr>";
            }
        ?>
    </tbody>
    </table>
</div>