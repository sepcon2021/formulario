$(function () {

    var IDEXAMEN = sessionStorage.getItem('idExamen');

    var CODIGO_PROYECTO = sessionStorage.getItem('codigoproyecto');

    var listaPreguntas = [];

    var listaEtiquetasValidacion =  [{nombre : "area",idtipopregunta : 1}];

    var notaAprobatoria = 0;

    const ALTERNATIVA = 1;
    const RESPUESTA = 2;
    // Sección para traer contenido del examen


    var contenidoHtml = "";

    $.post(RUTA + 'formulario/listaPreguntaByIdExamenRegistroLimit', { idExamen: IDEXAMEN ,idProyecto : CODIGO_PROYECTO}, function (data, textStatus, xhr) {

        if (data.status == 200) {

            $(".header").append(contenidoCabecera(data.contenido));


            contenidoHtml = crearHtmlPregunta(data.contenido);
            $("#contenido-pregunta").append(contenidoHtml);



        }


        registrarExamen();

    }, "json");





    function crearHtmlPregunta(contenido) {

        var htmlPregunta = "";
        var index = 1;

        notaAprobatoria = contenido.examen.nota;
        htmlPregunta += contenidoEstatico(contenido);
        listaPreguntas = contenido.examen.listaPreguntas;

        contenido.examen.listaPreguntas.forEach(pregunta => {

            //htmlPregunta += contenidoPregunta(pregunta, index);
            htmlPregunta += tipoAlternativaHtml(pregunta,index);

            //var data = ["pregunta" + pregunta.id , pregunta.idtipopregunta];
            var data = {nombre : ("pregunta" + pregunta.id),idtipopregunta : pregunta.idtipopregunta };

            //listaEtiquetasValidacion.push("pregunta" + pregunta.id);
            listaEtiquetasValidacion.push(data);
            index++;
        });

        return htmlPregunta;
    }


    function contenidoCabecera(contenido) {

        return `
        <div class="bordes">
        <h2> `+ contenido.examen.tema + `</h2>
        <br>
        <br>
        <h5>Mes</h5>
        <p> `+ getMonth() + `</p>
        <br>
        <h5>Proyecto</h5>
        <p> `+ contenido.examen.nombreProyecto + `</p>
        <br>
        <h5>Cliente</h5>
        <p> `+ contenido.examen.cliente+ ` </p>
        <br>
        <h5>Facilitador</h5>
        <p> `+ contenido.examen.facilitador + `</p>
    </div>`;

    }

    function tipoAlternativaHtml(pregunta,index) {



        var htmlAlternativa = ``;

        if(pregunta.idtipopregunta == ALTERNATIVA){

            htmlAlternativa = contenidoPregunta(pregunta, index);

        }
        if(pregunta.idtipopregunta ==  RESPUESTA){
            htmlAlternativa =  contenidoRespuestaHtml(pregunta,index);
        }
        return htmlAlternativa;
    }

    function contenidoRespuestaHtml(pregunta,index){
        return `<div class="contenido" > 
        <div class="bordes">
        <h4>${index}. ${pregunta.nombre} </h4> 
        <div> <textarea class="comentario" name="pregunta${pregunta.id}" id="pregunta${pregunta.id}" placeholder="Comentarios"></textarea>  </div>
        
        <div class="error_message" id="pregunta${pregunta.id}_message">
        <p>Marca una alternativa</p>
        </div>
        
        </div> 
        </div>`
    }


    function contenidoPregunta(pregunta, index) {

        return `<div class="contenido" > 
        <div class="bordes">
        <h4>  `+ index + `.` + pregunta.nombre + ` </h4> 
        <div> 
        <br> 
        <div id="listaAlternativa`+ pregunta.id + `"> 
        `+ crearHtmlAlternativa(pregunta) + `
        </div> 
        </div>

        <div class="error_message" id="pregunta`+ pregunta.id + `_message">
        <p>Marca una alternativa</p>
        </div>

        </div> 
        </div>`;


    }

    function crearHtmlAlternativa(pregunta) {
        var htmlAlternativa = "";


        pregunta.alternativa.forEach(alternativa => {


            htmlAlternativa += contenidoAlternativa(alternativa, pregunta);

        });


        return htmlAlternativa;
    }

    function contenidoAlternativa(alternativa, pregunta) {

        return ' <div> ' +

            '<input class="radioRespuesta" type="radio" name="pregunta' + pregunta.id + '" id="radio' + alternativa.id + '"  idalternativa="' + alternativa.id + '" value="' + alternativa.id + '" > ' +
            '<label >' + alternativa.nombre + '</label> ' +
            '</div>';
    }






    function contenidoEstatico(contenido) {

        return `
            <div class="contenido">
            <div class="bordes">
                    <h5>Nombres y Apellidos</h5>
                    <p name="nombresApellidos" id="nombresApellidos"> ${sessionStorage.getItem("nombresApellidosTrabajador")}
                    </p>
                    <h5>DNI</h5>
                    <p name="dni" id="dni"> ${sessionStorage.getItem("dniTrabajador")} </p>
                    <h5>Cargo</h5>
                    <p name="cargo" id="cargo"> ${sessionStorage.getItem("cargoTrabajador")} </p>
                </div>
            </div>

            <input type="hidden" name="idexamen" value="${IDEXAMEN}">
            <input type="hidden" name="dni" value="${sessionStorage.getItem("dniTrabajador")}"> 


                <div class=" contenido">
            <div class="bordes">
                <h4>Área</h4>
                <br> 
        <input type="radio" name="area" id="area1" value="1"> 
        <label for="area1">Obras Civiles</label> 
        <br> 
        <input type="radio" name="area" id="area2" value="2"> 
        <label for="area2">Piping</label> 
        <br> 
        <input type="radio" name="area" id="area3" value="3"> 
        <label for="area3">Precom/com</label> 
        <br> 
        <input type="radio" name="area" id="area4" value="4"> 
        <label for="area4">Contratista</label> 
        <br> 
        <input type="radio" name="area" id="area5" value="5"> 
        <label for="area5">Mantenimiento de Equipos Mecánicos</label> 
        <br> 
        <input type="radio" name="area" id="area6" value="6"> 
        <label for="area6">Logistica - Operadores, Rigger y Andamieros</label> 
        <br> 
        <input type="radio" name="area" id="area7" value="7"> 
        <label for="area7">Mantenimiento y Habilitación de Campamento</label> 
        <br> 
        <input type="radio" name="area" id="area8" value="8"> 
        <label for="area8">Oficina</label> 
        <br> 
        <input type="radio" name="area" id="area9" value="9"> 
        <label for="area9">SSMA - Seguridad y Salud</label> 
         <br> 
        <input type="radio" name="area" id="area10" value="10"> 
        <label for="area10">Calidad</label> 
        <br> 
        <input type="radio" name="area" id="area11" value="11"> 
        <label for="area11">Electricidad e Instrumentación</label> 
        <br>
                <br>
                <div class="error_message" id="area_message">
                    <p>Marca una alternativa</p>
                </div>
            </div>
            </div>
        `;
    }


    function listaArea(contenido) {
        var htmlSelect =  ` `;
        contenido.listaArea.forEach(area => {
            htmlSelect += `<br> 
            <input type="radio" name="area" id="area`+area.id+`" value="`+area.id+`"> 
            <label for="area`+area.id+`"> `+area.nombre+`</label> `;
        });
        return htmlSelect;
    }


    function registrarExamen() {

        $("#btnRegister").on('click', function (event) {

            $("#btnRegister").prop("disabled", false);


            event.preventDefault();


            console.log(validateFormulario());

            if (validateFormulario()) {

                //Iniciamos con el load de carga
                document.getElementsByClassName('load')[0].innerHTML = '<div class="loader"></div>';

                $("form").hide(0);

                var firmaTrabajador = document.getElementById("firma");

                $.post('public/inc/upload-sing.inc.php', { img: firmaTrabajador.toDataURL() }, function (data) {

                    $('#nombreFirmaTrabajador').val(data);

                    $("#examen").trigger('submit');


                });
            }






            return false;

        });


        //enviar formulario
        $("#examen").on('submit', function (event) {
            event.preventDefault();

            console.log($(this).serializeArray())

            var listaRespuestas = $(this).serializeArray();

            var arrayRespuesta = [];

            var jsonFormulario = "";


            arrayRespuesta.push({
                idexamen: listaRespuestas[1]["value"].trim(),
                dni: listaRespuestas[2]["value"].trim(),
                idarea: listaRespuestas[3]["value"].trim(),
                nota: calcularNota(listaRespuestas),
                //comentario: listaRespuestas[(listaRespuestas.length - 1)]["value"],
                firma: listaRespuestas[0]["value"].trim(),
                listaRespuestas: convertRespuestaToArray(listaRespuestas)
            });

            INFO = new FormData();
            jsonFormulario = JSON.stringify(arrayRespuesta);


            enviarFormulario(jsonFormulario, arrayRespuesta);

            return false;
        });
    }

    function enviarFormulario(jsonFormulario, arrayRespuesta) {


        $.post(RUTA + 'registro/verificarRegistro', { dniTrabajador: arrayRespuesta[0].dni, idExamen : IDEXAMEN}, function (data, textStatus, xhr) {


            console.log('DATA');
            console.log(data);

            if (data.status == 200) {

                $.post(RUTA + 'registro/insertExamen', { data: jsonFormulario }, function (data, textStatus, xhr) {

                    //Desactivamos el load de carga
                    document.getElementsByClassName("load")[0].innerHTML = '';


                    if (data.status == 200) {




                        if (arrayRespuesta[0].nota > notaAprobatoria) {

                            $(".respuesta").append(`<div class="contenido">  <div class="succesMessage"> <h3>El formulario fue enviado con éxito</h3> <br> <h3>Nota</h3> <br> <h1> ` + arrayRespuesta[0].nota + ` </h1> </div> </div>`)

                        } else {

                            $(".respuesta").append(`<div class="contenido">  <div class="succesMessage"> <h3>El formulario fue enviado con éxito</h3> <br> <h3>Nota</h3> <br> <h1> ` + arrayRespuesta[0].nota + ` </h1>  <br> <button type="submit" class="buttonInicio" id="btnInicio"> Volver a rendir examen </button> </div> </div>`)
                            regresarInicio()
                        }
                    } else {

                        $(".respuesta").append(` <div class="contenido">  <div class="succesMessage"> <h3` + data.contenido + ` </h3> <br> <button type="submit"  class="buttonInicio" id="btnInicio"> Volver a rendir examen </button> </div> </div> `);
                        regresarInicio()

                    }

                }, "json");


            } else {

                $.post(RUTA + 'registro/updateExamen', { data: jsonFormulario }, function (data, textStatus, xhr) {

                    //Desactivamos el load de carga
                    document.getElementsByClassName("load")[0].innerHTML = '';


                    if (data.status == 200) {




                        if (arrayRespuesta[0].nota > notaAprobatoria) {

                            $(".respuesta").append(`<div class="contenido">  <div class="succesMessage"> <h3>El formulario fue enviado con éxito</h3> <br> <h3>Nota</h3> <br> <h1> ` + arrayRespuesta[0].nota + ` </h1> </div> </div>`)

                        } else {
                            $(".respuesta").append(`<div class="contenido">  <div class="succesMessage"> <h3>El formulario fue enviado con éxito</h3> <br> <h3>Nota</h3> <br> <h1> ` + arrayRespuesta[0].nota + ` </h1>  <br> <button type="submit" class="buttonInicio" id="btnInicio"> Volver a rendir examen </button> </div> </div>`)
                            regresarInicio()
                        }
                    } else {

                        $(".respuesta").append(` <div class="contenido">  <div class="succesMessage"> <h3` + data.contenido + ` </h3> <br> <button type="submit"  class="buttonInicio" id="btnInicio"> Volver a rendir examen </button> </div> </div> `);
                        regresarInicio()

                    }

                }, "json");
            }

        }, "json");

    }



    function regresarInicio() {


        $("#btnInicio").on('click', function (event) {

            event.preventDefault();

            //window.location.href = RUTA;
            window.location.replace(RUTA + 'dashboard');

            return false;

        });
    }


    function calcularNota(listaRespuestas) {
        //Desde aca empieza el array con las respuestas acerca del examen
        var INICIO_PREGUNTA = 4;
        var nota = 0;

        const RESPUESTA_CORRECTA = 1;

        listaPreguntas.forEach(pregunta => {

            if(pregunta.idtipopregunta == ALTERNATIVA ){

                pregunta.alternativa.forEach(data =>{
                
                    if(data.respuesta == RESPUESTA_CORRECTA & data.id == listaRespuestas[INICIO_PREGUNTA]["value"] ){
                        
                        nota += pregunta.puntaje;
    
                    }
                });
    
            }

            INICIO_PREGUNTA++;

        })

        return nota;
    }


    function convertRespuestaToArray(listaRespuestas) {
        //Desde aca empieza el array con las respuestas acerca del examen
        var index = 4;
        var listaRespuestaArray = [];

        listaPreguntas.forEach(pregunta => {

            listaRespuestaArray.push({
                idPregunta: pregunta.id, respuesta: listaRespuestas[index]["value"]
            });

            index++;

        })


        return listaRespuestaArray;
    }

    /*
        function convertRespuestaToArray(listaRespuestas) {
            var index = 0;
    
            var listaRespuestaArray = [];
    
            listaRespuestas.forEach(respuesta => {
    
                if (index > 5 && index < listaRespuestas.length - 1) {
    
                    listaRespuestaArray.push({
                        respuesta: respuesta.value 
                    });
                }
    
                index++;
    
            })
    
            return listaRespuestaArray;
    
        }
    */




    /**************************************************************************** */
    /************* FUNCIONES PARA VALIDAR CHECKS   ****************************** */
    /**************************************************************************** */
    /**************************************************************************** */

    function validateFormulario() {



        var validarFormulario = true;


        listaEtiquetasValidacion.forEach((value) => {

            if(value.idtipopregunta == 1){

                $('input[type=radio][name=' + value.nombre + ']').change(function () {
                    setChangeErrorCheck(value.nombre)
                });
    
    
    
                if (!validateCheck(value.nombre)) {
    
                    validarFormulario = false;
                }
            }

            if(value.idtipopregunta == 2){

                $('#'+value.nombre).change(function () {
                    setChangeErrorCheck(value.nombre)
                });
    
    
    
                if (!validateCampo(value.nombre)) {
    
                    validarFormulario = false;
                }

            }



        });

        if (isCanvasBlank()) {

            validarFormulario = false;
        }






        return validarFormulario;
    }


    function isCanvasBlank() {

        var canvas = document.getElementById("firma");

        const context = canvas.getContext('2d');

        const pixelBuffer = new Uint32Array(
            context.getImageData(0, 0, canvas.width, canvas.height).data.buffer
        );

        var resultado = !pixelBuffer.some(color => color !== 0);

        if (resultado) {

            document.getElementById("firmaMessage").innerHTML = "Ingresar firma";

        }


        return resultado;
    }


    function validateCampo(etiqueta){

        var resultForm = true;


        const campo = document.getElementById(etiqueta);
        const campoValue = campo.value.trim();
    
        if (campoValue === '') {
            resultForm = false;
            setErrorForCheck(etiqueta);
        }
        return resultForm;
    }


    function validateCheck(idEtiqueta) {

        var resultForm = false;


        const etiqueta = document.getElementsByName(idEtiqueta);

        etiqueta.forEach((value) => {
            if (value.checked) {
                resultForm = true;
            }
        });

        if (!resultForm) {

            setErrorForCheck(idEtiqueta)

        }

        return resultForm;
    }


    function setErrorForCheck(etiqueta) {

        const message = document.getElementById(etiqueta + '_message');
        message.style.visibility = 'visible';
        message.scrollIntoView();

    }

    function setChangeErrorCheck(etiqueta) {
        const message = document.getElementById(etiqueta + '_message');
        message.style.visibility = 'hidden';
    }




    function getMonth() {
        var arrayMonths = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Dicimebre'];
        var day = new Date();

        return arrayMonths[day.getMonth()]
    }



});





