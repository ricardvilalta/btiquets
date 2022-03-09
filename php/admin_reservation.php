<?php  

    include_once 'common.php';
    include_once '../php/funcions.php';
    include_once '../php/btdv_funcions.php';  

    global $mysqli,$ref,$command;

    if($command)
    {        
        if($ref)
        {            
            $curref = intval(CheckConfirmReservation($ref));
            $ret = 0;
            if($curref==0)
            {
                switch($command)
                {
                    case 'accept':  // l'establiment accepta la reserva

                        $info_reserva = GetReservation_by_ref($mysqli,$ref);
                        $box = GetBox($mysqli,$info_reserva['box_id']);
                        if($info_reserva!=null)
                        {
                            $ret = ConfirmReservation($mysqli,$ref,1);
                            $info_reserva = GetReservation_by_ref($mysqli,$ref);
                            $info_reserva['colmail']=$box['mail_aux'];
                            SendConfirmation8($mysqli,$info_reserva);
                            SendConfirmation4($mysqli,$info_reserva);                            
                        }
                        break; 

                    case 'deny':  // l'establiment rebutja la reserva

                        $info_reserva = GetReservation_by_ref($mysqli,$ref);
                        $box = GetBox($mysqli,$info_reserva['box_id']);
                        if($info_reserva!=null)
                        {
                            $ret = ConfirmReservation($mysqli,$ref,-1);
                            $info_reserva = GetReservation_by_ref($mysqli,$ref);
                            $info_reserva['colmail']=$box['mail_aux'];
                            SendConfirmation8($mysqli,$info_reserva);
                            SendConfirmation5($mysqli,$info_reserva);                            
                        }
                        break; 

                    default:
                        break;
                }
            }
            else
            {
                $ret = -1;
            }
        }
    }
?>

<header>
    <div class="header_background">
        <?php
        if($ret==-1)
        {?>
        <h1><?php echo translate("RESERVA TRAMITADA",$lang); ?></h1>        
        <h4><?php echo translate("REFERÈNCIA",$lang) . ": " . $ref; ?></h4>
        <div><?php echo translate("Aquesta reserva ja ha estat resolta. Un cop contestada, les reserves ja no es poden modificar. Si vols modificar-la, posa't en contacte directamernt amb el client.",$lang); ?></div>
        <?php
        }
        else if($command=='accept')
        {?>
        <h1><?php echo translate("RESERVA ACCEPTADA",$lang); ?></h1>        
        <h4><?php echo translate("REFERÈNCIA",$lang) . ": " . $ref; ?></h4>
        <div><?php echo translate("S'ha enviat un correu de confirmació al client. Tens les seves dades per si consideres oportú establir contacte directe o per verificar les dades de la reserva.",$lang); ?></div>
        <?php
        }
        else
        {?>
        <h1><?php echo translate("RESERVA DENEGADA",$lang); ?></h1>        
        <h4><?php echo translate("REFERÈNCIA",$lang) . ": " . $ref; ?></h4>
        <div><?php echo translate("S'ha enviat un correu denegant la reserva al client. Tens les seves dades per si consideres oportú establir contacte directe per buscar una alternativa o fer qualsevol altra comunicació.",$lang); ?></div>    
        <?php
        }?>
    </div>
</header>