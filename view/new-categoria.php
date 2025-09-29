<!--INICIO DE PAGINA-->
<div class="container-fluid">
    <div class="card">
        <h5 class="card-header">Registrar Categoria
        </h5>
        <form id="frm_categorie" action="" method="">
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
                <button type="submit" class="btn btn-success">Registrar</button>
                <button type="reset" class="btn btn-info" reset>Limpiar</button>
                <button type="button" class="btn btn-danger">Cancelar</button>
                <button type="submit" class="btn btn-success">Lista de Categorias</button>
            </div>
        </form>
    </div>
</div>
<!--FIN DE PAGINA-->
<script src="<?php echo BASE_URL; ?>view/function/categoria.js"></script>