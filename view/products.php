<div class="container">
    <h4 class="mt-3 mb-3">Lista de Productos</h4>
    <a href="<?php echo BASE_URL; ?>new-product" class="btn btn-success">Nuevo Producto</a>
    <br><br>
    <table class="table table-bordered table-striped border-dark">
        <thead>
            <tr>
                <th>Nro</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Detalle</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Categoría</th>
                <th>Proveedor</th>
                <th>Fecha Vencimiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="content_products">
        </tbody>
    </table>     
</div>
<script src="<?= BASE_URL ?>view/function/product.js"></script>