<!--INICIO DE PAGINA-->
<div class="container-fluid">
    <div class="card">
        <h5 class="card-header">Editar Datos de Producto</h5>
        <?php
        if (isset($_GET["views"])) {
            $ruta = explode("/", $_GET["views"]);
            //echo $ruta[1];
        }
        ?>
        <form id="frm_edit_products" action="" method="">
            <input type="hidden" id="id" name="id" value="<?= $ruta[1]; ?>">
            <div class="card-body">
                <div class="mb-3 row">
                    <label for="codigo" class="col-sm-4 col-form-label">Código :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="codigo" name="codigo" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="nombre" class="col-sm-4 col-form-label">Nombre :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="detalle" class="col-sm-4 col-form-label">Detalle :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="detalle" name="detalle" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="precio" class="col-sm-4 col-form-label">Precio :</label>
                    <div class="col-sm-8">
                        <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="stock" class="col-sm-4 col-form-label">Stock :</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="stock" name="stock" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="id_categoria" class="col-sm-4 col-form-label">ID Categoría :</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="id_categoria" name="id_categoria" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="fecha_vencimiento" class="col-sm-4 col-form-label">Fecha de Vencimiento :</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="id_proveedor" class="col-sm-4 col-form-label">ID Proveedor :</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="id_proveedor" name="id_proveedor" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="<?= BASE_URL ?>productos" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<!--FIN DE PAGINA-->
<script src="<?php echo BASE_URL; ?>view/function/product.js"></script>
<script>
    edit_product();
</script>