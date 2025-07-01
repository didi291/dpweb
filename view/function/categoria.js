
function validar_form() {
    let nombre = document.getElementById("nombre").value;
    let detalle = document.getElementById("detalle").value;

    if (nombre=="" || detalle=="") {
       
         Swal.fire({
            icon: 'warning',
            title: 'Campos vacíos',
        });
        return;
    }
    registrarCategoria();
}

if(document.querySelector('#frm_categorie')){
    let frm_categorie = document.querySelector('#frm_categorie');
    frm_categorie.onsubmit = function(e){
        e.preventDefault();
        validar_form();
    }
}

async function registrarCategoria() {
    try {
        const datos = new FormData(frm_categorie);
        let respuesta = await fetch(base_url + 'control/categoriaController.php?tipo=registrar',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos 
        });
        let json = await respuesta.json();
        if (json.status) {
            alert(json.msg);
            document.getElementById('frm_categorie').reset();
        }else{
            alert(json.msg);
        }
        
    } catch (error) {
        console.log("error al registar categoria:" + error); 
    }
}
