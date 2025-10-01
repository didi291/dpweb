function validar_form() {
    let nombre = document.getElementById("nombre").value;
    let detalle = document.getElementById("detalle").value;

    if (nombre == "" || detalle == "") {

        Swal.fire({
            icon: 'warning',
            title: 'Campos vacíos',
            text: 'Por favor, complete todos los campos requeridos',
            confirmButtonText: 'Entendido'


        });
        if (tipo == "nuevo") {
            registrarUsuario();
        }
        if (tipo == "actualizar") {
            actualizarUsuario();
        }
        return;
    }
    registrarCategoria();
}
if (document.querySelector('#frm_categorie')) {
    let frm_categorie = document.querySelector('#frm_categorie');
    frm_categorie.onsubmit = function (e) {
        e.preventDefault();
        validar_form();
    }
}
async function registrarCategoria() {
    try {
        const datos = new FormData(frm_categorie);
        let respuesta = await fetch(base_url + 'control/categoriaController.php?tipo=registrar', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        let json = await respuesta.json();
        if (json.status) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: json.msg,
                confirmButtonText: 'OK'
            });
            document.getElementById('frm_categorie').reset();
            ver_categorias(); // Recarga la lista después de registrar
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: json.msg,
                confirmButtonText: 'OK'
            });
        }
    } catch (error) {
        console.log("error al registrar categoría: " + error);
    }
}

async function ver_categoria() {
    try {
        let respuesta = await fetch(base_url + 'control/CategoriaController.php?tipo=ver_categoria', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache'
        });
        json = await respuesta.json();
        contenidot = document.getElementById('content_category');
        if (json.status) {
            let cont = 1;
            json.data.forEach(categoria => {
                
                let nueva_fila = document.createElement("tr");
                nueva_fila.id = "fila" + categoria.id;
                nueva_fila.className = "filas_tabla";
                nueva_fila.innerHTML = `
                            <td>${cont}</td>
                            <td>${categoria.nombre}</td>
                            <td>${categoria.detalle}</td>
                            <td>
                                <a href="`+ base_url + `edit-category/` + categoria.id + `">Editar</a>
                                <button class="btn btn-danger" onclick="fn_eliminar(` + categoria.id + `);">Eliminar</button>
                            </td>
                `;
                cont++;
                contenidot.appendChild(nueva_fila);
            });
        }
    } catch (error) {
        console.log('error en mostrar categoria ' + error);
    }
}
if (document.getElementById('content_category')) {
    ver_categoria();
}


// Llamar a la función al cargar la página
document.addEventListener('DOMContentLoaded', function () {
    ver_categorias();
});
async function edit_categoria() {
    try {
        let id_categoria = document.getElementById('id_categoria').value;
        const datos = new FormData();
        datos.append('id_categoria', id_categoria);

        let respuesta = await fetch(base_url + 'control/CategoriaController.php?tipo=ver', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if (!json.status) {
            alert(json.msg);
            return;
        }
        document.getElementById('nombre').value = json.data.nombre;
        document.getElementById('detalle').value = json.data.detalle;
    } catch (error) {
        console.log('oops, ocurrió un error ' + error);
    }
}
if (document.querySelector('#frm_edit_category')) {
    edit_categoria();
    // evita que se envie el formulario
    let frm_user = document.querySelector('#frm_edit_category');
    frm_user.onsubmit = function (e) {
        e.preventDefault();
        validar_form("actualizar");
    }
}

async function actualizarCategoria() {
    const datos = new FormData(frm_edit_category);
    let respuesta = await fetch(base_url + 'control/CategoriaController.php?tipo=actualizar', {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        body: datos
    });
    json = await respuesta.json();
    if (!json.status) {
        alert("Oooooops, ocurrio un error al actualizar, intentelo nuevamente");
        console.log(json.msg);
        return;
    }else{
        alert(json.msg);
    }
}

// Actualiza la función validar_form para incluir la actualización
function validar_form(tipo = "nuevo") {
    let nombre = document.getElementById("nombre").value;
    let detalle = document.getElementById("detalle").value;

    if (nombre == "" || detalle == "") {
        Swal.fire({
            icon: 'warning',
            title: 'Campos vacíos',
            text: 'Por favor, complete todos los campos requeridos',
            confirmButtonText: 'Entendido'
        });
        return;
    }
    if (tipo == "actualizar") {
        actualizarCategoria();
    } else {
        registrarCategoria(); // Para el caso de nuevo registro, si aplica
    }
}
async function fn_eliminar(id) {
    if (window.confirm("Confirmar eliminar?")) {
        eliminar(id);
    }
}
async function eliminarCategoria(id) {
    let datos = new FormData();
    datos.append('id_categoria', id);
    let respuesta = await fetch(base_url + 'control/CategoriaController.php?tipo=eliminar', {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        body: datos
    });
    json = await respuesta.json();
    if (!json.status) {
        alert("Oooooops, ocurrio un error al eliminar categhoria, intentelo mas tarde");
        console.log(json.msg);
        return;
    }else{
        alert(json.msg);
        location.replace(base_url + 'category');
    }
}


