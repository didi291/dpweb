async function view_product() {
    try {
        let respuesta = await fetch(base_url + 'control/ProductoController.php?tipo=ver_productos', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache'
        });
        json = await respuesta.json();
        contenidot = document.getElementById('content_product');
        if (json.status) {
            let cont = 1;
            json.data.forEach(producto => {
                let nueva_fila = document.createElement("tr");
                nueva_fila.id = "fila" + producto.id;
                nueva_fila.className = "filas_tabla";
                nueva_fila.innerHTML = `
                            <td>${cont}</td>
                            <td>${producto.codigo}</td>
                            <td>${producto.nombre}</td>
                            <td>${producto.precio}</td>
                            <td>${producto.stock}</td>
                            <td>${producto.categoria}</td>
                            <td>${producto.fecha_vencimiento}</td>
                            <td>
                                <a href="`+ base_url + `edit-products/` + producto.id + `">Editar</a>
                                <button class="btn btn-danger" onclick="fn_eliminar(` + producto.id + `);">Eliminar</button>
                            </td>
                `;
                cont++;
                contenidot.appendChild(nueva_fila);
            });
        }
    } catch (e) {
        console.log('error al mostrar producto ' + e);
    }
}
if (document.getElementById('content_product')) {
    view_product();
}

function validar_form(tipo) {
    let codigo = document.getElementById("codigo").value;
    let nombre = document.getElementById("nombre").value;
    let detalle = document.getElementById("detalle").value;
    let precio = document.getElementById("precio").value;
    let stock = document.getElementById("stock").value;
    let id_categoria = document.getElementById("id_categoria").value;
    let fecha_vencimiento = document.getElementById("fecha_vencimiento").value;
    let imagen = document.getElementById("imagen").value;
    if (codigo == "" || nombre == "" || detalle == "" || precio == "" || stock == "" || id_categoria == "" || fecha_vencimiento == "" || imagen == "") {
        Swal.fire({
            title: "Error campos vacios!",
            icon: "Error",
            draggable: true
        });
        return;
    }
    if (tipo == "nuevo") {
        registrarProducto();
    }
    if (tipo == "actualizar") {
        actualizarProducto();
    }

}

if (document.querySelector('#frm_product')) {
    // evita que se envie el formulario
    let frm_product = document.querySelector('#frm_product');
    frm_product.onsubmit = function (e) {
        e.preventDefault();
        validar_form("nuevo");
    }
}

async function registrarProducto() {
    try {
        //capturar campos de formulario (HTML)
        const datos = new FormData(frm_product);
        //enviar datos a controlador
        let respuesta = await fetch(base_url + 'control/ProductoController.php?tipo=registrar', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        let json = await respuesta.json();
        // validamos que json.status sea = True
        if (json.status) { //true
            alert(json.msg);
            document.getElementById('frm_product').reset();
        } else {
            alert(json.msg);
        }
    } catch (e) {
        console.log("Error al registrar Producto:" + e);
    }
}

async function cargar_categoria() {
    let respuesta = await fetch(base_url + 'control/CategoriaController.php?tipo=ver_categoria', {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
    });
    let json = await respuesta.json();
    let contenido = '<option>Seleccione Categoria</option>';
    json.data.forEach(categoria => {  
        contenido += '<option value="'+categoria.id+'">'+categoria.nombre+'</option>';
    });
    //console.log(contenido);
    document.getElementById("id_categoria").innerHTML = contenido;
}

/*async function cargar_proveedores() {
    let respuesta = await fetch(base_url + 'control/UsuarioController.php?tipo=ver_proveedores', {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
    });
    let json = await respuesta.json();
    let contenido = '<option>Seleccione Proveedor</option>';
    json.data.forEach(proveedor => {
        contenido += '<option value="'+proveedor.id+'">'+proveedor.razon_social+'</option>';
    });
    //console.log(contenido);
    document.getElementById("id_proveedor").innerHTML = contenido;
}*/

async function cargarProveedores() {
  let respuesta = await fetch(base_url + 'control/UsuarioController.php?tipo=ver_proveedores');
  let json = await respuesta.json();
  let h = '<option value="">Seleccione Proveedor</option>';
  json.data.forEach(proveedor => h += `<option value="${proveedor.id}">${proveedor.razon_social}</option>`);
  document.getElementById("id_persona").innerHTML = h;
}        
