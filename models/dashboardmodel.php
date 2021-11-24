<?php

require_once 'models/examenDetalle.php';
require_once 'models/pregunta.php';
require_once 'models/alternativa.php';
require_once 'models/examen.php';


class DashboardModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }




    public function listaExamenByFecha($data)
    {
        try {
            $listaExamenDetalle=array();

            
            $codigoproyecto = $data['codigoproyecto'];
            $codigoTrabajador = $data['codigoTrabajador'];

            $query = $this->db->connect()->query("SELECT
            DISTINCT(tipo) AS tipo, 
            id,
            tema,
            fecha,
            areaEmpresa,nombre_trabajo,notaExamen
            
            FROM 
            examenDetalle   WHERE  estado = 1 AND idproyecto = '$codigoproyecto' AND id_puesto_trabajo = '$codigoTrabajador' ORDER BY fecha ASC");

            while($row = $query->fetch()){
                $modelExamenDetalle=new ExamenDetalle;
                $modelExamenDetalle->id=$row['id'];
                $modelExamenDetalle->tema=$row['tema'];
                $modelExamenDetalle->fecha=$row['fecha'];
                $modelExamenDetalle->tipoNombre=$row['tipo'];
                $modelExamenDetalle->areaEmpresa = $row['areaEmpresa'];
                $modelExamenDetalle->nota = $row['notaExamen'];
                array_push($listaExamenDetalle,$modelExamenDetalle);
                
            }

            return $listaExamenDetalle;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }


}
