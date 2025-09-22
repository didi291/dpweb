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
async function ver_categorias() {
    try {
        let respuesta = await fetch(base_url + 'control/categoriaController.php?tipo=ver_categoria', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache'
        });
        let json = await respuesta.json();
        let content_categories = document.getElementById('content_categories');
        content_categories.innerHTML = '';
        json.forEach((categoria, index) => {
            let fila = document.createElement('tr');
            fila.innerHTML = `
                <td>${index + 1}</td>
                <td>${categoria.nombre}</td>
                <td>${categoria.detalle}</td>
                <td>
                    <a href="${base_url}edit-category/${categoria.id_categoria}">Editar</a>
                    <button type="button" class="btn btn-danger" onclick="eliminarCategoria(${categoria.id_categoria})">Eliminar</button>
                </td>`;
            content_categories.appendChild(fila);
        });
    } catch (error) {
        console.log(error);
    }
}

// Llamar a la función al cargar la página
document.addEventListener('DOMContentLoaded', function () {
    ver_categorias();
});

async function edit_category() {
    try {
        let id_categoria = document.getElementById('id_categoria').value;
        if (!id_categoria) {
            console.log('ID de categoría no encontrado');
            return;
        }
        const datos = new FormData();
        datos.append('id_categoria', id_categoria);

        let respuesta = await fetch(base_url + 'control/CategoriaController.php?tipo=ver', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        let json = await respuesta.json(); // Asignar el resultado a una variable local
        if (!json.status) {
            alert(json.msg);
            return;
        }
        document.getElementById('id_categoria').value = json.data.id_categoria;
        document.getElementById('nombre').value = json.data.nombre;
        document.getElementById('detalle').value = json.data.detalle;
    } catch (error) {
        console.log('Error al cargar la categoría: ' + error);
    }
}

// Llamar a edit_category() cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('frm_edit_category')) {
        edit_category();
    }
});

async function actualizarCategoria() {
    try {
        const datos = new FormData(document.getElementById('frm_edit_category'));
        let respuesta = await fetch(base_url + 'control/categoriaController.php?tipo=actualizar', {
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
            window.location.href = base_url + 'categories'; // Redirigir a la lista
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: json.msg,
                confirmButtonText: 'OK'
            });
        }
    } catch (error) {
        console.log('Error al actualizar categoría: ' + error);
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

async function eliminarCategoria(id) {
    // Preguntar antes de eliminar
    const confirmar = confirm("¿Estás seguro de que deseas eliminar esta categoria?");
    if (!confirmar) {
        return; // si el usuario presiona "Cancelar", no hace nada más
    }
    const datos = new FormData();
    datos.append('id_categoria', id);

    let respuesta = await fetch(base_url + 'control/CategoriaController.php?tipo=eliminar', {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        body: datos
    });

    let json = await respuesta.json();
    if (!json.status) {
        alert("Ooops, ocurrió un error al eliminar, inténtalo nuevamente");
        console.log(json.msg);
        return;
    } else {
        alert(json.msg);
    }
}

