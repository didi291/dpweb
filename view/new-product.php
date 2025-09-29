<!-- INICIO DE CUERPO DE PÁGINA -->
<div class="container-fluid">
    <div class="card">
        <h5 class="card-header">Registro de Producto</h5>
        <form id="frm_product" action="" method="" enctype="multipart/form-data">
            <div class="card-body">
                <div class="mb-3 row">
                    <label for="codigo" class="col-sm-4 col-form-label">codigo :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="codigo" name="codigo" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="nombre" class="col-sm-4 col-form  -label">nombre :</label>
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
                        <input type="number" class="form-control" id="precio" name="precio" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="stock" class="col-sm-4 col-form-label">Stock :</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="stock" name="stock" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="id_categoria" class="col-sm-4 col-form-label">Categoria :</label>
                    <div class="col-sm-8">
                        <select class="form-select" name="id_categoria" id="id_categoria" required>
                            <option value="" disabled selected>Seleccione</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="id_proveedor" class="col-sm-4 col-form-label">Proveedor :</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="id_proveedor" name="id_proveedor" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="fecha_vencimiento" class="col-sm-4 col-form-label">Fecha de Vencimiento :</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="imagen" class="col-sm-4 col-form-label">Imagen :</label>
                    <div class="col-sm-8">
                        <input type="file" class="form-control" id="imagen" name="imagen" accept=".jpg, .jpeg, .png" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Registrar</button>
                <button type="reset" class="btn btn-info">Limpiar</button>
                <a href="<?= BASE_URL ?>category" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<!-- FIN DE CUERPO DE PÁGINA -->
<script src="<?php echo BASE_URL; ?>view/function/product.js"></script>
<script>
    cargar_categoria();
</script>