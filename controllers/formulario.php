<?php

require_once 'models/iniciomodel.php';

class Formulario extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function render()
    {
        $this->view->render('formulario/index');
    }


    public function crearFormulario()
    {

        $return["status"] = 404;
        $return["contenido"] = "Problemas en nuestros servicios";

        $idTipo = $_POST['idTipo'];
        $codigoproyecto = $_POST['codigoproyecto'];
        $idAreaEmpresa = $_POST['idareaempresa'];


        // EXTRAEMOS LA CABECERA DEL FORMULARIO
        $idExamen = $this->insertExamen($idTipo,$codigoproyecto,$idAreaEmpresa);        

        if ($idExamen != null) {

            $return["status"] = 200;
            $return["contenido"] = $idExamen;
        }

        header('Content-Type: application/json');
        echo json_encode($return);
    }

    //INSERTAMOS LA CABECERA DEL EXAMEN
    //Vamos a crear con campos por defecto el examen solo para retornar el ID que se genera
    public function insertExamen($idTipo,$codigoproyecto,$idAreaEmpresa)
    {

        $currentDate = new DateTime();

        $idProyecto = $codigoproyecto;
        $fase = "SSMA";
        $facilitador = "";
        $cliente = "";
        $fecha = $currentDate->format('Y-m-d');
        $duracion = 15;
        $idTipo = $idTipo;
        $tema = '';
        $horaInicio = '12:00:00';
        $horaFin = '12:00:00';
        $duracionProgramada = 0;
        $duracionEfectiva = 0;
        $idCurso = 1;
        $idAreaCapacitacion = 1;
        $detalle = "";
        $nota = 0;
        $estado = 1;
        $idFirmaFacilitador = 23;
        $observacion = '';
        $finalizo = 1;
        $continuara = 0;
        $fechaContinuacion = $currentDate->format('Y-m-d');
        $temarioA = '';
        $temarioB = '';
        $idareaempresa = $idAreaEmpresa;
        $cantidadPregunta = 1000;
        $aleatorio = 0;
        $horas_capacitadas = 0;


        $datos = compact(
            "idProyecto",
            "fase",
            "facilitador",
            "cliente",
            "fecha",
            "duracion",
            "idTipo",
            "tema",
            "horaInicio",
            "horaFin",
            "duracionProgramada",
            "duracionEfectiva",
            "idCurso",
            "idAreaCapacitacion",
            "detalle",
            "nota",
            "estado",
            "idFirmaFacilitador",
            "observacion",
            "finalizo",
            "continuara",
            "fechaContinuacion",
            "temarioA",
            "temarioB",
            "idareaempresa",
            "cantidadPregunta",
            "aleatorio",
            "horas_capacitadas"
        );

        $respuesta = $this->model->insertExamen($datos);

        return $respuesta;
    }


    public function updateExamenProyecto()
    {

        $id = $_POST['id'];
        $idProyecto = $_POST['idProyecto'];

        $datos = compact("id", "idProyecto");

        $respuesta = $this->model->updateExamenProyecto($datos);

        echo $this->responseMessage($respuesta);
    }


    public function updateExamenFase()
    {

        $id = $_POST['id'];
        $fase = $_POST['fase'];

        $datos = compact("id", "fase");

        $respuesta = $this->model->updateExamenFase($datos);

        echo $this->responseMessage($respuesta);
    }


    public function updateExamenFacilitador()
    {

        $id = $_POST['id'];
        $facilitador = $_POST['facilitador'];

        $datos = compact("id", "facilitador");

        $respuesta = $this->model->updateExamenFacilitador($datos);

        echo $this->responseMessage($respuesta);
    }


    public function updateExamenCliente()
    {

        $id = $_POST['id'];
        $cliente = $_POST['cliente'];

        $datos = compact("id", "cliente");

        $respuesta = $this->model->updateExamenCliente($datos);

        echo $this->responseMessage($respuesta);
    }


    public function updateExamenFecha()
    {

        $id = $_POST['id'];
        $fecha = $_POST['fecha'];

        $datos = compact("id", "fecha");

        $respuesta = $this->model->updateExamenFecha($datos);

        echo $this->responseMessage($respuesta);
    }



    public function updateExamenDuracion()
    {

        $id = $_POST['id'];
        $duracion = $_POST['duracion'];

        $datos = compact("id", "duracion");

        $respuesta = $this->model->updateExamenDuracion($datos);

        echo $this->responseMessage($respuesta);
    }



    public function updateExamenTema()
    {

        $id = $_POST['id'];
        $tema = $_POST['tema'];

        $datos = compact("id", "tema");

        $respuesta = $this->model->updateExamenTema($datos);

        echo $this->responseMessage($respuesta);
    }



    public function updateExamenHoraInicio()
    {

        $id = $_POST['id'];
        $horaInicio = $_POST['horaInicio'];

        $datos = compact("id", "horaInicio");

        $respuesta = $this->model->updateExamenHoraInicio($datos);

        echo $this->responseMessage($respuesta);
    }

    public function updateExamenHoraFin()
    {

        $id = $_POST['id'];
        $horaFin = $_POST['horaFin'];

        $datos = compact("id", "horaFin");

        $respuesta = $this->model->updateExamenHoraFin($datos);

        echo $this->responseMessage($respuesta);
    }


    public function updateExamenDuracionProgramada()
    {

        $id = $_POST['id'];
        $duracionProgramada = $_POST['duracionProgramada'];

        $datos = compact("id", "duracionProgramada");

        $respuesta = $this->model->updateExamenDuracionProgramada($datos);

        echo $this->responseMessage($respuesta);
    }


    public function updateExamenIdCurso()
    {

        $id = $_POST['id'];
        $idCurso = $_POST['idCurso'];

        $datos = compact("id", "idCurso");

        $respuesta = $this->model->updateExamenIdCurso($datos);

        echo $this->responseMessage($respuesta);
    }


    public function updateExamenIdAreaCapacitacion()
    {

        $id = $_POST['id'];
        $idAreaCapacitacion = $_POST['idAreaCapacitacion'];

        $datos = compact("id", "idAreaCapacitacion");

        $respuesta = $this->model->updateExamenIdAreaCapacitacion($datos);

        echo $this->responseMessage($respuesta);
    }




    public function updateExamenNota()
    {

        $id = $_POST['id'];
        $nota = $_POST['nota'];

        $datos = compact("id", "nota");

        $respuesta = $this->model->updateExamenNota($datos);

        echo $this->responseMessage($respuesta);
    }


        
    public function updateExamenTemarioA()
    {

        $id = $_POST['id'];
        $temarioA = $_POST['temarioA'];

        $datos = compact("id", "temarioA");

        $respuesta = $this->model->updateExamenTemarioA($datos);

        echo $this->responseMessage($respuesta);
    }

    public function updateExamenTemarioB()
    {

        $id = $_POST['id'];
        $temarioB = $_POST['temarioB'];

        $datos = compact("id", "temarioB");

        $respuesta = $this->model->updateExamenTemarioB($datos);

        echo $this->responseMessage($respuesta);
    }
    


    public function updateExamenObservacion()
    {

        $id = $_POST['id'];
        $observacion = $_POST['observacion'];

        $datos = compact("id", "observacion");

        $respuesta = $this->model->updateExamenObservacion($datos);

        echo $this->responseMessage($respuesta);
    }


    public function updateExamenFinalizo()
    {

        $id = $_POST['id'];
        $finalizo = $_POST['finalizo'];

        $datos = compact("id", "finalizo");

        $respuesta = $this->model->updateExamenFinalizo($datos);

        echo $this->responseMessage($respuesta);
    }

    public function updateExamenContinuara()
    {

        $id = $_POST['id'];
        $continuara = $_POST['continuara'];

        $datos = compact("id", "continuara");

        $respuesta = $this->model->updateExamenContinuara($datos);

        echo $this->responseMessage($respuesta);
    }


    public function updateExamenFechaContinuacion()
    {

        $id = $_POST['id'];
        $fechaContinuacion = $_POST['fechaContinuacion'];

        $datos = compact("id", "fechaContinuacion");

        $respuesta = $this->model->updateExamenFechaContinuacion($datos);

        echo $this->responseMessage($respuesta);
    }




    public function updateExamenFirmaFacilitador()
    {

        $id = $_POST['id'];
        $idFirmaFacilitador = $_POST['idFirmaFacilitador'];

        $datos = compact("id", "idFirmaFacilitador");

        $respuesta = $this->model->updateExamenFirmaFacilitador($datos);

        echo $this->responseMessage($respuesta);
    }


    public function updateEnviarCorreo()
    {

        $id = $_POST['id'];
        $enviarCorreo = $_POST['enviarCorreo'];

        $datos = compact("id", "enviarCorreo");

        $respuesta = $this->model->updateEnviarCorreo($datos);

        echo $this->responseMessage($respuesta);
    }

    public function updateExamenCantidadPregunta()
    {

        $id = $_POST['id'];
        $cantidadPregunta = $_POST['cantidadPregunta'];

        $datos = compact("id", "cantidadPregunta");

        $respuesta = $this->model->updateExamenCantidadPregunta($datos);

        echo $this->responseMessage($respuesta);
    }

    public function updateExamenAleatorio()
    {

        $id = $_POST['id'];
        $aleatorio = $_POST['aleatorio'];

        $datos = compact("id", "aleatorio");

        $respuesta = $this->model->updateExamenAleatorio($datos);

        echo $this->responseMessage($respuesta);
    }

    public function updateHorasCapacitadas()
    {

        $id = $_POST['id'];
        $horas_capacitadas = $_POST['horas_capacitadas'];

        $datos = compact("id", "horas_capacitadas");

        $respuesta = $this->model->updateHorasCapacitadas($datos);

        echo $this->responseMessage($respuesta);
    }


    //INSERTAMOS LA PREGUNTA
    public function insertPregunta()
    {

        $pregunta = json_decode($_POST['data'])[0];

        $nombre = $pregunta->nombre;
        $respuesta = $pregunta->respuesta;
        $puntaje = $pregunta->puntaje;
        $idExamen = $pregunta->idExamen;
        //By default es 1 : alternativa && 1 : obligatorio 
        $idtipopregunta = 1;
        $obligatorio = 1;

        $datos = compact("nombre", "respuesta", "puntaje", "idExamen","idtipopregunta","obligatorio");

        $idPregunta = $this->model->insertPregunta($datos);

        echo $this->responseMessageContenido($idPregunta);
    }

    //UPDATE PREGUNTA nombre
    public function updatePreguntaNombre()
    {

        $nombre = $_POST['nombre'];
        $idPregunta = $_POST['idPregunta'];

        $datos = compact("nombre", "idPregunta");

        $respuesta = $this->model->updatePreguntaNombre($datos);

        echo $this->responseMessage($respuesta);
    }

    //UPDATE PREGUNTA RESPUESTA
    public function updatePreguntaRespuesta()
    {

        $respuesta = $_POST['respuesta'];
        $idPregunta = $_POST['idPregunta'];

        $datos = compact("respuesta", "idPregunta");

        $respuesta = $this->model->updatePreguntaRespuesta($datos);

        echo $this->responseMessage($respuesta);
    }

    //UPDATE PREGUNTA PUNTAJE
    public function updatePreguntaPuntaje()
    {

        $puntaje = $_POST['puntaje'];
        $idPregunta = $_POST['idPregunta'];

        $datos = compact("puntaje", "idPregunta");

        $respuesta = $this->model->updatePreguntaPuntaje($datos);

        echo $this->responseMessage($respuesta);
    }

    
    //UPDATE PREGUNTA TIPO
    public function updatePreguntaTipo()
    {

        $idtipopregunta = $_POST['idtipopregunta'];
        $idPregunta = $_POST['idPregunta'];

        $datos = compact("idtipopregunta", "idPregunta");

        $respuesta = $this->model->updatePreguntaTipo($datos);

        echo $this->responseMessage($respuesta);
    }

    //ELIMINAR PREGUNTA
    public function eliminarPregunta()
    {

        $idPregunta = $_POST['idPregunta'];

        $datos = compact("idPregunta");

        $respuesta = $this->model->deletePregunta($datos);

        echo $this->responseMessage($respuesta);
    }

    //INSERTAMOS LA ALTERNATIVA
    public function insertAlternativa()
    {

        $DEAULT_ANSWER = 0;

        $nombre = '';
        $numero = $_POST['index'];
        $idPregunta = $_POST['idPregunta'];
        $respuesta = $DEAULT_ANSWER;

        $datos = compact("nombre", "numero", "idPregunta","respuesta");

        $idAlternativa = $this->model->insertAlternativa($datos);

        echo $this->responseMessageContenido($idAlternativa);
    }

    //UPDATE ALTERNATIVA nombre
    public function updateAlternativaNombre()
    {

        $nombre = $_POST['nombre'];
        $idAlternativa = $_POST['idAlternativa'];

        $datos = compact("nombre", "idAlternativa");

        $respuesta = $this->model->updateAlternativaNombre($datos);

        echo $this->responseMessage($respuesta);
    }


    //UPDATE ALTERNATIVA respuesta
    public function updateAlternativaRespuesta()
    {

        $idPregunta = $_POST['idPregunta'];

        $idAlternativa = $_POST['idAlternativa'];

        $respuesta = $this->model->updateAlternativaRespuesta($idPregunta,$idAlternativa);

        echo $this->responseMessage($respuesta);
    }

    

    //ELIMINAR ALTERNATIVA
    public function eliminarAlternativa()
    {

        $idAlternativa = $_POST['idAlternativa'];

        $datos = compact("idAlternativa");

        $respuesta = $this->model->deleteAlternativa($datos);

        echo $this->responseMessage($respuesta);
    }



    //LISTA EXAMEN DETALLE
    public function listaExamenDetalle()
    {
        $codigoproyecto = $_POST['codigoproyecto'];
        $idAreaEmpresa = $_POST['idAreaEmpresa'];
        
        $respuesta = $this->model->listaExamen($codigoproyecto,$idAreaEmpresa);

        echo $this->responseMessageContenido($respuesta);
    }



    //LISTA PREGUNTAS DETALLE
    public function listaPreguntaByIdExamen()
    {

        $idExamen = $_POST['idExamen'];
        $examen = $this->model->findByIdExamen($idExamen);

        echo $this->responseMessageContenido($examen);
    }

    //LISTA PREGUNTAS DETALLE
    public function listaPreguntaByIdExamenRegistro()
    {

        $idExamen = $_POST['idExamen'];

        $examen = $this->model->findByIdExamen($idExamen);

        $resultado = array(
            "examen" => $examen,
            "listaArea" => ''
        );


        echo $this->responseMessageContenido($resultado);
    }

        //LISTA PREGUNTAS DETALLE
        public function listaPreguntaByIdExamenRegistroLimit()
        {
    
            $idExamen = $_POST['idExamen'];
            $examen = $this->model->findByIdExamenLimit($idExamen);

            $resultado = array(
                "examen" => $examen,
                "listaArea" => ''
            );
    
    
            echo $this->responseMessageContenido($resultado);
        }


    //ELIMINAR PREGUNTA
    public function eliminarExamen()
    {

        $idExamen = $_POST['idExamen'];

        $respuesta = $this->model->deleteExamen($idExamen);

        echo $this->responseMessage($respuesta);
    }


    //LISTA DE FIRMA FACILITADOR
    public function getListaFirmaFacilitador()
    {

        $respuesta = $this->model->getListaFirmaFacilitador();

        echo $this->responseMessageContenido($respuesta);
    }

    //UPDATE PREGUNTA RESPUESTA
    public function insertFirmaFacilitador()
    {

        $nombreFacilitador = $_POST['nombreFacilitador'];
        $urlImagen = $_POST['urlImagen'];

        $datos = compact("nombreFacilitador", "urlImagen");

        $respuesta = $this->model->insertFirmaFacilitador($datos);

        if($respuesta!=null){

            $dataFirmaFacilitador = array(
                'id' => $respuesta,
                'nombreFacilitador' => $nombreFacilitador
            );

        }

        echo $this->responseMessageContenido($dataFirmaFacilitador);
    }


    //Duplicar formulario
    public function duplicarFormulario()
    {

        $idExamen = $_POST['idExamen'];

        //Traemos todo el examen y sus preguntas
        $respuesta = $this->model->findByIdExamen($idExamen);


        //Insertamos el examen 
        $respuestaExamen = $this->insertExamenDuplicado($respuesta);

        if( $respuestaExamen != 0){
            
            $this->insertPreguntaDuplicada($respuestaExamen,$respuesta);
            $this->insertPuestoDuplicada($respuestaExamen,$respuesta);
        }

        echo $this->responseMessageContenido($respuestaExamen);
    }


    public function insertExamenDuplicado($examen){

        $currentDate = new DateTime();

           
        $idProyecto = $examen->idProyecto;
        $fase = $examen->fase;
        $facilitador = $examen->facilitador;
        $cliente = $examen->cliente;
        $fecha =  $currentDate->format('Y-m-d');
        $duracion = $examen->duracion;
        $idTipo = $examen->idTipo;
        $tema = $examen->tema.'- Copia('.$currentDate->getTimestamp().')';
        $horaInicio = $examen->horaInicio;
        $horaFin =  $examen->horaFin;
        $duracionProgramada = $examen->duracionProgramada;
        $duracionEfectiva = $examen->duracionEfectiva;
        $idCurso = $examen->idCurso;
        $idAreaCapacitacion = $examen->idAreaCapacitacion;
        $detalle = $examen->detalle;
        $nota = $examen->nota;
        $estado = $examen->estado;
        $idFirmaFacilitador = $examen->idFirmaFacilitador;
        $observacion = $examen->observacion;
        $finalizo = $examen->finalizo;
        $continuara = $examen->continuara;
        $fechaContinuacion = $examen->fechaContinuacion;
        $temarioA = $examen->temarioA;
        $temarioB = $examen->temarioB;
        $idareaempresa = $examen->idareaempresa;

        $cantidadPregunta = 1000;
        $aleatorio = 0;
        $horas_capacitadas = 0;
        // INSERT EXAMEN
        $datos = compact(
            "idProyecto",
            "fase",
            "facilitador",
            "cliente",
            "fecha",
            "duracion",
            "idTipo",
            "tema",
            "horaInicio",
            "horaFin",
            "duracionProgramada",
            "duracionEfectiva",
            "idCurso",
            "idAreaCapacitacion",
            "detalle",
            "nota",
            "estado",
            "idFirmaFacilitador",
            "observacion",
            "finalizo",
            "continuara",
            "fechaContinuacion",
            "temarioA",
            "temarioB",
            "idareaempresa",
            "cantidadPregunta",
            "aleatorio",
            "horas_capacitadas"
        );

        return $this->model->insertExamen($datos);

    }


    public function insertPreguntaDuplicada($idExamenDuplicado,$examen)
    {

        foreach($examen->listaPreguntas as $pregunta) {

            $nombre = $pregunta->nombre;
            $respuesta = $pregunta->respuesta;
            $puntaje = $pregunta->puntaje;
            $idExamen = $idExamenDuplicado;
            $idtipopregunta = $pregunta->idtipopregunta;
            //By default es 1 : obligatorio
            $obligatorio = 1;

            $datos = compact("nombre", "respuesta", "puntaje", "idExamen", "idtipopregunta", "obligatorio");

            $idPregunta = $this->model->insertPregunta($datos);

            $this->model->insertAlternativaBulk($idPregunta, $pregunta->alternativa);
        }
    } 

    public function insertPuestoDuplicada($idExamenDuplicado,$examen)
    {
        $this->model->insertPuestoBulk($idExamenDuplicado , $examen->examenPuestoTrabajo);
    } 

    public function insertSubPregunta(){

        

        $nombre = 'Fila';
        $idPregunta = $_POST['idPregunta'];
        $puntaje = 0;

        $datos = compact("nombre", "idPregunta", "puntaje");

        $idSubPregunta = $this->model->insertSubPregunta($datos);


        $nombre = 'Columna';
        $respuesta = 0;
    
        $datos1 = compact("nombre", "idSubPregunta", "respuesta");
        $datos2 = compact("nombre", "idSubPregunta", "respuesta");


        $idSubAlternativa1 = $this->model->insertSubAlternativa($datos1);
        $idSubAlternativa2 = $this->model->insertSubAlternativa($datos2);

        $respuestaJson = array(
                                "fila" => $idSubPregunta ,
                                "columna" => array("uno" => $idSubAlternativa1 ,"dos" =>$idSubAlternativa2)
        );

        echo $this->responseMessageContenido($respuestaJson);

    }

    public function updateSubPreguntaNombre()
    {

        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $datos = compact("id", "nombre");
        $respuesta = $this->model->updateSubPreguntaNombre($datos);

        echo $this->responseMessage($respuesta);
    }

    public function updateSubAlternativaPreguntaNombre()
    {

        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $datos = compact("id", "nombre");
        $respuesta = $this->model->updateSubAlternativaPreguntaNombre($datos);

        echo $this->responseMessage($respuesta);
    }

    public function insertSubPreguntaFila(){

        $nombre = 'Fila';
        $idPregunta = $_POST['idPregunta'];
        $puntaje = 0;

        $datos = compact("nombre", "idPregunta", "puntaje");
        $idSubPregunta = $this->model->insertSubPregunta($datos);

        
        foreach ($_POST['listaAlternativa'] as $valor){
    
            $nombre = 'Columna';
            $respuesta = 0;
            $dato = compact("nombre", "idSubPregunta", "respuesta");
            $this->model->insertSubAlternativa($dato);
    
        }

        echo $this->responseMessageContenido($idSubPregunta);


    }


    public function insertSubPreguntaColumna(){

        
        foreach ($_POST['listaAlternativa'] as $valor){
    
            $idSubPregunta = $valor;
            $nombre = 'Columna';
            $respuesta = 0;
            $dato = compact("nombre", "idSubPregunta", "respuesta");
            $this->model->insertSubAlternativa($dato);
    
        }

        echo $this->responseMessageContenido($idSubPregunta);


    }

    
    public function insertExamenPuesto(){

        $id_examen = $_POST['id_examen'];
        $id_puesto_trabajo = $_POST['id_puesto_trabajo'];

        $datos = compact("id_examen", "id_puesto_trabajo");

        $resultado = $this->model->insertExamenPuesto($datos);
        echo $this->responseMessage($resultado);


    }

    
    public function getListExamenPuesto(){

        $id_examen = $_POST['id_examen'];

        $resultado = $this->model->getListExamenPuesto($id_examen);
        echo $this->responseMessageContenido($resultado);


    }


    public function getListPuesto(){

        $resultado = $this->model->getListPuesto();
        echo $this->responseMessageContenido($resultado);


    }

    
    public function deleteExamenPuesto()
    {

        $id_examen = $_POST['id_examen'];
        $id_puesto_trabajo = $_POST['id_puesto_trabajo'];

        $datos = compact("id_examen", "id_puesto_trabajo");

        $respuesta = $this->model->deleteExamenPuesto($datos);

        echo $this->responseMessage($respuesta);
    }


    public function responseMessage($value)
    {
        if ($value) {
            $return["status"] = 200;
            $return["contenido"] = "ok";
        } else {

            $return["status"] = 404;
            $return["contenido"] = "Problemas en nuestros servicios";
        }

        header('Content-Type: application/json');
        return json_encode($return);
    }

    public function responseMessageContenido($value)
    {
        if ($value != null) {
            $return["status"] = 200;
            $return["contenido"] = $value;
        } else {

            $return["status"] = 404;
            $return["contenido"] = "Problemas en nuestros servicios";
        }

        header('Content-Type: application/json');
        return json_encode($return);
    }
}
