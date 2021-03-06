<?php

require_once 'public/email/email.php';
require_once 'public/generate-pdf/generatepdf.php';

class Registro extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function render()
    {
        $this->view->render('registro/index');
    }


    public function insertExamen()
    {

        $registro = json_decode($_POST['data'])[0];


        $idExamen = $registro->idexamen;
        $dni = $registro->dni;
        $idarea = $registro->idarea;
        $nota = $registro->nota;
        $firma = $registro->firma;
        $listaRespuestas = $registro->listaRespuestas;

        $datos = compact("idExamen", "dni", "idarea", "nota", "firma");

        $idRegistro = $this->model->insertResgistro($datos);
        $respuesta=$this->model->insertRespuesta($listaRespuestas,$idRegistro);

        $this->enviarCertificado($idExamen,$dni);

        echo $this->responseMessage($respuesta);

    }

    public function enviarPrueba(){
        $idExamen = $_POST['idExamen'];
        $dni = $_POST['dni'];

        $this->enviarCertificado($idExamen,$dni);
    }


    public function enviarCertificado($idExamen,$dni){

        $curso = $this->model->findByIdCursoAndDni($idExamen,$dni);
        if($curso->enviarCorreo == 1){
            $urlPdf = $this->generarCertificado($curso);
            $this->updateRegistroUrlPDF($idExamen,$dni,$urlPdf);
            $this->enviarCorreo($curso,$urlPdf);
        }
    }

    public function enviarCorreo($curso,$urlPdf){

        $email = new Email;
        $email->enviarNotificacionAsignado($curso,$urlPdf);
    }


    public function generarCertificado($curso){

        $urlPdf = null;

        if($curso->notaExamen > $curso->notaAprobatoria){
            $pdf = new GeneratePDF;
            $urlPdf = $pdf->generateCertificate($curso);

        }

        return $urlPdf;
    }

    public function updateRegistroUrlPDF($idExamen,$dni,$urlPdf){

        $idExamen = $idExamen;
        $dni = $dni;
        $urlPdf = $urlPdf;

        $datos = compact("idExamen","dni", "urlPdf");

        $this->model->updateRegistroUrlPDF($datos);

    }


    public function updateExamen()
    {

        $registro = json_decode($_POST['data'])[0];


        $idExamen = $registro->idexamen;
        $dni = $registro->dni;
        $idarea = $registro->idarea;
        $nota = $registro->nota;
        $firma = $registro->firma;
        $listaRespuestas = $registro->listaRespuestas;

        $datos = compact("idExamen", "dni", "idarea","nota","firma");
        $registro = $this->model->verificarRegistro($dni,$idExamen);

        $this->model->updateResgistro($datos);

        $respuesta = $this->model->updateRespuesta($listaRespuestas,$registro);

        //Enviar el certificado del trabajador en caso apruebe el examen
        $this->enviarCertificado($idExamen, $dni);

        echo $this->responseMessage($respuesta);
    }

    public function verificarRegistro()
    {

        $idExamen  = $_POST['idExamen'];

        $dniTrabajador  = $_POST['dniTrabajador'];
        
        $respuesta =  $this->model->verificarRegistro($dniTrabajador,$idExamen);

        echo $this->responseMessageContenido($respuesta);

    }

    public function insertCuestionario()
    {

        $idExamen  = $_POST['idExamen'];

        $pregunta1  = isset($_POST['pregunta1']) ? $_POST['pregunta1'] : '0';
        $pregunta2  = isset($_POST['pregunta2']) ? $_POST['pregunta2'] : '0';
        $pregunta3  = isset($_POST['pregunta3']) ? $_POST['pregunta3'] : '0';
        $pregunta4  = isset($_POST['pregunta4']) ? $_POST['pregunta4'] : '0';
        $pregunta5  = isset($_POST['pregunta5']) ? $_POST['pregunta5'] : '0';
        $pregunta6  = isset($_POST['pregunta6']) ? $_POST['pregunta6'] : '0';
        $pregunta7  = isset($_POST['pregunta7']) ? $_POST['pregunta7'] : '0';
        $pregunta8  = isset($_POST['pregunta8']) ? $_POST['pregunta8'] : '0';

        $datos = compact("idExamen","pregunta1","pregunta2","pregunta3","pregunta4","pregunta5","pregunta6","pregunta7","pregunta8");

        $respuesta =  $this->model->insertCuestionario($datos);

         echo $this->responseMessageContenidoID($respuesta);

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
        if ($value ==  0) {
            $return["status"] = 200;
            $return["contenido"] = $value;

        } else {

            $return["status"] = 404;
            $return["contenido"] = "Problemas en nuestros servicios";

        }

        header('Content-Type: application/json');
        return json_encode($return);
    }

    public function responseMessageContenidoID($value)
    {
        if ($value > 0) {
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
