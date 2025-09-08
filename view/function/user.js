function validar_form(tipo) {//obtienenos los valores de los campos del formulario y valida que no esten vacios
    let nro_identidad = document.getElementById("nro_identidad").value;
    let razon_social = document.getElementById("razon_social").value;
    let telefono = document.getElementById("telefono").value;
    let correo = document.getElementById("correo").value;
    let departamento = document.getElementById("departamento").value;
    let provincia = document.getElementById("provincia").value;
    let distrito = document.getElementById("distrito").value;
    let cod_postal = document.getElementById("cod_postal").value;
    let direccion = document.getElementById("direccion").value;
    let rol = document.getElementById("rol").value;
    //si algun campo esta vacio, muestra un alerta de error y detiene la ejecucion
    if (nro_identidad == "" || razon_social == "" || telefono == "" || correo == "" || departamento == "" || provincia == "" || distrito == "" || cod_postal == "" || direccion == "" || rol == "") {
        alert("Error: Existen campos vacios");
        return;
    }
    Swal.fire({
        title: "¡Actualización exitosa!",
        icon: "success",
        draggable: true
    });
    if (tipo == "nuevo") {
        registrarUsuario();
    }
    if (tipo == "actualizar") {
        actualizarUsuario();
    }

}

if (document.querySelector('#frm_user')) {
    //evita que se envie el formulario
    let frm_user = document.querySelector('#frm_user');
    frm_user.onsubmit = function (e) {
        e.preventDefault();
        validar_form("nuevo");
    }
}
async function registrarUsuario() {
    try {
        //capturar campos de formulario (HTML)
        const datos = new FormData(frm_user);
        //enviar datos hacia el controlador
        let respuesta = await fetch(base_url + 'control/UsuarioController.php?tipo=registrar', {//fetch sirve para enviar y recibir datos sin recargar la  pagina
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        let json = await respuesta.json();
        //validamos que json.status sea = true
        if (json.status) { //true
            alert(json.msg);
            document.getElementById('frm_user').reset();
        } else {
            alert(json.msg);
        }
    } catch (e) {
        console.log("Error al registrar Usuario:" + e);
    }
}

async function iniciar_sesion() {
    let usuario = document.getElementById("username").value;//obtiene los valores del login
    let password = document.getElementById("password").value;
    if (usuario == "" || password == "") {
        alert("Error, campos vacios!");
        return;
    }
    try {
        const datos = new FormData(frm_login);
        let respuesta = await fetch(base_url + 'control/UsuarioController.php?tipo=iniciar_sesion', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        //--------------------------
        let json = await respuesta.json();
        //validamos que json.status sea = true
        if (json.status) { //true
            location.replace(base_url + 'new-user');
        } else {
            alert(json.msg);
        }

    } catch (error) {
        console.log(error);
    }
}

// Función asincrónica para ver usuarios
async function ver_usuarios() {
    try {
        // Espera la respuesta de la petición fetch a la URL con el parámetro tipo=ver_usuarios
        let respuesta = await fetch(base_url + 'control/UsuarioController.php?tipo=ver_usuarios', {
            method: 'POST',         // Se usa el método POST para enviar la solicitud
            mode: 'cors',           // 'cors' permite solicitudes a dominios distintos si están permitidos
            cache: 'no-cache'       // No se almacena en caché la respuesta (siempre pide datos nuevos)
        });

        // Convierte la respuesta del servidor a formato JSON
        let json = await respuesta.json();

        // Obtiene el elemento HTML con id 'content_users' (una tabla probablemente)
        let content_users = document.getElementById('content_users');

        // Limpia el contenido actual de la tabla (por si ya hay datos anteriores)
        content_users.innerHTML = '';

        // Recorre cada usuario recibido en el JSON
        json.forEach((usuarios, index) => {
            // Crea una fila nueva de tabla
            let fila = document.createElement('tr');
            // Define el contenido HTML de la fila con los datos del usuario
            fila.innerHTML = `
                <td>${index + 1}</td>
                <td>${usuarios.nro_identidad}</td>
                <td>${usuarios.razon_social}</td>
                <td>${usuarios.correo}</td>
                <td>${usuarios.rol}</td>
                <td>${usuarios.estado}</td>
                <td>
                    <a href="`+ base_url + `edit-user/` + usuarios.id + `">Editar</a>
                    <button type="button" class="btn btn-danger" onclick="eliminarUsuario(` + usuarios.id + `)">Eliminar</button>
                </td>`;
            content_users.appendChild(fila);
        });

    } catch (error) {
        console.log(error);
    }
}

// Si existe el elemento con id 'content_users' en el HTML, llama a la función ver_usuarios()
if (document.getElementById('content_users')) {
    ver_usuarios();
}

async function edit_user() {
    try {
        let id_persona = document.getElementById('id_persona').value;
        const datos = new FormData();
        datos.append('id_persona', id_persona);

        let respuesta = await fetch(base_url + 'control/UsuarioController.php?tipo=ver', {
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
        document.getElementById('nro_identidad').value = json.data.nro_identidad;
        document.getElementById('razon_social').value = json.data.razon_social;
        document.getElementById('telefono').value = json.data.telefono;
        document.getElementById('correo').value = json.data.correo;
        document.getElementById('departamento').value = json.data.departamento;
        document.getElementById('provincia').value = json.data.provincia;
        document.getElementById('distrito').value = json.data.distrito;
        document.getElementById('cod_postal').value = json.data.cod_postal;
        document.getElementById('direccion').value = json.data.direccion;
        document.getElementById('rol').value = json.data.rol;

    } catch (error) {
        console.log('Esta página se perdió… como tu ex. ¿Probamos otra? ' + error);

    }

}
if (document.querySelector('#frm_edit_user')) {
    //evita que se envie el formulario
    let frm_user = document.querySelector('#frm_edit_user');
    frm_user.onsubmit = function (e) {
        e.preventDefault();
        validar_form("actualizar");
    }
}

async function actualizarUsuario() {
    const datos = new FormData(frm_edit_user);
    let respuesta = await fetch(base_url + 'control/UsuarioController.php?tipo=actualizar', {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        body: datos
    });
    json = await respuesta.json();
    if (!json.status) {
        alert("Ooops, ocurrio un error al actualizar, intentalo nuevamente");
        console.log(json.msg);
        return;
    } else {
        alert(json.msg);
    }
}
async function eliminarUsuario(id) {
    // Preguntar antes de eliminar
    const confirmar = confirm("¿Estás seguro de que deseas eliminar este usuario?");
    if (!confirmar) {
        return; // si el usuario presiona "Cancelar", no hace nada más
    }
    const datos = new FormData();
    datos.append('id_persona', id);

    let respuesta = await fetch(base_url + 'control/UsuarioController.php?tipo=eliminar', {
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

