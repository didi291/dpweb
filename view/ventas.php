<div class="container-fluid mt-4 row">
    <div class="col-9">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Busqueda de Productos</h5>
                <div class="col-12 mb-3">
                    <input type="text" id="busqueda_venta" onkeyup="listar_productos();" class="form-control" placeholder="Buscar Producto por codigo o nombre">
                    <input type="hidden" id="id_producto_venta">
                    <input type="hidden" id="producto_precio_venta">
                    <input type="hidden" id="producto_cantidad_venta" value="1">
                </div>
                <div class="row container-fluid" id="productos_venta">

                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Lista de Compra</h5>
                <div class="row" style="min-height: 500px;">
                    <div class="col-12 table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="lista_compra">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-end">
                        <h4>Subtotal : <label id="subtotal_general"></label></h4>
                        <h4>Igv : <label id="igv_general"></label></h4>
                        <h4>Total : <label id="total"></label></h4>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Realizar Venta</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registro de Venta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_venta">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="cliente_dni" class="form-label">DNI del Cliente</label>
                            <input type="text" class="form-control" id="cliente_dni" name="cliente_dni" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="11">
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary mt-4" onclick="buscar_cliente_venta();">Buscar Cliente</button>
                        </div>
                        <div class="col-md-12">
                            <label for="cliente_nombre" class="form-label">Nombre del Cliente</label>
                            <input type="text" class="form-control" id="cliente_nombre" name="cliente_nombre" readonly>
                            <input type="hidden" class="form-control" id="id_cliente_venta" name="id_cliente_venta">
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_venta" class="form-label">Fecha de Venta</label>
                            <input type="datetime-local" class="form-control" id="fecha_venta" name="fecha_venta" value="<?= date('Y-m-d H:i') ?>"> 
                        </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="registrarVenta();">Registrar Venta</button>
            </div>
        </div>
    </div>
</div>
<script src="<?= BASE_URL ?>view/function/product.js"></script>
<script src="<?= BASE_URL ?>view/function/venta.js"></script>
<script>
    let input = document.getElementById("busqueda_venta");
    input.addEventListener('keydown', (event) => {
        if (event.key == 'Enter') {
            agregar_producto_temporal();
        }
    })
    listar_temporales();
    act_subt_general();
</script>