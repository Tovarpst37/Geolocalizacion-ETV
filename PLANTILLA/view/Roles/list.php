<div class="page-header">
    <div class="mb-3 contenedortext rounded-4">
        <br>
        <div>
            <h1 class="fw-bold text-center ">Roles</h1>
        </div>
        <br>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Id Rol</td>
                            <th>Nombre Rol</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($roles as $rol){
                                echo "<tr>";
                                    echo "<td>".$rol['id_rol']."</td>";
                                    echo "<td>".$rol['nombre_rol']."</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</div>