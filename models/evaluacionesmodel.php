<?php


require_once 'models/evaluacion.php';

require_once 'models/examenDetalle.php';

require_once 'models/respuesta.php';

require_once 'models/pregunta.php';

require_once 'models/nota.php';

class EvaluacionesModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }





    public function getExamenDetalleById($id)
    {

        $examen=new ExamenDetalle();

        try {
            $query = $this->db->connect()->query("SELECT 
            id,
            idareaempresa,
            proyecto,
            fase,
            facilitador,
            cliente,
            fecha,
            duracion,
            idTipo,
            tipo,
            tema,
            horaInicio,
            horaFin,
            duracionProgramada,
            duracionEfectiva,
            idCurso,
            curso,
            idAreaCapacitacion,
            areaCapacitacion,
            detalle,
            nota,
            estado,
            registro,
            observacion,
            finalizo,
            continuara,
            fechaContinuacion,
            temarioA,
            temarioB,
            firmaFacilitador
        
            FROM 
            
            examenDetalle
            
            WHERE
            
            examenDetalle.id = '$id' ");

            while ($row = $query->fetch()) {

                $examen->id=$row['id'];
                $examen->proyecto=$row['proyecto'];
                $examen->fase=$row['fase'];
                $examen->facilitador=$row['facilitador'];
                $examen->cliente=$row['cliente'];
                $examen->fecha=$row['fecha'];
                $examen->duracion=$row['duracion'];
                $examen->idTipo=$row['idTipo'];
                $examen->tipo=$row['tipo'];
                $examen->tema=$row['tema'];
                $examen->horaInicio=$row['horaInicio'];
                $examen->horaFin=$row['horaFin'];
                $examen->duracionProgramada=$row['duracionProgramada'];
                $examen->duracionEfectiva=$row['duracionEfectiva'];
                $examen->idCurso=$row['idCurso'];
                $examen->curso=$row['curso'];
                $examen->idAreaCapacitacion=$row['idAreaCapacitacion'];
                $examen->areaCapacitacion=$row['areaCapacitacion'];
                $examen->detalle=$row['detalle'];
                $examen->nota=$row['nota'];
                $examen->estado=$row['estado'];
                $examen->registro=$row['registro'];

                $examen->observacion=$row['observacion'];
                $examen->finalizo=$row['finalizo'];
                $examen->continuara=$row['continuara'];
                $examen->fechaContinuacion=$row['fechaContinuacion'];
                $examen->temarioA=$row['temarioA'];
                $examen->temarioB=$row['temarioB'];
                $examen->areaEmpresa = $row['idareaempresa'];

                $examen->firmaFacilitador=$row['firmaFacilitador'];

                $examen->listaEvaluacion = $this->getListaEvaluacionByIdExamen($id);


            }

            return $examen;

        } catch (PDOexception $e) {
            echo $e->getMessage();
            return false;
        }
    }


    
        
    public function getListaEvaluacionByIdExamen($idExamen)
    {

        $listaEvaluacion = array();

        try {
            $query = $this->db->connect()->query("SELECT 

            formulario.registro.id,
            CONCAT(rrhh.tabla_aquarius.nombres,' ',rrhh.tabla_aquarius.apellidos) AS nombresApellidos ,
            rrhh.tabla_aquarius.dcargo AS cargoTrabajador ,
            formulario.registro.dni,
            formulario.registro.firma  AS firma     
   
            FROM 
   
            formulario.registro INNER JOIN rrhh.tabla_aquarius ON formulario.registro.dni=rrhh.tabla_aquarius.dni
   
            WHERE formulario.registro.idExamen=$idExamen ");

            while ($row = $query->fetch()) {


                $modelEvaluacion = new Evaluacion();
                
                $modelEvaluacion->id=$row['id'];
                $modelEvaluacion->nombresApellidos=$row['nombresApellidos'];
                $modelEvaluacion->cargoTrabajador=$row['cargoTrabajador'];
                $modelEvaluacion->firma=$row['firma'];

                array_push($listaEvaluacion, $modelEvaluacion);


            }
            return $listaEvaluacion;

        } catch (PDOexception $e) {
            echo $e->getMessage();
            return false;
        }
    }






    // Extraer todos los registros de los examenes que rindieron los trabajadores
    public function getListaRegistroByIdExamen($idExamen)
    {

        $listaEvaluacion = array();

        try {
            $query = $this->db->connect()->query("SELECT 

            formulario.registro.id,
            formulario.registro.dni,
            CONCAT(rrhh.tabla_aquarius.nombres,' ',rrhh.tabla_aquarius.apellidos) AS nombresApellidos ,
            rrhh.tabla_aquarius.dcargo AS cargoTrabajador ,
            formulario.registro.respuestaTemperatura,
            formulario.registro.respuestaTemperaturaHoy,
            formulario.registro.comentario,
            formulario.registro.nota,
            formulario.registro.firma  AS firma     
   
            FROM 
   
            formulario.registro INNER JOIN rrhh.tabla_aquarius ON formulario.registro.dni=rrhh.tabla_aquarius.dni
   
            WHERE formulario.registro.idExamen=$idExamen ");

            while ($row = $query->fetch()) {


                $modelEvaluacion = new Evaluacion();
                 
                $modelEvaluacion->id=$row['id'];
                $modelEvaluacion->dni=$row['dni'];
                $modelEvaluacion->nombresApellidos=$row['nombresApellidos'];
                $modelEvaluacion->cargoTrabajador=$row['cargoTrabajador'];
                $modelEvaluacion->respuestaTemperatura=$row['respuestaTemperatura'];
                $modelEvaluacion->respuestaTemperaturaHoy=$row['respuestaTemperaturaHoy'];
                $modelEvaluacion->comentario=$row['comentario'];
                $modelEvaluacion->nota=$row['nota'];
                $modelEvaluacion->firma=$row['firma'];
                $modelEvaluacion->listaAlternativa = $this->getListaEvaluacionByIdRegistro($row['id']);

                array_push($listaEvaluacion, $modelEvaluacion);


            }
            return $listaEvaluacion;

        } catch (PDOexception $e) {
            echo $e->getMessage();
            return false;
        }
    }
 


    public function getListaEvaluacionByIdRegistro($idRegistro)
    {

        $listaRespuestas = array();

        try {
            $query = $this->db->connect()->query("SELECT alternativa,idPregunta FROM respuesta WHERE idRegistro = $idRegistro ");

            while ($row = $query->fetch()) {


                $modelRespuesta = new Respuesta();
                
                $modelRespuesta->alternativa = $row['alternativa'];
                $modelRespuesta->idPregunta = $row['idPregunta'];
                

                array_push($listaRespuestas, $modelRespuesta);


            }
            return $listaRespuestas;

        } catch (PDOexception $e) {
            echo $e->getMessage();
            return false;
        }
    }


    
    public function getExamenPreguntasDetalleById($id)
    {

        $examen=new ExamenDetalle();

        try {
            $query = $this->db->connect()->query(" SELECT 
            id,
            proyecto,
            fase,
            facilitador,
            cliente,
            fecha,
            duracion,
            idTipo,
            tipo,
            tema,
            horaInicio,
            horaFin,
            duracionProgramada,
            duracionEfectiva,
            idCurso,
            curso,
            idAreaCapacitacion,
            areaCapacitacion,
            detalle,
            nota,
            estado,
            registro
        
            FROM 
            
            examenDetalle
            
            WHERE
            
            examenDetalle.id = '$id' ");

            while ($row = $query->fetch()) {

                $examen->id=$row['id'];
                $examen->proyecto=$row['proyecto'];
                $examen->fase=$row['fase'];
                $examen->facilitador=$row['facilitador'];
                $examen->cliente=$row['cliente'];
                $examen->fecha=$row['fecha'];
                $examen->duracion=$row['duracion'];
                $examen->idTipo=$row['idTipo'];
                $examen->tipo=$row['tipo'];
                $examen->tema=$row['tema'];
                $examen->horaInicio=$row['horaInicio'];
                $examen->horaFin=$row['horaFin'];
                $examen->duracionProgramada=$row['duracionProgramada'];
                $examen->duracionEfectiva=$row['duracionEfectiva'];
                $examen->idCurso=$row['idCurso'];
                $examen->curso=$row['curso'];
                $examen->idAreaCapacitacion=$row['idAreaCapacitacion'];
                $examen->areaCapacitacion=$row['areaCapacitacion'];
                $examen->detalle=$row['detalle'];
                $examen->nota=$row['nota'];
                $examen->estado=$row['estado'];
                $examen->registro=$row['registro'];
                $examen->listaPreguntas = $this->getListaPreguntas($id);


            }

            return $examen;

        } catch (PDOexception $e) {
            echo $e->getMessage();
            return false;
        }
    }




    public function getListaPreguntas($idExamen)
    {

        $listaPreguntas = array();

        try {
            $query = $this->db->connect()->query("SELECT id,nombre,respuesta,puntaje FROM pregunta WHERE idExamen = $idExamen");

            while ($row = $query->fetch()) {


                $pregunta = new Pregunta();
                $pregunta->id=$row['id'];
                $pregunta->nombre = $row['nombre'];
                $pregunta->respuesta   = $row['respuesta'];
                $pregunta->puntaje    = $row['puntaje'];
                

                array_push($listaPreguntas, $pregunta);


            }
            return $listaPreguntas;

        } catch (PDOexception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function listaNotas($idExamen,$codigoProyecto){
        
        $listaNotas = array();

        try {

            $query = $this->db->connect()->query(" SELECT 
            CONCAT(rrhh.tabla_aquarius.nombres,rrhh.tabla_aquarius.apellidos) AS nombres_apellidos,
            rrhh.tabla_aquarius.dni,
            rrhh.tabla_aquarius.dcargo,
                rrhh.tabla_aquarius.dcostos,
            if(formularioFiltrado.nota IS NOT null , 'Si','No') AS examen,
            if(formularioFiltrado.nota IS NOT null , formularioFiltrado.nota , 'NR' ) AS nota,
                formularioFiltrado.fecha,
                formularioFiltrado.comentario
            
            FROM  rrhh.tabla_aquarius LEFT JOIN (SELECT * FROM formulario.registro WHERE formulario.registro.idExamen = $idExamen) AS formularioFiltrado ON rrhh.tabla_aquarius.dni = formularioFiltrado.dni 
          
          WHERE rrhh.tabla_aquarius.ccostos = '$codigoProyecto' AND rrhh.tabla_aquarius.estado = 'AC'   ORDER BY rrhh.tabla_aquarius.dni DESC ");

            while ($row = $query->fetch()) {
                $nota = new Nota();
                $nota->nombresApellidos=$row['nombres_apellidos'];
                $nota->dni=$row['dni'];
                $nota->nombreCargo=$row['dcargo'];
                $nota->nombeCostos=$row['dcostos'];
                $nota->examen=$row['examen'];
                $nota->nota=$row['nota'];
                $nota->fecha=$row['fecha'];
                $nota->comentario = $row['comentario'];

                array_push($listaNotas,$nota);
            }

            return $listaNotas;

        } catch (PDOexception $e) {
            echo $e->getMessage();
            return false;
        }
    }



    public function listaNotasSGI($idExamen){
        
        $listaNotas = array();

        try {
            $query = $this->db->connect()->query(" 		SELECT 
            formulario.registro.id, 
            CONCAT(rrhh.tabla_aquarius.nombres,rrhh.tabla_aquarius.apellidos) AS nombres_apellidos,
            rrhh.tabla_aquarius.dni,
            rrhh.tabla_aquarius.dcargo,
                rrhh.tabla_aquarius.dcostos,
            if(formulario.registro.nota IS NOT null , 'Si','No') AS examen,
            if(formulario.registro.nota IS NOT null , formulario.registro.nota , 'NR' ) AS nota,
                formulario.registro.fecha,
                formulario.registro.comentario
            
            FROM  rrhh.tabla_aquarius INNER JOIN  formulario.registro ON rrhh.tabla_aquarius.dni = formulario.registro.dni 
          
          WHERE formulario.registro.idExamen = $idExamen ");

            while ($row = $query->fetch()) {
                $nota = new Nota();
                $nota->id = $row['id'];
                $nota->nombresApellidos=$row['nombres_apellidos'];
                $nota->dni=$row['dni'];
                $nota->nombreCargo=$row['dcargo'];
                $nota->nombeCostos=$row['dcostos'];
                $nota->examen=$row['examen'];
                $nota->nota=$row['nota'];
                $nota->fecha=$row['fecha'];
                $nota->comentario = $row['comentario'];
                $nota->listaRespuesta = $this->listaRespuesta($row['id']);

                array_push($listaNotas,$nota);
            }

            return $listaNotas;

        } catch (PDOexception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function listaRespuesta($idRegistro){
        
        $listaPreguntas = array();

        try {
            $query = $this->db->connect()->query("SELECT  formulario.respuesta.alternativa , formulario.tipo_pregunta.id AS idTipoPregunta, formulario.tipo_pregunta.nombre nombreTipoPregunta
            FROM  formulario.respuesta INNER JOIN formulario.pregunta ON formulario.respuesta.idPregunta = formulario.pregunta.id
								INNER JOIN formulario.tipo_pregunta ON formulario.pregunta.idtipopregunta = formulario.tipo_pregunta.id
            WHERE formulario.respuesta.idRegistro = $idRegistro ");

            while ($row = $query->fetch()) {
            
                $pregunta = array(
                                "alternativa" =>$row['alternativa'],
                                "idTipoPregunta" => $row['idTipoPregunta'],
                                "nombreTipoPregunta" => $row['nombreTipoPregunta']);

                array_push($listaPreguntas,$pregunta);
            }

            return $listaPreguntas;

        } catch (PDOexception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    
}
