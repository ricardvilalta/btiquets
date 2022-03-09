<?php  

    include_once 'common.php';
    include_once '../php/funcions.php';
    include_once '../php/btdv_funcions.php'; 

    global $mysqli;

    if(isset($_POST["box_id"]) && isset($_POST["nom"]) && isset($_POST["email"]) && isset($_POST["tel"]) && isset($_POST["data_res"]) && isset($_POST["quant_str"]))
    {
        
        // Data
        date_default_timezone_set($zone);
        $data = date('Y-m-d');
        
        // Data res
        $edata = date_create_from_format('d/m/Y H:i',$_POST["data_res"]);
        $date_res = date_format($edata,'Y-m-d H:i:s');

        $num_reserva = GenerateReservation();

        $ret = InsertReservation($mysqli,-1,intval($_POST["box_id"]),-1,addslashes($_POST["com"]),null,$num_reserva,0,$data,null,intval($_POST["quant_str"]),0,$date_res,null,-2,"","",addslashes($_POST["nom"]),addslashes($_POST["email"]),addslashes($_POST["tel"]),"",false,"",6,false,null,$_POST["newsletter"]);
        
        // Si ha anat bé, he d'enviar els mails corresponents
        if($ret>0)
        {
            $info_reserva = GetReservation($mysqli,$ret);
            $box = GetBox($mysqli,$info_reserva['box_id']);
            $userdata = GetUInfo($mysqli,$box['propietari']);
            $info_reserva['colmail']=$box['mail_aux'];
            
            SendConfirmation2($mysqli,$info_reserva);
            SendConfirmation3($mysqli,$info_reserva);
            
            $ret = $info_reserva["ref"];
        }
        
        echo $ret;
    }
    else
    {
        echo -1;
    }

    
?>