<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class pregunta extends CI_Controller{

    function __construct(){
        parent::__construct();     
        $this->CI =& get_instance();
         $this->load->model('preguntamodel');
         $this->load->model('VerEncuestaModel');
    }

    function index(){       
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else {
            //$data['Pre'] = $this->preguntamodel->TPreguntas();
            $data['Enc'] = $this->preguntamodel->TEncuesta();
            $this->load->view('encuesta/encabezadoencuesta',$data);        
             //$this->load->view('encuesta/pregunta',$data);
//$this->load->view('encuesta');
        }
    }/*! index */
    function VistaEncuesta(){
        
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } 
        else 
        {
             
             //$data['Pre'] = $this->preguntamodel->TPreguntas();            
             $data['Enc'] = $this->preguntamodel->TEncuesta();
            $this->load->view('encuesta/encabezadoencuesta',$data);        
            
        }
    } 
    /************************** */
    //hrcm 10-10-2022
    function updateTitulo()// Modificado [2024-01-03]
    {
      $idencuesta= $_POST['idencuesta'];
      $titulo =$_POST['titulo'];
      $consulta = "update cabencuesta set descripcion ='".$titulo."' where idcabencuesta = ".$idencuesta;
      $result = $this->db->query($consulta);
      echo json_encode($result);
    }
    //hrcm 11-07-2022
    /********************************************* */
    function verificaNps()
    {
      $idencuesta= $_POST['idencuesta'];
      $pregunta =$_POST['pregunta'];
      $consulta = "select tipo from cabencuesta where idcabencuesta = ".$idencuesta;
      $valor = $this->db->query($consulta)->result();
      $total = 0;
      if($valor[0]->tipo == 1)
      {
        $consulta = "select count(*) as total from pregunta where idcabencuesta = ".$idencuesta." and nps='".$pregunta."'";
        $total = $this->db->query($consulta)->result()[0]->total;
      }
   
  
      echo json_encode($total);
    }
    /**************************************** */
  function grabaEncuestaurl(){
    $idencuesta= $_POST['strvalor'];
    $encuesta =json_decode($_POST['encuesta']);
    $correo= $_POST['correo'];
    $nombre= $_POST['nombre'];
  //  echo json_encode($encuesta);
    $sqlcadena = "INSERT INTO `calificaencuesta` ( `idencuesta`, `calificacion`, `usuario`, `idusuario`, `activa`, `cliente`,`fechacontesta`)
     VALUES (".$idencuesta.", 0,'".$nombre." / ".$correo."', 0, 1, 1,current_date)";
    $this->db->query($sqlcadena);
    $idcalifica = $this->db->insert_id(); 
    $respuesta = 0;
    $buenas = 0;
    $entro =0;
    foreach ($encuesta as $row)
    {
      $sqlcadena = "INSERT INTO `encuesta` ( `idcabencuesta`, `tipo`, `pregunta`, `respuesta`, `fecha`, `idusuario`, `respuestausuario`, `npsencuesta`)
       VALUES ( ${idcalifica},".$row->tipo.",'".$row->pregunta."','".$row->respuesta."', current_date, 0, '".$row->valorRespuesta."','".$row->nps."')";
       $this->db->query($sqlcadena);
       $respuesta ++;
       if($row->tipo == 0)
       {
         $entro =1;
         if($row->respuesta === $row->valorRespuesta)
         {
          $buenas++;
         }
       }
       if($row->tipo ==1)
       {
         $entro =2;
         $buenas =$buenas+ ($row->respuesta*10);

         /*if($row->respuesta === $row->valorRespuesta)
         {
          $buenas++;
         }*/
       }
    }
   if($entro ==1)
   {
    $buenas = ($buenas* 100)/ $respuesta;
    $sqlcadena = "update calificaencuesta set calificacion = ".$buenas." where idcalificaencuesta = ".$idcalifica;
    $this->db->query($sqlcadena);
   }
   if($entro ==2)
   {
    $buenas = ($buenas)/ $respuesta;
    $sqlcadena = "update calificaencuesta set calificacion = ".$buenas." where idcalificaencuesta = ".$idcalifica;
    $this->db->query($sqlcadena);
   }
    echo json_encode('listo');
  }
    /*********************** */
function getdata(){
        //$idencues = $this->input->get('IdEncuesta');
             //$id = $this->input->get('IdEncuesta');
              $cuenta=$_POST['cuenta'];
            //  $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($cuenta, TRUE));fclose($fp); 
               $sqlInsert_Referencia = "
                         select * from netscore";
  // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($sqlInsert_Referencia, TRUE));fclose($fp); 
             $datos = $this->db->query($sqlInsert_Referencia)->result();
            //  $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos, TRUE));fclose($fp); 
     $responce->cols[] = array( 
            "id" => "", 
            "label" => "Topping", 
            "pattern" => "", 
            "type" => "string" 
        ); 
        $responce->cols[] = array( 
            "id" => "", 
            "label" => "Total", 
            "pattern" => "", 
            "type" => "number" 
        ); 
        foreach($datos as $cd) 
            { 
            $responce->rows[]["c"] = array( 
                array( 
                    "v" => "$cd->nombre", 
                    "f" => null 
                ) , 
                array( 
                    "v" => "$cd->valor", 
                    "f" => null 
                ) 
            ); 
            } 
       //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($responce, TRUE));fclose($fp);   
        echo json_encode($responce); 
       // }              
         
 //return $datos;
}
       
function ReporteEncuesta(){
        
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } 
        else 
        {
           if($this->input->get('IdEncuesta',TRUE))
           { 
             $idencues = $this->input->get('IdEncuesta');
             //$id = $this->input->get('IdEncuesta');
             /*$sqlInsert_Referencia = "
                         select if(calificacion < 70,calificacion,0.00) as detractor,
                         if(calificacion >= 70 and calificacion < 90,calificacion,0.00) as pasivo,
                         if(calificacion >= 90,calificacion,0.00) as promoter
                         from
                            `calificaencuesta` where
                                        `activa` = 1 and 
                                        `idencuesta` ='".$idencues."'                                       
                                                                      ";
             $data['netpros'] = $this->db->query($sqlInsert_Referencia);
             $data['iden']= $idencues;*/
             $sqlInsert_Referencia = "select sum(if(calificacion <70,1,0))/(select count(*) from pregunta p where p.idcabencuesta=".$idencues.") as detractor,sum(if(calificacion >= 70 and calificacion < 90,1,0))/(select count(*) from pregunta p where p.idcabencuesta=".$idencues.") as pasivo,
             sum(if(calificacion >= 90,1,0 ))/(select count(*) from pregunta p where p.idcabencuesta=".$idencues.") as promoter
              from calificaencuesta cf,encuesta ec
              where cf.idencuesta= ".$idencues." and cf.idcalificaencuesta = ec.idcabencuesta
             and activa =1
           ";
             $sqlInsert_Referencia = "select count(idencuesta) AS numero
                         from calificaencuesta where  idencuesta = '".$idencues."'  and activa =1
                        and   calificacion <  70";
             $detractor = $this->db->query($sqlInsert_Referencia)->result();      
             $data['resul'] = $detractor;  
             foreach($detractor as $row)
             {
               $detra = $row->detractor;
               $pas = $row->pasivo;
               $pas = $row->promoter;
             }
             //$detra = $detractor['numero'];
             //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($detractor, TRUE));fclose($fp);        
             /*$sqlInsert_Referencia = "select count(idencuesta) AS numero
                         from calificaencuesta where  idencuesta = '".$idencues."'  and activa =1
                        and  calificacion  >= 70 and calificacion < 90";
             $pasivo = $this->db->query($sqlInsert_Referencia)->result(); 
             foreach($pasivo as $row)
             {
               $pas = $row->numero;
             } 
             //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($pas, TRUE));fclose($fp);           
              $sqlInsert_Referencia = "select count(idencuesta) AS numero
                         from calificaencuesta where  idencuesta = '".$idencues."'  and activa =1
                        and   calificacion  >= 90";
             $promotor = $this->db->query($sqlInsert_Referencia)->result();           
             //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($pasivo->numero, TRUE));fclose($fp);            
             foreach($promotor as $row)
             {
               $promo = $row->numero;
             } 
             $sqlInsert_Referencia = "delete from netscore";
             $this->db->query($sqlInsert_Referencia);   
           */
           // $valores = $this->db->query($sqlInsert_Referencia)->result();                                                        
                   $sqlInsert_Referencia = "
                        Insert Ignore Into
                            `netscore` 
                                    (
                                      
                                        `nombre`,
                                        `valor`                                                                         
                                        ) 
                                    Values
                                    (

                                        'DETRACTOR',
                                        '".$detra."' 
                                    );
                                            ";
                $this->db->query($sqlInsert_Referencia);    
                     $sqlInsert_Referencia = "
                        Insert Ignore Into
                            `netscore` 
                                    (
                                      
                                        `nombre`,
                                        `valor`                                                                         
                                        ) 
                                    Values
                                    (

                                        'PASIVO',
                                        '".$pas."' 
                                    );
                                            ";
                $this->db->query($sqlInsert_Referencia);  
                     $sqlInsert_Referencia = "
                        Insert Ignore Into
                            `netscore` 
                                    (
                                      
                                        `nombre`,
                                        `valor`                                                                         
                                        ) 
                                    Values
                                    (

                                        'PROMOTOR',
                                        '".$promo."' 
                                    );
                                            ";
                $this->db->query($sqlInsert_Referencia);  
               $sqlInsert_Referencia = "
                         select * from netscore";
              $data['netpro']= $this->db->query($sqlInsert_Referencia)->result();  
               //  $data['netpro']= $idencues;                         
             //             
            // $data['netprosc'] = $this->preguntamodel->TPreguntas($this->input->get('IdEncuesta'));         
             $this->load->view('encuesta/reporteencuesta',$data);
           } 
        }
    }    
/****************************************** */
function ReporteEncuestaNps(){

       $idencues = $_POST['strvalor'] ;   
       $datos['res'] = $idencues;
       //tipo de encuesta 
       $sqlInsert_Referencia = "select tipoencuesta from cabencuesta where idcabencuesta =" .$idencues;
       $tipoen = $this->db->query($sqlInsert_Referencia)->result(); 
       $datos['cadena']=$tipoen;
         /*$sqlInsert_Referencia = "
                     select if(calificacion < 70,calificacion,0.00) as detractor,
                     if(calificacion >= 70 and calificacion < 90,calificacion,0.00) as pasivo,
                     if(calificacion >= 90,calificacion,0.00) as promoter
                     from
                        `calificaencuesta` where
                                    `activa` = 1 and 
                                    `idencuesta` ='".$idencues."'                                       
                                                                  ";*/
                                                                /*  $sqlInsert_Referencia = "                                                         
                                                                  select if(calificacion < 70,calificacion,0.00) as detractor,
                                                                  if(calificacion >= 70 and calificacion < 90,calificacion,0.00) as pasivo,
                                                                   if(calificacion >= 90,calificacion,0.00) as promoter
                                                                   from calificaencuesta cf
                                                                  left join encuesta e on e.idcabencuesta = cf.idcalificaencuesta
                                                                  where  respuestausuario =1 and cf.idencuesta  ='".$idencues."'                                       
                                                                  ";                                           */
                                                                 /* $sqlInsert_Referencia = "select sum(if(calificacion <70,1,0))/(select count(*) from pregunta p where p.idcabencuesta=".$idencues.") as detractor,sum(if(calificacion >= 70 and calificacion < 90,1,0))/(select count(*) from pregunta p where p.idcabencuesta=".$idencues.") as pasivo,
                                                                  sum(if(calificacion >= 90,1,0 ))/(select count(*) from pregunta p where p.idcabencuesta=".$idencues.") as promoter
                                                                   from calificaencuesta cf,encuesta ec
                                                                   where cf.idencuesta= ".$idencues." and cf.idcalificaencuesta = ec.idcabencuesta
                                                                  and activa =1
                                                                ";*/
                                                                $sqlInsert_Referencia = "select (sum(if(respuesta <7,1,0))/(select count(*) from calificaencuesta cf1 where cf1.activa =1 and cf1.idencuesta= ".$idencues."))*100  as detractor,
                                                                (sum(if(respuesta >= 7 and respuesta < 9,1,0))/(select count(*) from calificaencuesta cf1 where cf1.activa =1 and cf1.idencuesta= ".$idencues."))*100  as pasivo,
                                                                (sum(if(respuesta >= 9,1,0 ))/(select count(*) from calificaencuesta cf1 where cf1.activa =1 and cf1.idencuesta= ".$idencues."))*100 as promoter
                                                                from calificaencuesta cf,encuesta ec 
                                                               where 
                                                               cf.idencuesta = ".$idencues." and  activa = 1
                                                               and ec.idcabencuesta = cf.idcalificaencuesta
                                                               and npsencuesta='TIEMPOS'";
                                                                $datos['consulta'] =$sqlInsert_Referencia;
         $datos['npstiempos'] = $this->db->query($sqlInsert_Referencia)->result();
         $sqlInsert_Referencia = "select (sum(if(respuesta <7,1,0))/(select count(*) from calificaencuesta cf1 where cf1.activa =1 and cf1.idencuesta= ".$idencues."))*100  as detractor,
         (sum(if(respuesta >= 7 and respuesta < 9,1,0))/(select count(*) from calificaencuesta cf1 where cf1.activa =1 and cf1.idencuesta= ".$idencues."))*100  as pasivo,
         (sum(if(respuesta >= 9,1,0 ))/(select count(*) from calificaencuesta cf1 where cf1.activa =1 and cf1.idencuesta= ".$idencues."))*100 as promoter
         from calificaencuesta cf,encuesta ec 
        where 
        cf.idencuesta = ".$idencues." and  activa = 1
        and ec.idcabencuesta = cf.idcalificaencuesta
        and npsencuesta='ASEGURADORA'";
         $datos['npsaseguradora'] = $this->db->query($sqlInsert_Referencia)->result();
        //Asesoria 
        $sqlInsert_Referencia = "select (sum(if(respuesta <7,1,0))/(select count(*) from calificaencuesta cf1 where cf1.activa =1 and cf1.idencuesta= ".$idencues."))*100  as detractor,
        (sum(if(respuesta >= 7 and respuesta < 9,1,0))/(select count(*) from calificaencuesta cf1 where cf1.activa =1 and cf1.idencuesta= ".$idencues."))*100  as pasivo,
        (sum(if(respuesta >= 9,1,0 ))/(select count(*) from calificaencuesta cf1 where cf1.activa =1 and cf1.idencuesta= ".$idencues."))*100 as promoter
        from calificaencuesta cf,encuesta ec 
       where 
       cf.idencuesta = ".$idencues." and  activa = 1
       and ec.idcabencuesta = cf.idcalificaencuesta
       and npsencuesta='ASESORIA'";
        $datos['npsasesoria'] = $this->db->query($sqlInsert_Referencia)->result();
        //GESTOR
        $sqlInsert_Referencia = "select (sum(if(respuesta <7,1,0))/(select count(*) from calificaencuesta cf1 where cf1.activa =1 and cf1.idencuesta= ".$idencues."))*100  as detractor,
        (sum(if(respuesta >= 7 and respuesta < 9,1,0))/(select count(*) from calificaencuesta cf1 where cf1.activa =1 and cf1.idencuesta= ".$idencues."))*100  as pasivo,
        (sum(if(respuesta >= 9,1,0 ))/(select count(*) from calificaencuesta cf1 where cf1.activa =1 and cf1.idencuesta= ".$idencues."))*100 as promoter
        from calificaencuesta cf,encuesta ec 
       where 
       cf.idencuesta = ".$idencues." and  activa = 1
       and ec.idcabencuesta = cf.idcalificaencuesta
       and npsencuesta='GESTOR'";
        $datos['npsgestor'] = $this->db->query($sqlInsert_Referencia)->result();
        //PROFESIONALISMO
        $sqlInsert_Referencia = "select (sum(if(respuesta <7,1,0))/(select count(*) from calificaencuesta cf1 where cf1.activa =1 and cf1.idencuesta= ".$idencues."))*100  as detractor,
        (sum(if(respuesta >= 7 and respuesta < 9,1,0))/(select count(*) from calificaencuesta cf1 where cf1.activa =1 and cf1.idencuesta= ".$idencues."))*100  as pasivo,
        (sum(if(respuesta >= 9,1,0 ))/(select count(*) from calificaencuesta cf1 where cf1.activa =1 and cf1.idencuesta= ".$idencues."))*100 as promoter
        from calificaencuesta cf,encuesta ec 
       where 
       cf.idencuesta = ".$idencues." and  activa = 1
       and ec.idcabencuesta = cf.idcalificaencuesta
       and npsencuesta='PROFESIONALISMO'";
        $datos['npsprofesionalismo'] = $this->db->query($sqlInsert_Referencia)->result();
        //NIVEL
        $sqlInsert_Referencia = "select (sum(if(respuesta <7,1,0))/(select count(*) from calificaencuesta cf1 where cf1.activa =1 and cf1.idencuesta= ".$idencues."))*100  as detractor,
        (sum(if(respuesta >= 7 and respuesta < 9,1,0))/(select count(*) from calificaencuesta cf1 where cf1.activa =1 and cf1.idencuesta= ".$idencues."))*100  as pasivo,
        (sum(if(respuesta >= 9,1,0 ))/(select count(*) from calificaencuesta cf1 where cf1.activa =1 and cf1.idencuesta= ".$idencues."))*100 as promoter
        from calificaencuesta cf,encuesta ec 
       where 
       cf.idencuesta = ".$idencues." and  activa = 1
       and ec.idcabencuesta = cf.idcalificaencuesta
       and npsencuesta='NIVEL'";
        $datos['npsnivel'] = $this->db->query($sqlInsert_Referencia)->result();
      
         $sqlInsert_Referencia = "select count(idencuesta) as personas from calificaencuesta where idencuesta = " .$idencues;
         $datos['persona'] = $this->db->query($sqlInsert_Referencia)->result();
       
         //Personas evaluada
         $sqlInsert_Referencia = "select count(idencuesta) as activas from calificaencuesta where activa =1 and idencuesta = " .$idencues;
         $datos['evaluada'] = $this->db->query($sqlInsert_Referencia)->result(); 
         //verdadero o falso
         $sqlInsert_Referencia = "select sum(if(respuesta ='V',1,0)) as verdadero
         ,sum(if(respuesta ='F',1,0)) as falso
          from encuesta e
         , calificaencuesta ce where ce.idcalificaencuesta =e.idcabencuesta
         and ce.idencuesta =" .$idencues." and ce.activa =1";
         //$datos['verfalso'] =$sqlInsert_Referencia;
         $datos['verfalso'] = $this->db->query($sqlInsert_Referencia)->result(); 
         
         $sqlInsert_Referencia = "select count(e.idencuesta) as Total  from encuesta e, calificaencuesta ce where ce.idcalificaencuesta =e.idcabencuesta
                                and (e.respuesta ='V' or e.respuesta ='F')  and ce.activa =1 and ce.idencuesta =" .$idencues;
         $datos['total'] = $this->db->query($sqlInsert_Referencia)->result(); 

         //Consulta nps siniestro
       //  if($tipoen === 1)
         //{
         $sqlInsert_Referencia = "select sum(if(respuesta <7,1,0))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1
         ) as detractor
         ,sum(if(respuesta >= 7 and respuesta < 9,1,0))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1) as pasivo,
           sum(if(respuesta >= 9,1,0 ))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1) as promoter
         from calificaencuesta cf,encuesta ec
           where cf.idencuesta= ".$idencues." and cf.idcalificaencuesta = ec.idcabencuesta
         and activa =1 and ec.npsencuesta = 'TIEMPOS'
         union all
         select sum(if(respuesta <7,1,0))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1
         ) as detractor1
         ,sum(if(respuesta >= 7 and respuesta < 9,1,0))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1) as pasivo1,
           sum(if(respuesta >= 9,1,0 ))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1) as promoter1
         from calificaencuesta cf,encuesta ec
           where cf.idencuesta= ".$idencues." and cf.idcalificaencuesta = ec.idcabencuesta
         and activa =1 and ec.npsencuesta = 'ASEGURADORA'
         union all
         select sum(if(respuesta <7,1,0))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1
         ) as detractor2
         ,sum(if(respuesta >= 7 and respuesta < 9,1,0))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1) as pasivo2,
           sum(if(respuesta >= 9,1,0 ))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1) as promoter2
         from calificaencuesta cf,encuesta ec
           where cf.idencuesta= ".$idencues." and cf.idcalificaencuesta = ec.idcabencuesta
         and activa =1 and ec.npsencuesta = 'ASESORIA'
         union all
         select sum(if(respuesta <7,1,0))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1
         ) as detractor3
         ,sum(if(respuesta >= 7 and respuesta < 9,1,0))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1) as pasivo3,
           sum(if(respuesta >= 9,1,0 ))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1) as promoter3
         from calificaencuesta cf,encuesta ec
           where cf.idencuesta= ".$idencues." and cf.idcalificaencuesta = ec.idcabencuesta
         and activa =1 and ec.npsencuesta = 'GESTOR'";
         $datos['siniestro'] = $this->db->query($sqlInsert_Referencia)->result(); 
        
         $sqlInsert_Referencia = "select sum(if(respuesta <7,1,0))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1
         ) as detractor
         ,sum(if(respuesta >= 7 and respuesta < 9,1,0))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1) as pasivo,
           sum(if(respuesta >= 9,1,0 ))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1) as promoter
         from calificaencuesta cf,encuesta ec
           where cf.idencuesta= ".$idencues." and cf.idcalificaencuesta = ec.idcabencuesta
         and activa =1 and ec.npsencuesta = 'TIEMPOS'
         union all
         select sum(if(respuesta <7,1,0))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1
         ) as detractor1
         ,sum(if(respuesta >= 7 and respuesta < 9,1,0))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1) as pasivo1,
           sum(if(respuesta >= 9,1,0 ))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1) as promoter1
         from calificaencuesta cf,encuesta ec
           where cf.idencuesta= ".$idencues." and cf.idcalificaencuesta = ec.idcabencuesta
         and activa =1 and ec.npsencuesta = 'ASEGURADORA'
         union all
         select sum(if(respuesta <7,1,0))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1
         ) as detractor2
         ,sum(if(respuesta >= 7 and respuesta < 9,1,0))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1) as pasivo2,
           sum(if(respuesta >= 9,1,0 ))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1) as promoter2
         from calificaencuesta cf,encuesta ec
           where cf.idencuesta= ".$idencues." and cf.idcalificaencuesta = ec.idcabencuesta
         and activa =1 and ec.npsencuesta = 'PROFESIONALISMO'
         union all
         select sum(if(respuesta <7,1,0))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1
         ) as detractor3
         ,sum(if(respuesta >= 7 and respuesta < 9,1,0))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1) as pasivo3,
           sum(if(respuesta >= 9,1,0 ))/(select count(*) from calificaencuesta p where p.idencuesta=".$idencues." and p.activa =1) as promoter3
         from calificaencuesta cf,encuesta ec
           where cf.idencuesta= ".$idencues." and cf.idcalificaencuesta = ec.idcabencuesta
         and activa =1 and ec.npsencuesta = 'NIVEL'";  
            $datos['clientenuevo'] = $this->db->query($sqlInsert_Referencia)->result(); 
     //Proemdios del 1 -10
     $sqlInsert_Referencia = "select  (sum(if(calificacion <70,1,0))/(count(*)))* 100 as men70, 
     (sum(if(calificacion >= 70 and calificacion < 90,1,0))/(count(*)))* 100 as entre7090,
     (sum(if(calificacion >=90,1,0))/(count(*)))* 100 as may90
      from calificaencuesta cf where cf.idencuesta =".$idencues." and cf.activa=1";
        
         $datos['promedio'] =  $this->db->query($sqlInsert_Referencia)->result(); 
         //Consulta nps cliente nuevo
          echo json_encode($datos);
         //echo json_encode($sqlInsert_Referencia);
       
}    

/****************************************** */
function VistaPregunta(){// Modificado [2024-01-03]
        
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } 
        else 
        {
           if($this->input->get('IdEncuesta',TRUE))
           { 
             $data['IdEncuesta'] = $this->input->get('IdEncuesta');
             $idencta = $this->input->get('IdEncuesta');
             //$data['Pre'] = $this->preguntamodel->TPreguntas($this->input->get('IdEncuesta'));         
             //28-10-2021 ver si la necuesta es de cliente o de siniestro 0=ninguno 1 =siniestro 2=cliente
             $data['tipoEncuesta'] = $this->preguntamodel->tipoEncuesta($this->input->get('IdEncuesta'));    
             //06-07-2022 hurcim Agrega para el nombre de la encuesta
             $sqlInsert_Referencia = "select descripcion,tipo from cabencuesta where idcabencuesta =" .$idencta;
             $data['nombre'] = $this->db->query($sqlInsert_Referencia)->result(); 
             //termina
            //$this->load->view('encuesta/pregunta',$data);
             echo json_encode($data);
           } 
        }
    }    
    function VistaPregunta2(){
        
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } 
        else 
        {
                
             $data['IdEncuesta'] =$this->session->flashdata('encta');
             //$idencta = $this->input->get('IdEncuesta');
             $data['Pre'] = $this->preguntamodel->TPreguntas($this->session->flashdata('encta'));         
              //28-10-2021 ver si la necuesta es de cliente o de siniestro 0=ninguno 1 =siniestro 2=cliente
              $data['tipoEncuesta'] = $this->preguntamodel->tipoEncuesta($this->session->flashdata('encta'));         
              $idencta = $this->session->flashdata('encta');
              $sqlInsert_Referencia = "select descripcion,tipo from cabencuesta where idcabencuesta =" .$idencta;
              $data['nombre'] = $this->db->query($sqlInsert_Referencia)->result();        
             $this->load->view('encuesta/pregunta',$data);
          
        }
    }    
  function editpregunta(){

        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else {

            if($this->input->get('IDpre',TRUE))
            {
    
                $idpre  = $this->input->get('IDpre');
                $data['detallepregunta'] = $this->preguntamodel->EnviaPregunta($idpre); 
                $this->load->view('encuesta/EditaPregunta', $data);
            }
        }
    } 
 

function GuardaEditaPregunta(){

        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } 
        else 
        {
            $movimiento  = $this->input->post('pregunta');
            $idche  = $this->input->post('idpregunta');
            $TipoRespuesta  =strtoupper ($this->input->post('TipoRespuesta'));
             if(strcmp ($TipoRespuesta,'NUMERO') == 0)
             {
                $TipoRespuesta = 1;
             }
             else {
               $TipoRespuesta = 0; 
              }
            $sqlInsert_Referencia = "
                        Update
                            `pregunta` set
                                        `pregunta` = '".$movimiento."',
                                        `tipo` ='".$TipoRespuesta."'                                       
                                    where
                                        `idpregunta`='".$idche."'
                                            ";

                         
            $this->db->query($sqlInsert_Referencia);
            $referencia = $this->db->insert_id();
               $data['movimientos'] =  $this->capsysdre->TipoMovimiento();
                $data['bancos'] =  $this->capsysdre->ListaBancos();
                $data['concepto'] = $this->capsysdre->ListaConceptos();
                $data['Cheque'] = $this->capsysdre->ListaCheques();
                 redirect('pregunta/VistaPregunta');
        }
    }

 function eliminaPregunta(){// Modificado [2024-01-03]

        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else {
            if($this->input->post('IDpre',TRUE))
            {
    
                $idencta   = $this->input->post('idenc');
                $idpre  = $this->input->post('IDpre');
                 $sqlInsert_Referencia = "
                        delete from
                            `pregunta` 
                                    where
                                        `idpregunta`='".$idpre."'

                                            ";

                         
            $this->db->query($sqlInsert_Referencia);
            $this->session->set_flashdata('encta', $idencta);
            //redirect('pregunta/VistaPregunta2');
            $data['idcabencuesta'] = $idencta;
            $data['idpregunta'] = $idpre;
            $data['status'] = "success";
            echo json_encode($data);
            }
        }
    }
 function CierraEncuesta(){// Modificado [2024-01-03]

      if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else {
            if($this->input->post('IdEncuesta',TRUE))
            {
    
                $idpre  = $this->input->post('IdEncuesta');
                 $sqlInsert_Referencia = "
                       update 
                            `cabencuesta`  set
                                  `activa` = 1
                                    where
                                        `idcabencuesta`='".$idpre."'

                                            ";

                         
            $this->db->query($sqlInsert_Referencia);
            //$data['Enc'] = $this->preguntamodel->TEncuesta();
            //redirect('pregunta/VistaEncuesta',$data);
             $data['status'] = "success";
              echo json_encode($data);
            }
        }
    
    }

function GuardarEncuesta(){// Modificado [2024-01-03]

        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else {
          $data['status'] = "error";
               $descripcion =$this->input->post('descripcion');
               $Fechadia =  date('Y-m-d');
               $tipo =$this->input->post('TipoRespuesta');
               $encuesta =$this->input->post('encuestaA');
               $valor =3;
               if($tipo == 'NPS')
                 $valor =1;
              if($tipo == 'NUMERO')
                 $valor =2;  
                 
               // $iddescripcion  = $this->input->get('descripcion');
                  $sqlInsert_Referencia = "
                        Insert Ignore Into
                            `cabencuesta` 
                                    (
                                      
                                        `fecha`,
                                        `activa`,
                                        `descripcion`,
                                        `tiprespuesta`,
                                        `tipoencuesta`,
                                        `tipo`
                                        ) 
                                    Values
                                    (

                                        '".$Fechadia."',
                                        '0',
                                        '".$descripcion."' ,                               
                                        'SI',
                                        '".$encuesta."',
                                        '".$valor."'
                                    );
                                            ";

                         
            $this->db->query($sqlInsert_Referencia);
            //redirect('pregunta/VistaEncuesta');
            $data['status'] = "success";
            echo json_encode($data);
            }
       
    }
function GuardarPregunta(){// Modificado [2024-01-03]
        
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } 
        else 
        {
          $data['status'] = "error";
            $pregu = strtoupper ($this->input->post('pregunta'));
            $movimiento  = strtoupper ($this->input->post('TipoRespuesta'));
            $respuesta = strtoupper ($this->input->post('respuesta'));
            $tipoencuesta = strtoupper ($this->input->post('selectNps'));
           // print $movimiento;
            $idencta = $this->input->post('Encuesta');
            $contador = $this->preguntamodel->TCantidadPreguntas($idencta);
            //$contador = $this->preguntamodel->ActualizaPregunta();
           // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($idencta, TRUE));fclose($fp);  
            $tipres = $this->preguntamodel->TNPS($idencta);
            // if( empty($idencta))
            // {
              
            //    redirect('pregunta/VistaEncuesta');   

            // }
            $conta = $this->preguntamodel->TCantidadPreguntas($idencta);
           // $this->preguntamodel->ActualizaPregunta($idencta,$datos);
           $datos= array(
              'preguntas'=> $conta
            );
            $this->preguntamodel->ActualizaPregunta($idencta,$datos);
           //$preguntas = $this->preguntamodel->TCantidadPreguntas('2');
            /*foreach($contador as $each)
            {
              $conta = $each->cont; 
            }*/
            $contador = $contador +1;
           if(strcmp ($movimiento,'NUMERO') == 0)
             {
                $movimiento = 1;
             }
             else {
               $movimiento = 0; 
              }
           /* if($tipres == 'SI')
             {
               $movimiento = 1;
             } 
         */

            $sqlInsert_Referencia = "
                        Insert Ignore Into
                            `pregunta` 
                                    (
                                      
                                        `pregunta`,
                                        `tipo`,
                                        `idusuario`,
                                        `idcabencuesta`,
                                        `respuesta`,
                                        `nps`
                                        ) 
                                    Values
                                    (

                                        '".$pregu."',
                                        '".$movimiento."',
                                        '".$contador."' ,
                                        '".$idencta."',
                                        '".$respuesta."',                             
                                        '".$tipoencuesta."'
                                    );
                                            ";

                         
                $this->db->query($sqlInsert_Referencia);
                //$referencia = $this->db->insert_id();
                $this->session->set_flashdata('encta', $idencta); 
                  
               /* $sqlInsert_Referencia = "
                        Update
                            `cabencuesta` set
                                        `preguntas` = '".$preguntas."'
                                                                             
                                    where
                                        `idcabencuesta`='".$idencta."'
                                            ";

                         
            $this->db->query($sqlInsert_Referencia);*/
            //$referencia = $this->db->insert_id();
            //redirect('pregunta/VistaPregunta2');
                $data['status'] = "success";
                echo json_encode($data);


            //$data['ListaProveedores']= $this->capsysdre->ListaProveedores();
            // redirect('cheques');
             
        }
    }

function excel()
    {
          
     //$nombre ="Reporte de Encuesta".date("Y-m-d H:i:s");
      /*$consulta="select ca.idcalificaencuesta,en.descripcion,ca.usuario,ca.calificacion 
               from calificaencuesta ca ,cabencuesta en 
               where ca.idencuesta = en.idcabencuesta and ca.activa = '1'";
      $datos=$this->db->query($consulta)->result();*/
      $this->load->library('excel'); $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Enctas Aplicadas');
        //ancho de las columnas
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        //valor de la celda
        $contador = 1;
      
        $this->excel->getActiveSheet()->getStyle('A1:E1')->applyFromArray
        (
         array('fill' =>
         array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' =>
         array('rgb' => 'FFFF00')
         )
         ) 
         );  

    $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("A{$contador}",'IDENCUESTA');
        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("B{$contador}",'ENCUESTA');
        $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("C{$contador}",'EMPLEADO');
        $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue("D{$contador}",'CALIFICACION');

    /*foreach($datos as $che){
           //Incrementamos una fila más, para ir a la siguiente.
             $contador++;
            // $bancos = $che->descripcionbancos;
            // $fechas = $che->FECHA;           
           $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
           $this->excel->getActiveSheet()->setCellValue("A".$contador,$che->idcalificaencuesta);
           
           $this->excel->getActiveSheet()->setCellValue("B".$contador,$che->descripcion);
           $this->excel->getActiveSheet()->setCellValue("C".$contador, $che->usuario);
           $this->excel->getActiveSheet()->setCellValue("D".$contador, $che->calificacion);
           /*$this->excel->getActiveSheet()->setCellValue("E".$contador, $che->total);
           $sumtotal = $sumtotal+$che->total;
           
           $this->excel->getActiveSheet()->setCellValue("F".$contador, $che->ACUMES);
           $summes=$summes +$che->ACUMES; 
           $this->excel->getActiveSheet()->setCellValue("G".$contador, $che->ACUMMESAMES);
           $summesames=$summesames+$che->ACUMMESAMES;
           $this->excel->getActiveSheet()->setCellValue("H".$contador, $che->ACUMANOPASADO);
           $sumano=$sumano+$che->ACUMANOPASADO;*/
        //}
       // $contador++;
        header("Content-Type: aplication/vnd.ms-excel ");
        $nombre ="Reporte".date("Y-m-d H:i:s");
        header("Content-Disposition: attachment; filename=\"$nombre.xls\"");
        header("Cache-Control: max-age=0")        ;
        $writer = PHPExcel_IOFactory::CreateWriter($this->excel,"Excel5");
        $writer->save("php://output");

 
    
  }

  //-----------------------------------------------------------------------
  function getTestOn() {
    $data = $this->preguntamodel->TEncuesta();
    echo json_encode($data);
  }

  function getQuestionTest() {
    $data = $this->preguntamodel->TPreguntas($this->input->get('id'));
    echo json_encode($data);
  }
//-------------------------------------------------------------------------

}
?>
 
