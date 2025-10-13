<div class="container">
    <h4 class="mt-3 mb-3">Lista de Proveedores</h4>
    <a href="<?php echo BASE_URL; ?>new-provider" class="btn btn-success">Nuevo Proveedor</a>
    <br><br>  
    <table class="table table-bordered table-striped border-dark">
        <thead>
            <tr>
                <th>Nro</th>
                <th>DNI</th>
                <th>Nombres y Apellidos</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="content_provider">
        </tbody>
    </table>
</div>
<script src="<?= BASE_URL ?>view/function/provider.js"></script>
