let productos_venta = {};
let id = 2;
let id2 = 4;
let producto = {};
producto.nombre = "Producto 1";
producto.precio = 100;
producto.cantidad = 2;

let producto2 = {};
producto2.nombre = "Producto 2";
producto2.precio = 200;
producto2.cantidad = 1;
//productos_venta.push(producto);

productos_venta[id] = producto;
productos_venta[id2] = producto2;
console.log(productos_venta);

async function agregar_producto_temporal() {
    let id = document.getElementById('id_producto_venta').value;
    let precio = document.getElementById('producto_precio_venta').value;
    let cantidad = document.getElementById('producto_cantidad_venta').value;
    const datos = new FormData();
    datos.append('id_producto', id);
    datos.append('precio', precio);
    datos.append('cantidad', cantidad);
    try {
        let respuesta = await fetch(base_url + 'control/VentaController.php?tipo=registrarTemporal', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if (json.status) {
            if (json.msg == 'registrado') {
                alert("el producto se agrego correctamente");
            } else {
                alert("el producto se actualizo correctamente");
            }
        }
    } catch (error) {
        console.log('error en agregar producto temporal' + error);
    }
}
async function listar_temporales() {
    try {
        let respuesta = await fetch(base_url + 'control/VentaController.php?tipo=lista_venta_temporal', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache'
        });
        json = await respuesta.json();
        if (json.status) {
            let listar_temporal = '';
            json.data.forEach(t_venta => {
                listar_temporal += `<tr>
                                    <td>${t_venta.nombre}</td>
                                    <td><input type="number" id="cant_${t_venta.id}" value="${t_venta.cantidad}" style="width: 60px;" onkeyup="actualizar_subtotal(${t_venta.id})" onchange="actualizar_subtotal(${t_venta.id})", ${t_venta.precio}></td>
                                    <td>S/.${t_venta.precio}</td>
                                    <input type="hidden" id="precio_${t_venta.id}" value="${t_venta.precio}">
                                    <td id="subtotal_${t_venta.id}">S/.${t_venta.cantidad * t_venta.precio}</td>
                                    <td><button class="btn btn-danger btn-sm">Eliminar</button></td>
                                </tr>`;
            });
            document.getElementById('lista_compra').innerHTML = listar_temporal;
        }
    } catch (error) {
        console.log('error en cargar productos temporales' + error);
    }
}
async function actualizar_subtotal(id) {
    let cantidad = document.getElementById('cant_' + id).value;
    try {
        const datos = new FormData();
        datos.append('id', id);
        datos.append('cantidad', cantidad);
        let respuesta = await fetch(base_url + 'control/VentaController.php?tipo=actualizar_cantidad', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if (json.status) {
            let precio = document.getElementById('precio_' + id).value;
            subtotal = cantidad * precio;
            document.getElementById('subtotal_' + id).innerHTML = 'S/.' + subtotal;
        }
    } catch (error) {
        console.log('error al actualizar cantidad' + error);
    }
}

async function act_subt_general() {
    try {
        let respuesta = await fetch(base_url + 'control/VentaController.php?tipo=lista_venta_temporal', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache'
        });
        json = await respuesta.json();
        if (json.status) {
            subtotal_general = 0;
            json.data.forEach(t_venta => {
                subtotal_general += (t_venta.cantidad * t_venta.precio);
            });
            document.getElementById('subtotal_general').innerHTML = 'S/.' + subtotal_general;
        }
    } catch (error) {
        console.log('error en cargar productos temporales' + error);
    }
}