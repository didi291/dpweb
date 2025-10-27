<!--INICIO DE PAGINA-->
<div class="container-fluid">
    <div class="card">
        <h5 class="card-header">Editar Productos</h5>
        <?php
        if (isset($_GET["views"])) {
            $ruta = explode("/", $_GET["views"]);
            //echo $ruta[1];
        }
        ?>
        <!-- Cambios: method="post" y enctype para enviar archivos -->
        <form id="frm_edit_product" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" id="id_producto" name="id_producto" value="<?= isset($ruta[1]) ? htmlspecialchars($ruta[1], ENT_QUOTES) : ''; ?>">
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
                    <label for="id_categoria" class="col-sm-4 col-form-label">Categoria :</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="id_categoria" id="id_categoria" required>
                            <option value="">Seleccione Categoria</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="fecha_vencimiento" class="col-sm-4 col-form-label">Fecha de Vencimiento :</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="id_proveedor" class="col-sm-4 col-form-label">Proveedor :</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="id_proveedor" id="id_proveedor" required>
                            <option value="">Seleccione Proveedor</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="imagen" class="col-sm-4 col-form-label">Imagen :</label>
                    <div class="col-sm-8">
                        <input type="file" class="form-control" id="imagen" name="imagen" accept=".jpg, .jpeg, .png">
                        <!-- <div class="mt-2">
                            <img id="img_preview" src="" alt="Imagen actual" style="max-width:150px; max-height:150px; display:none;">
                        </div> -->
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="<?= BASE_URL ?>products" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<!--FIN DE PAGINA-->
<script src="<?php echo BASE_URL; ?>view/function/product.js"></script>
<script>
    cargar_categorias();
    cargar_proveedores();
</script>

<script>
    // Rellena campos desde el servidor; edit_product() en product.js se encarga de poblarlos
    edit_product();

    // Mostrar preview al seleccionar nuevo archivo y liberar URL previa
    (function () {
        const input = document.getElementById('imagen');
        const preview = document.getElementById('img_preview');
        let currentObjectUrl = null;
        if (!input) return;
        input.addEventListener('change', function (e) {
            if (currentObjectUrl) {
                URL.revokeObjectURL(currentObjectUrl);
                currentObjectUrl = null;
            }
            if (!this.files || !this.files[0]) return;
            currentObjectUrl = URL.createObjectURL(this.files[0]);
            preview.src = currentObjectUrl;
            preview.style.display = 'block';
        });

        // Si edit_product() carga la imagen desde el servidor, mostrarla
        // product.js -> edit_product() debe asignar base_url + ruta a img_preview.src
    })();
</script>