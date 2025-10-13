<!--INICIO DE PAGINA-->
<div class="container-fluid">
    <div class="card">
        <h5 class="card-header">Editar Categoria</h5>
        <?php
        if (isset($_GET["views"])) {
            $ruta = explode("/", $_GET["views"]);
            //echo $ruta[1];
        }
        ?>
        <form id="frm_edit_category" action="" method="">
            <input type="hidden" id="id_categoria" name="id_categoria" value="<?= $ruta[1]; ?>">
            <div class="card-body">
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
                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="<?= BASE_URL ?>category" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<!--FIN DE PAGINA-->
<script src="<?php echo BASE_URL; ?>view/function/category.js"></script>
<script>
    edit_category();
</script>