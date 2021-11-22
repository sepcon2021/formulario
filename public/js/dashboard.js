$(function() {

    const CODIGO_PROYECTO = sessionStorage.getItem('codigoproyecto');
    const CARGO_TRABAJADOR = sessionStorage.getItem('cargoTrabajador');
    contenidoEstatico();

    function contenidoEstatico() {

        document.getElementById('header').innerHTML = `
            
            <div class="bordes">
                    <h5>Nombres y Apellidos</h5>
                    <p name="nombresApellidos" id="nombresApellidos"> ${sessionStorage.getItem("nombresApellidosTrabajador")}
                    </p>
                    <h5>DNI</h5>
                    <p name="dni" id="dni"> ${sessionStorage.getItem("dniTrabajador")} </p>
                    <h5>Cargo</h5>
                    <p name="cargo" id="cargo"> ${sessionStorage.getItem("cargoTrabajador")} </p>
                </div>
        
        `;
    }

    // Mostrar todas las capacitaciones

    $.post(RUTA + 'dashboard/listaExamenByFecha', {'codigoproyecto': CODIGO_PROYECTO , 'cargoTrabajador' : CARGO_TRABAJADOR}, function(data, textStatus, xhr) {

        var tablaExamenes = "";

        if (data.status == 200) {


            data.contenido.forEach(function(examen) {
                
                tablaExamenes +=  ` <tr> 
                    <td> ${examen.id} </td>
                    <td> ${examen.areaEmpresa} </td>
                    <td>  ${examen.tema} </td>
                    <td>  ${examen.fecha} </td>
                    <td> ${estadoExamen(examen.nota)} </td>
                    </tr> `;


            });

            $("#listaExamen").append(tablaExamenes);

        }

        vistaPrevia();

    }, "json");

    function estadoExamen(notaExamen){
        var htmlEstado = `<div class='estadoExamenListo'>Completado</div>`;
        console.log(notaExamen == 'NA')
        if(notaExamen == 'NA'){
            htmlEstado = `<div class='estadoExamenPendiente'>Pendiente</div>`;
        }
        return htmlEstado;
    }


    function vistaPrevia() {


        $("#listaExamen tr").on("click", function (event) {
            event.preventDefault();

            sessionStorage.setItem("idExamen", $(this).find('td').eq(0).text());
            window.location.href = RUTA + "registro";

        });
    }






})