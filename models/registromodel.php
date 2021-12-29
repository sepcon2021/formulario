<?php

require_once 'models/curso.php';

class RegistroModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

 
    public function insertResgistro($registro)
    {
        try {

            $conexion_bbdd = $this->db->connect();

            $query = $conexion_bbdd->prepare('INSERT INTO registro (idExamen,dni,idarea,respuestaTemperatura,respuestaTemperaturaHoy,nota,comentario,firma)
                                                        VALUES (:idExamen,:dni,:idarea,:respuestaTemperatura,:respuestaTemperaturaHoy,:nota,:comentario,:firma)');

            $query->execute([
                'idExamen' => $registro['idExamen'],
                'dni' => $registro['dni'],
                'idarea' => $registro['idarea'],
                'respuestaTemperatura' => null,
                'respuestaTemperaturaHoy' =>null,
                'nota' => $registro['nota'],
                'comentario' => null,
                'firma' => $registro['firma']
            ]);

            //EXTRAEMOS EL ID DEL INSERT QUE REALZIAMOS
            // comentario 69 https://www.php.net/manual/en/pdo.lastinsertid.php

            $last_insert_id = $conexion_bbdd->lastInsertId();

            return $last_insert_id;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }


    public function insertCuestionario($registro)
    {
        try {

            $conexion_bbdd = $this->db->connect();

            $query = $conexion_bbdd->prepare('INSERT INTO cuestionario (idExamen,pregunta1,pregunta2,pregunta3,pregunta4,pregunta5,pregunta6,pregunta7,pregunta8)
                                                        VALUES (:idExamen,:pregunta1,:pregunta2,:pregunta3,:pregunta4,:pregunta5,:pregunta6,:pregunta7,:pregunta8)');

            $query->execute([
                
                'idExamen' => $registro['idExamen'],
                'pregunta1' => $registro['pregunta1'],
                'pregunta2' => $registro['pregunta2'],
                'pregunta3' => $registro['pregunta3'],
                'pregunta4' => $registro['pregunta4'],
                'pregunta5' => $registro['pregunta5'],
                'pregunta6' => $registro['pregunta6'],
                'pregunta7' => $registro['pregunta7'],
                'pregunta8' => $registro['pregunta8']

            ]);

            //EXTRAEMOS EL ID DEL INSERT QUE REALZIAMOS
            // comentario 69 https://www.php.net/manual/en/pdo.lastinsertid.php

            $last_insert_id = $conexion_bbdd->lastInsertId();

            return $last_insert_id;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }



    public function insertRespuesta($listaRespuestas,$idExamen)
    {
        try {

            $conexion_bbdd = $this->db->connect();

            $query = $conexion_bbdd->prepare('INSERT INTO respuesta (idRegistro,alternativa,idPregunta)
                                                        VALUES (:idRegistro,:alternativa,:idPregunta)');


            foreach($listaRespuestas as $respuesta) {
                $query->bindParam(':idRegistro', $idExamen, PDO::PARAM_INT);
                $query->bindParam(':alternativa',$respuesta->respuesta, PDO::PARAM_INT);
                $query->bindParam(':idPregunta',$respuesta->idPregunta, PDO::PARAM_INT);
                $query->execute();
            }


            return true;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function updateRegistroUrlPDF($registro){
        try {

            $conexion_bbdd = $this->db->connect();

            $query = $conexion_bbdd->prepare('UPDATE registro 
                                                SET url_pdf = :url_pdf
                                                WHERE idExamen =:idExamen AND dni =:dni ');

            $query->execute([
                'idExamen' => $registro['idExamen'],
                'dni' => $registro['dni'],
                'url_pdf' => $registro['urlPdf']
            ]);

            return true;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }



    public function updateResgistro($registro)
    {
        try {

            $conexion_bbdd = $this->db->connect();

            $query = $conexion_bbdd->prepare('UPDATE registro 
                                                SET idarea = :idarea ,
                                                    respuestaTemperatura =:respuestaTemperatura,
                                                    respuestaTemperaturaHoy =:respuestaTemperaturaHoy,

                                                    nota =:nota ,
                                                    comentario = :comentario ,
                                                    firma =:firma 
                                                WHERE dni =:dni AND 
                                                     idExamen =:idExamen ');

            $query->execute([
                'idExamen' => $registro['idExamen'],
                'dni' => $registro['dni'],
                'idarea' => $registro['idarea'],
                'respuestaTemperatura' => null,
                'respuestaTemperaturaHoy' => null,
                'nota' => $registro['nota'],
                'comentario' => null,
                'firma' => $registro['firma']
            ]);

            return true;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }


    public function updateRespuesta($listaRespuestas,$idRegistro)
    {
        try {

            $conexion_bbdd = $this->db->connect();

            $query = $conexion_bbdd->prepare('UPDATE respuesta SET  alternativa = :alternativa WHERE  idPregunta =:idPregunta AND idRegistro = :idRegistro');


            foreach($listaRespuestas as $respuesta) {
                $query->bindParam(':alternativa',$respuesta->respuesta, PDO::PARAM_INT);
                $query->bindParam(':idPregunta',$respuesta->idPregunta, PDO::PARAM_INT);
                $query->bindParam(':idRegistro',$idRegistro, PDO::PARAM_INT);

                $query->execute();
            }


            return true;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }


    public function verificarRegistro($dni,$idExamen)
    {

        $idRegistro=0;

        try {

            $query = $this->db->connect()->prepare("SELECT id FROM registro WHERE dni = :dni AND idExamen = :idExamen");


            $query->execute(['dni'  => $dni , 'idExamen' => $idExamen]);
            
            while($row = $query->fetch()){
                $idRegistro = $row['id'];
            }


            return $idRegistro;

        } catch (PDOexception $e) {
            echo $e->getMessage();
            return false;
        }
    }




    public function findByIdCursoAndDni($idExamen,$dni)
    {
        try {
            $curso=new Curso;


            $query = $this->db->connect()->query("SELECT 
            rrhh.tabla_aquarius.dni,
            CONCAT(rrhh.tabla_aquarius.nombres,'',rrhh.tabla_aquarius.apellidos) AS nombres_apellidos,
            rrhh.tabla_aquarius.correo,
            IF(rrhh.tabla_aquarius.corporativo IS NULL ,'',rrhh.tabla_aquarius.corporativo) AS correo_corporativo,
            rrhh.tabla_aquarius.dcargo AS cargo,
            registro.nota AS notaExamen,
	        examen.nota AS notaAprobatoria,
            examen.tema AS tema_examen,
            examen.fecha AS fecha_examen,
            examen.correo AS enviarCorreo,
            examen.horas_capacitadas AS horasCapacitadas,
            proyecto.nombre AS nombre_proyecto,
            registro.firma AS firma_trabajador,
            registro.id AS idregistro
            
            FROM 
            
            registro INNER JOIN rrhh.tabla_aquarius  ON registro.dni = rrhh.tabla_aquarius.dni
                                INNER JOIN examen ON  registro.idExamen = examen.id 
                                INNER JOIN proyecto ON examen.idProyecto = proyecto.id
            WHERE
            
            examen.id = '$idExamen' AND registro.dni = '$dni'");

            while($row = $query->fetch()){
                $curso->dni = $row['dni'];
                $curso->nombresApellidos = $row['nombres_apellidos'];
                $curso->correo = $row['correo'];
                $curso->correoCorporativo = $row['correo_corporativo'];
                $curso->cargoTrabajador = $row['cargo'];
                $curso->temaExamen = $row['tema_examen'];
                $curso->fechaExamen = $row['fecha_examen'];
                $curso->nombreProyecto = $row['nombre_proyecto'];
                $curso->notaExamen = $row['notaExamen'];
                $curso->notaAprobatoria = $row['notaAprobatoria'];
                $curso->enviarCorreo = $row['enviarCorreo'];
                $curso->firmaTrabajador = $row['firma_trabajador'];
                $curso->idRegistro = $row['idregistro'];
                $curso->horasCapacitadas = $row['horasCapacitadas'];

            }

            return $curso;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    
}
