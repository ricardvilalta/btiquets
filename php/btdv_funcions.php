<?php

    $ciutats = $array = array("Aguilar de Segarra","Artés","Avinyó","Balsareny","Calders","Callús","Cardona","Castellbell i el Vilar","Castellfollit del Boix","Castellgalí","Castellnou de Bages","L'Estany","Fonollosa","Gaià","Manresa","Marganell","Moià","Monistrol de Calders","Monistrol de Montserrat","Mura","Navarcles","Navàs","Pont de Vilomara i Rocafort","Rajadell","Sallent","Sant Feliu Sasserra","Sant Fruitós de Bages","Sant Joan de Vilatorrada","Sant Mateu de Bages","Sant Salvador de Guardiola","Sant Vicenç de Castellet","Santa Maria d'Oló","Santpedor","Súria","Talamanca");

function GetDBData($from, $where = "", $orderby = "", $offset = 0, $limit = 0)
{
    global $mysqli;

    $sql = "SELECT * FROM $from";
    //WHERE
    if ($where != "") {
        $sql .= " WHERE $where";
    }
    //ORDER
    if ($orderby != "") {
        $sql .= " ORDER BY $orderby";
    }
    //LIMIT
    if ($limit != 0) {
        $sql .= " limit $offset, $limit";
    }
    //error_log($sql);
    $result = $mysqli->query($sql);
    $data = array();
    if ($result) {
        while ($row = $result->fetch_row()) {
            $data[] = $row;
        }
    }
    return $data;
}

function GetDBDataCount($from, $where = "", $orderby = "", $offset = 0, $limit = 0)
{
    global $mysqli;

    $sql = "SELECT COUNT(*) FROM $from";
    //WHERE
    if ($where != "") {
        $sql .= " WHERE $where";
    }
    //ORDER
    if ($orderby != "") {
        $sql .= " ORDER BY $orderby";
    }
    //LIMIT
    if ($limit != 0) {
        $sql .= " limit $offset, $limit";
    }
    $result = $mysqli->query($sql);
    $data = null;
    if ($result) {
        while ($row = $result->fetch_row()) {
            $data = $row[0];
        }
    }
    return (int)$data;
}

function GetSpecificDBData($DBName, $DBField, $DBValue, $DBField_not = "", $DBValue_not = "", $orderby = "")
{
    global $mysqli;

    $sql = "SELECT * FROM $DBName";


    if ($DBField != "" || $DBField_not != "") {
        $sql .= " WHERE";
    }

    if ($DBField != "") {
        $sql .= " $DBField='$DBValue'";
    }

    if ($DBField != "" && $DBField_not != "") {
        $sql .= " AND";
    }

    if ($DBField_not != "") {
        $sql .= " $DBField_not!='$DBValue_not'";
    }

    if ($orderby != "") {
        $sql .= " ORDER BY $orderby";
    }

    $result = $mysqli->query($sql);
    //($sql);
    $data = array();
    if ($result) {
        $data_aux = array();
        while ($row = $result->fetch_row()) {
            unset($data_aux);
            foreach ($row as $item) {
                $data_aux[] = $item;
            }
            $data[] = $data_aux;
        }
    }
    return $data;
}

function GetSpecificDBData_pair($DBName, $DBField, $DBValue, $DBField_2, $DBValue_2, $orderby = "")
{
    global $mysqli;

    $sql = "SELECT * FROM $DBName";


    if ($DBField != "" || $DBField_not != "") {
        $sql .= " WHERE";
    }

    if ($DBField != "") {
        $sql .= " $DBField='$DBValue'";
    }

    if ($DBField != "" && $DBField_2 != "") {
        $sql .= " AND";
    }

    if ($DBField_2 != "") {
        $sql .= " $DBField_2='$DBValue_2'";
    }

    if ($orderby != "") {
        $sql .= " ORDER BY $orderby";
    }

    $result = $mysqli->query($sql);
    $data = array();
    if ($result) {
        $data_aux = array();
        while ($row = $result->fetch_row()) {
            unset($data_aux);
            foreach ($row as $item) {
                $data_aux[] = $item;
            }
            $data[] = $data_aux;
        }
    }
    return $data;
}

function GetSpecificDBData_trio($DBName, $DBField, $DBValue, $DBField_2, $DBValue_2, $DBField_3, $DBValue_3, $orderby = "")
{
    global $mysqli;

    $sql = "SELECT * FROM $DBName";


    if ($DBField != "" || $DBField_not != "") {
        $sql .= " WHERE";
    }

    if ($DBField != "") {
        $sql .= " $DBField='$DBValue'";
    }

    if ($DBField != "" && $DBField_2 != "") {
        $sql .= " AND";
    }

    if ($DBField_2 != "") {
        $sql .= " $DBField_2='$DBValue_2'";
    }

    if (($DBField != "" || $DBField2 != "") && $DBField_3 != "") {
        $sql .= " AND";
    }

    if ($DBField_3 != "") {
        $sql .= " $DBField_3='$DBValue_3'";
    }

    if ($orderby != "") {
        $sql .= " ORDER BY $orderby";
    }

    $result = $mysqli->query($sql);
    $data = array();
    if ($result) {
        $data_aux = array();
        while ($row = $result->fetch_row()) {
            unset($data_aux);
            foreach ($row as $item) {
                $data_aux[] = $item;
            }
            $data[] = $data_aux;
        }
    }
    return $data;
}

function GetDBItem($DBName, $id)
{
    global $mysqli;

    $sql = "SELECT * FROM $DBName WHERE id=$id";
    $result = $mysqli->query($sql);
    $data = array();
    if ($result) {
        $row = $result->fetch_row();
        if ($row != null) {
            foreach ($row as $item) {
                $data[] = $item;
            }
        }

    }
    return $data;
}

function GetDBItem_($DBName, $DBVar, $DBValue)
{
    global $mysqli;

    $sql = "SELECT * FROM $DBName WHERE $DBVar='$DBValue'";
    $result = $mysqli->query($sql);
    $data = array();
    if ($result) {
        $row = $result->fetch_row();
        if (@count($row) > 0) {
            foreach ($row as $item) {
                $data[] = $item;
            }
        }
    }
    return $data;
}

function GetDBItem_pair($DBName, $DBVar1, $DBValue1, $DBVar2, $DBValue2)
{
    global $mysqli;

    $sql = "SELECT COUNT(*) FROM $DBName WHERE $DBVar1='$DBValue1' AND $DBVar2='$DBValue2'";
    $result = $mysqli->query($sql);
    if ($result) {
        $row = $result->fetch_row();
        return $row[0];
    }
    return 0;
}

function DelDBItem_pair($DBName, $DBVar1, $DBValue1, $DBVar2, $DBValue2)
{
    global $mysqli;

    $sql = "DELETE FROM $DBName WHERE $DBVar1='$DBValue1' AND $DBVar2='$DBValue2'";
    $mysqli->query($sql);
    return 1;
}

function GetDBItemVar($DBName, $DBVar, $id)
{
    global $mysqli;

    $sql = "SELECT $DBVar FROM $DBName WHERE id=$id";
    $result = $mysqli->query($sql);
    $data = null;
    if ($result) {
        $row = $result->fetch_row();
        $data = $row[0];
    }
    return $data;
}

function SetDBItemField($DBName, $DBField, $value, $id)
{
    global $mysqli;
    $ret = -1;
    $sql = "UPDATE " . $DBName . " SET " . $DBField . " = '" . $value . "' WHERE id=" . $id;
    $result = $mysqli->query($sql);
    if ($result) {
        $ret = 1;
    }
    return $ret;
}

function InsertDBData($DBName, $data, $id)
{
    global $mysqli;
    $ret = -1;

    $columnes = implode(', ', array_keys($data));
    $mysqlarray = array_fill(0, sizeof($data), $mysqli);
    $escaped_values = array_map('mysqli_real_escape_string', $mysqlarray, array_values($data));
    foreach ($escaped_values as $idx => $mydata) $escaped_values[$idx] = "'" . $mydata . "'";
    $data_escaped = array_combine(array_keys($data), $escaped_values);

    if ($id == -1) {
        $valors = implode(", ", $escaped_values);
        $sql = "INSERT INTO " . $DBName . " ( " . $columnes . ") VALUES (" . $valors . ")";
        //error_log($sql);
    } else {
        $aux = array();
        foreach ($data_escaped as $columna => $valor) $aux[] = $columna . "=" . $valor;
        $colsivalors = implode(", ", $aux);
        $sql = "UPDATE " . $DBName . " SET " . $colsivalors . " WHERE id=" . $id;
        //error_log($sql);
    }

    $result = $mysqli->query($sql);
    if ($result) {
        if ($id == -1) $ret = $mysqli->insert_id;
        else $ret = $id;
    }
    return $ret;
}

function DelDBData($DBName, $id)
{
    global $mysqli;

    $sql = "DELETE FROM $DBName WHERE id=$id";
    $mysqli->query($sql);
    return 1;
}

function DelSpecificDBData($DBName, $DBField, $DBValue, $DBField_not = "", $DBValue_not = "")
{
    global $mysqli;

    $sql = "DELETE FROM $DBName";


    if ($DBField != "") {
        $sql .= " WHERE";
    }

    if ($DBField != "") {
        $sql .= " $DBField=$DBValue";
    }

    if ($DBField_not != "") {
        $sql .= " AND";
    }

    if ($DBField_not != "") {
        $sql .= " $DBField_not!=$DBValue_not";
    }

    $mysqli->query($sql);
    return 1;
}

    function GetTypeList($all)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        global $lang;
        
        if($all)
        {
            $sql="SELECT id,name,url,name_es,name_en FROM box_type ORDER BY ipos";
        }
        else
        {
            switch($lang)
            {
                case 'es':
                    $sql="SELECT id,name_es,url FROM box_type WHERE hidden=false ORDER BY ipos";
                    break;
                
                case 'en':
                    $sql="SELECT id,name_en,url FROM box_type WHERE hidden=false ORDER BY ipos";
                    break;
                
                default:
                    $sql="SELECT id,name,url FROM box_type WHERE hidden=false ORDER BY ipos";
                    break;
            }
        }
        $result=$mysqli->query($sql); 
        $data = array();
        if($result)
        {            
            while ( $row = $result->fetch_row() )
            {   
                if($all)
                {
                    $data[] = array('id'=>$row[0],'name'=>$row[1],'url'=>$row[2],'name_es'=>$row[3],'name_en'=>$row[4]);
                }
                else
                {
                    $data[] = array('id'=>$row[0],'name'=>$row[1],'url'=>$row[2]);
                }
            }
        }
        
        return $data;
    }

    function GetTypeInfo($id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        global $lang;
        
        switch($lang)
        {
            case 'es':
                $sql="SELECT id,name_es,url FROM box_type WHERE id=$id";
                break;
            
            case 'en':
                $sql="SELECT id,name_en,url FROM box_type WHERE id=$id";
                break;
            
            default:
                $sql="SELECT id,name,url FROM box_type WHERE id=$id";
                break;
        }        
        $result=$mysqli->query($sql); 
        $data = null;
        if($result)
        {            
            $row = $result->fetch_row();
            $data = array('id'=>$row[0],'name'=>$row[1],'url'=>$row[2]);
        }
        
        return $data;
    }

    function GetTypeHidden($id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;

        $sql="SELECT hidden FROM box_type WHERE id=$id";
        $result=$mysqli->query($sql); 
        $data = 0;
        if($result)
        {            
            $row = $result->fetch_row();
            $data = $row[0];
        }
        
        return $data;
    }

    function GetTypeName($id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        $name = "";
        global $lang;
        
        switch($lang)
        {
            case 'es':
                $sql="SELECT name_es FROM box_type WHERE id=$id";
                break;
            
            case 'en':
                $sql="SELECT name_en FROM box_type WHERE id=$id";
                break;
            
            default:
                $sql="SELECT name FROM box_type WHERE id=$id";
                break;
        }
        
        $result=$mysqli->query($sql);
        if($result)
        {
            $row = $result->fetch_row();
            $name = $row[0];
        }

        return $name;
    }

    function GetBoxList($type,$calendari=false)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        global $lang;          
        
        if($type==-1)
        {
            switch($lang)   //TOTES
            {
                case 'es':
                    $sql="SELECT id,name_es,type,img,url,price_es,quotes_es,nou,activities,special_img,no_online,event_type,data FROM box_data WHERE ocult=0 ORDER BY RAND()";
                    break;
                
                case 'en':
                    $sql="SELECT id,name_en,type,img,url,price_en,quotes_en,nou,activities,special_img,no_online,event_type,data FROM box_data WHERE ocult=0 AND name_en!='' AND quotes_en!='' ORDER BY RAND()";
                    break;
                
                default:
                    $sql="SELECT id,name,type,img,url,price,quotes,nou,activities,special_img,no_online,event_type,data FROM box_data WHERE ocult=0 ORDER BY RAND()";
                    break;
            }
            
            $result=$mysqli->query($sql); 
            $data = array();
            if($result)
            {            
                while ( $row = $result->fetch_row() )
                {
                    $data[] = array('id'=>$row[0],'name'=>$row[1],'type'=>$row[2],'img'=>'boxes/box_'.$row[0].'/'.$row[3],'url'=>$row[4],'price'=>$row[5],'quotes'=>$row[6],'nou'=>intval($row[7]),'activities'=>intval($row[8]),'special_img'=>'boxes/box_'.$row[0].'/'.$row[9],'no_online'=>intval($row[10]),'event_type'=>intval($row[11]),'edate'=>stripslashes($row[12]));
                }
            }
        }
        else if($type==-2)  // DESTACADES
        {            
            switch($lang)
            {
                case 'es':
                    $sql="SELECT id,name_es,type,img,url,price_es,quotes_es,nou,activities,special_img,no_online,event_type,data FROM box_data WHERE destacat=1 AND ocult=0 ORDER BY RAND()";
                    break;
                
                case 'en':
                    $sql="SELECT id,name_en,type,img,url,price_en,quotes_en,nou,activities,special_img,no_online,event_type,data FROM box_data WHERE destacat=1 AND ocult=0 AND name_en!='' AND quotes_en!='' ORDER BY RAND()";
                    break;
                
                default:
                    $sql="SELECT id,name,type,img,url,price,quotes,nou,activities,special_img,no_online,event_type,data FROM box_data WHERE destacat=1 AND ocult=0 ORDER BY RAND()";
                    break;
            }
            
            $result=$mysqli->query($sql); 
            $data = array();
            if($result)
            {            
                while ( $row = $result->fetch_row() )
                {
                    $data[] = array('id'=>$row[0],'name'=>$row[1],'type'=>$row[2],'img'=>'boxes/box_'.$row[0].'/'.$row[3],'url'=>$row[4],'price'=>$row[5],'quotes'=>$row[6],'nou'=>intval($row[7]),'activities'=>intval($row[8]),'special_img'=>'boxes/box_'.$row[0].'/'.$row[9],'no_online'=>intval($row[10]),'event_type'=>intval($row[11]),'edate'=>stripslashes($row[12]));
                }
            }
        }
        else if($type==-3)
        {
            switch($lang)   //TOTES
            {
                case 'es':
                    $sql="SELECT id,name_es,type,img,url,price_es,quotes_es,nou,activities,special_img,no_online,event_type,data,short_description_es FROM box_data ORDER BY name";
                    break;
                
                case 'en':
                    $sql="SELECT id,name_en,type,img,url,price_en,quotes_en,nou,activities,special_img,no_online,event_type,data,short_description_en FROM box_data WHERE name_en!='' AND quotes_en!='' ORDER BY name";
                    break;
                
                default:
                    $sql="SELECT id,name,type,img,url,price,quotes,nou,activities,special_img,no_online,event_type,data,short_description FROM box_data ORDER BY name";
                    break;
            }
            
            $result=$mysqli->query($sql); 
            $data = array();
            if($result)
            {            
                while ( $row = $result->fetch_row() )
                {
                    $data[] = array('id'=>$row[0],'name'=>$row[1],'type'=>$row[2],'img'=>'boxes/box_'.$row[0].'/'.$row[3],'url'=>$row[4],'price'=>$row[5],'quotes'=>$row[6],'nou'=>intval($row[7]),'activities'=>intval($row[8]),'special_img'=>'boxes/box_'.$row[0].'/'.$row[9],'no_online'=>intval($row[10]),'event_type'=>intval($row[11]),'edate'=>stripslashes($row[12]),'short_description'=>$row[13]);
                }
            }
        }
        else if($type==-4)  // PROGRAMADES
        {            
            switch($lang)
            {
                case 'es':
                    $sql="SELECT id,name_es,type,img,url,price_es,quotes_es,nou,activities,special_img,no_online,event_type,data FROM box_data WHERE event_type=1 AND ocult=0 ORDER BY data";
                    break;
                
                case 'en':
                    $sql="SELECT id,name_en,type,img,url,price_en,quotes_en,nou,activities,special_img,no_online,event_type,data FROM box_data WHERE event_type=1 AND ocult=0 AND name_en!='' AND quotes_en!='' ORDER BY data";
                    break;
                
                default:
                    $sql="SELECT id,name,type,img,url,price,quotes,nou,activities,special_img,no_online,event_type,data FROM box_data WHERE event_type=1 AND ocult=0 ORDER BY data";
                    break;
            }
            
            $result=$mysqli->query($sql); 
            $data = array();
            if($result)
            {            
                while ( $row = $result->fetch_row() )
                {
                    $data[] = array('id'=>$row[0],'name'=>$row[1],'type'=>$row[2],'img'=>'boxes/box_'.$row[0].'/'.$row[3],'url'=>$row[4],'price'=>$row[5],'quotes'=>$row[6],'nou'=>intval($row[7]),'activities'=>intval($row[8]),'special_img'=>'boxes/box_'.$row[0].'/'.$row[9],'no_online'=>intval($row[10]),'event_type'=>intval($row[11]),'edate'=>stripslashes($row[12]));
                }
            }
        }
        else
        {
            if($calendari) // s'han d'ordenar per data
            {
                switch($lang)
                {
                    case 'es':
                        $sql="SELECT id,name_es,type,img,url,price_es,quotes_es,nou,activities,special_img,no_online,event_type,data FROM box_data WHERE ocult=0 ORDER BY data";
                        break;

                    case 'en':
                        $sql="SELECT id,name_en,type,img,url,price_en,quotes_en,nou,activities,special_img,no_online,event_type,data FROM box_data WHERE ocult=0 AND name_en!='' AND quotes_en!='' ORDER BY data";
                        break;

                    default:
                        $sql="SELECT id,name,type,img,url,price,quotes,nou,activities,special_img,no_online,event_type,data FROM box_data WHERE ocult=0 ORDER BY data";
                        break;
                }  
            }
            else
            {
                switch($lang)
                {
                    case 'es':
                        $sql="SELECT id,name_es,type,img,url,price_es,quotes_es,nou,activities,special_img,no_online,event_type,data FROM box_data WHERE ocult=0 ORDER BY RAND()";
                        break;

                    case 'en':
                        $sql="SELECT id,name_en,type,img,url,price_en,quotes_en,nou,activities,special_img,no_online,event_type,data FROM box_data WHERE ocult=0 AND name_en!='' AND quotes_en!='' ORDER BY RAND()";
                        break;

                    default:
                        $sql="SELECT id,name,type,img,url,price,quotes,nou,activities,special_img,no_online,event_type,data FROM box_data WHERE ocult=0 ORDER BY RAND()";
                        break;
                }   
            }
        
            $result=$mysqli->query($sql); 
            $data = array();
            if($result)
            {            
                while ( $row = $result->fetch_row() )
                {
                    $boxtypelist = null;
                    $boxtypelist=explode(';',$row[2]);
                    if(in_array($type,$boxtypelist))
                    {
                        $data[] = array('id'=>$row[0],'name'=>$row[1],'type'=>$type,'img'=>'boxes/box_'.$row[0].'/'.$row[3],'url'=>$row[4],'price'=>$row[5],'quotes'=>$row[6],'nou'=>intval($row[7]),'activities'=>intval($row[8]),'special_img'=>'boxes/box_'.$row[0].'/'.$row[9],'no_online'=>intval($row[10]),'event_type'=>intval($row[11]),'edate'=>stripslashes($row[12]));
                    }
                }
            }
        }
        
        return $data;
    }

    function GetBoxListHomebyCompte($mysqli,$compte,$type=1)
    {
        global $lang; 
        
        $compteid = GetAccountId($mysqli,$compte);
        
        if($type==1)
        {
            $type_str = " AND event_type<=1";
        }
        else if ($type==2)
        {
            $type_str = " AND event_type>=4 AND event_type<=5";
        }
//        
//        error_log($compte . " AND " . $compteid);
        
        if($compteid>0)
        {
            $sql="SELECT id,name,type,img,url,price,quotes,nou,activities,special_img,no_online,ocult,destacat,event_type,propietari,sessio_unica FROM box_data WHERE propietari=$compteid" . $type_str .  " AND ocult=0 AND portada_btiquets=1 AND taquilla_tancada=0 ORDER BY RAND()";

            $result=$mysqli->query($sql); 
            $data = array();
            if($result)
            {            
                //error_log(count($result));
                while ( $row = $result->fetch_row() )
                {   
                    // 1a condició: que exisiteixi imatge principal
                    // if(file_exists("./../boxes/box_" . $row[0] . "/box_image_0_medium.jpg"))
                    if(file_exists("./../boxes/box_" . $row[0] . "/box_image_0.jpg"))
                    {
                        $b_visible = true;

                        // 2a condició: si és sessió única, que no sigui un esdeveniment passat
                        if($row[2]==0 && intval($row[15])>0)
                        {
                            $session = GetSession($mysqli,intval($row[15]));
                            $now = strtotime('now');
                            $ses = strtotime($session['data'].' '.$session['hora']);
                            $ant = strtotime(' - ' . $session['antelacio'] . ' hour',$ses);                            
                            if($now>$ant)
                            {
                                $b_visible=false;
                            }
                        }
                        if($row[2]==1)
                        {
                            $valid = -1;
                            foreach($sessions as $session)
                            {                
                                $now = strtotime('now');
                                $ses = strtotime($session['data'].' '.$session['hora']);
                                $ant = strtotime(' - ' . $session['antelacio'] . ' hour',$ses);                            
                                if($now<$ant)
                                {
                                    $valid = 1;
                                    break;
                                }
                            }
                        }

                        // 3a condició: si és sessió única, que quedin places
                        if($row[2]==0 && intval($row[15])>0)
                        {
                            $session = GetSession($mysqli,intval($row[15]));
                            $ocupacio = GetReservationFromBox($mysqli,$row[2]);

                            if($ocupacio>$session['places'])
                            {
                                $b_visible=false;
                            }
                        }                    

                        if($b_visible)
                        {
                            $data[] = array('id'=>$row[0],'name'=>$row[1],'type'=>$row[2],'img'=>'boxes/box_'.$row[0].'/'.$row[3],'url'=>$row[4],'price'=>$row[5],'quotes'=>$row[6],'nou'=>intval($row[7]),'activities'=>intval($row[8]),'special_img'=>'boxes/box_'.$row[0].'/'.$row[9],'no_online'=>intval($row[10]),'ocult'=>intval($row[11]),'destacat'=>intval($row[12]),'etype'=>intval($row[13]),'propietari'=>intval($row[14]));
                        }
                    }
                }
            }
        }
        else
        {
        }
        
        return $data;
    }
    
    function GetBoxListHome($mysqli)
    {
        global $lang; 
        
        $sql="SELECT id,name,type,img,url,price,quotes,nou,activities,special_img,no_online,ocult,destacat,event_type,propietari,sessio_unica FROM box_data WHERE ocult=0 AND portada_btiquets=1 AND taquilla_tancada=0 ORDER BY RAND()";
        
        $result=$mysqli->query($sql); 
        $data = array();
        if($result)
        {            
            while ( $row = $result->fetch_row() )
            {   
                // 1a condició: que exisiteixi imatge principal
                if(file_exists("./../boxes/box_" . $row[0] . "/box_image_0_medium.jpg"))
                {
                    $b_visible = true;
                    
                    // 2a condició: si és sessió única, que no sigui un esdeveniment passat
                    if($row[2]==0 && intval($row[15])>0)
                    {
                        $session = GetSession($mysqli,intval($row[15]));
                        $now = strtotime('now');
                        $ses = strtotime($session['data'].' '.$session['hora']);
                        $ant = strtotime(' - ' . $session['antelacio'] . ' hour',$ses);                            
                        if($now>$ant)
                        {
                            $b_visible=false;
                        }
                    }
                    if($row[2]==1)
                    {
                        $valid = -1;
                        foreach($sessions as $session)
                        {                
                            $now = strtotime('now');
                            $ses = strtotime($session['data'].' '.$session['hora']);
                            $ant = strtotime(' - ' . $session['antelacio'] . ' hour',$ses);                            
                            if($now<$ant)
                            {
                                $valid = 1;
                                break;
                            }
                        }
                    }
                    
                    // 3a condició: si és sessió única, que quedin places
                    if($row[2]==0 && intval($row[15])>0)
                    {
                        $session = GetSession($mysqli,intval($row[15]));
                        $ocupacio = GetReservationFromBox($mysqli,$row[2]);
                        
                        if($ocupacio>$session['places'])
                        {
                            $b_visible=false;
                        }
                    }                    
                    
                    if($b_visible)
                    {
                        $data[] = array('id'=>$row[0],'name'=>$row[1],'type'=>$row[2],'img'=>'boxes/box_'.$row[0].'/'.$row[3],'url'=>$row[4],'price'=>$row[5],'quotes'=>$row[6],'nou'=>intval($row[7]),'activities'=>intval($row[8]),'special_img'=>'boxes/box_'.$row[0].'/'.$row[9],'no_online'=>intval($row[10]),'ocult'=>intval($row[11]),'destacat'=>intval($row[12]),'etype'=>intval($row[13]),'propietari'=>intval($row[14]));
                    }
                }
            }
        }
        
        return $data;
    }

    function GetBoxListAdmin($mysqli,$type,$userid=-1)
    {        
        global $lang;          
                
        if($type==-1)
        {
            //TOTES SENSE LES ARXIVADES
            if($userid==-1)
            {            
                $sql="SELECT id,name,type,img,url,price,quotes,nou,activities,special_img,no_online,ocult,destacat,event_type,propietari,taquilla_arxivada FROM box_data WHERE taquilla_arxivada=0 ORDER BY name";
            }
            else
            {
                $sql="SELECT id,name,type,img,url,price,quotes,nou,activities,special_img,no_online,ocult,destacat,event_type,propietari,taquilla_arxivada FROM box_data WHERE propietari=$userid AND taquilla_arxivada=0 ORDER BY name";
            }
        }
        else if($type==-3)
        {
            //TOTES AMB LES ARXIVADES
            if($userid==-1)
            {            
                $sql="SELECT id,name,type,img,url,price,quotes,nou,activities,special_img,no_online,ocult,destacat,event_type,propietari,taquilla_arxivada FROM box_data ORDER BY name";
            }
            else
            {
                $sql="SELECT id,name,type,img,url,price,quotes,nou,activities,special_img,no_online,ocult,destacat,event_type,propietari,taquilla_arxivada FROM box_data WHERE propietari=$userid ORDER BY name";
            }
        }
        else if($type==-2)  // DESTACADES
        {
            $sql="SELECT id,name,type,img,url,price,quotes,nou,activities,special_img,no_online,ocult,destacat,event_type,propietari,taquilla_arxivada FROM box_data WHERE destacat=1 ORDER BY ipos";
        }
        else
        {
            $sql="SELECT id,name,type,img,url,price,quotes,nou,activities,special_img,no_online,ocult,destacat,event_type,propietari,taquilla_arxivada FROM box_data WHERE type=$type ORDER BY ipos";
        }
        
        $result=$mysqli->query($sql); 
        $data = array();
        if($result)
        {            
            while ( $row = $result->fetch_row() )
            {                
                $data[] = array('id'=>$row[0],'name'=>$row[1],'type'=>$row[2],'img'=>'boxes/box_'.$row[0].'/'.$row[3],'url'=>$row[4],'price'=>$row[5],'quotes'=>$row[6],'nou'=>intval($row[7]),'activities'=>intval($row[8]),'special_img'=>'boxes/box_'.$row[0].'/'.$row[9],'no_online'=>intval($row[10]),'ocult'=>intval($row[11]),'destacat'=>intval($row[12]),'etype'=>intval($row[13]),'propietari'=>intval($row[14]),'arxivada'=>intval($row[15]));
            }
        }
        
        return $data;
    }

    function GetHotelListAdmin($mysqli,$type,$userid=-1)
    {        
        global $lang;          
                
        if($type==-1)
        {
            //TOTES
            if($userid==-1)
            {            
                $sql="SELECT id,name,poblacio,mail,tel,web,description,type,modalitat,propietari FROM allotjaments ORDER BY name";
            }
            else
            {
                $sql="SELECT id,name,poblacio,mail,tel,web,description,type,modalitat,propietari FROM allotjaments WHERE propietari=$userid ORDER BY name";
            }
        }        
        
        $result=$mysqli->query($sql); 
        $data = array();
        if($result)
        {            
            while ( $row = $result->fetch_row() )
            {                
                $data[] = array('id'=>intval($row[0]),'name'=>$row[1],'poblacio'=>$row[2],'mail'=>$row[3],'tel'=>$row[4],'web'=>$row[5],'desc'=>$row[6],'type'=>intval($row[7]),'modalitat'=>$row[8],'propietari'=>intval($row[9]));
            }
        }
        
        return $data;
    }

    function GetProductListAdmin($mysqli,$type,$userid=-1)
    {        
        global $lang;          
                
        if($type==-1)
        {
            //TOTES
            if($userid==-1)
            {            
                $sql="SELECT id,name,poblacio,mail,tel,web,description,type,modalitat,propietari,ocult FROM productes ORDER BY name";
            }
            else
            {
                $sql="SELECT id,name,poblacio,mail,tel,web,description,type,modalitat,propietari,ocult FROM productes WHERE propietari=$userid ORDER BY name";
            }
        }        
        
        $result=$mysqli->query($sql); 
        $data = array();
        if($result)
        {            
            while ( $row = $result->fetch_row() )
            {                
                $data[] = array('id'=>intval($row[0]),'name'=>$row[1],'poblacio'=>$row[2],'mail'=>$row[3],'tel'=>$row[4],'web'=>$row[5],'desc'=>$row[6],'type'=>intval($row[7]),'modalitat'=>$row[8],'propietari'=>intval($row[9]),'ocult'=>intval($row[10]));
            }
        }
        
        return $data;
    }

    function GetEnviamentListAdmin($mysqli,$type,$userid=-1)
    {        
        global $lang;          
                
        if($type==-1)
        {
            //TOTES
            if($userid==-1)
            {            
                $sql="SELECT id,name,description,type,deststr,propietari FROM enviaments ORDER BY name";
            }
            else
            {
                $sql="SELECT id,name,description,type,deststr,propietari FROM enviaments WHERE propietari=$userid ORDER BY name";
            }
        }        
        
        $result=$mysqli->query($sql); 
        $data = array();
        if($result)
        {            
            while ( $row = $result->fetch_row() )
            {                
                $data[] = array('id'=>intval($row[0]),'name'=>$row[1],'description'=>$row[2],'type'=>intval($row[3]),'deststr'=>stripslashes($row[4]),'propietari'=>intval($row[5]));
            }
        }
        
        return $data;
    }

    function GetHotelfromList($mysqli,$hotel_str)
    {        
        global $lang;
        $data = array();
        
        $hotel_id_list = decode_hotel_str($hotel_str);
                            
        foreach($hotel_id_list as $hotel_iter)
        {
            $id = $hotel_iter['id'];
            global $lang;

            switch($lang)
            {
                case 'es':
                    $sql="SELECT id,name_es,poblacio,mail,tel,web,description_es,type,modalitat_es,propietari FROM allotjaments WHERE ocult=0 AND id='$id' ORDER BY name";  
                    break;

                case 'en':
                    $sql="SELECT id,name_en,poblacio,mail,tel,web,description_es,type,modalitat,modalitat_en,propietari FROM allotjaments WHERE ocult=0 AND id='$id' ORDER BY name";  
                    break;

                default:
                    $sql="SELECT id,name,poblacio,mail,tel,web,description,type,modalitat,propietari FROM allotjaments WHERE ocult=0 AND id='$id' ORDER BY name";  
                    break;
            }

            $result=$mysqli->query($sql);             
            if($result)
            {                   
                $row = $result->fetch_row();
                // decodifico l'string de capacitats i preu
                $cap_modalities = null;
                $cap_modalities = decode_cap($row[8]);
                $data[] = array('id'=>intval($row[0]),'name'=>$row[1],'poblacio'=>$row[2],'mail'=>$row[3],'tel'=>$row[4],'web'=>$row[5],'desc'=>$row[6],'type'=>intval($row[7]),'modalitat'=>$cap_modalities,'propietari'=>intval($row[9]));
            }
        }
        
        return $data;
    }

    function GetHotelReservation($mysqli,$code)
    {
        global $lang;
        $data = null;
        
        $aux = explode('_',$code);
        if($aux && sizeof($aux)>=2) {
            $hid = $aux[0];
            $rid = $aux[1];        

            switch($lang)
            {
                case 'es':
                    $sql="SELECT id,name_es,poblacio,type,modalitat_es FROM allotjaments WHERE ocult=0 AND id='$hid'";
                    break;

                case 'en':
                    $sql="SELECT id,name_en,poblacio,type,modalitat_es FROM allotjaments WHERE ocult=0 AND id='$hid'";
                    break;

                default:
                    $sql="SELECT id,name,poblacio,type,modalitat FROM allotjaments WHERE ocult=0 AND id='$hid'";  
                    break;
            }
            
            $result=$mysqli->query($sql);             
            if($result)
            {                   
                $row = $result->fetch_row();
                // decodifico l'string de capacitats i preu
                $mod = null;
                if($row){
                    $mod = decode_cap($row[4],$rid);
                    if($mod!=null){
                        $data = array('id'=>intval($row[0]),'name'=>$row[1],'poblacio'=>$row[2],'type'=>intval($row[3]),'modalitat'=>$mod[0]['nom']);
                    }    
                }
            }
        }
        
        return $data;
    }

    function GetProductefromList($mysqli,$prod_str)
    {        
        global $lang;
        $data = array();
        
        $prod_id_list = decode_producte_str($prod_str);
                            
        foreach($prod_id_list as $prod_iter)
        {
            $id = $prod_iter['id'];
            global $lang;

            switch($lang)
            {
                case 'es':
                    $sql="SELECT id,name_es,poblacio,mail,tel,web,description_es,type,modalitat_es,propietari FROM productes WHERE ocult=0 AND id='$id' ORDER BY name";  
                    break;

                case 'en':
                    $sql="SELECT id,name_en,poblacio,mail,tel,web,description_es,type,modalitat,modalitat_en,propietari FROM productes WHERE ocult=0 AND id='$id' ORDER BY name";  
                    break;

                default:
                    $sql="SELECT id,name,poblacio,mail,tel,web,description,type,modalitat,propietari FROM productes WHERE ocult=0 AND id='$id' ORDER BY name";  
                    break;
            }

            $result=$mysqli->query($sql);             
            if($result)
            {                   
                $row = $result->fetch_row();
                // decodifico l'string de stocks i preu
                $cap_modalities = null;
                $cap_modalities = decode_prod($row[8]);
                $data[] = array('id'=>intval($row[0]),'name'=>$row[1],'poblacio'=>$row[2],'mail'=>$row[3],'tel'=>$row[4],'web'=>$row[5],'desc'=>$row[6],'type'=>intval($row[7]),'modalitat'=>$cap_modalities,'propietari'=>intval($row[9]));
            }
        }
        
        return $data;
    }

    function GetPromoBoxList()
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        
        $sql="SELECT id,name,type,img,url,price,promo_id FROM box_data WHERE promo_id>0 ORDER BY ipos";
        
        $result=$mysqli->query($sql); 
        $data = array();
        if($result)
        {            
            while ( $row = $result->fetch_row() )
            {                
                $data[] = array('id'=>$row[0],'name'=>$row[1],'type'=>$row[2],'img'=>'boxes/box_'.$row[0].'/'.$row[3],'url'=>$row[4],'price'=>$row[5],'promo_id'=>intval($row[6]));
            }
        }
        
        return $data;
    }


    function GetRelatedBoxesTotal($bid,$activities,$cellers,$patrimoni,$visites,$rutes)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;        
        global $lang;
        $data = array();
        
        switch($lang)
        {
            case 'es':
                $sql="SELECT id,name_es,type,img,url,price_es,no_online,nou,BIT_COUNT(activities & $activities) + BIT_COUNT(cellers & $cellers) + BIT_COUNT(patrimoni & $patrimoni) + BIT_COUNT(visites & $visites) + BIT_COUNT(rutes & $rutes) as c FROM box_data WHERE BIT_COUNT(activities & $activities) + BIT_COUNT(cellers & $cellers) + BIT_COUNT(patrimoni & $patrimoni) + BIT_COUNT(visites & $visites) + BIT_COUNT(rutes & $rutes) > 0 AND id!=$bid AND ocult=0 ORDER BY c DESC";
                break;
            
            case 'en':
                $sql="SELECT id,name_en,type,img,url,price_en,no_online,nou,BIT_COUNT(activities & $activities) + BIT_COUNT(cellers & $cellers) + BIT_COUNT(patrimoni & $patrimoni) + BIT_COUNT(visites & $visites) + BIT_COUNT(rutes & $rutes) as c FROM box_data WHERE BIT_COUNT(activities & $activities) + BIT_COUNT(cellers & $cellers) + BIT_COUNT(patrimoni & $patrimoni) + BIT_COUNT(visites & $visites) + BIT_COUNT(rutes & $rutes) > 0 AND id!=$bid AND ocult=0 ORDER BY c DESC";
                break;
            
            default:
                $sql="SELECT id,name,type,img,url,price,no_online,nou,BIT_COUNT(activities & $activities) + BIT_COUNT(cellers & $cellers) + BIT_COUNT(patrimoni & $patrimoni) + BIT_COUNT(visites & $visites) + BIT_COUNT(rutes & $rutes) as c FROM box_data WHERE BIT_COUNT(activities & $activities) + BIT_COUNT(cellers & $cellers) + BIT_COUNT(patrimoni & $patrimoni) + BIT_COUNT(visites & $visites) + BIT_COUNT(rutes & $rutes) > 0 AND id!=$bid AND ocult=0 ORDER BY c DESC";
                break;
        }
                
        $result=$mysqli->query($sql);
        if($result)
        {
            while ( $row = $result->fetch_row() )
            {
                $data[] = array('id'=>$row[0],'name'=>$row[1],'type'=>$row[2],'img'=>'boxes/box_'.$row[0].'/'.$row[3],'url'=>$row[4],'price'=>$row[5],'no_online'=>intval($row[6]),'nou'=>intval($row[7]));
            }
        }

        return $data;
    }

    function GetCellerBoxesTotal($bid,$celler)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;        
        global $lang;
        $data = array();
        
        
        
        switch($lang)
        {
            case 'es':
                $sql="SELECT id,name_es,type,img,url,price_es,no_online,nou FROM box_data WHERE BIT_COUNT(cellers & pow(2,$celler))>0 AND id!=$bid AND ocult=0 ORDER BY RAND()";
                break;
            
            case 'en':
                $sql="SELECT id,name_en,type,img,url,price_en,no_online,nou FROM box_data WHERE BIT_COUNT(cellers & pow(2,$celler))>0 AND id!=$bid AND ocult=0 ORDER BY RAND()";
                break;
            
            default:
                $sql="SELECT id,name,type,img,url,price,no_online,nou FROM box_data WHERE BIT_COUNT(cellers & pow(2,$celler))>0 AND id!=$bid AND ocult=0 ORDER BY RAND()";
                break;
        }
                
        $result=$mysqli->query($sql);
        if($result)
        {
            while ( $row = $result->fetch_row() )
            {
                $data[] = array('id'=>$row[0],'name'=>$row[1],'type'=>$row[2],'img'=>'boxes/box_'.$row[0].'/'.$row[3],'url'=>$row[4],'price'=>$row[5],'no_online'=>intval($row[6]),'nou'=>intval($row[7]));
            }
        }

        return $data;
    }

    function GetBoxPrices($mysqli,$id)
    {
        global $lang;
        
        switch($lang)
        {
            case 'es':
                $sql="SELECT price_es FROM box_data WHERE id=$id";
                break;
            
            case 'en':
                $sql="SELECT price_en FROM box_data WHERE id=$id";        
                break;
            
            default:
                $sql="SELECT price FROM box_data WHERE id=$id";        
                break;
        }                
        
        $result=$mysqli->query($sql); 
        $data = array();
        if($result)
        {            
            $row = $result->fetch_row();
            $aux = explode(";",$row[0]);
            for ($i = 0; $i < count($aux); $i++)
            {
                if($aux[$i]!="")
                {
                    $aux2 = explode(":",$aux[$i]);
                    if(count($aux2>=2))
                    $data[] = array('nom'=>$aux2[0],'preu'=>$aux2[1]);
                }
            }
        }
        
        return $data;
    }

    function GetPromoList()
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        
        $sql="SELECT id,nom,descripcio,col_id,punts FROM promocions ORDER BY ipos";
        
        $result=$mysqli->query($sql); 
        $data = array();
        if($result)
        {            
            while ( $row = $result->fetch_row() )
            {                
                $data[] = array('id'=>intval($row[0]),'name'=>$row[1],'description'=>htmlspecialchars(stripslashes($row[2])),'col_id'=>$row[3],'punts'=>intval($row[4]));
            }
        }
        
        return $data;
    }

    function GetPromo($id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        $data=null;
        
        $sql="SELECT * FROM promocions WHERE id=$id";
        
        $result=$mysqli->query($sql); 
        if($result)
        {            
            $row = $result->fetch_row();
            $data = array('id'=>intval($row[0]),'name'=>html_entity_decode(htmlspecialchars(stripslashes($row[1]))),'description'=>html_entity_decode(nl2br(htmlspecialchars(stripslashes($row[2])))),'conditions'=>html_entity_decode(nl2br(htmlspecialchars(stripslashes($row[3])))),'col_id'=>intval($row[4]),'punts'=>intval($row[5]));
        }
        
        return $data;
    }

    function GetCellerList()
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        
        $sql="SELECT id,name,img,url,visita FROM cellers";
        
        $result=$mysqli->query($sql); 
        $data = array();
        if($result)
        {            
            while ( $row = $result->fetch_row() )
            {                
                $data[] = array('id'=>$row[0],'name'=>$row[1],'img'=>$row[2],'url'=>$row[3],'visita'=>$row[4]);
            }
        }
        
        return $data;
    }

    function GetCeller($id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        global $lang;
        
        switch($lang)
        {
            case 'es':
                $sql="SELECT id,name,description_es,img,url,visita,descripcio_visita_es,add_1,add_2,tel,email,facebook,twitter,web,instagram FROM cellers WHERE id='$id'";
                break;
            
            case 'en':
                $sql="SELECT id,name,description_en,img,url,visita,descripcio_visita_en,add_1,add_2,tel,email,facebook,twitter,web,instagram FROM cellers WHERE id='$id'";
                break;
            
            default:
                $sql="SELECT id,name,description,img,url,visita,descripcio_visita,add_1,add_2,tel,email,facebook,twitter,web,instagram FROM cellers WHERE id='$id'";
                break;
        }        
        
        $result=$mysqli->query($sql); 
        if($result)
        {            
            $row = $result->fetch_row();
            $data = array('id'=>$row[0],'name'=>$row[1],'description'=>nl2br(stripslashes($row[2])),'img'=>$row[3],'url'=>$row[4],'visita'=>intval($row[5]),'visita_desc'=>nl2br(stripslashes($row[6])),'add_1'=>stripslashes($row[7]),'add_2'=>stripslashes($row[8]),'tel'=>stripslashes($row[9]),'email'=>stripslashes($row[10]),'facebook'=>stripslashes($row[11]),'twitter'=>stripslashes($row[12]),'web'=>stripslashes($row[13]),'instagram'=>stripslashes($row[14]));
        }
        
        return $data;
    }

    function GetRestList()
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        
        $sql="SELECT id,name,img,url FROM restaurants ORDER BY ipos";
        
        $result=$mysqli->query($sql); 
        $data = array();
        if($result)
        {            
            while ( $row = $result->fetch_row() )
            {                
                $data[] = array('id'=>$row[0],'name'=>$row[1],'img'=>$row[2],'url'=>$row[3]);
            }
        }
        
        return $data;
    }

    function GetAllRestList()
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        global $lang;

        switch($lang)
        {
            case 'es':
                $sql="SELECT id,name,description_es,img,url,add_1,add_2,tel,email,facebook,twitter,web,instagram,tipus_es,lat,lng,ciutat,quotes_es,logo,logo_2 FROM restaurants WHERE ocult=0 ORDER BY RAND()";
                break;
            
            case 'en':
                $sql="SELECT id,name,description_en,img,url,add_1,add_2,tel,email,facebook,twitter,web,instagram,tipus_en,lat,lng,ciutat,quotes_en,logo,logo_2 FROM restaurants WHERE ocult=0 ORDER BY RAND()";
                break;
            
            default:
                $sql="SELECT id,name,description,img,url,add_1,add_2,tel,email,facebook,twitter,web,instagram,tipus,lat,lng,ciutat,quotes,logo,logo_2 FROM restaurants WHERE ocult=0 ORDER BY RAND()";
                break;
        }        
        
        $result=$mysqli->query($sql);
        $data = array();
        if($result)
        {            
            while ( $row = $result->fetch_row() )
            {
                $data[] = array('id'=>$row[0],'name'=>$row[1],'description'=>nl2br(stripslashes($row[2])),'quotes'=>stripslashes($row[17]),'img'=>$row[3],'logo'=>$row[18],'logo_2'=>$row[19],'url'=>$row[4],'add_1'=>stripslashes($row[5]),'add_2'=>stripslashes($row[6]),'tel'=>stripslashes($row[7]),'email'=>stripslashes($row[8]),'facebook'=>stripslashes($row[9]),'twitter'=>stripslashes($row[10]),'web'=>stripslashes($row[11]),'instagram'=>stripslashes($row[12]),'tipus'=>nl2br(stripslashes($row[13])),'lat'=>floatval($row[14]),'lng'=>floatval($row[15]),'city'=>intval($row[16]));
            }
        }
        
        return $data;
    }

    function GetRest($mysqli,$id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $lang;
        
        switch($lang)
        {
            case 'es':
                $sql="SELECT id,name,description_es,img,url,add_1,add_2,tel,email,facebook,twitter,web,instagram,tipus_es,lat,lng,ciutat,quotes_es,logo,horari_es,logo_2,col_id FROM restaurants WHERE id='$id'";
                break;
            
            case 'en':
                $sql="SELECT id,name,description_en,img,url,add_1,add_2,tel,email,facebook,twitter,web,instagram,tipus_en,lat,lng,ciutat,quotes_en,logo,horari_en,logo_2,col_id FROM restaurants WHERE id='$id'";
                break;
            
            default:
                $sql="SELECT id,name,description,img,url,add_1,add_2,tel,email,facebook,twitter,web,instagram,tipus,lat,lng,ciutat,quotes,logo,horari,logo_2,col_id FROM restaurants WHERE id='$id'";
                break;
        }
        
        $result=$mysqli->query($sql); 
        if($result)
        {            
            $row = $result->fetch_row();
            $data = array('id'=>$row[0],'name'=>$row[1],'description'=>nl2br(stripslashes($row[2])),'quotes'=>stripslashes($row[17]),'horari'=>nl2br(stripslashes($row[19])),'img'=>$row[3],'logo'=>$row[18],'logo_2'=>$row[20],'url'=>$row[4],'add_1'=>stripslashes($row[5]),'add_2'=>stripslashes($row[6]),'tel'=>stripslashes($row[7]),'email'=>stripslashes($row[8]),'facebook'=>stripslashes($row[9]),'twitter'=>stripslashes($row[10]),'web'=>stripslashes($row[11]),'instagram'=>stripslashes($row[12]),'tipus'=>nl2br(stripslashes($row[13])),'lat'=>floatval($row[14]),'lng'=>floatval($row[15]),'city'=>intval($row[16]),'col_id'=>intval($row[21]));
        }
        
        return $data;
    }

    function GetAlljList()
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        
        $sql="SELECT id,name,img,url FROM allotjaments ORDER BY ipos";
        
        $result=$mysqli->query($sql); 
        $data = array();
        if($result)
        {            
            while ( $row = $result->fetch_row() )
            {                
                $data[] = array('id'=>$row[0],'name'=>$row[1],'img'=>$row[2],'url'=>$row[3]);
            }
        }
        
        return $data;
    }

    function GetAllAlljList()
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        global $lang;

        switch($lang)
        {
            case 'es':
                $sql="SELECT id,name,description_es,img,url,add_1,add_2,tel,email,facebook,twitter,web,instagram,tipus_es,lat,lng,ciutat,quotes_es,logo,logo_2 FROM allotjaments ORDER BY RAND()";
                break;
            
            case 'en':
                $sql="SELECT id,name,description_en,img,url,add_1,add_2,tel,email,facebook,twitter,web,instagram,tipus_en,lat,lng,ciutat,quotes_en,logo,logo_2 FROM allotjaments ORDER BY RAND()";
                break;
            
            default:
                $sql="SELECT id,name,description,img,url,add_1,add_2,tel,email,facebook,twitter,web,instagram,tipus,lat,lng,ciutat,quotes,logo,logo_2 FROM allotjaments ORDER BY RAND()";
                break;
        }        
        
        $result=$mysqli->query($sql);
        $data = array();
        if($result)
        {            
            while ( $row = $result->fetch_row() )
            {
                $data[] = array('id'=>$row[0],'name'=>$row[1],'description'=>nl2br(stripslashes($row[2])),'quotes'=>stripslashes($row[17]),'img'=>$row[3],'logo'=>$row[18],'logo_2'=>$row[19],'url'=>$row[4],'add_1'=>stripslashes($row[5]),'add_2'=>stripslashes($row[6]),'tel'=>stripslashes($row[7]),'email'=>stripslashes($row[8]),'facebook'=>stripslashes($row[9]),'twitter'=>stripslashes($row[10]),'web'=>stripslashes($row[11]),'instagram'=>stripslashes($row[12]),'tipus'=>nl2br(stripslashes($row[13])),'lat'=>floatval($row[14]),'lng'=>floatval($row[15]),'city'=>intval($row[16]));
            }
        }
        
        return $data;
    }

    function GetAllj($mysqli,$id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $lang;
        
        switch($lang)
        {
            case 'es':
                $sql="SELECT id,name,description_es,img,url,add_1,add_2,tel,email,facebook,twitter,web,instagram,tipus_es,lat,lng,ciutat,quotes_es,logo,horari_es,logo_2,col_id FROM allotjaments WHERE id='$id'";
                break;
            
            case 'en':
                $sql="SELECT id,name,description_en,img,url,add_1,add_2,tel,email,facebook,twitter,web,instagram,tipus_en,lat,lng,ciutat,quotes_en,logo,horari_en,logo_2,col_id FROM allotjaments WHERE id='$id'";
                break;
            
            default:
                $sql="SELECT id,name,description,img,url,add_1,add_2,tel,email,facebook,twitter,web,instagram,tipus,lat,lng,ciutat,quotes,logo,horari,logo_2,col_id FROM allotjaments WHERE id='$id'";
                break;
        }
        
        $result=$mysqli->query($sql); 
        if($result)
        {            
            $row = $result->fetch_row();
            $data = array('id'=>$row[0],'name'=>$row[1],'description'=>nl2br(stripslashes($row[2])),'quotes'=>stripslashes($row[17]),'horari'=>nl2br(stripslashes($row[19])),'img'=>$row[3],'logo'=>$row[18],'logo_2'=>$row[20],'url'=>$row[4],'add_1'=>stripslashes($row[5]),'add_2'=>stripslashes($row[6]),'tel'=>stripslashes($row[7]),'email'=>stripslashes($row[8]),'facebook'=>stripslashes($row[9]),'twitter'=>stripslashes($row[10]),'web'=>stripslashes($row[11]),'instagram'=>stripslashes($row[12]),'tipus'=>nl2br(stripslashes($row[13])),'lat'=>floatval($row[14]),'lng'=>floatval($row[15]),'city'=>intval($row[16]),'col_id'=>intval($row[21]));
        }
        
        return $data;
    }

    function GetBoxes($mysqli)
    {        
        $sql="SELECT id,name FROM box_data";
        
        $result=$mysqli->query($sql); 
        $data = array();
        $data[-1] = "Personalitzada";
        if($result)
        {            
            while ( $row = $result->fetch_row() )
            {       
                $data[$row[0]] = $row[1];
            }
        }
        
        return $data;
    }

    function GetBoxesbyCol($mysqli,$colid)
    {
        $aux = ';'.$colid.';';
        $sql="SELECT id,name FROM box_data WHERE collaboradors LIKE '$aux'";
        
        $result=$mysqli->query($sql); 
        $data = array();
        if($result)
        {            
            while ( $row = $result->fetch_row() )
            {       
                $data[] = array('id'=>$row[0],'name'=>$row[1]);
            }
        }
        
        return $data;
    }

    function GetBox($mysqli,$id,$ext_lang="")
    {
        global $lang;
        
        if($ext_lang!="")
        {
            $lang = $ext_lang;
        }

        switch($lang)
        {
            case 'es':
                $sql="SELECT name_es,type,description_es,price_es,quotes_es,activities,details_es,reservation_es,n_min,n_max,lat,lng,url,event_type,data,n_total,cellers,patrimoni,visites,rutes,promo_quant,promo_id,no_online,special_img,extra_fields,img,collaboradors,qr_img,persons_per_ticket,res_days,close_time,propietari,sessio_unica,ocult,aavv,mail_aux,com_obl,com_aux,linksessions,recordatori_es,xaccept,xaccept_description_es,taquilla_tancada,productes,enviament_id,pagament,enviament_str,codi_descompte,productes_relacionats,taquilla_arxivada FROM box_data WHERE id=$id";
                break;
            
            case 'en':
                $sql="SELECT name_en,type,description_en,price_en,quotes_en,activities,details_en,reservation_en,n_min,n_max,lat,lng,url,event_type,data,n_total,cellers,patrimoni,visites,rutes,promo_quant,promo_id,no_online,special_img,extra_fields,img,collaboradors,qr_img,persons_per_ticket,res_days,close_time,propietari,sessio_unica,ocult,aavv,mail_aux,com_obl,com_aux,linksessions,recordatori_en,xaccept,xaccept_description_en,taquilla_tancada,productes,enviament_id,pagament,enviament_str,codi_descompte,productes_relacionats,taquilla_arxivada FROM box_data WHERE id=$id";
                break;
            
            default:
                $sql="SELECT name,type,description,price,quotes,activities,details,reservation,n_min,n_max,lat,lng,url,event_type,data,n_total,cellers,patrimoni,visites,rutes,promo_quant,promo_id,no_online,special_img,extra_fields,img,collaboradors,qr_img,persons_per_ticket,res_days,close_time,propietari,sessio_unica,ocult,aavv,mail_aux,com_obl,com_aux,linksessions,recordatori,xaccept,xaccept_description,taquilla_tancada,productes,enviament_id,pagament,enviament_str,codi_descompte,productes_relacionats,taquilla_arxivada FROM box_data WHERE id=$id";
                break;
        }
        $result=$mysqli->query($sql);
        $box = null;
        if($result)
        {
            $row = $result->fetch_row();
            if($row!=null)
            {
                $res_total = 0;
                if(intval($row[13])==1)
                {                
                    $sql="SELECT quantitat FROM reserva WHERE box_id=$id AND confirmat>=1";
                    $result2=$mysqli->query($sql);
                    while ( $row2 = $result2->fetch_row() )
                    {
                        $aux = explode(";",$row2[0]);
                        for ($i = 0; $i < count($aux); $i++)
                        {
                            if($aux[$i]!="")
                            {
                                $res_total += intval($aux[$i]);
                            }
                        }
                    }
                }

                $box = array('id'=>$id,'name'=>$row[0],'type'=>$row[1],'description'=>html_entity_decode(nl2br(htmlspecialchars(stripslashes($row[2])))),'price'=>$row[3],'quotes'=>html_entity_decode(nl2br(htmlspecialchars(stripslashes($row[4])))),'activities'=>floatval($row[5]),'details'=>html_entity_decode(nl2br(htmlspecialchars(stripslashes($row[6])))),'use'=>html_entity_decode(nl2br(htmlspecialchars(stripslashes($row[7])))),'n_min'=>intval($row[8]),'n_max'=>intval($row[9]),'lat'=>floatval($row[10]),'lng'=>floatval($row[11]),'url'=>$row[12],'etype'=>intval($row[13]),'edate'=>stripslashes($row[14]),'etotal'=>intval($row[15]),'erestotal'=>$res_total,'cellers'=>$row[16],'patrimoni'=>$row[17],'visites'=>$row[18],'rutes'=>$row[19],'promo_quant'=>floatval($row[20]),'promo_id'=>intval($row[21]),'no_online'=>intval($row[22]),'special_img'=>$row[23],'extra_fields'=>intval($row[24]),'img'=>'boxes/box_'.$id.'/'.$row[25],'collaboradors'=>stripslashes($row[26]),'qr_img'=>$row[27],'persons_per_ticket'=>$row[28],'res_days'=>$row[29],'close_time'=>intval($row[30]),'propietari'=>intval($row[31]),'sessio_unica'=>intval($row[32]),'ocult'=>intval($row[33]),'aavv'=>intval($row[34]),'mail_aux'=>stripslashes($row[35]),'com_obl'=>intval($row[36]),'com_aux'=>stripslashes($row[37]),'linksessions'=>intval($row[38]),'recordatori'=>stripslashes($row[39]),'xaccept'=>intval($row[40]),'xaccept_description'=>stripslashes($row[41]),'taquilla_tancada'=>intval($row[42]),'productes'=>stripslashes($row[43]),'enviament_id'=>intval($row[44]),'pagament'=>intval($row[45]),'enviament_str'=>stripslashes($row[46]),'codi_descompte'=>stripslashes($row[47]),'productes_relacionats'=>stripslashes($row[48]),'arxivada'=>intval($row[49]));
            }
        }

        return $box;
    }

    function GetTranslationText()
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';

        global $mysqli;
        global $lang;

        $sql="SELECT name,description,quotes FROM box_data WHERE 1";     
        $result=$mysqli->query($sql);
        $data = "";
        if($result)
        {
            while ( $row = $result->fetch_row() )
            {
                $data .= '<u>';
                $data .= $row[0];
                $data .= '</u><br><br>';
                $data .= html_entity_decode(nl2br(htmlspecialchars(stripslashes($row[1]))));
                $data .= '<br><br>';
                $data .= html_entity_decode(nl2br(htmlspecialchars(stripslashes($row[2]))));
                $data .= '<br><br><br>';
            }
        }

        return $data;
    }

    function GelColImages($colidlist)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        $data = array();
        global $mysqli;
        
        $collist=explode(';',$colidlist);
        foreach($collist as $coliter)
        {
            $result = $mysqli->query("SELECT nom FROM collaboradors WHERE id='$coliter'");
            if($result != null)
            {
                $row = $result->fetch_row();
                $data[] = array('id'=>$coliter,'name'=>$row[0],'img'=>GetFolderImages("cols/col_" . $coliter));
            }
        }
        return $data;
    }

    function GetUsersInfo($mysqli)
    {
        $data = array();
        
        $result = $mysqli->query("SELECT * FROM members ORDER BY username ASC");
                
        if($result != null)
        {            
            while ( $row = $result->fetch_row() )
            {       
                $data[] = array('id'=>$row[0],'name'=>$row[1],'surnames'=>$row[2],'email'=>$row[3],'country'=>$row[10],'tel'=>$row[11],'last_visit'=>$row[6],'creation'=>$row[7],'confirmed'=>$row[8],'deleted'=>$row[12],'city'=>$row[15],'newsletter'=>$row[16]);
            }
        }
            
        return $data;   
    }

    function GetAccountsInfo($mysqli)
    {
        $data = array();
        
        $result = $mysqli->query("SELECT * FROM comptes ORDER BY nom ASC");
                
        if($result != null)
        {            
            while ( $row = $result->fetch_row() )
            {
                
                if($row[19]=="")
                {
                    $nom_url = to_slug($row[1]);
                    $mysqli->query("UPDATE comptes SET `nom_url`='$nom_url' WHERE id='$row[0]'");
                }
                else
                {
                    $nom_url = $row[19];
                }
                
                $userdata = GetUInfo($mysqli,$row[2]);
                if($userdata==null)
                {
                    $data[] = array('id'=>$row[0],'nom'=>$row[1],'uid'=>$row[2],'propietari'=>"",'nom_url'=>$nom_url);
                }
                else
                {
                    $data[] = array('id'=>$row[0],'nom'=>$row[1],'uid'=>$row[2],'propietari'=>$userdata['name'] . ' ' . $userdata['surnames'],'nom_url'=>$nom_url);
                }
            }
        }
            
        return $data;   
    }

    function GetAccountInfo($mysqli,$id)
    {        
        $result = $mysqli->query("SELECT * FROM comptes WHERE id='$id'");
        $data = null;
        if($result != null)
        { 
            $row = $result->fetch_row();
            if($row!=null)
            {
                $userdata = GetUInfo($mysqli,$row[2]);
                if($userdata==null)
                {
                    $data = array('id'=>$row[0],'nom'=>$row[1],'uid'=>$row[2],'propietari'=>"",'max_activitats'=>$row[3],'permisos'=>$row[4],'merchantcode'=>$row[5],'terminal'=>$row[6],'currency'=>$row[7],'key'=>$row[8],'url'=>$row[9],'btype_0'=>intval($row[10]),'btype_1'=>intval($row[11]),'btype_2'=>intval($row[12]),'btype_3'=>intval($row[13]),'btype_4'=>intval($row[17]),'btype_5'=>intval($row[18]),'btype_6'=>intval($row[21]),'btype_7'=>intval($row[22]),'mail'=>$row[14],'lopd'=>$row[15],'extern'=>intval($row[16]),'bizum'=>intval($row[20]),'versio'=>intval($row[23]));
                }
                else
                {
                    $data = array('id'=>$row[0],'nom'=>$row[1],'uid'=>$row[2],'propietari'=>$userdata['name'] . ' ' . $userdata['surnames'],'max_activitats'=>$row[3],'permisos'=>$row[4],'merchantcode'=>$row[5],'terminal'=>$row[6],'currency'=>$row[7],'key'=>$row[8],'url'=>$row[9],'btype_0'=>intval($row[10]),'btype_1'=>intval($row[11]),'btype_2'=>intval($row[12]),'btype_3'=>intval($row[13]),'btype_4'=>intval($row[17]),'btype_5'=>intval($row[18]),'btype_6'=>intval($row[21]),'btype_7'=>intval($row[22]),'mail'=>$row[14],'lopd'=>$row[15],'extern'=>intval($row[16]),'bizum'=>intval($row[20]),'versio'=>intval($row[23]));
                }
            }
        }
                  
        return $data;
    }

    function GetAccountId($mysqli,$nom_url)
    {        
        $result = $mysqli->query("SELECT id FROM comptes WHERE LOWER(nom_url)=LOWER('$nom_url')");
        $id = -1;
        if($result != null)
        { 
            $row = $result->fetch_row();
            if($row != null)
            {
                $id = $row[0];
            }
        }
                  
        return $id;
    }

    function GetAccountfromUserInfo($mysqli,$id)
    {        
        $result = $mysqli->query("SELECT * FROM comptes WHERE propietari='$id'");   
        $data = null;
        if($result != null)
        { 
            $row = $result->fetch_row();
            $userdata = GetUInfo($mysqli,$row[2]);
            $data = array('id'=>$row[0],'nom'=>$row[1],'uid'=>$row[2],'propietari'=>$userdata['name'] . ' ' . $userdata['surnames'],'btype_0'=>intval($row[10]),'btype_1'=>intval($row[11]),'btype_2'=>intval($row[12]),'btype_3'=>intval($row[13]),'btype_4'=>intval($row[17]),'btype_5'=>intval($row[18]),'btype_6'=>intval($row[21]),'btype_7'=>intval($row[22]),'mail'=>$row[14],'lopd'=>$row[15],'extern'=>intval($row[16]),'bizum'=>intval($row[20]),'versio'=>intval($row[23]));
        }
                  
        return $data;
    }

    function GetActivitiesfromUser($mysqli,$id)
    { 
        $data = array('btype_0'=>0,'btype_1'=>0,'btype_2'=>0,'btype_3'=>0,'btype_4'=>0,'btype_5'=>0,'btype_6'=>0,'btype_7'=>0);
        $result = $mysqli->query("SELECT COUNT(*) FROM box_data AS box WHERE propietari='$id' AND box.event_type='0'");
        if($result != null)
        { 
            $row = $result->fetch_row();
            $data['btype_0']=intval($row[0]);
        }
        $result = $mysqli->query("SELECT COUNT(*) FROM box_data AS box WHERE propietari='$id' AND box.event_type='1'");
        if($result != null)
        { 
            $row = $result->fetch_row();
            $data['btype_1']=intval($row[0]);
        }
        $result = $mysqli->query("SELECT COUNT(*) FROM box_data AS box WHERE propietari='$id' AND box.event_type='2'");
        if($result != null)
        { 
            $row = $result->fetch_row();
            $data['btype_2']=intval($row[0]);
        }
        $result = $mysqli->query("SELECT COUNT(*) FROM box_data AS box WHERE propietari='$id' AND box.event_type='3'");
        if($result != null)
        { 
            $row = $result->fetch_row();
            $data['btype_3']=intval($row[0]);
        }
        $result = $mysqli->query("SELECT COUNT(*) FROM box_data AS box WHERE propietari='$id' AND box.event_type='4'");
        if($result != null)
        { 
            $row = $result->fetch_row();
            $data['btype_4']=intval($row[0]);
        }
        $result = $mysqli->query("SELECT COUNT(*) FROM box_data AS box WHERE propietari='$id' AND box.event_type='5'");
        if($result != null)
        { 
            $row = $result->fetch_row();
            $data['btype_5']=intval($row[0]);
        }
        $result = $mysqli->query("SELECT COUNT(*) FROM box_data AS box WHERE propietari='$id' AND box.event_type='6'");
        if($result != null)
        { 
            $row = $result->fetch_row();
            $data['btype_6']=intval($row[0]);
        }
        $result = $mysqli->query("SELECT COUNT(*) FROM box_data AS box WHERE propietari='$id' AND box.event_type='7'");
        if($result != null)
        { 
            $row = $result->fetch_row();
            $data['btype_7']=intval($row[0]);
        }
                  
        return $data;
    }

    function GetAllotjamentsfromUser($mysqli,$id)
    { 
        $data = array();
        $result = $mysqli->query("SELECT id,name,type FROM allotjaments WHERE propietari='$id'");
        if($result != null)
        { 
            while ( $row = $result->fetch_row() )
            {
                $data[] = array('id'=>$row[0],'name'=>$row[1],'type'=>$row[2]);
            }
        }        
                  
        return $data;
    }

    function GetProductesfromUser($mysqli,$id)
    { 
        $data = array();
        $result = $mysqli->query("SELECT id,name,type FROM productes WHERE propietari='$id'");
        if($result != null)
        { 
            while ( $row = $result->fetch_row() )
            {
                $data[] = array('id'=>$row[0],'name'=>$row[1],'type'=>$row[2]);
            }
        }        
                  
        return $data;
    }

    function GetEnviamentsfromUser($mysqli,$id)
    { 
        $data = array();
        $result = $mysqli->query("SELECT id,name,type,deststr FROM enviaments WHERE propietari='$id'");
        if($result != null)
        { 
            while ( $row = $result->fetch_row() )
            {
                $data[] = array('id'=>$row[0],'name'=>$row[1],'type'=>intval($row[2]),'deststr'=>stripslashes($row[3]));
            }
        }        
                  
        return $data;
    }

    function GetEnviamentsfromBox($mysqli,$id,$env_str)
    {   
        $env_list=explode(';',$env_str);
        if($id==0)
        {
            $data = array('id'=>0,'name'=>'Recollida','type'=>0,'list'=>null);
        }
        else if($id==-1)
        {
            $data = array('id'=>-1,'name'=>'Enviament gratuït','type'=>-1,'list'=>null);
        }
        else if($id==-2)
        {
            $data_env = array();
            foreach($env_list as $env_id)
            {
                $result = $mysqli->query("SELECT id,name,type,deststr FROM enviaments WHERE id='$env_id'");
                if($result != null)
                {
                    $row = $result->fetch_row();
                    $data_env[] = array('id'=>$row[0],'name'=>$row[1],'type'=>intval($row[2]),'deststr'=>stripslashes($row[3]));
                }                
            }
            
            if(count($data_env)>0)
            {
                $data = array('id'=>-1,'name'=>'','type'=>-2,'list'=>$data_env);
            }
            else
            {
                $data = array('id'=>-1,'name'=>'','type'=>-2,'list'=>null);
            }
        }
        else
        {
        }
                  
        return $data;
    }

    function GetUInfo($mysqli,$id)
    {        
        $result = $mysqli->query("SELECT * FROM members WHERE id='$id'");
        $data = null;
        if($result != null)
        { 
            $row = $result->fetch_row();
            if($row!=null)
            {
                $data = array('id'=>$row[0],'name'=>$row[1],'surnames'=>$row[2],'email'=>$row[3],'country'=>$row[10],'tel'=>$row[11],'last_visit'=>$row[6],'creation'=>$row[7],'confirmed'=>$row[8],'deleted'=>$row[12]);
            }
        }
                  
        return $data;
    }

    function GetColsInfo()
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        $data = array();
        global $mysqli;
        
        $result = $mysqli->query("SELECT * FROM collaboradors ORDER BY nom ASC ");
                
        if($result != null)
        {
            while ( $row = $result->fetch_row() )
            {
                $result2 = $mysqli->query("SELECT username,surnames,email,tel FROM members WHERE id=$row[2]");

                if($result2 != null)
                {
                    $row2 = $result2->fetch_row();

                    $data[] = array('id'=>$row[0],'name'=>$row[1],'username'=>$row2[0],'surnames'=>$row2[1],'email'=>$row2[2],'tel'=>$row2[3]);
                }
            }
        }

        return $data;
    }

    function GetReservationFromBox($mysqli,$box_id)
    {
        $ret = 0;
        $result = $mysqli->query("SELECT quantitat FROM reserva WHERE box_id='$box_id' AND confirmat='1'");
        if($result != null)
        { 
            while ( $row = $result->fetch_row() )
            {
                $quantarray = explode(';',$row[0]);
                foreach($quantarray as $quant)
                {
                    $ret+=intval($quant);
                }
            }
        }
        
        return $ret;
    }

    function GetReservationFromBox_modalities($mysqli,$box_id,$modalities)
    {
        $ret = array();
        for($i=0;$i<$modalities;$i++)
        {
            $ret[$i]=0;
        }
        $result = $mysqli->query("SELECT quantitat FROM reserva WHERE box_id='$box_id' AND confirmat='1'");
        if($result != null)
        { 
            while ( $row = $result->fetch_row() )
            {
                $quantarray = explode(';',$row[0]);
                $i=0;
                foreach($quantarray as $quant)
                {
                    if($i<$modalities)  $ret[$i]+=intval($quant);
                    $i++;
                }
            }
        }
        
        return $ret;
    }

    function GetReservationFromSession($mysqli,$session_id)
    {
        $ret = 0;
        $result = $mysqli->query("SELECT quantitat FROM reserva WHERE session_id='$session_id' AND confirmat='1'");
        if($result != null)
        { 
            while ( $row = $result->fetch_row() )
            {
                $quantarray = explode(';',$row[0]);
                foreach($quantarray as $quant)
                {
                    $ret+=intval($quant);
                }
            }
        }
        
        return $ret;
    }

    function GetReservationListInfo($mysqli,$user_id=-1)
    {
        if($user_id!=-1)
        {
            $sql = "SELECT COUNT(*) FROM reserva AS res,box_data AS bdata WHERE res.box_id=bdata.id AND bdata.propietari=$user_id";
        }
        else
        {
            $sql = "SELECT COUNT(*) FROM reserva ORDER BY data DESC, id";
        } 
        $result = $mysqli->query($sql);
        $lines = $result->fetch_row()[0];
        return $lines;
    }
    function GetReservationList($mysqli,$user_id=-1,$number=100,$pag=1)
    {
        $data = array();
        $offset = ($pag-1)*$number;
        $limitstr = "LIMIT ".$offset.','.$number;        
        
        if($user_id!=-1)
        {
            $sql = "SELECT res.* FROM reserva AS res,box_data AS bdata WHERE res.box_id=bdata.id AND bdata.propietari=$user_id ORDER BY res.data DESC, res.id DESC ".$limitstr;
        }
        else
        {
            $sql = "SELECT * FROM reserva ORDER BY data DESC, id DESC ".$limitstr;
        }                
        $result = $mysqli->query($sql);
        // error_log($sql);
        if($result != null)
        {
            while ( $row = $result->fetch_row() )
            {
                if(intval($row[2])>0)
                {
                    $result2 = $mysqli->query("SELECT username,email,tel,surnames FROM members WHERE id=$row[2]");

                    if($result2 != null)
                    {
                        $row2 = $result2->fetch_row();

                        $data[] = array('id'=>$row[0],'ref'=>$row[1],'nom'=>$row2[0],'cognoms'=>$row2[3],'email'=>$row2[1],'tel'=>$row2[2],'comentaris'=>stripslashes($row[3]),'quantitat'=>$row[4],'confirmat'=>$row[5],'box_id'=>$row[6],'total'=>$row[7],'data'=>$row[8],'data_reservada'=>$row[9],'data_executada'=>$row[10],'facturada'=>intval($row[12]),'quant_total'=>intval($row[13]),'tipus'=>intval($row[14]),'session_id'=>$row[15],'nom_exp'=>$row[16],'desc_exp'=>$row[17],'comentaris'=>stripslashes($row[3]),'col_comentaris'=>stripslashes($row[11]),'enquesta'=>intval($row[23]),'rnom'=>$row[18],'text_regal'=>stripslashes($row[24]),'caducitat'=>intval($row[25]),'promovins'=>intval($row[30]));
                    }
                }
                else
                {
                    $data[] = array('id'=>$row[0],'ref'=>$row[1],'nom'=>"",'cognoms'=>"",'email'=>"",'tel'=>"",'comentaris'=>stripslashes($row[3]),'quantitat'=>$row[4],'confirmat'=>$row[5],'box_id'=>$row[6],'total'=>$row[7],'data'=>$row[8],'data_reservada'=>$row[9],'data_executada'=>$row[10],'facturada'=>intval($row[12]),'quant_total'=>intval($row[13]),'tipus'=>intval($row[14]),'session_id'=>$row[15],'nom_exp'=>$row[16],'desc_exp'=>$row[17],'comentaris'=>stripslashes($row[3]),'col_comentaris'=>stripslashes($row[11]),'enquesta'=>intval($row[23]),'rnom'=>$row[18],'text_regal'=>stripslashes($row[24]),'caducitat'=>intval($row[25]),'promovins'=>intval($row[30]));
                }
            }
        }
            
        return $data;
    }

    function GetReservationListFromBox($mysqli,$boxid=-1,$state=-999,$userid=-1,$did1="",$did2="",$number=100,$pag=1)
    {
        global $zone;
        $data = array();
        if($pag<=0)$pag=1;
        $offset = ($pag-1)*$number;
        $limitstr = "LIMIT ".$offset.','.$number;
        
        date_default_timezone_set($zone);
        
        $date_ini_aux = date_create_from_format('d-m-Y','1-1-2000');
        $date_fin_aux = date_create_from_format('d-m-Y',date('d-m-Y'));

        if($did1!="" && $did1!="-")
        {
            $date_ini_aux = date_create_from_format('d-m-Y',$did1);            
        }
        if($did2!="" && $did2!="-")
        {
            $date_fin_aux = date_create_from_format('d-m-Y',$did2);
        }
        
        $date_ini = date_format($date_ini_aux,'Y-m-d');
        $date_fin = date_format($date_fin_aux,'Y-m-d');                        
        
        if($state==-10)
        {
            if($boxid>0)
            {
                $sql = "SELECT * FROM reserva WHERE box_id=$boxid AND `data` >= '$date_ini' AND `data` <= '$date_fin' ORDER BY data DESC ";
            }
            else
            {
                if($userid!=-1)
                {
                    if($userid==1)
                    {
                        $sql = "SELECT res.* FROM reserva AS res,box_data AS bdata WHERE res.box_id=bdata.id AND res.data >= '$date_ini' AND res.data <= '$date_fin' ORDER BY res.data DESC ";
                    }
                    else
                    {
                        $sql = "SELECT res.* FROM reserva AS res,box_data AS bdata WHERE res.box_id=bdata.id AND bdata.propietari=$userid AND res.data >= '$date_ini' AND res.data <= '$date_fin' ORDER BY res.data DESC ";
                    }
                }
                else
                {
                    $sql = "SELECT * FROM reserva WHERE `data` >= '$date_ini' AND `data` <= '$date_fin' ORDER BY data DESC ";
                }
            }
        }
        else
        {
            if($boxid>0)
            {
                $sql = "SELECT * FROM reserva WHERE box_id=$boxid AND confirmat=$state AND `data` >= '$date_ini' AND `data` <= '$date_fin' ORDER BY data DESC ";
            }
            else
            {
                if($userid!=-1)
                {
                    $sql = "SELECT res.* FROM reserva AS res,box_data AS bdata WHERE res.box_id=bdata.id AND bdata.propietari=$userid AND res.confirmat=$state AND res.data >= '$date_ini' AND res.data <= '$date_fin' ORDER BY res.data DESC ";
                }
                else
                {
                    $sql = "SELECT * FROM reserva WHERE confirmat=$state AND `data` >= '$date_ini' AND `data` <= '$date_fin' ORDER BY data DESC ";
                }
            }  
        }
        
        $sql .= $limitstr;
        //error_log($sql);
        
        $result = $mysqli->query($sql);
                
        if($result != null)
        {
            while ( $row = $result->fetch_row() )
            {
                $result2 = $mysqli->query("SELECT username,email,tel,surnames FROM members WHERE id=$row[2]");
                
                if($result2 != null)
                {
                    $row2 = $result2->fetch_row();
                    
                    $data[] = array('id'=>$row[0],'ref'=>$row[1],'nom'=>$row2[0],'cognoms'=>$row2[3],'email'=>$row2[1],'tel'=>$row2[2],'comentaris'=>stripslashes($row[3]),'quantitat'=>$row[4],'confirmat'=>$row[5],'box_id'=>$row[6],'total'=>$row[7],'data'=>$row[8],'data_reservada'=>$row[9],'data_executada'=>$row[10],'facturada'=>intval($row[12]),'quant_total'=>intval($row[13]),'tipus'=>intval($row[14]),'session_id'=>$row[15],'nom_exp'=>$row[16],'desc_exp'=>$row[17],'col_comentaris'=>stripslashes($row[11]),'enquesta'=>intval($row[23]),'rnom'=>$row[18],'rmail'=>$row[19],'rtel'=>$row[20],'rmun'=>$row[21],'rnom'=>$row[18],'text_regal'=>stripslashes($row[24]),'caducitat'=>intval($row[25]),'newsletter'=>intval($row[28]),'dades'=>stripslashes($row[34]),'genere'=>intval($row[35]),'check_1'=>intval($row[36]),'check_2'=>intval($row[37]),'check_3'=>intval($row[38]),'validat'=>intval($row[39]),'val_com'=>stripslashes($row[40]),'check_special'=>intval($row[41]));
                }
            }
        }
        
        return $data;
    }

    function GetReservationListFromBoxInfo($mysqli,$boxid=-1,$state=-999,$userid=-1,$did1="",$did2="")
    {
        global $zone;
        date_default_timezone_set($zone);
        
        $date_ini_aux = date_create_from_format('d-m-Y','1-1-2000');
        $date_fin_aux = date_create_from_format('d-m-Y',date('d-m-Y'));

        if($did1!="" && $did1!="-")
        {
            $date_ini_aux = date_create_from_format('d-m-Y',$did1);            
        }
        if($did2!="" && $did2!="-")
        {
            $date_fin_aux = date_create_from_format('d-m-Y',$did2);
        }
        
        $date_ini = date_format($date_ini_aux,'Y-m-d');
        $date_fin = date_format($date_fin_aux,'Y-m-d');                        
        
        if($state==-10)
        {
            if($boxid>0)
            {
                $sql = "SELECT COUNT(*) FROM reserva WHERE box_id=$boxid AND `data` >= '$date_ini' AND `data` <= '$date_fin' ORDER BY data DESC ";
            }
            else
            {
                if($userid!=-1)
                {
                    if($userid==1)
                    {
                        $sql = "SELECT COUNT(*) FROM reserva AS res,box_data AS bdata WHERE res.box_id=bdata.id AND res.data >= '$date_ini' AND res.data <= '$date_fin' ORDER BY res.data DESC ";
                    }
                    else
                    {
                        $sql = "SELECT COUNT(*) FROM reserva AS res,box_data AS bdata WHERE res.box_id=bdata.id AND bdata.propietari=$userid AND res.data >= '$date_ini' AND res.data <= '$date_fin' ORDER BY res.data DESC ";
                    }
                }
                else
                {
                    $sql = "SELECT COUNT(*) FROM reserva WHERE `data` >= '$date_ini' AND `data` <= '$date_fin' ORDER BY data DESC ";
                }
            }
        }
        else
        {
            if($boxid>0)
            {
                $sql = "SELECT COUNT(*) FROM reserva WHERE box_id=$boxid AND confirmat=$state AND `data` >= '$date_ini' AND `data` <= '$date_fin' ORDER BY data DESC ";
            }
            else
            {
                if($userid!=-1)
                {
                    $sql = "SELECT COUNT(*) FROM reserva AS res,box_data AS bdata WHERE res.box_id=bdata.id AND bdata.propietari=$userid AND res.confirmat=$state AND res.data >= '$date_ini' AND res.data <= '$date_fin' ORDER BY res.data DESC ";
                }
                else
                {
                    $sql = "SELECT COUNT(*) FROM reserva WHERE confirmat=$state AND `data` >= '$date_ini' AND `data` <= '$date_fin' ORDER BY data DESC ";
                }
            }  
        }
        
        $result = $mysqli->query($sql);
        $lines = $result->fetch_row()[0];
        return $lines;
    }

    function GetColReservationList($userid)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        $data = array();
        global $mysqli,$SUPERUSER;
        
        $result = $mysqli->query("SELECT id FROM collaboradors WHERE user=$userid");
        if($result != null)
        {
            $row = $result->fetch_row();
            $col_id = $row[0];            

            $result = $mysqli->query("SELECT * FROM reserva ORDER BY data DESC");       
            if($result != null)
            {
                while ( $row = $result->fetch_row() )
                {
                    $result2 = $mysqli->query("SELECT price,collaboradors FROM box_data WHERE id=$row[6]");
                    if($result2 != null)
                    {
                        $row2 = $result2->fetch_row();
                        
                        $cols = explode(';',$row2[1]);
                        if(in_array($col_id,$cols) || $userid==$SUPERUSER)
                        {
//                        $price_modalities = explode(';',$row2[0]);
//                        if(count($price_modalities)>0)
//                        {
//                            $price = explode(':',$price_modalities[0]);
//                            $c_count = count($price)/2 - 1;
//                            $found = false;
//                            for($i=0;$i<$c_count;$i++)
//                            {
//                                if($price[2*$i+2]==$col_id)
//                                {
//                                    $found = true;
//                                    break;
//                                }
//                            }
//
//                            if($found)
//                            {
                                $result2 = $mysqli->query("SELECT username,email,tel FROM members WHERE id=$row[2]");
                
                                if($result2 != null)
                                {
                                    $row2 = $result2->fetch_row();
                                    
                                    $data[] = array('id'=>$row[0],'ref'=>$row[1],'nom'=>$row2[0],'email'=>$row2[1],'tel'=>$row2[2],'comentaris'=>stripslashes($row[3]),'quantitat'=>$row[4],'confirmat'=>$row[5],'box_id'=>$row[6],'total'=>$row[7],'data'=>$row[8],'data_reservada'=>$row[9],'data_executada'=>$row[10],'col_comentaris'=>stripslashes($row[11]),'nom_exp'=>$row[16],'desc_exp'=>$row[17]);
                                }
//                            }
                        }
                    }
                }
            }
        }
            
        return $data;
    }

    function GetUserReservationList($user_id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        $data = array();
        global $mysqli;
        
        $result = $mysqli->query("SELECT * FROM reserva WHERE user_id=$user_id ORDER BY data DESC");
                
        if($result != null)
        {
            while ( $row = $result->fetch_row() )
            {                
                $data[] = array('id'=>$row[0],'ref'=>$row[1],'comentaris'=>stripslashes($row[3]),'quantitat'=>$row[4],'confirmat'=>$row[5],'box_id'=>$row[6],'total'=>$row[7],'data'=>$row[8],'nom_exp'=>$row[16],'desc_exp'=>$row[17]);
            }
        }
            
        return $data;
    }

    function GetReservation($mysqli,$id)
    {    
        $data = null;
        global $mysqli_btiquets;
        
        $result = $mysqli->query("SELECT * FROM reserva WHERE id='$id'");
                
        if($result != null)
        {     
            $row = $result->fetch_row();
            $result2 = $mysqli->query("SELECT username,email,tel,surnames,city FROM members WHERE id=$row[2]");
                
            if($result2 != null)
            {
                $row2 = $result2->fetch_row();

                $data_session = "0000-00-00 00:00:00";
                $session_name = "";
                if($row[15]!=0 && $row[15]!=-1 && $row[15]!=-2)
                {
                    if($row[15]>0)
                    {
                        $mysqli_aux = $mysqli;
                        $sid = $row[15];
                    }
                    else
                    {
                        $mysqli_aux = $mysqli_btiquets;
                        $sid = $row[15] * -1;
                    }
                    
                    $result3 = $mysqli_aux->query("SELECT data,session_name FROM sessions WHERE id=$sid");

                    if($result3 != null)
                    {
                        $row3 = $result3->fetch_row();
                        $data_session = $row3[0];
                        $session_name = $row3[1];
                    }
                }
                
                $data = array('id'=>$row[0],'ref'=>$row[1],'nom'=>$row2[0],'cognoms'=>$row2[3],'email'=>$row2[1],'tel'=>$row2[2],'city'=>$row2[4],'comentaris'=>stripslashes($row[3]),'quantitat'=>$row[4],'confirmat'=>$row[5],'box_id'=>$row[6],'total'=>$row[7],'data'=>$row[8],'data_res'=>$row[9],'data_exe'=>$row[10],'session_id'=>$row[15],'data_session'=>$data_session,'session_name'=>$session_name,'nom_exp'=>$row[16],'desc_exp'=>$row[17],'quant_total'=>intval($row[13]),'regal'=>intval($row[22]),'rnom'=>$row[18],'rmail'=>$row[19],'rtel'=>$row[20],'rmun'=>$row[21],'text_regal'=>stripslashes($row[24]),'caducitat'=>intval($row[25]),'aavv'=>intval($row[26]),'data_res_out'=>$row[27],'raddr1'=>stripslashes($row[31]),'raddr2'=>stripslashes($row[32]),'rcp'=>stripslashes($row[33]),'dades'=>stripslashes($row[34]),'check_1'=>intval($row[36]),'check_2'=>intval($row[37]),'check_3'=>intval($row[38]));
            }
        }
            
        return $data;
    }

    function GetReservation_by_ref($mysqli,$ref)
    {        
        $data = null;  
        global $mysqli_btiquets;
        
        $result = $mysqli->query("SELECT * FROM reserva WHERE ref=LOWER('$ref')");
                
        if($result != null)
        {            
            $row = $result->fetch_row();
            $result2 = $mysqli->query("SELECT username,email,tel,surnames,city FROM members WHERE id=$row[2]");
                
            if($result2 != null)
            {
                $row2 = $result2->fetch_row();
                
                $data_session = "0000-00-00 00:00:00";
                $session_name = "";
                if($row[15]!=0 && $row[15]!=-1 && $row[15]!=-2)
                {
                    if($row[15]>0)
                    {
                        $mysqli_aux = $mysqli;
                        $sid = $row[15];
                    }
                    else
                    {
                        $mysqli_aux = $mysqli_btiquets;
                        $sid = $row[15] * -1;
                    }
                    
                    $result3 = $mysqli_aux->query("SELECT data,session_name FROM sessions WHERE id=$sid");

                    if($result3 != null)
                    {
                        $row3 = $result3->fetch_row();
                        $data_session = $row3[0];
                        $session_name = $row3[1];
                    }
                }
                
                $data = array('id'=>$row[0],'ref'=>$row[1],'nom'=>$row2[0],'cognoms'=>$row2[3],'email'=>$row2[1],'tel'=>$row2[2],'city'=>$row2[4],'comentaris'=>stripslashes($row[3]),'quantitat'=>$row[4],'confirmat'=>$row[5],'box_id'=>$row[6],'total'=>$row[7],'data'=>$row[8],'data_res'=>$row[9],'data_exe'=>$row[10],'session_id'=>$row[15],'data_session'=>$data_session,'session_name'=>$session_name,'nom_exp'=>$row[16],'desc_exp'=>$row[17],'quant_total'=>intval($row[13]),'regal'=>intval($row[22]),'rnom'=>$row[18],'rmail'=>$row[19],'rtel'=>$row[20],'rmun'=>$row[21],'text_regal'=>stripslashes($row[24]),'caducitat'=>intval($row[25]),'aavv'=>intval($row[26]),'data_res_out'=>$row[27],'raddr1'=>stripslashes($row[31]),'raddr2'=>stripslashes($row[32]),'rcp'=>stripslashes($row[33]),'dades'=>stripslashes($row[34]),'check_1'=>intval($row[36]),'check_2'=>intval($row[37]),'check_3'=>intval($row[38]),'validat'=>intval($row[39]),'val_com'=>stripslashes($row[40]));
            }
        }
            
        return $data;
    }

    function GetActivityReservations($mysqli,$activity)
    {        
        $data = null;
        
        $result = $mysqli->query("SELECT * FROM reserva WHERE box_id='$activity'");
                
        if($result != null)
        {
            while ( $row = $result->fetch_row() )
            {                
                $data[] = array('id'=>$row[0],'ref'=>$row[1],'comentaris'=>stripslashes($row[3]),'quantitat'=>$row[4],'confirmat'=>$row[5],'box_id'=>$row[6],'total'=>$row[7],'data'=>$row[8],'session_id'=>$row[15],'nom_exp'=>$row[16],'desc_exp'=>$row[17]);
            }
        }
            
        return $data;
    }


    function DeleteReservation($mysqli,$id)
    {    
        $sql="DELETE FROM reserva WHERE id='$id'";
        $mysqli->query($sql);
    }

    function Downloadreservation($id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        include_once '../plugins/mpdf/mpdf.php';
        
        global $mysqli;
        
        $info_reserva = GetReservation($mysqli,$id);
        $mpdf = GeneratePDF1($info_reserva); 
        $filename = "BTiquets-" . strtoupper($info_reserva['ref']) . '.pdf';
        $mpdf->Output($filename, 'F');  
        
        $mpdf_2 = GeneratePDF2($info_reserva); 
        $filename_2 = "BTiquets-" . translate('xec-regal',$lang) . '-' . strtoupper($info_reserva['ref']) . '.pdf';
        $mpdf_2->Output($filename_2, 'F');  
        
        $mpdf_22 = GeneratePDF2($info_reserva,1); 
        $filename_22 = "BTiquets-" . translate('bonus',$lang) . '-' . strtoupper($info_reserva['ref']) . '.pdf';
        $mpdf_22->Output($filename_22, 'F');  
        
        $mpdf_3 = GeneratePDF3($info_reserva); 
        $filename_3 = "BTiquets-" . translate('regal',$lang) . '-' . strtoupper($info_reserva['ref']) . '.pdf';
        $mpdf_3->Output($filename_3, 'F');  
        
        return $mpdf;
    }

    function SendReservationbtiquets($mysqli,$id,$admin_mail="")
    {
        //include_once '../plugins/mpdf/mpdf.php';
        
        $info_reserva = GetReservation($mysqli,$id);
        $box = GetBox($mysqli,$info_reserva['box_id']);
        if(false) // Comerç SFB
        {
            SendConfirmation6_sp1($mysqli,$info_reserva,"",true);
        }
        else if($box['id']==348 || $box['id']==358 || $box['id']==359 || $box['id']==360 || $box['id']==361 || $box['id']==362 || $box['id']==363) // Transèquia 2021
        {
            SendConfirmation6_sp2($mysqli,$info_reserva,"",true);
        }
        else if($box['id']==502 || $box['id']==510 || $box['id']==511) // Transèquia 2022
        {
            SendConfirmation6_sp2($mysqli,$info_reserva,"",true);
        }
        else
        {
            SendConfirmation6($mysqli,$info_reserva,$admin_mail);
        }
        
        return true;
    }

    function SendNotifcationbtiquets($mysqli,$id)
    {
        //include_once '../plugins/mpdf/mpdf.php';
        
        $info_reserva = GetReservation($mysqli,$id);
        SendConfirmation7($mysqli,$info_reserva);
        
        return true;
    }

    function SendPayment($mysqli,$id)
    {
        include_once '../plugins/mpdf/mpdf.php';
        
        $info_reserva = GetReservation($mysqli,$id);
        SendPaymentlink($mysqli,$info_reserva);
        
        return true;
    }

    function SendReservation($id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
                
        global $mysqli;
        
        $info_reserva = GetReservation($mysqli,$id);
        ConfirmReservation($mysqli,$id,1);
        return SendConfirmation($info_reserva);
    }

    function SendReservationAdmin($id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
                
        global $mysqli;
        
        $info_reserva = GetReservation($mysqli,$id);
        $info_reserva_2 = GetReservation_by_ref($mysqli,$info_reserva['ref']);
        ConfirmReservation($mysqli,$id,1);
        return SendConfirmation($info_reserva_2);
    }

    function DeleteIncompleteReservations($mysqli,$zone)
    {        
        date_default_timezone_set($zone);
        $date = date('Y-m-d');
        $str="";
        
        $sql="SELECT ref FROM reserva WHERE `data` < DATE_SUB('$date', INTERVAL 7 DAY) AND `confirmat`<1";
        $res = $mysqli->query($sql);
        if($res->num_rows>0)
        {
            while($row = $res->fetch_row())
            {
                $str .= $row[0];
                $str .= '/';
            }
        }
        error_log("ESBORRANT RESERVES INCOMPLETES");
        if($str!="") error_log("RESERVES ELIMINADES....." . $str);
        
        $sql="DELETE FROM reserva WHERE `data` < DATE_SUB('$date', INTERVAL 7 DAY) AND `confirmat`<1";
        $mysqli->query($sql);
    }

    function ExecuteSessions($mysqli,$zone)
    {        
        date_default_timezone_set($zone);
        $date = date('Y-m-d');
        
        $sql="UPDATE reserva AS r INNER JOIN sessions AS s ON r.session_id=s.id SET r.confirmat='2',r.data_executada=s.data WHERE s.data < '$date' AND r.confirmat=1";
        $mysqli->query($sql);
    }

    function ExecuteSessions_btdv($mysqli,$zone)
    {        
        date_default_timezone_set($zone);
        $date = date('Y-m-d');
        $str="";
        
        $sql="SELECT ref FROM reserva AS r INNER JOIN sessions AS s ON r.session_id=s.id WHERE (s.data < '$date' AND r.confirmat=1) OR (r.data_reserva < '$date' AND r.confirmat=1)";
        $res = $mysqli->query($sql);
        if($res->num_rows>0)
        {
            while($row = $res->fetch_row())
            {
                $str .= $row[0];
                $str .= '/';
            }            
        }
        
        $sql="SELECT ref FROM reserva AS r WHERE r.data_reserva < '$date' AND r.data_reserva != '0000-00-00 00:00:00' AND r.confirmat=1";
        $res = $mysqli->query($sql);
        if($res->num_rows>0)
        {
            while($row = $res->fetch_row())
            {
                $str .= $row[0];
                $str .= '/';
            }
        }
        
        error_log("EXECUTANT RESERVES");
        if($str!="") error_log("RESERVES EXECUTADES....." . $str);
        
        $sql="UPDATE reserva AS r INNER JOIN sessions AS s ON r.session_id=s.id SET r.confirmat='2',r.data_executada=s.data WHERE (s.data < '$date' AND r.confirmat=1) OR (r.data_reserva < '$date' AND r.confirmat=1)";
        $mysqli->query($sql);
        
        $sql="UPDATE reserva AS r SET r.confirmat='2',r.data_executada=r.data_reserva WHERE r.data_reserva < '$date' AND r.data_reserva != '0000-00-00 00:00:00' AND r.confirmat=1";
        $mysqli->query($sql);
    }

    function SendEnquestes($mysqli,$zone)
    {
        // Fer la llista de reserves que s'han realitzat passat un determinat temps i no se'ls ha enviat encara l'enquesta (i tenen els camps necessaris)
        $reserves = GetReservesEnquesta($mysqli,$zone);
        
        // Enviar-los el mail
        $str = "";
        foreach($reserves as $reserva)
        {
            $reserva_info = GetReservation($mysqli,$reserva['id']);            
            if($reserva_info['rmail']!="")
            {
                $str .= $reserva_info['ref'];
                $str .= '/';
                $ret = SendEnquesta($mysqli,$reserva_info);            
                $ret = true;
                if($ret)
                {
                    // Marcar enquesta realitzada
                    $id = $reserva['id'];
                    $sql="UPDATE reserva SET `enquesta`='1' WHERE id='$id'";
                    $mysqli->query($sql);
                }
            }
        }
        error_log("ENVIANT ENQUESTES");
        error_log("ENQUESTES ENVIADES A....." . $str);
    }

    function GetReservesEnquesta($mysqli,$zone)
    {
        // Retorna aquelles reserves que s'han realitzat fa més de X dies i no la tenen feta, i tenen a qui enviar-se
        
        global $dies_enquesta;
        date_default_timezone_set($zone);
        $date = date('Y-m-d');
        
        $sql="SELECT id FROM reserva WHERE reserva.data_executada < DATE_SUB('$date', INTERVAL 15 DAY) AND reserva.confirmat=2 AND reserva.enquesta=0";
        $reserves = array();
        $res = $mysqli->query($sql);
        while($row = $res->fetch_row())
        {
            $reserves[] = array('id'=>intval($row[0]));
        }
        return $reserves;
    }

    function SendPromoVins($mysqli,$zone)
    {
        // Fer la llista de reserves que s'han realitzat passat un determinat temps i no se'ls ha enviat encara la promo de vinsdelbages, i tenen la LOPD correcte (i tenen els camps necessaris)
        $reserves = GetReservesPromoVins($mysqli,$zone);
        
        // Enviar-los el mail
        $str = "";
        foreach($reserves as $reserva)
        {
            $reserva_info = GetReservation($mysqli,$reserva['id']);            
            $str .= $reserva_info['ref'];
            $str .= '/';
            //$ret = SendPromoVi($mysqli,$reserva_info);            
            $ret = true;
            if($ret)
            {
                // Marcar enquesta realitzada
                $id = $reserva['id'];
                $sql="UPDATE reserva SET `promovins`='1' WHERE id='$id'";                
                $mysqli->query($sql);
            }
        }
        error_log("PROMOVINS ENVIADES A....." . $str);
    }

    function GetReservesPromoVins($mysqli,$zone)
    {
        // Retorna aquelles reserves que s'han realitzat fa més de X dies, encara no se'ls ha enviat la promo de vinsdelbages
        
        global $dies_promovins;
        date_default_timezone_set($zone);
        $date = date('Y-m-d');
        
        $sql="SELECT id FROM reserva WHERE reserva.data_executada < DATE_SUB('$date', INTERVAL '$dies_promovins' DAY) AND reserva.confirmat=2 AND reserva.promovins=0";
        $reserves = array();
        $res = $mysqli->query($sql);
        while($row = $res->fetch_row())
        {
            $reserves[] = array('id'=>intval($row[0]));
        }
        return $reserves;
    }

    function FinishReservation($id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        global $zone;
        
        date_default_timezone_set($zone);
        $date = date('Y-m-d');
        
        $sql="UPDATE reserva SET `confirmat`='2',`data_executada`='$date' WHERE id='$id'";
        $mysqli->query($sql);
    }

    function FactReservation($id,$val)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        
        $sql="UPDATE reserva SET `facturada`='$val' WHERE id='$id'";
        $mysqli->query($sql);
    }

    function EnquestaFeta($mysqli,$id)
    {                
        $sql="UPDATE reserva SET `enquesta`='1' WHERE id='$id'";
        $mysqli->query($sql);
    }

    function GetSessionsList()
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        
        // recullo totes les sessions d'aquesta experiència
        $sql="SELECT id,data,box_id,places,estat FROM sessions ORDER BY data";
        $sessions = array();
        $res = $mysqli->query($sql);
        while($row = $res->fetch_row())
        {
            if($row[1]=="0000-00-00 00:00:00")
            {
                $date_session = date('d-m-Y');
                $time_session = date('H:i');
            }
            else
            {
                $sdata = date_create_from_format('Y-m-d H:i:s',$row[1]);
                $date_session = date_format($sdata,'d-m-Y');
                $time_session = date_format($sdata,'H:i');
            }
            $sessions[] = array('id'=>intval($row[0]),'box_id'=>intval($row[2]),'data'=>$date_session,'hora'=>$time_session,'places'=>$row[3],'estat'=>intval($row[4]));
        }
        return $sessions;
    }

    function ExportUsersDataset($mysqli)
    {
        $data=null;
                
        $users = GetUsersInfo($mysqli);
        $lang = 'ca';
        
        
        // output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=userdata.csv');

        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        // output the column headings
        fputcsv($output, array('Nom', 'Cognoms', 'Email', 'Telèfon', 'Municipi', 'País', 'Newsletter'));
        

        // loop over the rows, outputting them        
        foreach($users as $user)
        {
            $csvarray =  array($user['name'],$user['surnames'],$user['email'],$user['tel'],$user['city'],$user['country'],$user['newsletter'],$user['creation']);
            fputcsv($output, $csvarray);
        }
        
        return $data;
    }

    function ExportDataset($mysqli,$tid,$xid,$sid,$userid,$did1="",$did2="",$did3="",$did4="")
    {
        $data=null;
                
        $reserves = GetReservationListFromBox($mysqli,$xid,$tid,$userid,$did1,$did2,5000);
        $sessio = GetSession($mysqli,$sid);
        $activitats = GetBoxes($mysqli);
        
        $lang = 'ca';
        
        $estat_reserva_1 = array(-2 => translate("Pagament en curs", $lang), -1 => translate("Pagament denegat", $lang), 0 => translate("Pendent de pagament", $lang), 1 => translate("Reserva correcta", $lang), 2 => translate("Activitat realitzada", $lang), 3 => translate("Pre-reserva", $lang));

        $estat_reserva_2 = array(-2 => translate("Reserva en curs", $lang), -1 => translate("Reserva denegada", $lang), 0 => translate("Reserva enviada", $lang), 1 => translate("Reserva acceptada", $lang), 2 => translate("Reserva realitzada", $lang), 3 => translate("Pre-reserva", $lang));
        
        $estat_reserva_3 = array(-2 => translate("Pagament en curs", $lang), -1 => translate("Pagament denegat", $lang), 0 => translate("Pendent de pagament", $lang), 1 => translate("Compra correcta", $lang), 2 => translate("Compra correcta", $lang), 3 => translate("Pre-reserva", $lang));
        
        // output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=data.csv');

        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');
        fputs($output, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

        // output the column headings
        
        if($reserves[0]['box_id']==104)
        {
            fputcsv($output, array('Data', 'Referència', 'Activitat', 'Tiquets', 'PVP', 'Nom', 'Mail','Tel', 'Municipi', 'Col·laboració', 'Escola', 'Infants', 'Edats', 'Intolerància', 'Tipus', 'Permís', 'Tenda', 'Residència', 'Àpat-1', 'Àpat-2', 'Àpat-3', 'Àpat-4', 'Àpat-5', 'Àpat-6', 'Donació','', 'Estat'),";");
        }
        else if($reserves[0]['box_id']==502 || $reserves[0]['box_id']==510 || $reserves[0]['box_id']==511)
        {
            $quant_modalities = explode(';',$reserves[0]['quantitat']);
            $box = GetBox($mysqli,$reserves[0]['box_id']);
            $price_modalities = decode_price($box['price'],false);
            if(count($quant_modalities)>1 && $reserves[0]['quantitat']!="")
            {
                $headerarray = Array();
                $headerarray[]="Data compra";
                $headerarray[]="Referència";
                $headerarray[]="Nom";
                $headerarray[]="Mail";
                $headerarray[]="Tel";
                $headerarray[]="Municipi";
                $headerarray[]="Comentari";
                $headerarray[]="Estat";
                $headerarray[]="Newsletter";
                $headerarray[]="Activitat";
                $headerarray[]="Sessió";
                $headerarray[]="PVP";
                $headerarray[]="Genere";
                $headerarray[]="Solidari";
                $headerarray[]="Autocar";
                $headerarray[]="Corrent";
                $headerarray[]="Celiaquia";
                $headerarray[]="Validat";
                $headerarray[]="Comentari validació";
                for($j=0;$j<count($price_modalities);$j++)
                {
                    $price = $price_modalities[$j];
                    $aux = "Tiquets - " . $price['name'];
                    $headerarray[]=$aux;
                }
                for($j=1;$j<=30;$j++)
                {
                    $headerarray[]="Gènere-".$j;
                    $headerarray[]="Nom-".$j;
                    $headerarray[]="DNI-".$j;
                    $headerarray[]="Menor-".$j;
                }
                fputcsv($output, $headerarray,";");
            }
            else
            {
                fputcsv($output, array('Data compra', 'Referència', 'Nom', 'Mail', 'Tel', 'Municipi', 'Comentari', 'Estat', 'Newsletter', 'Activitat', 'Sessió', 'PVP', 'Tiquets'),";");
            }
        }
        else if($reserves[0]['box_id']==548)
        {
            $quant_modalities = explode(';',$reserves[0]['quantitat']);
            $box = GetBox($mysqli,$reserves[0]['box_id']);
            $price_modalities = decode_price($box['price'],false);
            if(count($quant_modalities)>1 && $reserves[0]['quantitat']!="")
            {
                $headerarray = Array();
                $headerarray[]="Data compra";
                $headerarray[]="Referència";
                $headerarray[]="Nom";
                $headerarray[]="Mail";
                $headerarray[]="Tel";
                $headerarray[]="Municipi";
                $headerarray[]="Comentari";
                $headerarray[]="Estat";
                $headerarray[]="Newsletter";
                $headerarray[]="Activitat";
                $headerarray[]="Sessió";
                $headerarray[]="PVP";
                $headerarray[]="Genere";
                for($j=0;$j<count($price_modalities);$j++)
                {
                    $price = $price_modalities[$j];
                    $aux = "Tiquets - " . $price['name'];
                    $headerarray[]=$aux;
                }
                for($j=1;$j<=30;$j++)
                {
                    $headerarray[]="Gènere-".$j;
                    $headerarray[]="Nom-".$j;
                    $headerarray[]="Tel-".$j;
                    $headerarray[]="Mail-".$j;
                    $headerarray[]="Municipi-".$j;
                    $headerarray[]="Edat-".$j;
                }
                fputcsv($output, $headerarray,";");
            }
            else
            {
                fputcsv($output, array('Data compra', 'Referència', 'Nom', 'Mail', 'Tel', 'Municipi', 'Comentari', 'Estat', 'Newsletter', 'Activitat', 'Sessió', 'PVP', 'Tiquets'),";");
            }
        }
        else
        {
            $quant_modalities = explode(';',$reserves[0]['quantitat']);
            $box = GetBox($mysqli,$reserves[0]['box_id']);
            $price_modalities = decode_price($box['price'],false);
            if(count($quant_modalities)>1 && $reserves[0]['quantitat']!="")
            {
                $headerarray = Array();
                $headerarray[]="Data compra";
                $headerarray[]="Referència";
                $headerarray[]="Nom";
                $headerarray[]="Mail";
                $headerarray[]="Tel";
                $headerarray[]="Municipi";
                $headerarray[]="Comentari";
                $headerarray[]="Estat";
                $headerarray[]="Newsletter";
                $headerarray[]="Activitat";
                $headerarray[]="Sessió";
                $headerarray[]="PVP";
                for($j=0;$j<count($price_modalities);$j++)
                {
                    $price = $price_modalities[$j];
                    $aux = "Tiquets - " . $price['name'];
                    $headerarray[]=$aux;
                }
                fputcsv($output, $headerarray,";");
            }
            else
            {
                fputcsv($output, array('Data compra', 'Referència', 'Nom', 'Mail', 'Tel', 'Municipi', 'Comentari', 'Estat', 'Newsletter', 'Activitat', 'Sessió', 'PVP', 'Tiquets'),";");
            }
        }

        // loop over the rows, outputting them        
        $quantstr = "";
        foreach($reserves as $reserva)
        {
            if($reserva['box_id']==-1) $nom = $reserva['nom_exp']; else $nom = $activitats[$reserva['box_id']];
            
            if($sid>0 && $reserva['session_id']!=$sid) continue;
            
            $quant_modalities = explode(';',$reserva['quantitat']);
            $box = GetBox($mysqli,$reserva['box_id']);
            $price_modalities = decode_price($box['price'],false);
            $quantstr = "";
            $sessiostr = "";
            
            if($reserva["session_id"]!=-1)
            {
                $session = GetSession($mysqli,$reserva["session_id"]);
                
                if($session['session_name']!="")
                {
                    $sessiostr = $session['data'] . " - " . $session['session_name'];
                }
                else
                {
                    $sessiostr = $session['data'] . " - " . $session['hora'];
                }
//                else
//                {
//                    $sessiostr = $session['data'];
//                }
            }
            
            if($box['etype']<=1) $estat = $estat_reserva_1[$reserva['confirmat']]; 
            else if($box['etype']==4 || $box['etype']==5 || $box['etype']==7) $estat = $estat_reserva_3[$reserva['confirmat']]; 
            else $estat = $estat_reserva_2[$reserva['confirmat']];
            
            $comentari = str_replace("\n"," ",$reserva['comentaris']);
            $comentari = str_replace("\r"," ",$comentari);
            
            switch($box['etype'])
            {
                case 4:
                    $sessiostr = "-";
                    break;
                case 5:
                    $sessiostr = "-";
                    break;
                case 7:
                    $sessiostr = "-";
                    break;
            }

            $generestr = "-";
            switch($reserva['genere'])
            {
                case 1:
                    $generestr = "Home";
                    break;
                case 2:
                    $generestr = "Dona";
                    break;
                case 3:
                    $generestr = "No binari";
                    break;
            }
            
            if(count($quant_modalities)==0 || $reserva['quantitat']=="")
            {
                $quantstr = $reserva['quant_total'];
                fputcsv($output, array($reserva['data'],$reserva['ref'],$reserva['rnom'],$reserva['rmail'],$reserva['rtel'],$reserva['rmun'],$comentari,$estat,$reserva['newsletter'],$nom,$sessiostr,strtr($reserva['total'],'.',','),$quantstr),";");
            }
            else
            {                   
                $auxarray = Array();
                $auxarray[]=$reserva['data'];
                $auxarray[]=strtoupper($reserva['ref']);                
                $auxarray[]=$reserva['rnom'];
                $auxarray[]=$reserva['rmail'];
                $auxarray[]=$reserva['rtel'];
                $auxarray[]=$reserva['rmun'];
                $auxarray[]=$comentari;
                $auxarray[]=$estat;
                $auxarray[]=$reserva['newsletter'];
                $auxarray[]=$nom;
                $auxarray[]=$sessiostr;
                $auxarray[]=strtr($reserva['total'],'.',',');
                if($reserva['box_id']==502 || $reserva['box_id']==510 || $reserva['box_id']==511)
                {                    
                    $auxarray[]=$generestr;
                    $auxarray[]=$reserva['check_special'];
                    $auxarray[]=$reserva['check_1'];
                    $auxarray[]=$reserva['check_2'];
                    $auxarray[]=$reserva['check_3'];
                    $auxarray[]=$reserva['validat'];
                    $auxarray[]=$reserva['val_com'];
                }
                else if($reserva['box_id']==548) {
                    $auxarray[]=$generestr;
                }
                for($j=0;$j<count($price_modalities);$j++)
                {
                    if($quant_modalities[$j]!="" && intval($quant_modalities[$j])>0)
                    {
                        if($quantstr!="") $quantstr .= " / ";
                        $price = $price_modalities[$j];
                        $quantstr = $quant_modalities[$j];
                        //$quantstr = $quantstr . $quant_modalities[$j] . ' x ' . $price['name'];
                    }
                    else
                    {
                        $quantstr = 0;
                    }
                    $auxarray[]=$quantstr;
                }

                if($reserva['box_id']==502 || $reserva['box_id']==510 || $reserva['box_id']==511)
                {
                    if($reserva['dades']!="")
                    {
                        $dades_info = decode_dades($reserva['dades']);
                        foreach($dades_info as $dades_iter)
                        {
                            $auxstr = "-";
                            switch($dades_iter['camp_1'])
                            {
                                case 1:
                                    $auxstr = "Home";
                                    break;
                                case 2:
                                    $auxstr = "Dona";
                                    break;
                                case 3:
                                    $auxstr = "No binari";
                                    break;
                            }
                            $auxarray[]=$auxstr;
                            $auxarray[]=$dades_iter['camp_2'];
                            $auxarray[]=$dades_iter['camp_3'];
                            $auxarray[]=$dades_iter['camp_4'];
                        }
                    }
                }
                else if($reserva['box_id']==548)
                {
                    if($reserva['dades']!="")
                    {
                        $dades_info = decode_dades($reserva['dades']);
                        foreach($dades_info as $dades_iter)
                        {
                            $auxstr = "-";
                            switch($dades_iter['camp_1'])
                            {
                                case 1:
                                    $auxstr = "Home";
                                    break;
                                case 2:
                                    $auxstr = "Dona";
                                    break;
                                case 3:
                                    $auxstr = "No binari";
                                    break;
                            }
                            $auxarray[]=$auxstr;
                            $auxarray[]=$dades_iter['camp_2'];
                            $auxarray[]=$dades_iter['camp_3'];
                            $auxarray[]=$dades_iter['camp_4'];
                            $auxarray[]=$dades_iter['camp_5'];
                            switch($dades_iter['camp_6'])
                            {
                                case 1:
                                    $auxstr = "0-11 anys";
                                    break;
                                case 2:
                                    $auxstr = "12-17 anys";
                                    break;
                                case 3:
                                    $auxstr = "31-60 anys";
                                    break;
                                case 4:
                                    $auxstr = "+60 anys";
                                    break;
                            }
                            $auxarray[]=$auxstr;
                        }
                    }
                }
                
                fputcsv($output,$auxarray,";");
            }
                                    

            
//            if($reserva['box_id']==104)
//            {
//                $csvarray =  array($reserva['data'],$reserva['ref'],$nom,$quantstr,$reserva['total'],$reserva['rnom'],$reserva['rmail'],$reserva['rtel'],$reserva['rmun']);
//                
//                $respostes = explode(';',$reserva['comentaris']);
//                foreach($respostes as $resposta)
//                {
//                    $q = explode(':',$resposta);
//                    array_push($csvarray, $q[1]);
//                }
//
//                array_push($csvarray, $estat);
//                fputcsv($output, $csvarray);
//            }
//            else
//            {
//                fputcsv($output, array($reserva['data'],$reserva['ref'],$nom,$sessiostr,$quantstr,$reserva['total'],$reserva['rnom'],$reserva['rmail'],$reserva['rtel'],$reserva['rmun'],$reserva['comentaris'],$estat,$reserva['newsletter']));
//            }
        }
        
        return $data;
    }

    function GetSessions($mysqli,$box_id,$admin=false)
    {
        $data = array();
        
        // recullo totes les sessions d'aquesta experiència
        if($admin)
        {
            $sql="SELECT id,data,places,estat,antelacio,session_name,tarifes,reserva_unica FROM sessions WHERE box_id='$box_id' AND estat!=0 ORDER BY data";
        }
        else
        {
            $sql="SELECT id,data,places,estat,antelacio,session_name,tarifes,reserva_unica FROM sessions WHERE box_id='$box_id' AND estat!=0 AND `data` > DATE_SUB(now(), INTERVAL 1 DAY) AND DATE_SUB(data, INTERVAL antelacio HOUR) > now() ORDER BY data";
        }
        $res = $mysqli->query($sql);
        while($row = $res->fetch_row())
        {
            if($row[1]=="0000-00-00 00:00:00")
            {
                $date_session = date('d-m-Y');
                $time_session = date('H:i');
            }
            else
            {
                $sdata = date_create_from_format('Y-m-d H:i:s',$row[1]);
                $date_session = date_format($sdata,'d-m-Y');
                $time_session = date_format($sdata,'H:i');
            }
            $data[] = array('id'=>intval($row[0]),'box_id'=>$box_id,'data'=>$date_session,'hora'=>$time_session,'places'=>$row[2],'estat'=>intval($row[3]),'antelacio'=>intval($row[4]),'session_name'=>$row[5],'tarifes'=>$row[6],'reserva_unica'=>intval($row[7]));
        }
        return $data;
    }

    function GetSession($mysqli,$session_id)
    {
        $data = null;
        
        // recullo totes les sessions d'aquesta experiència
        $sql="SELECT id,data,places,estat,antelacio,box_id,all_day,session_name,tarifes,reserva_unica FROM sessions WHERE id='$session_id'";        
        $res = $mysqli->query($sql);
        if($res)
        {
            if($res->num_rows>0) 
            {
                $row = $res->fetch_row();
                if($row[1]=="0000-00-00 00:00:00")
                {
                    $date_session = date('d-m-Y');
                    $time_session = date('H:i');
                }
                else
                {
                    $sdata = date_create_from_format('Y-m-d H:i:s',$row[1]);
                    $date_session = date_format($sdata,'d-m-Y');
                    if($row[6]==true)
                    {
                        $time_session = "tot el dia";
                    }
                    else
                    {
                        $time_session = date_format($sdata,'H:i');
                    }
                }
                $data = array('id'=>intval($row[0]),'box_id'=>$row[5],'data'=>$date_session,'hora'=>$time_session,'places'=>$row[2],'estat'=>intval($row[3]),'antelacio'=>intval($row[4]),'session_name'=>$row[7],'tarifes'=>$row[8],'reserva_unica'=>intval($row[9]));
            }
        }
        
        return $data;
    }

    function InsertPromo($id,$name,$desc,$cond,$col_id,$punts)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        $ret=-1;
        
        if($id==-1)
        {
            $sql="INSERT INTO promocions (nom,descripcio,condicions,col_id,punts) VALUES ('$name','$desc','$cond','$col_id','$punts')";
        }
        else
        {
            $sql="UPDATE promocions SET `nom`='$name',`descripcio`='$desc',`condicions`='$cond',`col_id`='$col_id',`punts`='$punts' WHERE id='$id'";
        }
        $result = $mysqli->query($sql);
        if($result)
        {
            $ret = $mysqli->insert_id;
            
            if($id==-1)
            {
                if(file_exists('../promos/image_-1.jpg'))
                {
                    rename("../promos/image_-1.jpg","../promos/image_" . $ret . ".jpg");
                }
            }
        }
        return $ret;
    }


    function GetGlobals()
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';

        global $mysqli;
        global $lang;

        $sql="SELECT banner_1_activat,banner_1_url,banner_2_activat,banner_2_url FROM globals WHERE id=0";     
        $result=$mysqli->query($sql);
        $data = null;
        if($result)
        {
            $row = $result->fetch_row();
            $data = array('banner_1_act'=>intval($row[0]),'banner_1_url'=>stripslashes($row[1]),'banner_2_act'=>intval($row[2]),'banner_2_url'=>stripslashes($row[3]));
        }

        return $data;
    }

    function InsertGlobals($banner_1_act,$banner_1_url,$banner_2_act,$banner_2_url)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        $ret=-1;
        
        $sql="UPDATE globals SET `banner_1_activat`='$banner_1_act',`banner_1_url`='$banner_1_url',`banner_2_activat`='$banner_2_act',`banner_2_url`='$banner_2_url' WHERE id=0";
        
        $result = $mysqli->query($sql);
        if($result)
        {
            $ret = $mysqli->insert_id;
        }
        return $ret;
    }

    function InsertType($id,$name,$name_es,$name_en,$description,$hidden)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
   
        global $mysqli;
        $ret=-1;

        $url = to_slug($name);

        if($id==-1)
        {
            $sql="INSERT INTO box_type (name,url,hidden,description,name_es,name_en) VALUES ('$name','$url','$hidden','$description','$name_es','$name_en')";
        }
        else
        {
            $sql="UPDATE box_type SET `name`='$name',`url`='$url',`hidden`='$hidden',`description`='$description',`name_es`='$name_es',`name_en`='$name_en' WHERE id='$id'";
        }
        $result = $mysqli->query($sql);
        if($result)
        {
            $ret = $mysqli->insert_id;
        }
        return $ret;
    }

    function InsertBox($mysqli,$id,$name,$description,$details,$use,$price,$type,$quotes,$img,$activities,$n_min,$n_max,$lat,$lng,$etype,$edate,$etotal,$cellers,$patrimoni,$visites,$rutes,$destacat,$nou,$ocult,$no_online,$special_img,$qr_img,$extra_fields,$min_price,$name_es,$description_es,$details_es,$use_es,$quotes_es,$price_es,$name_en,$description_en,$details_en,$use_en,$quotes_en,$price_en,$ppt,$collaboradors,$sessions,$res_days="",$close_time=12,$propietari=0,$sessio_unica="",$aavv=false,$mail_aux="",$com_obl=false,$com_aux="",$linksessions=-1,$recordatori="",$recordatori_es="",$recordatori_en="",$xaccept=false,$xaccept_description="",$xaccept_description_es="",$xaccept_description_en="",$taquilla_tancada=false,$portada_btiquets=true,$productes="",$enviament_id=0,$pagament=1,$enviament_str="",$codi_descompte=-1,$productes_relacionats="",$taquilla_arxivada=false)
    {
        global $lang;
        $ret=-1;
        
        $url = to_slug($name);
        while(true)
        {   
            $sql="SELECT COUNT(*) FROM box_data WHERE url='$url' AND id!='$id'";
            $result=$mysqli->query($sql);
            $c = $result->fetch_row();
            if($c[0]>0) 
            {
                $url .= "-";
            }
            else
            {
                break;
            }
        }
        
        if($id==-1)
        {
            $sql="INSERT INTO box_data(name,description,details,img,price,type,url,quotes,activities,reservation,n_min,n_max,lat,lng,event_type,data,n_total,cellers,patrimoni,visites,rutes,destacat,nou,ocult,no_online,special_img,qr_img,extra_fields,min_price,name_es,description_es,details_es,reservation_es,quotes_es,price_es,name_en,description_en,details_en,reservation_en,quotes_en,price_en,collaboradors,persons_per_ticket,propietari,res_days,close_time,aavv,mail_aux,com_obl,com_aux,linksessions,recordatori,recordatori_es,recordatori_en,xaccept,xaccept_description,xaccept_description_es,xaccept_description_en,taquilla_tancada,portada_btiquets,productes,enviament_id,pagament,enviament_str,codi_descompte,productes_relacionats,taquilla_arxivada) VALUES ('$name','$description','$details','$img','$price','$type','$url','$quotes','$activities','$use','$n_min','$n_max','$lat','$lng','$etype','$edate','$etotal','$cellers','$patrimoni','$visites','$rutes','$destacat','$nou','$ocult','$no_online','$special_img','$qr_img','$extra_fields','$min_price','$name_es','$description_es','$details_es','$use_es','$quotes_es','$price_es','$name_en','$description_en','$details_en','$use_en','$quotes_en','$price_en','$collaboradors','$ppt','$propietari','$res_days','$close_time','$aavv','$mail_aux','$com_obl','$com_aux','$linksessions','$recordatori','$recordatori_es','$recordatori_en','$xaccept','$xaccept_description','$xaccept_description_es','$xaccept_description_en','$taquilla_tancada','$portada_btiquets','$productes','$enviament_id','$pagament','$enviament_str','$codi_descompte','$productes_relacionats','$taquilla_arxivada')";
        }
        else
        {   
            $sql="UPDATE box_data SET `name`='$name',`description`='$description',`details`='$details',`img`='$img',`price`='$price',`type`='$type',`url`='$url',`quotes`='$quotes',`activities`='$activities',`reservation`='$use',`n_min`='$n_min',`n_max`='$n_max',`lat`='$lat',`lng`='$lng',`event_type`='$etype',`data`='$edate',`n_total`='$etotal',`cellers`='$cellers',`patrimoni`='$patrimoni',`visites`='$visites',`rutes`='$rutes',`destacat`='$destacat',`nou`='$nou',`ocult`='$ocult',`no_online`='$no_online',`special_img`='$special_img',`qr_img`='$qr_img',`extra_fields`='$extra_fields',`min_price`='$min_price',`name_es`='$name_es',`description_es`='$description_es',`details_es`='$details_es',`reservation_es`='$use_es',`quotes_es`='$quotes_es',`price_es`='$price_es',`name_en`='$name_en',`description_en`='$description_en',`details_en`='$details_en',`reservation_en`='$use_en',`quotes_en`='$quotes_en',`price_en`='$price_en',`collaboradors`='$collaboradors',`persons_per_ticket`='$ppt',`propietari`='$propietari',`res_days`='$res_days',`close_time`='$close_time',`aavv`='$aavv',`mail_aux`='$mail_aux',`com_obl`='$com_obl',`com_aux`='$com_aux',`linksessions`='$linksessions',`recordatori`='$recordatori',`recordatori_es`='$recordatori_es',`recordatori_en`='$recordatori_en',`xaccept`='$xaccept',`xaccept_description`='$xaccept_description',`xaccept_description_es`='$xaccept_description_es',`xaccept_description_en`='$xaccept_description_en',`taquilla_tancada`='$taquilla_tancada',`portada_btiquets`='$portada_btiquets',`productes`='$productes',`enviament_id`='$enviament_id',`pagament`='$pagament',`enviament_str`='$enviament_str',`codi_descompte`='$codi_descompte',`productes_relacionats`='$productes_relacionats',`taquilla_arxivada`='$taquilla_arxivada' WHERE id='$id'";
        }
        $result = $mysqli->query($sql);
        //error_log($sql);
        if($result)
        {
            $ret = $mysqli->insert_id;
            
            if($id==-1)
            {
                $id = $mysqli->insert_id;
                if(file_exists("../boxes/box_-1"))
                {
                    rename("../boxes/box_-1","../boxes/box_" . $mysqli->insert_id);
                }
                else
                {
                    mkdir("../boxes/box_" . $mysqli->insert_id);
                }
            }
        }
                
        
        if(intval($etype)==1)
        {
            // Ara recorrem totes les sessions mirant si s'ha de crear, modificar o eliminiar        
            $sessionlist = explode(';',$sessions);
            foreach($sessionlist as $sessioniter)
            {
                if($sessioniter!="")
                {
                    AdminSession($mysqli,$sessioniter,$id);
                }
            }
        }
        else if(intval($etype)==0)
        {
            // i finalment també gestionem la sessió única
            if($sessio_unica!="")
            {
                AdminSession($mysqli,$sessio_unica,$id);
            }
        }
        
        
        return $ret;
    }

function InsertHouse($mysqli,$id,$name,$poblacio,$mail,$tel,$web,$description,$mod,$type,$ocult,$name_es,$description_es,$name_en,$description_en,$mod_es,$mod_en,$propietari=0,$mail_aux="")
    {
        global $lang;
        $ret=-1;        
                
        if($id==-1)
        {
            $sql="INSERT INTO allotjaments(name,poblacio,mail,tel,web,description,type,modalitat,propietari,ocult,name_es,description_es,name_en,description_en,modalitat_es,modalitat_en,mail_aux) VALUES ('$name','$poblacio','$mail','$tel','$web','$description','$type','$mod','$propietari','$ocult','$name_es','$description_es','$name_en','$description_en','$mod_es','$mod_en','$mail_aux')";
        }
        else
        {   
            $sql="UPDATE allotjaments SET `name`='$name',`poblacio`='$poblacio',`mail`='$mail',`tel`='$tel',`web`='$web',`description`='$description',`type`='$type',`modalitat`='$mod',`propietari`='$propietari',`ocult`='$ocult',`name_es`='$name_es',`description_es`='$description_es',`name_en`='$name_en',`description_en`='$description_en',`modalitat_es`='$mod_es',`modalitat_en`='$mod_en',`mail_aux`='$mail_aux' WHERE id='$id'";
        }
        $result = $mysqli->query($sql);
        if($result)
        {
            $ret = $mysqli->insert_id;
            
            if($id==-1)
            {
                $id = $mysqli->insert_id;
                if(file_exists("../allotjaments/all_-1"))
                {
                    rename("../allotjaments/all_-1","../allotjaments/all_" . $mysqli->insert_id);
                }
                else
                {
                    mkdir("../allotjaments/all_" . $mysqli->insert_id);
                }
            }
        }
        
        return $ret;
    }

function CopyHouse($mysqli,$id)
    {        
        $sql = "INSERT into allotjaments(name,poblacio,mail,tel,web,description,type,modalitat,propietari,ocult,name_es,description_es,name_en,description_en,modalitat_es,modalitat_en,mail_aux) SELECT name,poblacio,mail,tel,web,description,type,modalitat,propietari,ocult,name_es,description_es,name_en,description_en,modalitat_es,modalitat_en,mail_aux from allotjaments where id='$id';";
        $result=$mysqli->query($sql);
        //error_log($sql);
        if($result)
        {
            $newid = $mysqli->insert_id;
            
            $sql = "SELECT name FROM allotjaments WHERE id='$newid'";
            $result=$mysqli->query($sql);
            $row = $result->fetch_row();
            $name = $row[0].'_copy';
            $sql = "UPDATE allotjaments SET `name`='$name' WHERE id='$newid'";
            $mysqli->query($sql);
        }
    }

function DeleteHouse($mysqli,$id)
{   
    $reserves=0;
        //Mirar si hi ha reserves d'aquest allotjament
//        $sql="SELECT COUNT(*) FROM reserva WHERE box_id='$id'";
//        $result=$mysqli->query($sql);  
//        $row = $result->fetch_row();
//        $reserves = $row[0];
        if($reserves==0)
        {
            $sql="DELETE FROM allotjaments WHERE id='$id'";
            $mysqli->query($sql);

            // ara toca borrar les imatges
            delete_dir("../allotjaments/all_".$id,true);
            
            return true;
        }
        
        return false;
        
    }

function InsertProducte($mysqli,$id,$name,$poblacio,$mail,$tel,$web,$description,$mod,$type,$ocult,$name_es,$description_es,$name_en,$description_en,$mod_es,$mod_en,$propietari=0,$mail_aux="")
    {
        global $lang;
        $ret=-1;        
                
        if($id==-1)
        {
            $sql="INSERT INTO productes(name,poblacio,mail,tel,web,description,type,modalitat,propietari,ocult,name_es,description_es,name_en,description_en,modalitat_es,modalitat_en,mail_aux) VALUES ('$name','$poblacio','$mail','$tel','$web','$description','$type','$mod','$propietari','$ocult','$name_es','$description_es','$name_en','$description_en','$mod_es','$mod_en','$mail_aux')";
        }
        else
        {   
            $sql="UPDATE productes SET `name`='$name',`poblacio`='$poblacio',`mail`='$mail',`tel`='$tel',`web`='$web',`description`='$description',`type`='$type',`modalitat`='$mod',`propietari`='$propietari',`ocult`='$ocult',`name_es`='$name_es',`description_es`='$description_es',`name_en`='$name_en',`description_en`='$description_en',`modalitat_es`='$mod_es',`modalitat_en`='$mod_en',`mail_aux`='$mail_aux' WHERE id='$id'";
        }
        $result = $mysqli->query($sql);
        if($result)
        {
            $ret = $mysqli->insert_id;
            
            if($id==-1)
            {
                $id = $mysqli->insert_id;
                if(file_exists("../productes/p_-1"))
                {
                    rename("../productes/p_-1","../productes/p_" . $mysqli->insert_id);
                }
                else
                {
                    mkdir("../productes/p_" . $mysqli->insert_id);
                }
            }
        }
        
        return $ret;
    }

function CopyProducte($mysqli,$id)
{        
    $sql = "INSERT into productes(name,poblacio,mail,tel,web,description,type,modalitat,propietari,ocult,name_es,description_es,name_en,description_en,modalitat_es,modalitat_en,mail_aux) SELECT name,poblacio,mail,tel,web,description,type,modalitat,propietari,ocult,name_es,description_es,name_en,description_en,modalitat_es,modalitat_en,mail_aux from productes where id='$id';";
    $result=$mysqli->query($sql);
    //error_log($sql);
    if($result)
    {
        $newid = $mysqli->insert_id;

        $sql = "SELECT name FROM productes WHERE id='$newid'";
        $result=$mysqli->query($sql);
        $row = $result->fetch_row();
        $name = $row[0].'_copy';
        $sql = "UPDATE productes SET `name`='$name' WHERE id='$newid'";
        $mysqli->query($sql);
    }
}

function DeleteProducte($mysqli,$id)
{   
    //Mirar si hi ha taquilles associades a aquest producte
    $taquilles=0;
    $sql="SELECT productes FROM box_data WHERE event_type=5";
    $result=$mysqli->query($sql);
    while ( $row = $result->fetch_row() )
    {
        $producte_list = decode_producte_str($row[0]);
        if($producte_list[$id]['active']==true) $taquilles++;
    }

    if($taquilles==0)
    {
        $sql="DELETE FROM productes WHERE id='$id'";
        $mysqli->query($sql);

        // ara toca borrar les imatges
        delete_dir("../productes/p_".$id,true);

        return true;
    }

    return false;
}

    function InsertEnviament($mysqli,$id,$name,$description,$type,$deststr,$propietari)
    {
        global $lang;
        $ret=-1;        
                
        if($id==-1)
        {
            $sql="INSERT INTO enviaments(name,description,type,deststr,propietari) VALUES ('$name','$description','$type','$deststr','$propietari')";
        }
        else
        {   
            $sql="UPDATE enviaments SET `name`='$name',`description`='$description',`type`='$type',`deststr`='$deststr',`propietari`='$propietari' WHERE id='$id'";
        }
        $result = $mysqli->query($sql);
        if($result)
        {
            $ret = $mysqli->insert_id;
        }
        
        return $ret;
    }

function CopyEnviament($mysqli,$id)
{        
    $sql = "INSERT into enviaments(name,description,type,deststr,propietari) SELECT name,description,type,deststr,propietari from enviaments where id='$id';";
    $result=$mysqli->query($sql);
    //error_log($sql);
    if($result)
    {
        $newid = $mysqli->insert_id;

        $sql = "SELECT name FROM enviaments WHERE id='$newid'";
        $result=$mysqli->query($sql);
        $row = $result->fetch_row();
        $name = $row[0].'_copy';
        $sql = "UPDATE enviaments SET `name`='$name' WHERE id='$newid'";
        $mysqli->query($sql);
    }
}

function DeleteEnviament($mysqli,$id)
{   
    $productes=0;
    //Mirar si hi ha taquilles associades a aquest enviament
    $sql="SELECT COUNT(*) FROM box_data WHERE enviament_id='$id'";
    $result=$mysqli->query($sql);  
    $row = $result->fetch_row();
    $productes = $row[0];

    if($productes==0)
    {
        $sql="DELETE FROM enviaments WHERE id='$id'";
        $mysqli->query($sql);

        return true;
    }

    return false;        
}

function AdminSession($mysqli,$sessionstr,$id)
{
    $sql = "";
    $session_name = "";
    $tarifes = "-1:";
    $reserva_unica = 0;
    $sessionitem = explode('%',$sessionstr);
    if(count($sessionitem)>=9)
    {
        $del = intval($sessionitem[0]);
        $sid = intval($sessionitem[1]);
        $data = $sessionitem[2];
        $places = intval($sessionitem[3]);
        $estat = intval($sessionitem[4]);
        $antelacio = intval($sessionitem[5]);
        $session_name = $sessionitem[6];
        $tarifes = $sessionitem[7];
        $reserva_unica = intval($sessionitem[8]);
    }
    else if(count($sessionitem)==8)
    {
        $del = intval($sessionitem[0]);
        $sid = intval($sessionitem[1]);
        $data = $sessionitem[2];
        $places = intval($sessionitem[3]);
        $estat = intval($sessionitem[4]);
        $antelacio = intval($sessionitem[5]);
        $session_name = $sessionitem[6];
        $tarifes = $sessionitem[7];
    }
    else if(count($sessionitem)==7)
    {
        $del = intval($sessionitem[0]);
        $sid = intval($sessionitem[1]);
        $data = $sessionitem[2];
        $places = intval($sessionitem[3]);
        $estat = intval($sessionitem[4]);
        $antelacio = intval($sessionitem[5]);
        $session_name = $sessionitem[6];
    }
    else if(count($sessionitem)==6)
    {
        $del = intval($sessionitem[0]);
        $sid = intval($sessionitem[1]);
        $data = $sessionitem[2];
        $places = intval($sessionitem[3]);
        $estat = intval($sessionitem[4]);
        $antelacio = intval($sessionitem[5]);
    }
    else if(count($sessionitem)==5)
    {
        $del = 0;
        $sid = intval($sessionitem[0]);
        $data = $sessionitem[1];
        $places = intval($sessionitem[2]);
        $estat = intval($sessionitem[3]);
        $antelacio = intval($sessionitem[4]);
    }
    else if(count($sessionitem)==4)
    {
        $del = 0;
        $sid = -1;
        $data = $sessionitem[0];
        $places = intval($sessionitem[1]);
        $estat = intval($sessionitem[2]);
        $antelacio = intval($sessionitem[3]);
    }

    if($del==1)
    {
        $sql="DELETE FROM sessions WHERE id='$sid'";  
        $result = $mysqli->query($sql);
    }
    else
    {
        switch($sid)
        {
            case -1:    // entro la sessió

                $sdata = date_create_from_format('d-m-Y H:i',$data);
                $date_str = date_format($sdata,'Y-m-d H:i:s');
                $sql="INSERT INTO sessions(data,box_id,places,estat,antelacio,session_name,tarifes,reserva_unica) VALUES ('$date_str','$id','$places','$estat','$antelacio','$session_name','$tarifes','$reserva_unica')";

                $result = $mysqli->query($sql);
                $sql="UPDATE box_data SET `sessio_unica`='$mysqli->insert_id' WHERE id='$id'";
                $result = $mysqli->query($sql);
                
            
                break;
            
            default:    // modifico la sessió
                $sdata = date_create_from_format('d-m-Y H:i',$data);
                $date_str = date_format($sdata,'Y-m-d H:i:s');
                $sql="UPDATE sessions SET `data`='$date_str',`box_id`='$id',`places`='$places',`estat`='$estat',`antelacio`='$antelacio',`session_name`='$session_name',`tarifes`='$tarifes',`reserva_unica`='$reserva_unica' WHERE id='$sid'";
                $result = $mysqli->query($sql);
            
                break;
        }
    }
    
    return $sql;
}

    function InsertCeller($id,$name,$description,$img,$lat,$lng,$visit,$url,$visit_desc,$add_1,$add_2,$tel,$email,$facebook,$twitter,$web,$instagram)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        global $lang;
        $ret=-1;
        
        if($url=="")
        {
            $url = to_slug($name);
        }
        
        
        if($id==-1)
        {
            switch($lang)
            {
                case 'es':
                    $sql="INSERT INTO cellers(name,description_es,img,lat,lng,visita,url,descripcio_visita_es,add_1,add_2,tel,email,facebook,twitter,web,instagram) VALUES ('$name','$description','$img','$lat','$lng','$visit','$url','$visit_desc','$add_1','$add_2','$tel','$email','$facebook','$twitter','$web','$instagram')";
                    break;

                case 'en':
                    $sql="INSERT INTO cellers(name,description_en,img,lat,lng,visita,url,descripcio_visita_en,add_1,add_2,tel,email,facebook,twitter,web,instagram) VALUES ('$name','$description','$img','$lat','$lng','$visit','$url','$visit_desc','$add_1','$add_2','$tel','$email','$facebook','$twitter','$web','$instagram')";
                    break;

                default:
                    $sql="INSERT INTO cellers(name,description,img,lat,lng,visita,url,descripcio_visita,add_1,add_2,tel,email,facebook,twitter,web,instagram) VALUES ('$name','$description','$img','$lat','$lng','$visit','$url','$visit_desc','$add_1','$add_2','$tel','$email','$facebook','$twitter','$web',''$instagram')";
                    break;
            }             
        }
        else
        {
            switch($lang)
            {
                case 'es':
                    $sql="UPDATE cellers SET `name`='$name',`description_es`='$description',`img`='$img',`lat`='$lat',`lng`='$lng',`visita`='$visit',`url`='$url',`descripcio_visita_es`='$visit_desc',`add_1`='$add_1',`add_2`='$add_2',`tel`='$tel',`email`='$email',`facebook`='$facebook',`twitter`='$twitter',`web`='$web',`instagram`='$instagram' WHERE id='$id'";
                    break;

                case 'en':
                    $sql="UPDATE cellers SET `name`='$name',`description_en`='$description',`img`='$img',`lat`='$lat',`lng`='$lng',`visita`='$visit',`url`='$url',`descripcio_visita_en`='$visit_desc',`add_1`='$add_1',`add_2`='$add_2',`tel`='$tel',`email`='$email',`facebook`='$facebook',`twitter`='$twitter',`web`='$web',`instagram`='$instagram' WHERE id='$id'";
                    break;

                default:
                    $sql="UPDATE cellers SET `name`='$name',`description`='$description',`img`='$img',`lat`='$lat',`lng`='$lng',`visita`='$visit',`url`='$url',`descripcio_visita`='$visit_desc',`add_1`='$add_1',`add_2`='$add_2',`tel`='$tel',`email`='$email',`facebook`='$facebook',`twitter`='$twitter',`web`='$web',`instagram`='$instagram' WHERE id='$id'";
                    break;
            }             
        }
        $result = $mysqli->query($sql);
        if($result)
        {
            $ret = $mysqli->insert_id;
            
            if($id==-1)
            {
                if(file_exists("../cellers/celler_-1"))
                {
                    rename("../cellers/celler_-1","../cellers/celler_" . $mysqli->insert_id);
                }
                else
                {
                    mkdir("../cellers/celler_" . $mysqli->insert_id);
                }
            }
        }
        return $ret;
    }

    function InsertRest($id,$name,$description,$img,$lat,$lng,$url,$add_1,$add_2,$city,$tel,$email,$facebook,$twitter,$web,$description_es,$description_en,$instagram,$tipus,$tipus_es,$tipus_en,$quotes,$quotes_es,$quotes_en,$logo,$logo_2,$horari,$horari_es,$horari_en,$ocult,$col_id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        $ret=-1;
        
        $url = to_slug($name);
        
        if($id==-1)
        {
            $sql="INSERT INTO restaurants(name,description,img,lat,lng,url,add_1,add_2,tel,email,facebook,twitter,web,description_es,description_en,instagram,tipus,tipus_es,tipus_en,ciutat,quotes,quotes_es,quotes_en,logo,horari,horari_es,horari_en,logo_2,ocult,col_id) VALUES ('$name','$description','$img','$lat','$lng','$url','$add_1','$add_2','$tel','$email','$facebook','$twitter','$web','$description_es','$description_en','$instagram','$tipus','$tipus_es','$tipus_en','$city','$quotes','$quotes_es','$quotes_en','$logo','$horari','$horari_es','$horari_en','$logo_2','$ocult','$col_id')";
        }
        else
        {
            $sql="UPDATE restaurants SET `name`='$name',`description`='$description',`img`='$img',`lat`='$lat',`lng`='$lng',`url`='$url',`add_1`='$add_1',`add_2`='$add_2',`tel`='$tel',`email`='$email',`facebook`='$facebook',`twitter`='$twitter',`web`='$web',`description_es`='$description_es',`description_en`='$description_en',`instagram`='$instagram',`tipus`='$tipus',`tipus_es`='$tipus_es',`tipus_en`='$tipus_en',`ciutat`='$city',`quotes`='$quotes',`quotes_es`='$quotes_es',`quotes_en`='$quotes_en',`logo`='$logo',`horari`='$horari',`horari_es`='$horari_es',`horari_en`='$horari_en',`logo_2`='$logo_2',`ocult`='$ocult',`col_id`='$col_id' WHERE id='$id'";
        }
        $result = $mysqli->query($sql);
        if($result)
        {
            $ret = $mysqli->insert_id;
            
            if($id==-1)
            {
                if(file_exists("../rest/restaurant_-1"))
                {
                    rename("../rest/restaurant_-1","../rest/restaurant_" . $mysqli->insert_id);
                }
                else
                {
                    mkdir("../rest/restaurant_" . $mysqli->insert_id);
                }
            }
        }
        return $ret;
    }

    function InsertAllj($id,$name,$description,$img,$lat,$lng,$url,$add_1,$add_2,$city,$tel,$email,$facebook,$twitter,$web,$description_es,$description_en,$instagram,$tipus,$tipus_es,$tipus_en,$quotes,$quotes_es,$quotes_en,$logo,$logo_2,$horari,$horari_es,$horari_en,$ocult,$col_id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        $ret=-1;
        
        $url = to_slug($name);
        
        if($id==-1)
        {
            $sql="INSERT INTO allotjaments(name,description,img,lat,lng,url,add_1,add_2,tel,email,facebook,twitter,web,description_es,description_en,instagram,tipus,tipus_es,tipus_en,ciutat,quotes,quotes_es,quotes_en,logo,horari,horari_es,horari_en,logo_2,ocult,col_id) VALUES ('$name','$description','$img','$lat','$lng','$url','$add_1','$add_2','$tel','$email','$facebook','$twitter','$web','$description_es','$description_en','$instagram','$tipus','$tipus_es','$tipus_en','$city','$quotes','$quotes_es','$quotes_en','$logo','$horari','$horari_es','$horari_en','$logo_2','$ocult','$col_id')";
        }
        else
        {
            $sql="UPDATE allotjaments SET `name`='$name',`description`='$description',`img`='$img',`lat`='$lat',`lng`='$lng',`url`='$url',`add_1`='$add_1',`add_2`='$add_2',`tel`='$tel',`email`='$email',`facebook`='$facebook',`twitter`='$twitter',`web`='$web',`description_es`='$description_es',`description_en`='$description_en',`instagram`='$instagram',`tipus`='$tipus',`tipus_es`='$tipus_es',`tipus_en`='$tipus_en',`ciutat`='$city',`quotes`='$quotes',`quotes_es`='$quotes_es',`quotes_en`='$quotes_en',`logo`='$logo',`horari`='$horari',`horari_es`='$horari_es',`horari_en`='$horari_en',`logo_2`='$logo_2',`ocult`='$ocult',`col_id`='$col_id' WHERE id='$id'";
        }
        $result = $mysqli->query($sql);
        if($result)
        {
            $ret = $mysqli->insert_id;
            
            if($id==-1)
            {
                if(file_exists("../allotj/allotjament_-1"))
                {
                    rename("../allotj/allotjament_-1","../allotj/allotjament_" . $mysqli->insert_id);
                }
                else
                {
                    mkdir("../allotj/allotjament_" . $mysqli->insert_id);
                }
            }
        }
        return $ret;
    }

    function EditCol($id,$name,$user)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        $ret=-1;
        
        
        if($id==-1)
        {
            $sql="INSERT INTO collaboradors (nom,user) VALUES ('$name','$user')";
        }
        else
        {
            $sql="UPDATE collaboradors SET `nom`='$name',`user`='$user' WHERE id='$id'";
        }
        $result = $mysqli->query($sql);
        if($result)
        {
            $ret = $mysqli->insert_id;            
        }        
        return $ret;
    }

    function EditCompte($mysqli,$id,$name,$user,$merchantcode,$terminal,$currency,$key,$url,$btype_0,$btype_1,$btype_2,$btype_3,$btype_4,$btype_5,$btype_6,$btype_7,$mail,$lopd,$bizum,$versio)
    {        
        $ret=-1;
        $nom_url = to_slug($name);
        
        if($id==-1)
        {
            $sql="INSERT INTO comptes (nom,propietari,tpv_merchantCode,tpv_terminal,tpv_currency,tpv_key,tpv_url,btype_0,btype_1,btype_2,btype_3,btype_4,btype_5,btype_6,btype_7,mail,lopd,nom_url,bizum,versio) VALUES ('$name','$user','$merchantcode','$terminal','$currency','$key','$url','$btype_0','$btype_1','$btype_2','$btype_3','$btype_4','$btype_5','$btype_6','$btype_7','$mail','$lopd','$nom_url','$bizum','$versio')";
        }
        else
        {
            $sql="UPDATE comptes SET `nom`='$name',`propietari`='$user',`tpv_merchantCode`='$merchantcode',`tpv_terminal`='$terminal',`tpv_currency`='$currency',`tpv_key`='$key',`tpv_url`='$url',`btype_0`='$btype_0',`btype_1`='$btype_1',`btype_2`='$btype_2',`btype_3`='$btype_3',`btype_4`='$btype_4',`btype_5`='$btype_5',`btype_6`='$btype_6',`btype_7`='$btype_7',`mail`='$mail',`lopd`='$lopd',`nom_url`='$nom_url',`bizum`='$bizum',`versio`='$versio' WHERE id='$id'";
        }
        $result = $mysqli->query($sql);
        if($result)
        {
            $ret = $mysqli->insert_id;
            
            if($id==-1)
            {
                $id = $mysqli->insert_id;
                if(file_exists("../boxes/logo_image_-1.jpg"))
                {
                    rename("../boxes/logo_image_-1.jpg","../boxes/logo_image_" . $mysqli->insert_id . ".jpg");
                }
            }
        }       
        return $ret;
    }

    function DeleteType($id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        
        $sql="DELETE FROM box_type WHERE id='$id'";
        $mysqli->query($sql);
    }

    function DeleteBox($mysqli,$id)
    {   
        //Mirar si hi ha reserves d'aquesta BOX
        $sql="SELECT COUNT(*) FROM reserva WHERE box_id='$id'";
        $result=$mysqli->query($sql);  
        $row = $result->fetch_row();
        $reserves = $row[0];
        if($reserves==0)
        {
            $sql="DELETE FROM box_data WHERE id='$id'";
            $mysqli->query($sql);

            // ara toca borrar les imatges
            delete_dir("../boxes/box_".$id,true);
            
            return true;
        }
        
        return false;
        
    }

    function TranslateBox($id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        
        $sql = "UPDATE box_data SET `name_es`=`name` WHERE id='$id' AND name_es=''";
        $mysqli->query($sql);
        
        $sql = "UPDATE box_data SET `description_es`=`description` WHERE id='$id' AND description_es=''";
        $mysqli->query($sql);
        
        $sql = "UPDATE box_data SET `price_es`=`price` WHERE id='$id' AND price_es=''";
        $mysqli->query($sql);
        
        $sql = "UPDATE box_data SET `quotes_es`=`quotes` WHERE id='$id' AND quotes_es=''";
        $mysqli->query($sql);
        
        $sql = "UPDATE box_data SET `details_es`=`details` WHERE id='$id' AND details_es=''";
        $mysqli->query($sql);
        
        $sql = "UPDATE box_data SET `reservation_es`=`reservation` WHERE id='$id' AND reservation_es=''";
        $mysqli->query($sql);
        
        $sql = "UPDATE box_data SET `name_en`=`name` WHERE id='$id' AND name_en=''";
        $mysqli->query($sql);
        
        $sql = "UPDATE box_data SET `description_en`=`description` WHERE id='$id' AND description_en=''";
        $mysqli->query($sql);
        
        $sql = "UPDATE box_data SET `price_en`=`price` WHERE id='$id' AND price_en=''";
        $mysqli->query($sql);
        
        $sql = "UPDATE box_data SET `quotes_en`=`quotes` WHERE id='$id' AND quotes_en=''";
        $mysqli->query($sql);
        
        $sql = "UPDATE box_data SET `details_en`=`details` WHERE id='$id' AND details_en=''";
        $mysqli->query($sql);
        
        $sql = "UPDATE box_data SET `reservation_en`=`reservation` WHERE id='$id' AND reservation_en=''";
        $mysqli->query($sql);
    }

    function CopyBox($mysqli,$id)
    {        
        $sql = "INSERT into box_data(name,description,img,price,type,quotes,activities,details,reservation,n_min,n_max,lat,lng,event_type,data,n_total,cellers,patrimoni,visites,rutes,promo_quant,promo_id,destacat,nou,ocult,no_online,special_img,extra_fields,min_price,name_es,name_en,description_es,description_en,price_es,price_en,quotes_es,quotes_en,details_es,details_en,reservation_es,reservation_en,collaboradors,short_description,short_description_es,short_description_en,persons_per_ticket,propietari,res_days,close_time,aavv,mail_aux) SELECT name,description,img,price,type,quotes,activities,details,reservation,n_min,n_max,lat,lng,event_type,data,n_total,cellers,patrimoni,visites,rutes,promo_quant,promo_id,destacat,nou,ocult,no_online,special_img,extra_fields,min_price,name_es,name_en,description_es,description_en,price_es,price_en,quotes_es,quotes_en,details_es,details_en,reservation_es,reservation_en,collaboradors,short_description,short_description_es,short_description_en,persons_per_ticket,propietari,res_days,close_time,aavv,mail_aux from box_data where id='$id';";
        $result=$mysqli->query($sql);
        if($result)
        {
            $newid = $mysqli->insert_id;
            
            $sql = "SELECT name FROM box_data WHERE id='$newid'";
            $result=$mysqli->query($sql);
            $row = $result->fetch_row();
            $name = $row[0].'_copy';
            $sql = "UPDATE box_data SET `name`='$name' WHERE id='$newid'";
            $mysqli->query($sql);
        }
    }

    function DeletePromo($id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        
        $sql="DELETE FROM promocions WHERE id='$id'";
        $mysqli->query($sql);
        
        if(file_exists('../promos/image_'.$id.'.jpg'))
        {
            unlink('../promos/image_'.$id.'.jpg');
        }
    }

    function DeleteCeller($id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        
        $sql="DELETE FROM cellers WHERE id='$id'";
        $mysqli->query($sql);
        
        // ara toca borrar les imatges
        delete_dir("../cellers/celler_".$id,true);
    }

    function DeleteRest($id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        
        $sql="DELETE FROM restaurants WHERE id='$id'";
        $mysqli->query($sql);
        
        // ara toca borrar les imatges
        delete_dir("../rest/restaurant_".$id,true);
    }

    function DeleteAllj($id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        
        $sql="DELETE FROM allotjaments WHERE id='$id'";
        $mysqli->query($sql);
        
        // ara toca borrar les imatges
        delete_dir("../allotj/allotjament_".$id,true);
    }

    function DeleteCol($id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        
        $sql="DELETE FROM collaboradors WHERE id='$id'";
        $mysqli->query($sql);
    }

    function DeleteCompte($mysqli,$id)
    {
        
        $sql="DELETE FROM compte WHERE id='$id'";
        $mysqli->query($sql);
    }

    function SortTable($str,$table)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        $ret=-1;
        
        $id_list = explode(";",$str);
        
        for ($i = 0; $i < count($id_list); $i++)
        {
            $aux = explode(":",$id_list[$i]);
            
            if(count($aux)==2)
            {
                $sql = "UPDATE " . $table . " SET `ipos`='$aux[1]' WHERE id='$aux[0]'";
                $mysqli->query($sql);
                $ret=1;
            }
        }
        return $ret;
    }

    function decode_url($mysqli,$str,$table)
    {        
        $id = -1;
        $sql="SELECT id FROM " . $table . " WHERE url='$str'";
        $result=$mysqli->query($sql);
        if($result->num_rows>0) 
        {
            $row = $result->fetch_row();
            $id = $row[0];
        }

        return $id;
    }    

    function GenerateReservation()
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        $repetit = 1;
        
        while($repetit)
        {
            // Primer genero el codi
            $codi = RandomString(6,false,true,false);
            
            // i ara miro si existeix (improbable, però no impossible)
            $sql="SELECT COUNT(*) FROM reserva WHERE ref='$codi'";
            $result=$mysqli->query($sql);
            $row = $result->fetch_row();
            $repetit = $row[0];
        }
        
        return $codi;
    }

    function InsertReservation($mysqli,$id,$box_id,$user_id,$comentaris,$quant_str,$num_reserva,$total,$data,$state,$quant_total,$tipus,$data_r,$data_e,$session_id=-1,$bnom="",$bdesc="",$rnom="",$rmail="",$rtel="",$rmun="",$regal=false,$text_regal="",$caducitat=6,$aavv=false,$data_e_out=null,$newsletter=false,$pagament=1,$addr1="",$addr2="",$cp="",$dades="",$genere=0,$check_1=0,$check_2=0,$check_3=0,$check_special=0,$codi_aplicat=null,$descompte_aplicat=0)
    {
        $ret=-1;
        
        // Aquí busco la sessió per tal d'entrar la data corresponent
        // Però aquest pas no s'ha de fer si l'activitat ja ha estat realitzada, per si es recicla la sessió
        $sid=intval($session_id);
        if($sid>0 && $state!=2)
        {
            $sql="SELECT data FROM sessions WHERE id='$sid'";
            $result = $mysqli->query($sql);
            $data_r = $result->fetch_row()[0];
        }
        
        
        if($id==-1)
        {
            $sql="INSERT INTO reserva (ref,user_id,comentaris,quantitat,box_id,total,data,data_reserva,data_executada,quant_total,tipus,session_id,nom,descripcio,res_nom,res_mail,res_tel,res_mun,regal,text_regal,caducitat,aavv,data_reserva_out,newsletter,pagament,res_adr_1,res_adr_2,res_cp,dades,genere,check_1,check_2,check_3,check_special,codi_aplicat,descompte_aplicat) VALUES ('$num_reserva','$user_id','$comentaris','$quant_str','$box_id','$total','$data','$data_r','$data_e','$quant_total','$tipus','$session_id','$bnom','$bdesc','$rnom','$rmail','$rtel','$rmun','$regal','$text_regal','$caducitat','$aavv','$data_e_out','$newsletter','$pagament','$addr1','$addr2','$cp','$dades','$genere','$check_1','$check_2','$check_3','$check_special','$codi_aplicat','$descompte_aplicat')";
            $result = $mysqli->query($sql);
            if($result)
            {
                $ret = $mysqli->insert_id;                                
            }
        }
        else
        {
            $sql="UPDATE reserva SET `ref`='$num_reserva',`user_id`='$user_id',`comentaris`='$comentaris',`quantitat`='$quant_str',`box_id`='$box_id',`total`='$total',`data`='$data',`data_reserva`='$data_r',`data_executada`='$data_e',`quant_total`='$quant_total',`tipus`='$tipus',`session_id`='$session_id',`nom`='$bnom',`descripcio`='$bdesc',`res_nom`='$rnom',`res_mail`='$rmail',`res_tel`='$rtel',`res_mun`='$rmun',`regal`='$regal',`text_regal`='$text_regal',`caducitat`='$caducitat',`aavv`='$aavv',`data_reserva_out`='$data_e_out',`newsletter`='$newsletter',`pagament`='$pagament',`res_adr_1`='$addr1',`res_adr_2`='$addr2',`res_cp`='$cp',`dades`='$dades',`genere`='$genere',`check_1`='$check_1',`check_2`='$check_2',`check_3`='$check_3',`check_special`='$check_special',`codi_aplicat`='$codi_aplicat',`descompte_aplicat`='$descompte_aplicat' WHERE id='$id'";
            $result = $mysqli->query($sql);
            if($result)
            {
                $ret = $id;
            }
        }

        //error_log($sql);
        
        if($state!==null && $ret!==-1)
        {
            $sql="UPDATE reserva SET `confirmat`='$state' WHERE id='$ret'";
            $result = $mysqli->query($sql);
        }
        
        return $ret;
    }

    

    function GeneratePDF1($info_reserva)
    {
        include_once '../plugins/mpdf/mpdf.php';
          
        global $mysqli;
        global $lang;
        global $admin_mail;
        global $admin_tel;
        global $lan_dir;
        global $iva_1;
        
        $celler = null;    
        
        // Calculo la caducitat
        $cad = $info_reserva["caducitat"]>0?$info_reserva["caducitat"]:6;
        $cad_str = "+" . $cad . " months";
        $edate = date('d-m-Y', strtotime($cad_str, strtotime($info_reserva["data"])));
        
        if($info_reserva['box_id']!=-1)
        {
            // Activitat existent
            
            $box = GetBox($mysqli,$info_reserva['box_id']);
            if($box['extra_fields']>0)
            {
                $celler = GetCeller($box['extra_fields']);
            }
            
            // Tipus d'esdeveniment
            $etype = intval($box['etype']); // 0: oberta / 1: programada
            
            // REAV
            $reav = $box['aavv'];
            
            // Tipus de reserva
            $rtype = intval($info_reserva['session_id']);   // -1: oberta (per defecte) / -2: programada manual                  
            $auxdata = date_create_from_format('Y-m-d H:i:s',$info_reserva["data_res"]);
            $rdate = date_format($auxdata,'d-m-Y H:i');                                    
                
            switch($etype)
            {
                case 1:
                    // No hi ha cap sessió assignada, passa a ser oberta
                    if($rtype==-1)
                    {
                        $etype = 0;
                    }
                    else if($rtype==-2)
                    {
                        $edate = $rdate;
                    }                    
                    else
                    {
                        $sdata = date_create_from_format('Y-m-d H:i:s',$info_reserva['data_session']);
                        $edate = date_format($sdata,'d-m-Y H:i');                        
                    }
                    break;
                
                default:
                    // Tot i ser amb data oberta, si se li ha assignat manualment una data
                    // passa a ser programada                    
                    if($rtype==-2)
                    {
                        $etype = 1;
                        $edate = $rdate;
                    }                    

                    break;
            }
            
            
            // decodifico els strings de modalitats
            $price_modalities = decode_price($box['price'],false);
            $quant_modalities = explode(';',$info_reserva['quantitat']);                        
            $ppts = explode(';',$box['persons_per_ticket']);
            
            $ptotal = 0;
            $i=0;
            foreach($quant_modalities as $quant)
            {
                $ppt = count($ppts)<=$i?1:$ppts[$i];
                $ptotal += (intval($quant) * $ppt);
                $i++;
            }
            
            if($info_reserva['quant_total']>0)
            {
                $ptotal = $info_reserva['quant_total'];
            }
            
            $box_name = $box['name'];
            $box_description = $box['description'];
            $box_details = $box['details'];
            $box_use = $box['use'];
        }
        else
        {
            // Activitat personalitzada
            
            // Tipus de reserva
            $rtype = $info_reserva['session_id'];   // -1: oberta (per defecte) / -2: programada manual                  
            $auxdata = date_create_from_format('Y-m-d H:i:s',$info_reserva["data_res"]);
            $rdate = date_format($auxdata,'d-m-Y H:i');
            
            // REAV
            $reav = $info_reserva["aavv"];
            
            // Tipus d'esdeveniment
            if($rtype==-1)
            {
                $etype = 0;
            }
            else if($rtype==-2)
            {
                // Programada manualment
                $etype = 1;
                $edate = $rdate;
            }
            else
            {
                // Sessió
                $etype = 1;
                $sdata = date_create_from_format('Y-m-d H:i:s',$info_reserva['data_session']);
                $edate = date_format($sdata,'d-m-Y H:i');
            }   
            
            $ptotal = $info_reserva['quant_total'];
            
            $box_name = $info_reserva['nom_exp'];
            $box_description = html_entity_decode(nl2br(htmlspecialchars(stripslashes($info_reserva['desc_exp']))));
            $box_details = $info_reserva['details'];
            $box_use = $info_reserva['use'];
        }  
        
        $sdata = date_create_from_format('Y-m-d',$info_reserva['data']);
        $cdata = date_format($sdata,'d-m-Y');
        
        // Fem el document PDF
        $mpdf=new mPDF();            
        $mpdf->SetAuthor("BTiquets");        
        $mpdf->SetDisplayMode('fullpage');
        
        ob_start();

        $html_css = '

        <html>
        <head>
        <link rel="stylesheet" type="text/css" href="/css/newstyle.css" media="all" />
        <style>
            body { 
                color:#000000;                 
                margin: 0 auto;
            }
            h2 {
                margin: 20px 0px 5px;
            }
            .pdf_header {
                font-size: 0;
                margin-bottom: 10px;
            }
            .pdf_info {                
                padding:10px;
                text-align:right;
                vertical-align: top;
                font-size:10px;
            }
            .pdf_info p {
                margin:0 ;
            }
            .pdf_info > h4 {
                font-size:12px;
                text-transform: uppercase;
            }
            .pdf_subheader {
                border-bottom: 2px solid #5e132b;
                padding-bottom: 10px;
            }
            .ticket_main {
                padding-top:0;
            }
            .ticket_main h1 {
                font-size: 30px;
                margin-bottom: 10px;
            }
            .ticket_main div.ticket_p {
                font-size: 12px;
            }
            div.ticket_description {
                font-size: 11px;
            }
            .ticket_main .ticket_options .b3 .l2 {
                font-size: 20px;
            }
            .ticket_options {
                width: auto;
                padding-left: 0px;
            }
            .ticket_main .ticket_options .b3 {
                border: none;
                padding: 0;
            }
            .ticket_pictures {
                padding-top:10px;
            }            
                
        </style>
        </head>';



        $html = $html_css . '<body>
        <table width="100%" class="pdf_header"><tr>
            <td width="20%"><img width="100" src="../img/pdf-3.jpg" alt="h1"></td>
            <td width="80%" class="pdf_info">
                <p>' . "# " . $info_reserva['id'] . '</p>
                <p>' . "La Brocada Serveis S.L." . '</p>
                <p>' . "NIF. B66405887" . '</p>
                <h4>' . translate('informació de contacte',$lang) . '</h4>
                <p>MAIL. ' . $admin_mail . '</p>
                <p>TEL. ' . $admin_tel . '</p>
            </td>
        </tr></table>
        <div class="ticket_main">            
            <h1>' . $box_name . '</h1>

            <h2>' . translate("Codi de la reserva", $lang) . '</h2>
            <div class="ticket_p">' . strtoupper($info_reserva['ref']) . '</div>';

            if($etype==0)
            {
                $html .= ('<h2>' . translate("Data de compra", $lang) . '</h2>
                <div class="ticket_p">' . $cdata . '</div>');
                          
                $html .= ('<h2>' . translate("Vigència de l'experiència", $lang) . '</h2>
                <div class="ticket_p">' . $edate . '</div>');
            }
            else
            {
                $html .= ('<h2>' . translate("Data de compra", $lang) . '</h2>
                <div class="ticket_p">' . $cdata . '</div>');
                          
                $html .= ('<h2>' . translate("Data de la reserva", $lang) . '</h2>
                <div class="ticket_p">' . $edate . '</div>');
            }

            $html .= ('<h2>' . translate("Dades de l'usuari", $lang) . '</h2>
            <div class="ticket_p">' . $info_reserva['nom'] . ' ' . $info_reserva['cognoms'] . '</div>
            <div class="ticket_p">' . $info_reserva['email'] . '</div>
            <div class="ticket_p">' . $info_reserva['tel'] . '</div>            

            <h2>' . translate("Dades de l'activitat", $lang) . '</h2>');

            if($celler==null)
            {
                $html = $html . '<div class="ticket_description">' . $box_description . '</div>';
            }
            else
            {
                $html = $html . '<div class="ticket_description">' . $celler['visita_desc'] . '</div>';
            }
        
            if($info_reserva['box_id']!=-1)
            {
                if($etype==0)
                {
                    if($box_details!="")
                    {
                        $html = $html . '<h2>' . translate("Disponibilitat", $lang) . '</h2>
                        <div class="ticket_description">' . $box_details . '</div>';
                    }

                    if($box_use!="")
                    {
                        $html .= ('<h2>' . translate("Reserva", $lang) . '</h2>
                        <div class="ticket_description">' . $box_use . '</div>');
                    }
                }
                else
                {
                }
            }

            $html .= ('<h2>' . translate("Preu", $lang) . '</h2>
            <div class="ticket_options">
                <div class="b2">');            
        
            if(count($quant_modalities)==0 || $info_reserva['quantitat']=="" || $info_reserva['quant_total']>0)
            {
                $perstr = intval($ptotal)>1 ? translate('persones',$lang) : translate('persona',$lang);
                $html = $html . '<div>' . $ptotal . ' ' . $perstr . '</div>';
            }
            else
            {
                for($i=0;$i<count($price_modalities);$i++)
                {
                    $price = $price_modalities[$i];
                    if($quant_modalities[$i]!=undefined && $quant_modalities[$i]!=null)
                    {
                        $quant = $quant_modalities[$i];
                        if($quant>0)
                        {
                            $html = $html . '<div>' . $quant . ' x ' . $price['price'] . '€ (' . $price['name'] . ')</div>';
                        }
                    }
                    else
                    {
                        $quant = 0;
                    }
                }
            }
        
                $html = $html . '</div>
                <div class="b3">
                    <div class="l1"></div>
                    <div class="l2">' . $info_reserva['total'] . '€ </div><div class="ticket_p">(';
        
                if($reav)
                {
                    $html = $html . translate("RÈGIM ESPECIAL DE LES AGÈNCIES DE VIATGE", $lang);                    
                }
                else
                {
//                    $html = $html . $iva_1 . '% ' . translate("IVA INCLÒS", $lang);
                    $html = $html . translate("IVA INCLÒS", $lang);
                }
        
                $html = $html . ')</div>
                </div>
            </div>
        </div></body></html>';

        echo $html;
        $htmld = ob_get_contents();
        ob_end_clean();
        $mpdf->WriteHTML($htmld);                
        
        return $mpdf;
    }

    function GeneratePDF3($info_reserva)
    {
        include_once '../plugins/mpdf/mpdf.php';
          
        global $mysqli;
        global $lang;
        global $admin_mail;
        global $admin_tel;
        global $lan_dir;
        global $iva_1;
        
        $celler = null;    
        
        // Calculo la caducitat
        $cad = $info_reserva["caducitat"]>0?$info_reserva["caducitat"]:6;
        $cad_str = "+" . $cad . " months";
        $edate = date('d-m-Y', strtotime($cad_str, strtotime($info_reserva["data"])));
        
        if($info_reserva['box_id']!=-1)
        {
            // Activitat existent
            
            $box = GetBox($mysqli,$info_reserva['box_id']);
            if($box['extra_fields']>0)
            {
                $celler = GetCeller($box['extra_fields']);
            }
            
            // Tipus d'esdeveniment
            $etype = intval($box['etype']); // 0: oberta / 1: programada
            
            // Tipus de reserva
            $rtype = intval($info_reserva['session_id']);   // -1: oberta (per defecte) / -2: programada manual                  
            $auxdata = date_create_from_format('Y-m-d H:i:s',$info_reserva["data_res"]);
            $rdate = date_format($auxdata,'d-m-Y H:i');                                    
                
            switch($etype)
            {
                case 1:
                    // No hi ha cap sessió assignada, passa a ser oberta
                    if($rtype==-1)
                    {
                        $etype = 0;
                    }
                    else if($rtype==-2)
                    {
                        $edate = $rdate;
                    }                    
                    else
                    {
                        $sdata = date_create_from_format('Y-m-d H:i:s',$info_reserva['data_session']);
                        $edate = date_format($sdata,'d-m-Y H:i');                        
                    }
                    break;
                
                default:
                    // Tot i ser amb data oberta, si se li ha assignat manualment una data
                    // passa a ser programada                    
                    if($rtype==-2)
                    {
                        $etype = 1;
                        $edate = $rdate;
                    }                    

                    break;
            }
            
            
            // decodifico els strings de modalitats
            $price_modalities = decode_price($box['price'],false);
            $quant_modalities = explode(';',$info_reserva['quantitat']);                        
            $ppts = explode(';',$box['persons_per_ticket']);
            
            $ptotal = 0;
            $i=0;
            foreach($quant_modalities as $quant)
            {
                $ppt = count($ppts)<=$i?1:$ppts[$i];
                $ptotal += (intval($quant) * $ppt);
                $i++;
            }
            
            if($info_reserva['quant_total']>0)
            {
                $ptotal = $info_reserva['quant_total'];
            }
            
            $box_name = $box['name'];
            $box_description = $box['description'];
            $box_details = $box['details'];
            $box_use = $box['use'];
        }
        else
        {
            // Activitat personalitzada
            
            // Tipus de reserva
            $rtype = $info_reserva['session_id'];   // -1: oberta (per defecte) / -2: programada manual                  
            $auxdata = date_create_from_format('Y-m-d H:i:s',$info_reserva["data_res"]);
            $rdate = date_format($auxdata,'d-m-Y H:i');
            
            // Tipus d'esdeveniment
            if($rtype==-1)
            {
                $etype = 0;
            }
            else if($rtype==-2)
            {
                // Programada manualment
                $etype = 1;
                $edate = $rdate;
            }
            else
            {
                // Sessió
                $etype = 1;
                $sdata = date_create_from_format('Y-m-d H:i:s',$info_reserva['data_session']);
                $edate = date_format($sdata,'d-m-Y H:i');
            }   
            
            $ptotal = $info_reserva['quant_total'];
            
            $box_name = $info_reserva['nom_exp'];
            $box_description = html_entity_decode(nl2br(htmlspecialchars(stripslashes($info_reserva['desc_exp']))));
            $box_details = $info_reserva['details'];
            $box_use = $info_reserva['use'];
        }  
        
        $sdata = date_create_from_format('Y-m-d',$info_reserva['data']);
        $cdata = date_format($sdata,'d-m-Y');
        
        // Fem el document PDF
        $mpdf=new mPDF();            
        $mpdf->SetAuthor("BTiquets");        
        $mpdf->SetDisplayMode('fullpage');
        
        ob_start();

        $html_css = '

        <html>
        <head>
        <link rel="stylesheet" type="text/css" href="/css/newstyle.css" media="all" />
        <style>
            body { 
                color:#000000;                 
                margin: 0 auto;
            }
            h2 {
                margin: 20px 0px 5px;
            }
            .pdf_header {
                font-size: 0;
                margin-bottom: 10px;
            }
            .pdf_info {                
                padding:10px;
                text-align:right;
                vertical-align: top;
                font-size:10px;
            }
            .pdf_info p {
                margin:0 ;
            }
            .pdf_info > h4 {
                font-size:12px;
                text-transform: uppercase;
            }
            .pdf_subheader {
                border-bottom: 2px solid #5e132b;
                padding-bottom: 10px;
            }
            .ticket_main {
                padding-top:0;
            }
            .ticket_main h1 {
                font-size: 30px;
                margin-bottom: 10px;
            }
            .ticket_main div.ticket_p {
                font-size: 12px;
            }
            div.ticket_description {
                font-size: 11px;
            }
            .ticket_main .ticket_options .b3 .l2 {
                font-size: 20px;
            }
            .ticket_options {
                width: auto;
                padding-left: 0px;
            }
            .ticket_main .ticket_options .b3 {
                border: none;
                padding: 0;
            }
            .ticket_pictures {
                padding-top:10px;
            }            
                
        </style>
        </head>';



        $html = $html_css . '<body>
        <table width="100%" class="pdf_header"><tr>
            <td width="20%"><img width="100" src="../img/pdf-3.jpg" alt="h1"></td>
            <td width="80%" class="pdf_info">
                <p>' . "# " . $info_reserva['id'] . '</p>
                <p>' . "La Brocada Serveis S.L." . '</p>
                <p>' . "NIF. B66405887" . '</p>
                <h4>' . translate('informació de contacte',$lang) . '</h4>
                <p>MAIL. ' . $admin_mail . '</p>
                <p>TEL. ' . $admin_tel . '</p>
            </td>
        </tr></table>
        <div class="ticket_main">            
            <h1>' . $box_name . '</h1>

            <h2>' . translate("Codi de la reserva", $lang) . '</h2>
            <div class="ticket_p">' . strtoupper($info_reserva['ref']) . '</div>';

            if($etype==0)
            {
                $html .= ('<h2>' . translate("Data de compra", $lang) . '</h2>
                <div class="ticket_p">' . $cdata . '</div>');
                          
                $html .= ('<h2>' . translate("Vigència de l'experiència", $lang) . '</h2>
                <div class="ticket_p">' . $edate . '</div>');
            }
            else
            {
                $html .= ('<h2>' . translate("Data de compra", $lang) . '</h2>
                <div class="ticket_p">' . $cdata . '</div>');
                          
                $html .= ('<h2>' . translate("Data de la reserva", $lang) . '</h2>
                <div class="ticket_p">' . $edate . '</div>');
            }
            
            $html .= ('<h2>' . translate("Dades de l'activitat", $lang) . '</h2>');

            if($celler==null)
            {
                $html = $html . '<div class="ticket_description">' . $box_description . '</div>';
            }
            else
            {
                $html = $html . '<div class="ticket_description">' . $celler['visita_desc'] . '</div>';
            }
        
            if($info_reserva['box_id']!=-1)
            {
                if($etype==0)
                {
                    if($box_details!="")
                    {
                        $html = $html . '<h2>' . translate("Disponibilitat", $lang) . '</h2>
                        <div class="ticket_description">' . $box_details . '</div>';
                    }

                    if($box_use!="")
                    {
                        $html .= ('<h2>' . translate("Reserva", $lang) . '</h2>
                        <div class="ticket_description">' . $box_use . '</div>');
                    }
                }
            }
            
            $html = $html . '</div>
        </div></body></html>';

        echo $html;
        $htmld = ob_get_contents();
        ob_end_clean();
        $mpdf->WriteHTML($htmld);                
        
        return $mpdf;
    }

    function GeneratePDF4($info_reserva)
    {
        //include_once '../plugins/mpdf/mpdf.php';
        require_once '../vendor/autoload.php';
                
        global $mysqli;
        global $lang;
        global $admin_mail;
        global $admin_tel;
        global $lan_dir;
        global $iva_1;               
        
        //$mpdf_2=new mPDF('', array(210,150),'','',15,15,16,16,0,0);
        //$mpdf_2=new mPDF('','A4','','',15,15,16,16,0,0);
        $mpdf_2 = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
        ]);
        ob_start();
        
        $pdfmodel='val_co_sfb.jpg'; 
        
        $html_css = '

        <html>
        <head>
        <style>
            body { 
                color:#000000;                 
                margin: 0 auto;
            }
            .pdf_xec {
                width: 100%;
                height: 100%;
                padding-top: 172px;
                padding-left: 200px;
                font-family: "arial";
                font-size: 12px;
                background-image: url("../img/' . $pdfmodel . ')";
                background-repeat: no-repeat;
                background-image-resize: 1;
                background-size: cover;
            }
                
        </style>
        </head>';
                
        $html = $html_css . '<body>
        
        <div class="pdf_xec">
            <div style="width: 595px;">
                <div style="font-size:30px;">' . $info_reserva['total'] . '€</div>
                <div style="padding-left:80px;padding-top: 40px;font-size:16px;">' . strtoupper($info_reserva['comentaris']) . '</div>
                <div style="padding-top: 18px;font-size:16px;">' . strtoupper($info_reserva['ref']) . '</div>
            </div>              
        </div>
        </body></html>';
 
        echo $html;
        $htmld = ob_get_contents();
        ob_end_clean();
        $mpdf_2->WriteHTML($htmld);        

        return $mpdf_2;
    }

    function GeneratePDF5($info_reserva,$num,$tiquets_reservats,$pvp,$date_str,$qrimgname)
    {
        //include_once '../plugins/mpdf/mpdf.php';
        require_once '../vendor/autoload.php';        
                
        global $mysqli;
        global $lang;
        global $admin_mail;
        global $admin_tel;
        global $lan_dir;
        global $iva_1;
        global $server;
        
        $box = GetBox($mysqli,$info_reserva['box_id']);
        $compte = GetAccountInfo($mysqli,$box['propietari']);
        
        $mpdf_2 = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
        ]);
        ob_start();
        
        $pdfmodel='dorsal_run_transequia2021.jpg'; 
        $qrurl = '/img/'.$qrimgname;
        
        // $html_css = '

        // <html>
        // <head>
        // <style>
        //     body { 
        //         color:#000000;                 
        //         margin: 0 auto;
        //     }
        //     .pdf_xec {
        //         width: 100%;
        //         height: 100%;
        //         padding-top: 100px;
        //         padding-left: 200px;
        //         font-family: "arial";
        //         font-size: 12px;
        //         background-image: url("../img/' . $pdfmodel . ')";
        //         background-repeat: no-repeat;
        //         background-image-resize: 1;
        //         background-size: 1962px 1374px;
        //         text-align: center;
        //     }
                
        // </style>
        // </head>';

        $html_css = '

        <html>
        <head>
        <style>
            body { 
                color:#000000;                 
                margin: 0 auto;
            }
            .pdf_xec {
                width: 100%;
                height: 100%;
                padding-top: 100px;
                font-family: "arial";
                font-size: 14px;
                text-align: center;
            }
                
        </style>
        </head>';
                
        $html = $html_css . '<body>
        
        <div class="pdf_xec">
            <img style="margin: 0 auto 30px" width="200" src= "https://btiquets.com/boxes/logo_image_' . $compte['id'] . '.png" alt="logo">
            <div style="text-align:center;background:#FFFFFF;border-radius:4px;padding:20px;width:1962px;">
                <h1 style="font-size: 24px;text-transform: uppercase;margin: 10px 0 10px 0">' . $info_reserva['ref'] . '</h1>
                <div style="font-size: 18px;"><b>' . $box['name'] . '</b></div>' . $date_str .
                '<div style="font-size: 16px;">' . $tiquets_reservats . '</div>
                <div style="font-size: 16px;">' . $pvp . '</div><br>
                <div style="font-size: 18px;"><b>' . $box['recordatori'] . '</div>
            </div>
            <div style="width:1962px;">
                <img src="' . $server . $qrurl . '">
            </div>
        </div>
        </body></html>';
 
        echo $html;
        $htmld = ob_get_contents();
        ob_end_clean();
        $mpdf_2->WriteHTML($htmld);        

        return $mpdf_2;
    }

    function GeneratePDF2($info_reserva, $bonustype=0)
    {
        include_once '../plugins/mpdf/mpdf.php';
                
        global $mysqli;
        global $lang;
        global $admin_mail;
        global $admin_tel;
        global $lan_dir;
        global $iva_1;
        
        $celler = null;                
        
        // Calculo la caducitat
        $cad = $info_reserva["caducitat"]>0?$info_reserva["caducitat"]:6;
        $cad_str = "+" . $cad . " months";
        $edate = date('d-m-Y', strtotime($cad_str, strtotime($info_reserva["data"])));
        
        if($info_reserva['box_id']!=-1)
        {
            // Activitat existent
            
            $box = GetBox($mysqli,$info_reserva['box_id']);
            if($box['extra_fields']>0)
            {
                $celler = GetCeller($box['extra_fields']);
            }
            
            // Tipus d'esdeveniment
            $etype = intval($box['etype']); // 0: oberta / 1: programada
            
            // Tipus de reserva
            $rtype = intval($info_reserva['session_id']);   // -1: oberta (per defecte) / -2: programada manual                  
            $auxdata = date_create_from_format('Y-m-d H:i:s',$info_reserva["data_res"]);
            $rdate = date_format($auxdata,'d-m-Y H:i');                        
                
            switch($etype)
            {
                case 1:
                    // No hi ha cap sessió assignada, passa a ser oberta
                    if($rtype==-1)
                    {
                        $etype = 0;
                    }
                    else if($rtype==-2)
                    {
                        $edate = $rdate;
                    }                    
                    else
                    {
                        $sdata = date_create_from_format('Y-m-d H:i:s',$info_reserva['data_session']);
                        $edate = date_format($sdata,'d-m-Y H:i');                        
                    }
                    break;
                
                default:
                    // Tot i ser amb data oberta, si se li ha assignat manualment una data
                    // passa a ser programada                    
                    if($rtype==-2)
                    {
                        $etype = 1;
                        $edate = $rdate;
                    }                    

                    break;
            }
            
            
            // decodifico els strings de modalitats
            $price_modalities = decode_price($box['price'],false);
            $quant_modalities = explode(';',$info_reserva['quantitat']);                        
            $ppts = explode(';',$box['persons_per_ticket']);
            
            $ptotal = 0;
            $i=0;
            foreach($quant_modalities as $quant)
            {
                $ppt = count($ppts)<=$i?1:$ppts[$i];
                $ptotal += (intval($quant) * $ppt);
                $i++;
            }
            
            if($info_reserva['quant_total']>0)
            {
                $ptotal = $info_reserva['quant_total'];
            }
            
            $box_name = $box['name'];
            if($info_reserva['text_regal']=="")
            {
                $box_description = $box['description'];
            }
            else
            {
                $box_description = preg_replace( "/\r|\n/", " ", $info_reserva['text_regal']);
            }
            $box_details = $box['details'];
            $box_use = $box['use'];
        }
        else
        {
            // Activitat personalitzada
            
            // Tipus de reserva
            $rtype = $info_reserva['session_id'];   // -1: oberta (per defecte) / -2: programada manual                  
            $auxdata = date_create_from_format('Y-m-d H:i:s',$info_reserva["data_res"]);
            $rdate = date_format($auxdata,'d-m-Y H:i');
            
            // Tipus d'esdeveniment
            if($rtype==-1)
            {
                $etype = 0;
            }
            else if($rtype==-2)
            {
                // Programada manualment
                $etype = 1;
                $edate = $rdate;
            }
            else
            {
                // Sessió
                $etype = 1;
                $sdata = date_create_from_format('Y-m-d H:i:s',$info_reserva['data_session']);
                $edate = date_format($sdata,'d-m-Y H:i');
            }   
            
            $ptotal = $info_reserva['quant_total'];            
            
            $box_name = $info_reserva['nom_exp'];
            if($info_reserva['text_regal']=="")
            {
                $box_description = $info_reserva['desc_exp'];
            }
            else
            {
                $box_description = preg_replace( "/\r|\n/", " ", $info_reserva['text_regal']);
            }
            $box_details = $info_reserva['details'];
            $box_use = $info_reserva['use'];
        }
        
        $perstr = intval($ptotal)>1 ? translate('persones',$lang) : translate('persona',$lang);
        
        $mpdf_2=new mPDF('', array(210,150),'','',15,15,16,16,0,0);
        ob_start();
        
        if($etype==0)  
        {
            if($bonustype==1)
            {
                $pdfmodel='pdf-5-bonus.jpg'; 
            }
            else
            {
                $pdfmodel='pdf-5.jpg'; 
            }
        }
        else
        {
            if($bonustype==1)
            {
                $pdfmodel='pdf-6-bonus.jpg'; 
            }
            else
            {
                $pdfmodel='pdf-6.jpg';
            }
        }
        
        $html_css = '

        <html>
        <head>
        <link rel="stylesheet" type="text/css" href="/css/newstyle.css" media="all" />
        <style>
            body { 
                color:#222222;                 
                margin: 0 auto;
            }
            .pdf_xec {
                width: 595px;
                height: 244px;
                padding-top: 34px;
                padding-left: 180px;
                font-family: "lora";
                font-size: 12px;
                background-image: url("../img/' . $lan_dir . $pdfmodel . '");
                background-size: 595px 244px;
                background-repeat: no-repeat;
                background-image-resize: 1;
            }
                
        </style>
        </head>';                
        
        if(strpos($box_description,"\n") !== false)
        {
            // Si hi ha un salt de línia, agafem fins allà
            $description_str = strtoupper(substr($box_description,0,strpos($box_description,"\n")-6));
        }
        else
        {
            // si no, ho agafem tot
            $description_str = strtoupper($box_description);
        }
        
        if (strlen($description_str) > 240)
        {
            // Si el text supera els 240 caràcters, el tallem a 240
            $description_str = substr($description_str, 0, 240);
        }
        else if(strlen($description_str) > 180 && strlen($description_str) < 240)
        {
            // Si està entre 180 i 240, res.
        }
        else
        {
            // si està per sota a 150, emplenem de * fins a 260
            $description_str = str_pad($description_str, 260," *");
        }
        

        if($box['qr_img']!="" && file_exists('../boxes/box_' . $info_reserva['box_id'] . '/' . $box['qr_img']))
            $qrimage = '../boxes/box_' . $info_reserva['box_id'] . '/' . $box['qr_img'];
        else
            $qrimage = '../img/qr_img_home.png';
                
        $html = $html_css . '<body>
        
        <div class="pdf_xec">
            <div style="width: 470px;">
                <div style="">' . strtoupper($box_name) . '</div>
                <div style="margin-top: 15px;font-size:10px;">' . $description_str . '</div>
            </div>
            <table style="margin-top: 23px;width: 470px;">
                <tr>
                    <td style="width: 32%;">' . strtoupper($info_reserva['ref']) . '</td>
                    <td style="width: 34%;">' . strtoupper($ptotal) . ' ' . $perstr . '</td>
                    <td style="width: 34%;">' . strtoupper($edate) . '</td>
                </tr>
            </table>
            <div style="margin-left: 388px;margin-top: 20px"><img width="80px" src="' . $qrimage . '" alt="QR"></div>                
        </div>
        </body></html>';
 
        echo $html;
        $htmld = ob_get_contents();
        ob_end_clean();
        $mpdf_2->WriteHTML($htmld);        

        return $mpdf_2;
    }

    function SendConfirmation($info_reserva)
    {
        include_once '../plugins/mpdf/mpdf.php';
        
        $mpdf = GeneratePDF1($info_reserva);
        $content = $mpdf->Output('', 'S');    
        $content = chunk_split(base64_encode($content));
        
        if($info_reserva['regal'])
        {
            $mpdf_2 = GeneratePDF2($info_reserva);        
            $content_2 = $mpdf_2->Output('', 'S');    
            $content_2 = chunk_split(base64_encode($content_2)); 
            
            $mpdf_3 = GeneratePDF3($info_reserva);        
            $content_3 = $mpdf_3->Output('', 'S');    
            $content_3 = chunk_split(base64_encode($content_3)); 
        }
        
        $mailto = $info_reserva['email'];
        $from_name = 'Reserves - BTiquets';
        $from_mail = 'btiquets@btiquets.com';
        $replyto = 'btiquets@btiquets.com';
        $uid = md5(uniqid(time()));
        $subject = translate("La teva reserva de BTiquets", $lang);
        $message = translate("Benvolgut/da", $lang) . ' ' . $info_reserva['nom'] . ".\r\n\r\n";
        $message .= translate("Gràcies per utilitzar btiquets.com. Imprimeix aquesta confirmació, segueix les instruccions de reserva i presenta-la el moment de realitzar l'experiència.", $lang);
        $filename = "BTiquets-" . strtoupper($info_reserva['ref']) . '.pdf';
        $filename_2 = "BTiquets-" . translate('xec-regal',$lang) . '-' . strtoupper($info_reserva['ref']) . '.pdf';
        $filename_3 = "BTiquets-" . translate('regal',$lang) . '-' . strtoupper($info_reserva['ref']) . '.pdf';
        
        $fmessage = "This is a multi-part message in MIME format.\r\n";
        $fmessage .= "--".$uid."\r\n";
        $fmessage .= "Content-type:text/plain; charset=utf-8\r\n";
        $fmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $fmessage .= $message."\r\n\r\n";
        $fmessage .= "--".$uid."\r\n";
        $fmessage .= "Content-Type: application/pdf; name=\"".$filename."\"\r\n";
        $fmessage .= "Content-Transfer-Encoding: base64\r\n";
        $fmessage .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
        $fmessage .= $content."\r\n\r\n";
        if($info_reserva['regal'])
        {
            $fmessage .= "--".$uid."\r\n";
            $fmessage .= "Content-Type: application/pdf; name=\"".$filename_2."\"\r\n";
            $fmessage .= "Content-Transfer-Encoding: base64\r\n";
            $fmessage .= "Content-Disposition: attachment; filename=\"".$filename_2."\"\r\n\r\n";
            $fmessage .= $content_2."\r\n\r\n";
            $fmessage .= "--".$uid."\r\n";
            $fmessage .= "Content-Type: application/pdf; name=\"".$filename_3."\"\r\n";
            $fmessage .= "Content-Transfer-Encoding: base64\r\n";
            $fmessage .= "Content-Disposition: attachment; filename=\"".$filename_3."\"\r\n\r\n";
            $fmessage .= $content_3."\r\n\r\n";
        }
        $fmessage .= "--".$uid."--";
        
        $header = "From: ".$from_name." <".$from_mail.">\r\n";
        $header .= "Reply-To: ".$replyto."\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
        
        return mail($mailto, $subject,$fmessage, $header);
    }

    function SendConfirmation2($mysqli,$info_reserva)
    {
        // NOTIFICACIÓ AL CLIENT DE LA SOL·LICITUD DE RESERVA RESTAURANT
        
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $lang;
        global $server;
        global $info_mail;
        
        $box = GetBox($mysqli,$info_reserva['box_id']);
        $compte = GetAccountInfo($mysqli,$box['propietari']);
        
        $email = $info_reserva['rmail'];
        $subject = translate("Sol·licitud de reserva enviada - BTiquets",$lang);
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: BTiquets <btiquets@btiquets.com>' . "\r\n";
        $mensaje = 
            '<html style="font-family:verdana">' . 
                '<body style="height:100%;background:#cccccc;color: #555555;padding: 30px 0;">' .
                    '<div style="margin:auto;width:560px;">' .
                        '<img style="margin: 0 auto 30px" width="100" src="http://btiquets.com/boxes/logo_image_' . $compte['id'] . '.png" alt="logo">' . 
                        '<div style="text-align:center;background:#FFFFFF;border-radius:4px;padding:20px;">' .
                            '<div style="font-size: 14px;">' . translate("Benvingut/da",$lang) . ' <b>' . $info_reserva['rnom'] . '</b>. ' . translate("Gràcies per utilitzar el servei de reserves de ",$lang) . $compte['nom'] . '</div>' .
                             '<h1 style="margin: 10px 0 20px 0";>' . translate("La teva sol·licitud ha estat enviada correctament",$lang) . '</h1>' .
                            '<div style="font-size: 14px;">' . translate("Recorda que la reserva no és vàlida fins que no rebis la corresponent confirmació de l'establiment. Si no rebeu la confirmació en les properes 2 hores, heu de considerar la reserva no atesa i, per tant, no vàlida",$lang) . '</div>' .
                            '<br>' .
                            '<br>' .
                            '<div style="font-size: 12px;">' . translate("Si has rebut aquest missatge per error, simplement elimina'l o posa't en contacte amb nosaltres.",$lang) . '</div>' .
                            '<div style="font-size: 12px;"><b>' . $info_mail . '</b></div>' .
                        '</div>' .
                        '<div style="margin-top:20px;background:#FFFFFF;border-radius:4px;padding:10px;">' .
                            '<div style="font-size: 12px;">' . translate("Estàs rebent aquesta comunicació perquè recentment has realitzat una reserva a través de BTiquets. L'ús d'aquest lloc constitueix l'acceptació de les nostres",$lang) . ' <a style="color:#cdb49a" href="' . $server . '/condicions">' . translate("Condicions d'ús",$lang) . '</a> ' . translate("i",$lang) . ' <a style="color:#cdb49a" href="' . $server . '/privacitat">' . translate("Política de privacitat",$lang) . '</a>. ' . translate("Tots els drets reservats.",$lang) . '</div>' .
                        '</div>' .
                    '</div>' . 
                '</body>' . 
            '</html>';

        @mail($email,$subject,$mensaje,$headers);
    }

    function SendConfirmation3($mysqli,$info_reserva)
    {
        // SOL·LICITUD AL RESTAURANT
        
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $lang;
        global $server;
        global $info_mail;
        
        $box = GetBox($mysqli,$info_reserva['box_id']);
        $compte = GetAccountInfo($mysqli,$box['propietari']);
        
        $sdata = date_create_from_format('Y-m-d H:i:s',$info_reserva['data_res']);
        $data_2 = date_format($sdata,'d-m-Y H:i'); 
//        $date_session = date_format($sdata,'d-m-Y');
//        $time_session = date_format($sdata,'H:i');
//        if($time_session=="00:00")
//        {
//            $data_2 = $date_session . " MIGDIA";
//        }
//        else
//        {
//            $data_2 = $date_session . " NIT";
//        }
        
        $email = $info_reserva['colmail'];
        $subject = translate("Sol·licitud de reserva - BTiquets",$lang);
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: BTiquets <btiquets@btiquets.com>' . "\r\n";
        $mensaje = 
            '<html style="font-family:verdana">' . 
                '<body style="height:100%;background:#cccccc;color: #555555;padding: 30px 0;">' .
                    '<div style="margin:auto;width:560px;">' .
                        '<img style="margin: 0 auto 30px" width="100" src="http://btiquets.com/boxes/logo_image_' . $compte['id'] . '.png" alt="logo">' . 
            
                        '<div style="font-size: 16px;background:#FFFFFF;border-radius:4px;padding:20px;">' .
                            '<div style="font-size: 14px;margin: 10px 0">' . translate("Estimat col·laborador, hem rebut una sol·licitud de reserva pel teu establiment amb les següents dades:",$lang) . '</div>' .
                            
                            '<div style="text-transform: uppercase;">CODI:' . $info_reserva['ref'] . '</div>' .
                            '<div style="">NOM: ' . $info_reserva['rnom'] . '</div>' .
                            '<div style="">MAIL: ' . $info_reserva['rmail'] . '</div>' .
                            '<div style="">TELÈFON: ' . $info_reserva['rtel'] . '</div>' .                            
                            '<div style="">COMENTARI: ' . $info_reserva['comentaris'] . '</div>' .
                            '<div style="">COMENSALS: ' . $info_reserva['quant_total'] . '</div>' .
                            '<div style="">DATA: ' . $data_2 . '</div>' .                        
            
                            '<div style="font-size:14px;margin: 10px 0 20px 0";>' . translate("Sisplau, respon a la sol·licitud de reserva",$lang) . '</div>' .                            
                            '<a style="margin-right:10px;width:50%;padding: 10px 20px;border-radius:4px;background: #555555;color: #FFFFFF;text-decoration:none;font-size: 14px;" href="' . $server . "admin-reserva/confirma/" . $info_reserva['ref'] . '">' . translate("Sí, accepto la reserva",$lang) . '</a>' .
                            '<a style="margin:10px;width:50%;padding: 10px 20px;border-radius:4px;background: #555555;color: #FFFFFF;text-decoration:none;font-size: 14px;" href="' . $server . "admin-reserva/denega/" . $info_reserva['ref'] . '">' . translate("No podem atendre la reserva",$lang) . '</a>' .
                        '</div>' .
                        '<div style="margin-top:20px;background:#FFFFFF;border-radius:4px;padding:10px;">' .
                            '<div style="font-size: 12px;">' . translate("Si has rebut aquest missatge per error, simplement elimina'l o posa't en contacte amb nosaltres.",$lang) . ' <b>' . $info_mail . '</b></div>' .
                        '</div>' .
                '</body>' . 
            '</html>';

        @mail($email,$subject,$mensaje,$headers);
    }

    function SendConfirmation4($mysqli,$info_reserva)
    {
        // RESPOSTA AL CLIENT - RESERVA ACCEPTADA
        
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $lang;
        global $server;
        global $info_mail;
        
        $box = GetBox($mysqli,$info_reserva['box_id']);
        $compte = GetAccountInfo($mysqli,$box['propietari']);
        
        $sdata = date_create_from_format('Y-m-d H:i:s',$info_reserva['data_res']);
        $data_2 = date_format($sdata,'d-m-Y H:i'); 
//        $date_session = date_format($sdata,'d-m-Y');
//        $time_session = date_format($sdata,'H:i');
//        if($time_session=="00:00")
//        {
//            $data_2 = $date_session . " MIGDIA";
//        }
//        else
//        {
//            $data_2 = $date_session . " NIT";
//        }
        
        $email = $info_reserva['rmail'];
        $subject = translate("Reserva acceptada - BTiquets",$lang);
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: BTiquets <btiquets@btiquets.com>' . "\r\n";
        $mensaje = 
            '<html style="font-family:verdana">' . 
                '<body style="height:100%;background:#cccccc;color: #555555;padding: 30px 0;">' .
                    '<div style="margin:auto;width:560px;">' .
                        '<img style="margin: 0 auto 30px" width="100" src="http://btiquets.com/boxes/logo_image_' . $compte['id'] . '.png" alt="logo">' . 
                        '<div style="text-align:center;background:#FFFFFF;border-radius:4px;padding:20px;">' .
                            '<div style="font-size: 14px;">' . translate("Benvingut/da",$lang) . ' <b>' . $info_reserva['rnom'] . '</b>. ' . translate("Gràcies per utilitzar el servei de reserves de ",$lang) . $compte['nom'] . '</div>' .
                             '<h1 style="margin: 10px 0 20px 0";>' . translate("La teva reserva ha estat acceptada",$lang) . '</h1>' .
                            '<div style="font-size: 14px;">' . translate("Aquestes són les dades de la reserva realitzada:",$lang) . '</div>' .
                            '<br>' .
                            '<div style="text-transform: uppercase;">CODI:' . $info_reserva['ref'] . '</div>' .
                            '<div style="">NOM: ' . $info_reserva['rnom'] . '</div>' .
                            '<div style="">MAIL: ' . $info_reserva['rmail'] . '</div>' .
                            '<div style="">TELÈFON: ' . $info_reserva['rtel'] . '</div>' .                            
                            '<div style="">COMENTARI: ' . $info_reserva['comentaris'] . '</div>' .
                            '<div style="">COMENSALS: ' . $info_reserva['quant_total'] . '</div>' .
                            '<div style="">DATA: ' . $data_2 . '</div>' .  
                            '<br>' .
                            '<br>' .
                            '<div style="font-size: 12px;">' . translate("Si has rebut aquest missatge per error, simplement elimina'l o posa't en contacte amb nosaltres.",$lang) . '</div>' .
                            '<div style="font-size: 12px;"><b>' . $info_mail . '</b></div>' .
                        '</div>' .
                        '<div style="margin-top:20px;background:#FFFFFF;border-radius:4px;padding:10px;">' .
                            '<div style="font-size: 12px;">' . translate("Estàs rebent aquesta comunicació perquè recentment has realitzat una reserva a través de BTiquets. L'ús d'aquest lloc constitueix l'acceptació de les nostres",$lang) . ' <a style="color:#cdb49a" href="' . $server . '/condicions">' . translate("Condicions d'ús",$lang) . '</a> ' . translate("i",$lang) . ' <a style="color:#cdb49a" href="' . $server . '/privacitat">' . translate("Política de privacitat",$lang) . '</a>. ' . translate("Tots els drets reservats.",$lang) . '</div>' .
                        '</div>' .
                    '</div>' . 
                '</body>' . 
            '</html>';

        @mail($email,$subject,$mensaje,$headers);
    }

    function SendConfirmation5($mysqli,$info_reserva)
    {
        // RESPOSTA AL CLIENT - RESERVA DENEGADA
        
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $lang;
        global $server;
        global $info_mail;
        
        $box = GetBox($mysqli,$info_reserva['box_id']);
        $compte = GetAccountInfo($mysqli,$box['propietari']);
        
        $email = $info_reserva['rmail'];
        $subject = translate("Reserva denegada - BTiquets",$lang);
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: BTiquets <btiquets@btiquets.com>' . "\r\n";
        $mensaje = 
            '<html style="font-family:verdana">' . 
                '<body style="height:100%;background:#cccccc;color: #555555;padding: 30px 0;">' .
                    '<div style="margin:auto;width:560px;">' .
                        '<img style="margin: 0 auto 30px" width="100" src="http://btiquets.com/boxes/logo_image_' . $compte['id'] . '.png" alt="logo">' . 
                        '<div style="text-align:center;background:#FFFFFF;border-radius:4px;padding:20px;">' .
                            '<div style="font-size: 14px;">' . translate("Benvingut/da",$lang) . ' <b>' . $info_reserva['rnom'] . '</b>. ' . translate("Gràcies per utilitzar el servei de reserves de ",$lang) . $compte['nom'] . '</div>' .
                             '<h1 style="margin: 10px 0 20px 0";>' . translate("La teva reserva ha estat denegada",$lang) . '</h1>' .
                            '<div style="font-size: 14px;">' . translate("L'establiment ha denegat al teva sol·licitud de reserva per falta de disponibilitat. Si vols conèixer altres opcions, posa't en contacte directament amb l'establiment",$lang) . '</div>' .
                            '<br>' .
                            '<div style="font-size: 12px;">' . translate("Si has rebut aquest missatge per error, simplement elimina'l o posa't en contacte amb nosaltres.",$lang) . '</div>' .
                            '<div style="font-size: 12px;"><b>' . $info_mail . '</b></div>' .
                        '</div>' .
                        '<div style="margin-top:20px;background:#FFFFFF;border-radius:4px;padding:10px;">' .
                            '<div style="font-size: 12px;">' . translate("Estàs rebent aquesta comunicació perquè recentment has realitzat una reserva a través de BTiquets. L'ús d'aquest lloc constitueix l'acceptació de les nostres",$lang) . ' <a style="color:#cdb49a" href="' . $server . '/condicions">' . translate("Condicions d'ús",$lang) . '</a> ' . translate("i",$lang) . ' <a style="color:#cdb49a" href="' . $server . '/privacitat">' . translate("Política de privacitat",$lang) . '</a>. ' . translate("Tots els drets reservats.",$lang) . '</div>' .
                        '</div>' .
                    '</div>' . 
                '</body>' . 
            '</html>';

        @mail($email,$subject,$mensaje,$headers);
    }

    function SendConfirmation6($mysqli,$info_reserva,$dmail="",$pdf=false)
    {
        // NOTIFICACIÓ AL CLIENT RESERVA CORRECTE
        
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        //use PHPMailer\PHPMailer\PHPMailer;
        require_once '../vendor/autoload.php';
        //include_once '../plugins/mpdf/mpdf.php';
        
        global $lang;
        global $server;
        global $info_mail;
        
        $box = GetBox($mysqli,$info_reserva['box_id']);
        $compte = GetAccountInfo($mysqli,$box['propietari']);
        $quant_modalities = decode_quant($info_reserva['quantitat']);
        $price_modalities = decode_price($box['price'],false);
        $total = 0;
        $pvp = "";
        $tiquets_reservats = "";
        
        
        if($pdf)
        {
            $mpdf = GeneratePDF4($info_reserva);
            $content = $mpdf->Output('', 'S');    
            $content = chunk_split(base64_encode($content));
            $filename = "BTiquets-" . strtoupper($info_reserva['ref']) . '.pdf';
        }
        
        if(sizeof($quant_modalities)==sizeof($price_modalities) && sizeof($price_modalities)>0)
        {
            for($i=0;$i<count($price_modalities);$i++)
            {
                $price = floatval($price_modalities[$i]['price']);
                if($quant_modalities[$i]!='undefined' && $quant_modalities[$i]!=null)
                {
                    $quant = intval($quant_modalities[$i]);

                    if($quant>0)
                    {
                        $str = $quant . ' x ' . $price_modalities[$i]['name'] . '</br>';
                        $tiquets_reservats .= $str;
                    }
                }
                else
                {
                    $quant = 0;
                }

                $subtotal = $quant*$price;
                $total += $subtotal;
            }
            if($total==0 && $info_reserva["total"]>0)
            {
                $pvp = "TOTAL = " . $info_reserva["total"] . "€";
            }
            else
            {
                $pvp = "TOTAL = " . $total . "€";
            }
        }   
        else if($info_reserva["total"]>0)
        {
            $pvp = "TOTAL = " . $info_reserva["total"] . "€";
        }
        
        $date_str = "";
        if($box["etype"]!=4 && $box["etype"]!=5)
        {
            if($info_reserva['data_session']!="0000-00-00 00:00:00")
            {
                if($info_reserva['session_name']!="")
                {
                    $sdata = date_create_from_format('Y-m-d H:i:s',$info_reserva['data_session']);
                    $edate = date_format($sdata,'d-m-Y');  
                    $date_str = '<div style="font-size: 16px;"><b>' . $edate . " - " . $info_reserva['session_name'] . '</b></div>';
                }
                else
                {
                    $sdata = date_create_from_format('Y-m-d H:i:s',$info_reserva['data_session']);
                    $edate = date_format($sdata,'d-m-Y H:i');  
                    $date_str = '<div style="font-size: 16px;"><b>' . $edate . '</b></div>'; 
                }
            }
        }
        
        if($dmail!="")
        {
            $email = $dmail;
        }
        else
        {
            $email = $info_reserva['rmail'];
        }
        
        error_log("mail to: ".$email);        
    
        $subject = "BTiquets - " . translate("Confirmació",$lang);
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $uid = md5(uniqid(time()));        
        //$headers .= 'From: ' . $compte['nom'] . ' <' . $compte['mail'] . '>' . "\r\n";
        $headers .= 'From: BTiquets <btiquets@btiquets.com>' . "\r\n";
        if($pdf)
        {
            $headers .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
        }
        else
        {
            $headers .= "X-Priority: 3\r\n";
            $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        }
        
        switch($box["etype"])
        {
            case 4:
                $str1 = translate("Gràcies per utilitzar el servei de compra online de ",$lang);
                $str2 = translate("El codi de la teva compra és: ",$lang);
                $str3 = translate("Aquest codi és l'identificador únic de la comanda.",$lang);
                break;
            
            case 5:
                $str1 = translate("Gràcies per utilitzar el servei de compra online de ",$lang);
                $str2 = translate("El codi de la teva compra és: ",$lang);
                $str3 = translate("Aquest codi és l'identificador únic de la comanda.",$lang);
                break;            
            
            default:
                $str1 = translate("Gràcies per utilitzar el servei de reserves de ",$lang);
                $str2 = translate("El codi de la teva reserva és: ",$lang);
                $str3 = translate("Aquest codi és l'identificador vàlid per a dur a terme l'activitat contractada.",$lang);
                break;
        }
        
        $mensaje = 
            '<html style="font-family:verdana">' . 
                '<body style="height:100%;background:#FFFFFF;color: #555555;padding: 30px 0;">' .
                    '<div style="margin:auto;width:560px;">' .
                        '<img style="margin: 0 auto 30px" width="100" src="http://btiquets.com/boxes/logo_image_' . $compte['id'] . '.png" alt="logo">' . 
                        '<div style="text-align:center;background:#FFFFFF;border-radius:4px;padding:20px;">' .
                            '<div style="font-size: 16px;">' . translate("Benvingut/da",$lang) . ' <b>' . $info_reserva['rnom'] . '</b>. ' . $str1 . $compte['nom'] . '</div>' .
                            '<h1 style="margin: 10px 0 10px 0";>' . $str2 . '</h1>' .
                            '<h1 style="font-size: 24px;text-transform: uppercase;margin: 10px 0 10px 0">' . $info_reserva['ref'] . '</h1>' .
                            '<div style="font-size: 18px;"><b>' . $box['name'] . '</b></div>' .
                            $date_str .
                            '<div style="font-size: 16px;">' . $tiquets_reservats . '</div>' .
                            '<div style="font-size: 16px;">' . $pvp . '</div><br>' .
                            '<div style="font-size: 18px;"><b>' . $box['recordatori'] . '</div>' .
                            '<div style="font-size: 14px;margin-top:20px;">' . $str3 . '</div>' .
                            '<div style="font-size: 12px;margin-top:50px;">' . translate("Si has rebut aquest missatge per error, simplement elimina’l o posa't en contacte amb nosaltres.",$lang) . ' <b>' . $compte['mail'] . '</b></div>' .
                        '</div>' .
                        '<div style="font-size: 12px;text-align:justify;padding:10px;margin:20px 0;background:#FFFFFF;border-radius:4px;">' .
                            '<div style="">' . translate("Estàs rebent aquesta comunicació perquè recentment has realitzat una reserva o compra a través de la central de reserves operada per ",$lang) . $compte['nom'] . translate(". L'ús d'aquest lloc constitueix l'acceptació de les nostres",$lang) . ' <a style="color:#888888" href="http://btiquets.com/condicions">' . translate("Condicions d'ús",$lang) . '</a> ' . translate("i",$lang) . ' <a style="color:#888888" href="http://btiquets.com/lopd/' . $compte['id'] .' ">' . translate("Política de privacitat",$lang) . '</a>. ' . translate("Tots els drets reservats.",$lang) . '</div>' .
                        '</div>' .
                    '</div>' . 
                '</body>' . 
            '</html>';
        
        
        if($pdf)
        {
//            $fmessage = "This is a multi-part message in MIME format.\r\n";
//            $fmessage .= "--".$uid."\r\n";
//            $fmessage .= "Content-type: text/html; charset=utf-8\r\n";
//            $fmessage .= $mensaje."\r\n\r\n";
//            $fmessage .= "--".$uid."\r\n";
//            $fmessage .= "Content-Type: application/pdf; name=\"".$filename."\"\r\n";
//            $fmessage .= "Content-Transfer-Encoding: base64\r\n";
//            $fmessage .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
//            $fmessage .= $content."\r\n\r\n";
//            $fmessage .= "--".$uid."--";
            
            $mailto = $info_reserva['rmail'];
            $from_name = 'Reserves - BTiquets';
            $from_mail = 'btiquets@btiquets.com';
            $replyto = 'btiquets@btiquets.com';
            $uid = md5(uniqid(time()));
            $subject = translate("La teva reserva de BTiquets", $lang);
            $message = translate("Benvolgut/da", $lang) . ' ' . $info_reserva['rnom'] . ".\r\n\r\n";
            $message .= $str1;
            $filename = "BTiquets-" . strtoupper($info_reserva['ref']) . '.pdf';

            $fmessage = "This is a multi-part message in MIME format.\r\n";
            $fmessage .= "--".$uid."\r\n";
            $fmessage .= "Content-type:text/html; charset=utf-8\r\n";
            $fmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
            $fmessage .= $mensaje."\r\n\r\n";
            $fmessage .= "--".$uid."\r\n";
            $fmessage .= "Content-Type: application/pdf; name=\"".$filename."\"\r\n";
            $fmessage .= "Content-Transfer-Encoding: base64\r\n";
            $fmessage .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
            $fmessage .= $content."\r\n\r\n";
            $fmessage .= "--".$uid."--";

            $header = "From: ".$from_name." <".$from_mail.">\r\n";
            $header .= "Reply-To: ".$replyto."\r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";

            return mail($mailto, $subject,$fmessage, $header);
        }
        else
        {
            $fmessage = $mensaje;
        }
        
//        $email = new PHPMailer(TRUE);
//        $mail->setFrom($from_mail);
//        $mail->addAddress($mailto);
//        $mail->Subject = $subject;
//        $mail->isHTML(TRUE);
//        $mail->addAttachment($filename,"Xec");
//        $mail->Body = $mensaje;
//
//        if (!$mail->send())
//        {
//            error_log($mail->ErrorInfo);
//        }
        
//        return 1;

        return @mail($email,$subject,$fmessage,$headers);
    }

    function SendConfirmation6_sp1($mysqli,$info_reserva,$dmail="",$pdf=false)
    {
        // NOTIFICACIÓ AL CLIENT RESERVA CORRECTE
        // TRANSÈQUIA
        
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        //use PHPMailer\PHPMailer\PHPMailer;
        require_once '../vendor/autoload.php';
        //include_once '../plugins/mpdf/mpdf.php';
        
        global $lang;
        global $server;
        global $info_mail;
        
        $box = GetBox($mysqli,$info_reserva['box_id']);
        $compte = GetAccountInfo($mysqli,$box['propietari']);
        $quant_modalities = decode_quant($info_reserva['quantitat']);
        $price_modalities = decode_price($box['price'],false);
        $total = 0;
        $pvp = "";
        $tiquets_reservats = "";
        
        
        if($pdf)
        {
            $mpdf = GeneratePDF4($info_reserva);
            $content = $mpdf->Output('', 'S');    
            $content = chunk_split(base64_encode($content));
            $filename = "BTiquets-" . strtoupper($info_reserva['ref']) . '.pdf';
        }
        
        if(sizeof($quant_modalities)==sizeof($price_modalities) && sizeof($price_modalities)>0)
        {
            for($i=0;$i<count($price_modalities);$i++)
            {
                $price = floatval($price_modalities[$i]['price']);
                if($quant_modalities[$i]!='undefined' && $quant_modalities[$i]!=null)
                {
                    $quant = intval($quant_modalities[$i]);

                    if($quant>0)
                    {
                        $str = $quant . ' x ' . $price_modalities[$i]['name'] . '</br>';
                        $tiquets_reservats .= $str;
                    }
                }
                else
                {
                    $quant = 0;
                }

                $subtotal = $quant*$price;
                $total += $subtotal;
            }
            if($total==0 && $info_reserva["total"]>0)
            {
                $pvp = "TOTAL = " . $info_reserva["total"] . "€";
            }
            else
            {
                $pvp = "TOTAL = " . $total . "€";
            }
        }   
        else if($info_reserva["total"]>0)
        {
            $pvp = "TOTAL = " . $info_reserva["total"] . "€";
        }
        
        $date_str = "";
        if($box["etype"]!=4 && $box["etype"]!=5)
        {
            if($info_reserva['data_session']!="0000-00-00 00:00:00")
            {
                if($info_reserva['session_name']!="")
                {
                    $date_str = '<div style="font-size: 16px;"><b>' . $info_reserva['session_name'] . '</b></div>'; 
                }
                else
                {
                    $sdata = date_create_from_format('Y-m-d H:i:s',$info_reserva['data_session']);
                    $edate = date_format($sdata,'d-m-Y H:i');  
                    $date_str = '<div style="font-size: 16px;"><b>' . $edate . '</b></div>'; 
                }
            }
        }
        
        if($dmail!="")
        {
            $email = $dmail;
        }
        else
        {
            $email = $info_reserva['rmail'];
        }
        
        error_log("mail to: ".$email);
        
    
        $subject = "BTiquets - " . translate("Confirmació",$lang);
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $uid = md5(uniqid(time()));        
        //$headers .= 'From: ' . $compte['nom'] . ' <' . $compte['mail'] . '>' . "\r\n";
        $headers .= 'From: BTiquets <btiquets@btiquets.com>' . "\r\n";
        if($pdf)
        {
            $headers .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
        }
        else
        {
            $headers .= "X-Priority: 3\r\n";
            $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        }
        
        switch($box["etype"])
        {
            case 4:
                $str1 = translate("Gràcies per utilitzar el servei de compra online de ",$lang);
                $str2 = translate("El codi de la teva compra és: ",$lang);
                $str3 = translate("Aquest codi és l'identificador únic de la comanda.",$lang);
                break;
            
            case 5:
                $str1 = translate("Gràcies per utilitzar el servei de compra online de ",$lang);
                $str2 = translate("El codi de la teva compra és: ",$lang);
                $str3 = translate("Aquest codi és l'identificador únic de la comanda.",$lang);
                break;            
            
            default:
                $str1 = translate("Gràcies per utilitzar el servei de reserves de ",$lang);
                $str2 = translate("El codi de la teva reserva és: ",$lang);
                $str3 = translate("Aquest codi és l'identificador vàlid per a dur a terme l'activitat contractada.",$lang);
                break;
        }
        
        $mensaje = 
            '<html style="font-family:verdana">' . 
                '<body style="height:100%;background:#FFFFFF;color: #555555;padding: 30px 0;">' .
                    '<div style="margin:auto;width:560px;">' .
                        '<img style="margin: 0 auto 30px" width="200" src="http://btiquets.com/boxes/logo_image_' . $compte['id'] . '.png" alt="logo">' . 
                        '<div style="text-align:center;background:#FFFFFF;border-radius:4px;padding:20px;">' .
                            '<div style="font-size: 16px;">' . translate("Benvingut/da",$lang) . ' <b>' . $info_reserva['rnom'] . '</b>. ' . $str1 . $compte['nom'] . '</div>' .
                            '<h1 style="margin: 10px 0 10px 0";>' . $str2 . '</h1>' .
                            '<h1 style="font-size: 24px;text-transform: uppercase;margin: 10px 0 10px 0">' . $info_reserva['ref'] . '</h1>' .
                            '<div style="font-size: 18px;"><b>' . $box['name'] . '</b></div>' .
                            $date_str .
                            '<div style="font-size: 16px;">' . $tiquets_reservats . '</div>' .
                            '<div style="font-size: 16px;">' . $pvp . '</div><br>' .
                            '<div style="font-size: 18px;"><b>' . $box['recordatori'] . '</div>' .
                            '<div style="font-size: 14px;margin-top:20px;">' . $str3 . '</div>' .
                            '<div style="font-size: 12px;margin-top:50px;">' . translate("Si has rebut aquest missatge per error, simplement elimina’l o posa't en contacte amb nosaltres.",$lang) . ' <b>' . $compte['mail'] . '</b></div>' .
                        '</div>' .
                        '<div style="font-size: 12px;text-align:justify;padding:10px;margin:20px 0;background:#FFFFFF;border-radius:4px;">' .
                            '<div style="">' . translate("Estàs rebent aquesta comunicació perquè recentment has realitzat una compra a través de la web comercobert.santfruitos.cat amb el sistema de venda online BTiquets",$lang) . translate(". L'ús d'aquest lloc constitueix l'acceptació de les nostres",$lang) . ' <a style="color:#888888" href="http://btiquets.com/condicions">' . translate("Condicions d'ús",$lang) . '</a> ' . translate("i",$lang) . ' <a style="color:#888888" href="http://btiquets.com/lopd/' . $compte['id'] .' ">' . translate("Política de privacitat",$lang) . '</a>. ' . translate("Tots els drets reservats.",$lang) . '</div>' .
                        '</div>' .
                    '</div>' . 
                '</body>' . 
            '</html>';
        
        
        if($pdf)
        {
            $mailto = $info_reserva['rmail'];
            $from_name = 'Reserves - BTiquets';
            $from_mail = 'btiquets@btiquets.com';
            $replyto = 'btiquets@btiquets.com';
            $uid = md5(uniqid(time()));
            $subject = translate("Confirmació de compra del ", $lang) . $box['name'];
            $message = translate("Benvolgut/da", $lang) . ' ' . $info_reserva['rnom'] . ".\r\n\r\n";
            $message .= $str1;
            $filename = "BTiquets-" . strtoupper($info_reserva['ref']) . '.pdf';

            $fmessage = "This is a multi-part message in MIME format.\r\n";
            $fmessage .= "--".$uid."\r\n";
            $fmessage .= "Content-type:text/html; charset=utf-8\r\n";
            $fmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
            $fmessage .= $mensaje."\r\n\r\n";
            $fmessage .= "--".$uid."\r\n";
            $fmessage .= "Content-Type: application/pdf; name=\"".$filename."\"\r\n";
            $fmessage .= "Content-Transfer-Encoding: base64\r\n";
            $fmessage .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
            $fmessage .= $content."\r\n\r\n";
            $fmessage .= "--".$uid."--";

            $header = "From: ".$from_name." <".$from_mail.">\r\n";
            $header .= "Reply-To: ".$replyto."\r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";

            return mail($mailto, $subject,$fmessage, $header);
        }
        else
        {
            $fmessage = $mensaje;
        }
        
//        $email = new PHPMailer(TRUE);
//        $mail->setFrom($from_mail);
//        $mail->addAddress($mailto);
//        $mail->Subject = $subject;
//        $mail->isHTML(TRUE);
//        $mail->addAttachment($filename,"Xec");
//        $mail->Body = $mensaje;
//
//        if (!$mail->send())
//        {
//            error_log($mail->ErrorInfo);
//        }
        
//        return 1;

        return @mail($email,$subject,$fmessage,$headers);
    }

    function SendConfirmation6_sp2($mysqli,$info_reserva,$dmail="",$pdf=false)
    {
        // NOTIFICACIÓ AL CLIENT RESERVA CORRECTE
        
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        //use PHPMailer\PHPMailer\PHPMailer;
        require_once '../vendor/autoload.php';
        include_once "qrbarcode.php"; 
        
        global $lang;
        global $server;
        global $info_mail;
        
        $box = GetBox($mysqli,$info_reserva['box_id']);
        $compte = GetAccountInfo($mysqli,$box['propietari']);
        $quant_modalities = decode_quant($info_reserva['quantitat']);
        $price_modalities = decode_price($box['price'],false);
        $total = 0;
        $qtotal = 0;
        $pvp = "";
        $tiquets_reservats = "";        
        
        if($box["etype"]==7)
        {
            $pvp = "IMPORT = " . $info_reserva["total"] . "€";
            $qtotal = 1;
        }
        else
        {
            if(sizeof($quant_modalities)==sizeof($price_modalities) && sizeof($price_modalities)>0)
            {
                for($i=0;$i<count($price_modalities);$i++)
                {
                    $price = floatval($price_modalities[$i]['price']);
                    if($quant_modalities[$i]!='undefined' && $quant_modalities[$i]!=null)
                    {
                        $quant = intval($quant_modalities[$i]);

                        if($quant>0)
                        {
                            $str = $quant . ' x ' . $price_modalities[$i]['name'] . '</br>';
                            $tiquets_reservats .= $str;
                        }
                    }
                    else
                    {
                        $quant = 0;
                    }

                    $subtotal = $quant*$price;
                    $total += $subtotal;
                    $qtotal += $quant;
                }
                if($total==0 && $info_reserva["total"]>0)
                {
                    $pvp = "TOTAL = " . $info_reserva["total"] . "€";
                }
                else
                {
                    $pvp = "TOTAL = " . $total . "€";
                }
            }   
            else if($info_reserva["total"]>0)
            {
                $pvp = "TOTAL = " . $info_reserva["total"] . "€";
            }
        }
        
        $date_str = "";
        if($box["etype"]!=4 && $box["etype"]!=5 && $box["etype"]!=7)
        {
            if($info_reserva['data_session']!="0000-00-00 00:00:00")
            {
                if($info_reserva['session_name']!="")
                {
                    $sdata = date_create_from_format('Y-m-d H:i:s',$info_reserva['data_session']);
                    $edate = date_format($sdata,'d-m-Y');  
                    $date_str = '<div style="font-size: 16px;"><b>' . $edate . " - " . $info_reserva['session_name'] . '</b></div>';
                }
                else
                {
                    $sdata = date_create_from_format('Y-m-d H:i:s',$info_reserva['data_session']);
                    $edate = date_format($sdata,'d-m-Y H:i');  
                    $date_str = '<div style="font-size: 16px;"><b>' . $edate . '</b></div>'; 
                }
            }
        }
        
        if($dmail!="")
        {
            $email = $dmail;
        }
        else
        {
            $email = $info_reserva['rmail'];
        }
        
        error_log("mail to: ".$email);

        $qr = new QRBarCode(); 
        $qr->text('btiquets.com/check/'.$info_reserva['ref']); 
        $qrimgname = 'qrimg_'.$info_reserva['ref'].'.png';
        $qr->qrCode(200,'./../img/'.$qrimgname);
        
        $content = array();
        $filename = array();
        if($pdf)
        {
            $mpdf = GeneratePDF5($info_reserva,0,$tiquets_reservats,$pvp,$date_str,$qrimgname);
            $content_aux = $mpdf->Output('', 'S');    
            $content[] = chunk_split(base64_encode($content_aux));
            $filename[] = "BTiquets-" . strtoupper($info_reserva['ref']) . '.pdf';

            // Primer he de determinar el nombre
            // $comptador = GetComptador($mysqli,348);
            // for($i=1; $i<=$qtotal;$i++)
            // {
            //     $mpdf = GeneratePDF5($info_reserva,$comptador,$tiquets_reservats,$pvp,$date_str);
            //     $content_aux = $mpdf->Output('', 'S');    
            //     $content[] = chunk_split(base64_encode($content_aux));
            //     $filename[] = "BTiquets-" . strtoupper($info_reserva['ref']) . '_' . $comptador . '.pdf';
            //     $comptador++;
            // }
            // SetComptador($mysqli,348,$comptador);
        }        
    
        $subject = "BTiquets - " . translate("Confirmació",$lang);
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $uid = md5(uniqid(time()));        
        //$headers .= 'From: ' . $compte['nom'] . ' <' . $compte['mail'] . '>' . "\r\n";
        $headers .= 'From: BTiquets <btiquets@btiquets.com>' . "\r\n";
        if($pdf)
        {
            $headers .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
        }
        else
        {
            $headers .= "X-Priority: 3\r\n";
            $headers .= "X-Mailer: PHP";
            $headers .= phpversion();
            $headers .= "\r\n" ;
            $headers .= 'Content-type: text/html; charset=utf-8\r\n';
        }
        
        switch($box["etype"])
        {
            case 4:
                $str1 = translate("Gràcies per utilitzar el servei de compra online de ",$lang);
                $str2 = translate("El codi de la teva compra és: ",$lang);
                $str3 = translate("Aquest codi és l'identificador únic de la comanda.",$lang);
                break;
            
            case 5:
                $str1 = translate("Gràcies per utilitzar el servei de compra online de ",$lang);
                $str2 = translate("El codi de la teva compra és: ",$lang);
                $str3 = translate("Aquest codi és l'identificador únic de la comanda.",$lang);
                break; 
            
            case 7:
                $str1 = translate("Gràcies per utilitzar el servei de compra online de ",$lang);
                $str2 = translate("El codi de la teva compra és: ",$lang);
                $str3 = translate("Aquest codi és l'identificador únic de la comanda.",$lang);
                break; 
            
            default:
                $str1 = translate("Gràcies per utilitzar el servei de reserves de ",$lang);
                $str2 = translate("El codi de la teva reserva és: ",$lang);
                $str3 = translate("Aquest codi és l'identificador vàlid per a dur a terme l'activitat contractada.",$lang);
                break;
        }
        
        $mensaje = 
            '<html style="font-family:verdana">' . 
                '<body style="height:100%;background:#FFFFFF;color: #555555;padding: 30px 0;">' .
                    '<div style="margin:auto;width:560px;">' .
                        '<img style="margin: 0 auto 30px" width="200" src="https://btiquets.com/boxes/logo_image_' . $compte['id'] . '.png" alt="logo">' . 
                        '<div style="text-align:center;background:#FFFFFF;border-radius:4px;padding:20px;">' .
                            '<div style="font-size: 16px;">' . translate("Benvingut/da",$lang) . ' <b>' . $info_reserva['rnom'] . '</b>. ' . $str1 . $compte['nom'] . '</div>' .
                            '<h1 style="margin: 10px 0 10px 0";>' . $str2 . '</h1>' .
                            '<h1 style="font-size: 24px;text-transform: uppercase;margin: 10px 0 10px 0">' . $info_reserva['ref'] . '</h1>' .
                            '<div style="font-size: 18px;"><b>' . $box['name'] . '</b></div>' .
                            $date_str .
                            '<div style="font-size: 16px;">' . $tiquets_reservats . '</div>' .
                            '<div style="font-size: 16px;">' . $pvp . '</div><br>' .
                            '<div style="font-size: 18px;"><b>' . $box['recordatori'] . '</div>' .
                            '<div style="font-size: 14px;margin-top:20px;">' . $str3 . '</div>' .
                            '<img style="margin: 20px auto 20px" width="200" src="https://btiquets.com/img/' . $qrimgname . '" alt="codi qr">' . 
                            '<div style="font-size: 12px;margin-top:50px;">' . translate("Si has rebut aquest missatge per error, simplement elimina'l o posa't en contacte amb nosaltres.",$lang) . ' <b>' . $compte['mail'] . '</b></div>' .
                        '</div>' .
                        '<div style="font-size: 12px;text-align:justify;padding:10px;margin:20px 0;background:#FFFFFF;border-radius:4px;">' .
                            '<div style="">' . translate("Estàs rebent aquesta comunicació perquè recentment has realitzat una compra a través de la web comercobert.santfruitos.cat amb el sistema de venda online BTiquets",$lang) . translate(". L'ús d'aquest lloc constitueix l'acceptació de les nostres",$lang) . ' <a style="color:#888888" href="http://btiquets.com/condicions">' . translate("Condicions d'ús",$lang) . '</a> ' . translate("i",$lang) . ' <a style="color:#888888" href="http://btiquets.com/lopd/' . $compte['id'] .' ">' . translate("Política de privacitat",$lang) . '</a>. ' . translate("Tots els drets reservats.",$lang) . '</div>' .
                        '</div>' .
                    '</div>' . 
                '</body>' . 
            '</html>';
        
        
        if($pdf)
        {
            $mailto = $info_reserva['rmail'];
            $from_name = 'Reserves - BTiquets';
            $from_mail = 'btiquets@btiquets.com';
            $replyto = 'btiquets@btiquets.com';
            $uid = md5(uniqid(time()));
            $subject = translate("Confirmació de compra del ", $lang) . $box['name'];
            $message = translate("Benvolgut/da", $lang) . ' ' . $info_reserva['rnom'] . ".\r\n\r\n";
            $message .= $str1;

            $fmessage = "This is a multi-part message in MIME format.\r\n";
            $fmessage .= "--".$uid."\r\n";
            $fmessage .= "Content-type:text/html; charset=utf-8\r\n";
            $fmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
            $fmessage .= $mensaje."\r\n\r\n";
            $fmessage .= "--".$uid."\r\n";
            
            // for($i=0; $i<$qtotal;$i++)
            // {
            //     $fmessage .= "Content-Type: application/pdf; name=\"".$filename[$i]."\"\r\n";
            //     $fmessage .= "Content-Transfer-Encoding: base64\r\n";
            //     $fmessage .= "Content-Disposition: attachment; filename=\"".$filename[$i]."\"\r\n\r\n";
            //     $fmessage .= $content[$i]."\r\n\r\n";
            //     $fmessage .= "--".$uid."\r\n";
            // }

            $fmessage .= "Content-Type: application/pdf; name=\"".$filename[0]."\"\r\n";
            $fmessage .= "Content-Transfer-Encoding: base64\r\n";
            $fmessage .= "Content-Disposition: attachment; filename=\"".$filename[0]."\"\r\n\r\n";
            $fmessage .= $content[0]."\r\n\r\n";
            $fmessage .= "--".$uid."\r\n";

            $header = "From: ".$from_name." <".$from_mail.">\r\n";
            $header .= "Reply-To: ".$replyto."\r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";

            return mail($mailto, $subject,$fmessage, $header);
        }
        else
        {
            $fmessage = $mensaje;
        }

        return @mail($email,$subject,$fmessage,$headers);
    }

    function SendConfirmation7($mysqli,$info_reserva)
    {
        // NOTIFICACIÓ A L'OPERADOR RESERVA CORRECTE
        
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $lang;
        global $server;
        global $info_mail;
        
        $box = GetBox($mysqli,$info_reserva['box_id']);
        $compte = GetAccountInfo($mysqli,$box['propietari']);
        $quant_modalities = decode_quant($info_reserva['quantitat']);
        $price_modalities = decode_price($box['price'],false);        
        $total = 0;
        $pvp = "";
        $tiquets_reservats = "";
          
        if($box["etype"]==7)
        {
            $pvp = "IMPORT = " . $info_reserva["total"] . "€";
        }
        else
        {
            if(sizeof($quant_modalities)==sizeof($price_modalities) && sizeof($price_modalities)>0)
            {
                for($i=0;$i<count($price_modalities);$i++)
                {
                    $price = floatval($price_modalities[$i]['price']);
                    if($quant_modalities[$i]!='undefined' && $quant_modalities[$i]!=null)
                    {
                        $quant = intval($quant_modalities[$i]);

                        if($quant>0)
                        {
                            $str = $quant . ' x ' . $price_modalities[$i]['name'] . '</br>';
                            $tiquets_reservats .= $str;
                        }
                    }
                    else
                    {
                        $quant = 0;
                    }

                    $subtotal = $quant*$price;
                    $total += $subtotal;
                }
                if($total==0 && $info_reserva["total"]>0)
                {
                    $pvp = "TOTAL = " . $info_reserva["total"] . "€";
                }
                else
                {
                    $pvp = "TOTAL = " . $total . "€";
                }
            }   
            else if($info_reserva["total"]>0)
            {
                $pvp = "TOTAL = " . $info_reserva["total"] . "€";
            }
        }
        
        $date_str = "";
        if($box["etype"]!=4 && $box["etype"]!=5 && $box["etype"]!=7)
        {
            if($info_reserva['data_session']!="0000-00-00 00:00:00")
            {
                if($info_reserva['session_name']!="")
                {
                    $sdata = date_create_from_format('Y-m-d H:i:s',$info_reserva['data_session']);
                    $edate = date_format($sdata,'d-m-Y');  
                    $date_str = '<div style="font-size: 16px;"><b>' . $edate . " - " . $info_reserva['session_name'] . '</b></div>';
                }
                else
                {
                    $sdata = date_create_from_format('Y-m-d H:i:s',$info_reserva['data_session']);
                    $edate = date_format($sdata,'d-m-Y H:i');  
                    $date_str = '<div style="font-size: 16px;"><b>' . $edate . '</b></div>';
                }
            }
        }
        
        $productes = "";
        if($box["etype"]==5)
        {
            $producte_list = GetProductefromList($mysqli,$box["productes"]);
            foreach($producte_list as $producte)
            {
                foreach($producte['modalitat'] as $prod_item)
                {
                    $carret = decode_carret($info_reserva['quantitat'],$producte['id'],$prod_item['id']);
                    $quant = intval($carret[0]['quant']);
                    if($quant>0)
                    {
                        $producte_line = $quant . " x " . $producte['name'] . ' - ' . $prod_item['nom'] . ' (' . $prod_item['preu'] . '€)<br>';
                        $productes .= $producte_line;
                    }
                }
            }            
        }
        
        $email = $compte['mail'];
        $subject = "BTiquets - " . translate("Notificació",$lang);
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: BTiquets <btiquets@btiquets.com>' . "\r\n";
        
        if($box["etype"]==5)
        {    
            $mensaje = 
            '<html style="font-family:verdana">' . 
                '<body style="height:100%;background:#FFFFFF;color: #555555;padding: 30px 0;">' .
                    '<div style="margin:auto;width:560px;">' .
                        '<img style="margin: 0 auto 30px" width="100" src="http://btiquets.com/boxes/logo_image_' . $compte['id'] . '.png" alt="logo">' . 
                        '<div style="background:#FFFFFF;border-radius:4px;padding:20px;">' .
                            '<div style="font-size: 16px;margin: 10px 0">S\'ha rebut la següent comanda:</div>' .
                            '<div style="font-size: 16px;text-transform: uppercase;">CODI:' . $info_reserva['ref'] . '</div>' .
                            '<div style="font-size: 16px;">TAQUILLA: <b>' . $box['name'] . '</b></div>' .
                            '<div style="font-size: 16px;">COMANDA:</div>' .
                            '<div style="font-size: 16px;"><b>' . $productes . '</b></div>' .
                            $date_str .
                            '<div style="font-size: 16px;">' . $tiquets_reservats . '</div>' .
                            '<div style="font-size: 16px;">' . $pvp . '</div>' .
                            '<div style="font-size: 16px;">NOM: ' . $info_reserva['rnom'] . '</div>' .
                            '<div style="font-size: 16px;">MAIL: ' . $info_reserva['rmail'] . '</div>' .
                            '<div style="font-size: 16px;">ADREÇA: ' . $info_reserva['raddr1'] . " " . $info_reserva['raddr2'] . '</div>' .
                            '<div style="font-size: 16px;">MUNICIPI: ' . $info_reserva['rcp'] . " " . $info_reserva['rmun'] . '</div>' .
                            '<div style="font-size: 16px;">TELÈFON: ' . $info_reserva['rtel'] . '</div>' .
                            '<div style="font-size: 16px;">COMENTARI: ' . $info_reserva['comentaris'] . '</div>' .            
                        '</div>' .                        
                    '</div>' . 
                '</body>' . 
            '</html>';
        }
        else 
        {
            $mensaje = 
            '<html style="font-family:verdana">' . 
                '<body style="height:100%;background:#FFFFFF;color: #555555;padding: 30px 0;">' .
                    '<div style="margin:auto;width:560px;">' .
                        '<img style="margin: 0 auto 30px" width="100" src="http://btiquets.com/boxes/logo_image_' . $compte['id'] . '.png" alt="logo">' . 
                        '<div style="background:#FFFFFF;border-radius:4px;padding:20px;">' .
                            '<div style="font-size: 16px;margin: 10px 0">S\'ha rebut la següent reserva:</div>' .
                            '<div style="font-size: 16px;text-transform: uppercase;">CODI:' . $info_reserva['ref'] . '</div>' .
                            '<div style="font-size: 16px;">ACTIVITAT: <b>' . $box['name'] . '</b></div>' .
                            $date_str .
                            '<div style="font-size: 16px;">' . $tiquets_reservats . '</div>' .
                            '<div style="font-size: 16px;">' . $pvp . '</div>' .
                            '<div style="font-size: 16px;">NOM: ' . $info_reserva['rnom'] . '</div>' .
                            '<div style="font-size: 16px;">MAIL: ' . $info_reserva['rmail'] . '</div>' .
                            '<div style="font-size: 16px;">TELÈFON: ' . $info_reserva['rtel'] . '</div>' .
                            '<div style="font-size: 16px;">MUNICIPI: ' . $info_reserva['rmun'] . '</div>' .
                            '<div style="font-size: 16px;">COMENTARI: ' . $info_reserva['comentaris'] . '</div>' .            
                        '</div>' .                        
                    '</div>' . 
                '</body>' . 
            '</html>';
        }
        
        return @mail($email,$subject,$mensaje,$headers);
    }

    function SendConfirmation8($mysqli,$info_reserva)
    {
        // NOTIFICACIÓ AL RESTAURANT TRAMIT ACABAT
        
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $lang;
        global $server;
        global $info_mail;
        
        $box = GetBox($mysqli,$info_reserva['box_id']);
        $compte = GetAccountInfo($mysqli,$box['propietari']);
        
        $sdata = date_create_from_format('Y-m-d H:i:s',$info_reserva['data_res']);
        $data_2 = date_format($sdata,'d-m-Y H:i'); 
        
        if($info_reserva['confirmat']==1)
        {
            $response = translate("RESERVA ACCEPTADA",$lang);
        }
        else
        {
            $response = translate("RESERVA DENEGADA",$lang);
        }
        
        $email = $info_reserva['colmail'];
        $subject = translate("Reserva realitzada - BTiquets",$lang);
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: Btiquets <btiquets@btiquets.com>' . "\r\n";
        $mensaje = 
            '<html style="font-family:verdana">' . 
                '<body style="height:100%;background:#cccccc;color: #555555;padding: 30px 0;">' .
                    '<div style="margin:auto;width:560px;">' .
                        '<img style="margin: 0 auto 30px" width="100" src="http://btiquets.com/boxes/logo_image_' . $compte['id'] . '.png" alt="logo">' . 
            
                        '<div style="font-size: 16px;background:#FFFFFF;border-radius:4px;padding:20px;">' .
                            '<div style="font-size: 14px;margin: 10px 0">' . translate("Estimat col·laborador, la teva resposta ha estat enviada:",$lang) . '</div>' .
                            '<h1 style="margin: 10px 0 20px 0";>' . $response . '</h1>' .
                            '<div style="text-transform: uppercase;">CODI:' . $info_reserva['ref'] . '</div>' .
                            '<div style="">NOM: ' . $info_reserva['rnom'] . '</div>' .
                            '<div style="">MAIL: ' . $info_reserva['rmail'] . '</div>' .
                            '<div style="">TELÈFON: ' . $info_reserva['rtel'] . '</div>' .                            
                            '<div style="">COMENTARI: ' . $info_reserva['comentaris'] . '</div>' .
                            '<div style="">COMENSALS: ' . $info_reserva['quant_total'] . '</div>' .
                            '<div style="">DATA: ' . $data_2 . '</div>' .                        
            
                        '</div>' .
                        '<div style="margin-top:20px;background:#FFFFFF;border-radius:4px;padding:10px;">' .
                            '<div style="font-size: 12px;">' . translate("Si has rebut aquest missatge per error, simplement elimina'l o posa't en contacte amb nosaltres.",$lang) . ' <b>' . $info_mail . '</b></div>' .
                        '</div>' .
                '</body>' . 
            '</html>';

        @mail($email,$subject,$mensaje,$headers);
    }

    function SendPaymentlink($mysqli,$info_reserva)
    {
        // ENVIEM L'ENLLAÇ DE PAGAMENT AL CLIENT
        
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        include_once '../php/apiRedsys.php';
        require("../php/postClass.php");
        $thisPost = new Post_Block;
        
        global $lang;
        global $server;
        global $info_mail;
        
        $box = GetBox($mysqli,$info_reserva['box_id']);
        $quant_modalities = decode_quant($info_reserva['quantitat']);
        $price_modalities = decode_price($box['price'],false);
        $total = 0;
        $pvp = "";
        $tiquets_reservats = "";
        
        if(sizeof($quant_modalities)==sizeof($price_modalities) && sizeof($price_modalities)>0)
        {
            for($i=0;$i<count($price_modalities);$i++)
            {
                $price = floatval($price_modalities[$i]['price']);
                if($quant_modalities[$i]!='undefined' && $quant_modalities[$i]!=null)
                {
                    $quant = intval($quant_modalities[$i]);

                    if($quant>0)
                    {
                        $str = $quant . ' x ' . $price_modalities[$i]['name'] . '</br>';
                        $tiquets_reservats .= $str;
                    }
                }
                else
                {
                    $quant = 0;
                }

                $subtotal = $quant*$price;
                $total += $subtotal;
            }
            if($total==0 && $info_reserva["total"]>0)
            {
                $pvp = "TOTAL = " . $info_reserva["total"] . "€";
                $total = $info_reserva["total"];
            }
            else
            {
                $pvp = "TOTAL = " . $total . "€";
            }
        }   
        else if($info_reserva["total"]>0)
        {
            $pvp = "TOTAL = " . $info_reserva["total"] . "€";
            $total = $info_reserva["total"];
        }
        
        $date_str = "";
        if($info_reserva['data_session']!="0000-00-00 00:00:00")
        {
            $sdata = date_create_from_format('Y-m-d H:i:s',$info_reserva['data_session']);
            $edate = date_format($sdata,'d-m-Y H:i');  
            $date_str = '<div style="font-size: 16px;"><b>' . $edate . '</b></div>';
        }
        
        $email = $info_reserva['email'];        
        
        // Aquest string és le preu amb dos decimals però sense coma ni punt
        $total_str = number_format($total,2,'','');

        // Data
        date_default_timezone_set($zone);
        $data = date('d-m-Y');

        $urlPago = 'https://btiquets.com/pagament-reserva/' . $info_reserva['ref'];
            
        $from_name = 'Reserves - BTiquets';
        $from_mail = 'btiquets@btiquets.com';
        $replyto = 'btiquets@btiquets.com';
        
        $subject = translate("La teva reserva",$lang);
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= "X-Priority: 3\r\n";
        $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
        $headers .= 'From: ' . $from_name . ' <' . $from_mail . '>' . "\r\n";
        $mensaje =             
            '<html style="font-family:verdana">' . 
                '<body style="height:100%;background:#cccccc;color: #555555;padding: 30px 0;">' .
                    '<div style="margin:auto;width:560px;">' .
                        '<img style="margin: 0 auto 30px" width="100" src="http://btiquets.com/img/pdf-3.jpg" alt="logo">' . 
                        '<div style="text-align:center;background:#FFFFFF;border-radius:4px;padding:20px;">' .
                            '<div style="font-size: 16px;">' . translate("Benvingut/da",$lang) . ' <b>' . $info_reserva['rnom'] . '</b>. ' . translate("Gràcies per utilitzar el servei de reserves de ",$lang) . "BTiquets" . '</div>' .
                            '<h1 style="margin: 10px 0 10px 0";>' . translate("El codi de la teva reserva és: ",$lang) . '</h1>' .
                            '<h1 style="font-size: 24px;text-transform: uppercase;margin: 10px 0 10px 0">' . $info_reserva['ref'] . '</h1>' .
                            '<div style="font-size: 18px;"><b>' . $box['name'] . '</b></div>' .
                            $date_str .
                            '<div style="font-size: 16px;">' . $tiquets_reservats . '</div>' .
                            '<div style="font-size: 16px;">' . $pvp . '</div>' .                            
                            '<div style="font-size:14px;margin: 10px 0 20px 0";>' . translate("Aquest és l'enllaç per poder realitzar el pagament de la reserva",$lang) . '</div>' .                                                   
                            '<a href=' . $urlPago . ' style="margin-right:10px;width:50%;padding: 10px 20px;border-radius:4px;background: #555555;color: #FFFFFF;text-decoration:none;font-size: 14px;">PAGAMENT</a>'.
                            '<div style="font-size: 12px;margin-top:50px;">' . translate("Si has rebut aquest missatge per error, simplement elimina’l o posa't en contacte amb nosaltres.",$lang) . ' <b>' . $replyto . '</b></div>' .
                        '</div>' .
                        '<div style="font-size: 12px;padding:10px;margin:20px 0;background:#FFFFFF;border-radius:4px;">' .
                            '<div style="font-size: 14px;">' . translate("Estàs rebent aquesta comunicació perquè recentment has realitzat una reserva a través de la central de reserves operada per ") . "BTiquets" . translate(". L'ús d'aquest lloc constitueix l'acceptació de les nostres",$lang) . ' <a style="color:#888888" href="http://btiquets.com/condicions">' . translate("Condicions d'ús",$lang) . '</a> ' . translate("i",$lang) . ' <a style="color:#888888" href="http://btiquets.com/privacitat">' . translate("Política de privacitat",$lang) . '</a>. ' . translate("Tots els drets reservats.",$lang) . '</div>' .
                        '</div>' .
                    '</div>' . 
                '</body>' . 
            '</html>';
        
        
        //error_log("SendPaymentlink Data: ".$email." / ".$subject." / ".$mensaje." / ".$headers);
        return @mail($email,$subject,$mensaje,$headers,"-f$from");
    }


    function SendEnquesta($mysqli,$info_reserva)
    {
        // ENVIAMENT ENQUESTA DE SATISFACCIÓ
        
        if(file_exists('./../php/common.php'))
            include_once './../php/common.php';
    
        if(file_exists('./../php/funcions.php'))
            include_once './../php/funcions.php';
        
        
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $lang;
        global $server;
        global $info_mail;
        
        $box = GetBox($mysqli,$info_reserva['box_id']);
        $compte = GetAccountInfo($mysqli,$box['propietari']);

        $email = $info_reserva['rmail'];
        $subject = translate("Enquesta de satisfacció - BTiquets",$lang);
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: BTiquets <btiquets@btiquets.com>' . "\r\n";
        $mensaje = 
            '<html style="font-family:verdana">' . 
                '<body style="height:100%;background:#cccccc;color: #555555;padding: 30px 0;">' .
                    '<div style="margin:auto;width:560px;">' .
                        '<img style="margin: 0 auto 30px" width="100" src="http://btiquets.com/img/logo-og.jpg" alt="logo">' . 
            
                        '<div style="font-size: 16px;background:#FFFFFF;border-radius:4px;padding:20px;">' .
                            '<div style="font-size: 14px;margin: 10px 0">Hola.</div>'.
                            '<div style="font-size: 14px;margin: 10px 0">Recentment has fet una activitat a través de BTiquets. Et passem un enllaç per fer-te una petita enquesta de satisfacció, si no et sap greu, per anar millorant en el què poguem.</div>'.
                            '<div style="font-size: 14px;margin: 10px 0 30px">Moltes gràcies i fins aviat.</div>'.
                            '<a href="http://goo.gl/forms/KPl3BkMb3m" style="margin-right:10px;width:50%;padding: 10px 20px;border-radius:4px;background: #555555;color: #FFFFFF;text-decoration:none;font-size: 14px;">REALITZAR ENQUESTA</a>'.

                        '<div style="font-size: 14px;margin: 40px 0 10px">Recientmente has realizado una actividad a través de BTiquets. Te pasamos un enlace para hacerte una pequeña encuesta de satisfacción, si no te importa, para mejorar en todo lo que sea posible.</div>'.
                        '<div style="font-size: 14px;margin: 10px 0 30px">Muchas gracias y hasta pronto.</div>'.
                        '<a href="http://goo.gl/forms/KPl3BkMb3m" style="margin-right:10px;width:50%;padding: 10px 20px;border-radius:4px;background: #555555;color: #FFFFFF;text-decoration:none;font-size: 14px;">REALIZAR ENCUESTA</a>'.
                        '</div>' .
                        '<div style="margin-top:20px;background:#FFFFFF;border-radius:4px;padding:10px;">' .
                            '<div style="font-size: 12px;">' . translate("Si has rebut aquest missatge per error, simplement elimina'l o posa't en contacte amb nosaltres.",$lang) . ' <b>' . $info_mail . '</b></div>' .
                        '</div>' .
                '</body>' . 
            '</html>';

        return mail($email,$subject,$mensaje,$headers);
    }    

    function ConfirmReservation($mysqli,$ref,$val)
    {
        $ret=1;
        
        $sql="UPDATE reserva SET `confirmat`='$val' WHERE ref=LOWER('$ref')";
        $result = $mysqli->query($sql);
        
        return $ret;
    }

    function ValidateReservation($mysqli,$ref,$val,$com)
    {
        $ret=1;
        
        $sql="UPDATE reserva SET `validat`='$val',`val_com`='$com' WHERE ref=LOWER('$ref')";
        $result = $mysqli->query($sql);
        
        return $ret;
    }

    function CheckConfirmReservation($ref)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        $ret=1;
        
        $sql="SELECT confirmat FROM reserva WHERE ref=LOWER('$ref')";
        $result = $mysqli->query($sql);
        $row = $result->fetch_row();
        
        return $row;
    }

    function CheckDescompte($id_str,$codi)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        $ret=array();
        $ret['descompte']=0;
        $ret['type']=-1;

        $descompte_ids = explode(';',$id_str);
        
        foreach($descompte_ids as $id){
            $sql="SELECT * FROM descomptes WHERE id=$id";
            $result = $mysqli->query($sql);
            if ($result) {
                $row = $result->fetch_row();                
                if(strtolower($row[2])==strtolower($codi)) {
                    $ret['descompte']=$row[4];
                    $ret['type']=$row[3];
                    break;
                }
            }
        }
        
        return $ret;
    }

    function InsertColComment($id,$comment)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        $ret=1;
        
        $sql="UPDATE reserva SET `col_comentaris`='$comment' WHERE id='$id'";
        $result = $mysqli->query($sql);
        
        return $ret;
    }

    function InsertComment($id,$comment)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
        $ret=1;
        
        $sql="UPDATE reserva SET `comentaris`='$comment' WHERE id='$id'";
        $result = $mysqli->query($sql);
        
        return $ret;
    }

    function GetMinPrice($id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
            
        $sql="SELECT min_price FROM box_data WHERE id='$id'";
        $result=$mysqli->query($sql);
        $row = $result->fetch_row();
        $ret = isInteger(round(floatval($row[0]),2)) ? round(floatval($row[0]),2) : number_format(round(floatval($row[0]),2),2);

        
        return $ret;
    }

    function decode_price($price_str,$b_coldata=false)
    {  
        // Versió 20200212
        // modpreu1;modpreu2;modpreu3;....;modpreuN;
        // nom:preu:min:max:desc:tipus:stock
        // classe: mode tipus (0), mode excloent (1) o mode complement (2)
        
        // Versió 20190815
        // modpreu1;modpreu2;modpreu3;....;modpreuN;
        // nom:preu:min:max:desc:tipus
        // classe: mode tipus (0), mode excloent (1) o mode complement (2)
        $data = array();
        $aux1 = explode(';',$price_str);
        if(count($aux1)>0)
        {
            for($k=0;$k<count($aux1);$k++)
            {
                if($aux1[$k]!="")
                {
                    $aux2 = explode(':',$aux1[$k]);                    
                    if(count($aux2)==7)
                    {
                        $data[] = array('name'=>htmlspecialchars(stripslashes($aux2[0])),'price'=>isInteger(round(floatval($aux2[1]),2)) ? round(floatval($aux2[1]),2) : number_format(round(floatval($aux2[1]),2),2),'min'=>intval($aux2[2]),'max'=>intval($aux2[3]),'desc'=>htmlspecialchars(stripslashes($aux2[4])),'type'=>intval($aux2[5]),'stock'=>intval($aux2[6]));
                    }
                    else if(count($aux2)==6)
                    {
                        $data[] = array('name'=>htmlspecialchars(stripslashes($aux2[0])),'price'=>isInteger(round(floatval($aux2[1]),2)) ? round(floatval($aux2[1]),2) : number_format(round(floatval($aux2[1]),2),2),'min'=>intval($aux2[2]),'max'=>intval($aux2[3]),'desc'=>htmlspecialchars(stripslashes($aux2[4])),'type'=>intval($aux2[5]),'stock'=>0);
                    }
                    else
                    {
                        $coldata = null;
                        $n_cols = (count($aux2)-4)/2;                        
                        if($n_cols>0 && $b_coldata)
                        {
                            $coldata = array();
                            for($j=0;$j<$n_cols;$j++)
                            {
                                $coldata[] = array('col_id'=>$aux2[4+2*$j],'price'=>$aux2[4+2*$j+1]);
                            }
                        }
                        $data[] = array('name'=>htmlspecialchars(stripslashes($aux2[0])),'price'=>isInteger(round(floatval($aux2[1]),2)) ? round(floatval($aux2[1]),2) : number_format(round(floatval($aux2[1]),2),2),'min'=>intval($aux2[2]),'max'=>intval($aux2[3]),'n_cols'=>$n_cols,'coldata'=>$coldata,'desc'=>"",'type'=>0,'stock'=>0);
                    }
                }
            }
        }
        
        return $data;
    }

    function decode_quant($quant_str)
    {   
        $data = array();
        $aux1 = explode(';',$quant_str);
        if(count($aux1)>0)
        {
            for($k=0;$k<count($aux1);$k++)
            {
                if($aux1[$k]!="")
                {
                    $data[] = $aux1[$k];
                }
            }
        }
        
        return $data;
    }

    function decode_cap($cap_str,$sel=-1)
    {   
        $data = array();
        $aux1 = explode(';',$cap_str);
        if(count($aux1)>0)
        {
            for($k=0;$k<count($aux1);$k++)
            {
                if($aux1[$k]!="")
                {
                    $aux2 = explode(':',$aux1[$k]);
                    if(count($aux2)>=3)
                    {
                        if($sel==-1 || $sel==$k)
                        {
                            $data[] = array('id'=>$k,'nom'=>$aux2[0],'desc'=>$aux2[1],'preu'=>$aux2[2]);
                        }
                    }
                }
            }
        }
        
        return $data;
    }

    function decode_dades($str)
    {   
        $data = array();
        $aux1 = explode(';;',$str);
        if(count($aux1)>0)
        {
            for($k=0;$k<count($aux1);$k++)
            {
                if($aux1[$k]!="")
                {
                    $aux2 = explode('::',$aux1[$k]);
                    if(count($aux2)==3)
                    {
                        $data[] = array('camp_1'=>$aux2[0],'camp_2'=>$aux2[1],'camp_3'=>$aux2[2],'camp_4'=>0);
                    }
                    else if(count($aux2)==4)
                    {
                        $data[] = array('camp_1'=>$aux2[0],'camp_2'=>$aux2[1],'camp_3'=>$aux2[2],'camp_4'=>$aux2[3]);
                    }
                    else if(count($aux2)==5)
                    {
                        $data[] = array('camp_1'=>$aux2[0],'camp_2'=>$aux2[1],'camp_3'=>$aux2[2],'camp_4'=>$aux2[3],'camp_5'=>$aux2[4]);
                    }
                    else if(count($aux2)>=6)
                    {
                        $data[] = array('camp_1'=>$aux2[0],'camp_2'=>$aux2[1],'camp_3'=>$aux2[2],'camp_4'=>$aux2[3],'camp_5'=>$aux2[4],'camp_6'=>$aux2[5]);
                    }
                }
            }
        }
        
        return $data;
    }

    function decode_prod($cap_str,$sel=-1)
    {   
        $data = array();
        $aux1 = explode(';',$cap_str);
        if(count($aux1)>0)
        {
            for($k=0;$k<count($aux1);$k++)
            {
                if($aux1[$k]!="")
                {
                    $aux2 = explode(':',$aux1[$k]);
                    if(count($aux2)>=3)
                    {
                        if($sel==-1 || $sel==$k)
                        {
                            $data[] = array('id'=>$k,'nom'=>$aux2[0],'desc'=>$aux2[1],'stock'=>$aux2[2],'preu'=>$aux2[3]);
                        }
                    }
                }
            }
        }
        
        return $data;
    }

    function decode_res_days($res_days_str)
    {   
        $data = array();
        $aux1 = explode(';',$res_days_str);
        if(count($aux1)>0)
        {
            for($k=0;$k<count($aux1);$k++)
            {
                if($aux1[$k]!="")
                {
                    $aux2 = explode('%',$aux1[$k]);
                    if(count($aux2)==4)
                    {                      
                        $data[$aux2[0]] = array('act'=>intval($aux2[1]),'tarifa'=>intval($aux2[2]),'places'=>intval($aux2[3]));
                    }
                }
            }
        }
        
        return $data;
    }

    function decode_hotel_str($hotel_str)
    {   
        $data = array();
        $aux1 = explode(';',$hotel_str);
        if(count($aux1)>0)
        {
            for($k=0;$k<count($aux1);$k++)
            {
                if($aux1[$k]!="")
                {
                    $data[intval($aux1[$k])] = array('id'=>intval($aux1[$k]),'active'=>true);
                }
            }
        }
        
        return $data;
    }

    function decode_producte_str($producte_str)
    {   
        $data = array();
        $aux1 = explode(';',$producte_str);
        if(count($aux1)>0)
        {
            for($k=0;$k<count($aux1);$k++)
            {
                if($aux1[$k]!="")
                {
                    $data[intval($aux1[$k])] = array('id'=>intval($aux1[$k]),'active'=>true);
                }
            }
        }
        
        return $data;
    }

    function decode_enviament_str($enviament_str)
    {   
        $data = array();
        $aux1 = explode(';',$enviament_str);
        if(count($aux1)>0)
        {
            for($k=0;$k<count($aux1);$k++)
            {
                if($aux1[$k]!="")
                {
                    $data[intval($aux1[$k])] = array('id'=>intval($aux1[$k]),'active'=>true);
                }
            }
        }
        
        return $data;
    }

    function decode_deststr($deststr,$ini)
    {   
        $data = array();
        
        if($ini)
        {
            $provincies=array("Àlaba", "Albacete", "Alicant", "Almeria", "Astúries", "Àvila", "Badajoz", "Barcelona", "Burgos", "Càceres", "Cadis", "Cantàbria", "Castelló", "Ciudad Real", "Còrdova", "Conca", "Girona", "Granada", "Guadalajara", "Guipúscoa", "Huelva", "Osca", "Illes Balears", "Jaén", "La Corunya", "La Rioja", "Las Palmas", "Lleó", "Lleida", "Lugo", "Madrid", "Màlaga", "Múrcia", "Navarra", "Ourense", "Palència", "Pontevedra", "Salamanca", "Santa Cruz de Tenerife", "Segòvia", "Sevilla", "Sòria", "Tarragona", "Terol", "Toledo", "València", "Valladolid", "Bizcaia", "Zamora", "Saragossa");

            $provincies_es=array("Álava", "Albacete", "Alicante", "Almería", "Asturias", "Ávila", "Badajoz", "Barcelona", "Burgos", "Cáceres", "Cádiz", "Cantabria", "Castellón", "Ciudad Real", "Córdoba", "Cuenca", "Gerona", "Granada", "Guadalajara", "Guipúzcoa", "Huelva", "Huesca", "Islas Baleares", "Jaén", "La Coruña", "La Rioja", "Las Palmas", "León", "Lérida", "Lugo", "Madrid", "Málaga", "Murcia", "Navarra", "Orense", "Palencia", "Pontevedra", "Salamanca", "Santa Cruz de Tenerife", "Segovia", "Sevilla", "Soria", "Tarragona", "Teruel", "Toledo", "Valencia", "Valladolid", "Vizcaya", "Zamora", "Zaragoza");
            
            $aux1 = explode(';',$deststr);
            foreach($provincies as $provincia)
            {
                $data[] = array('nom'=>$provincia,'actiu'=>false,'val'=>0);
            }
        }
        else
        {
            $aux1 = explode(';',$deststr);
            if(count($aux1)>0)
            {
                for($j=0;$j<count($aux1);$j++)
                {
                    $aux2 = explode(':',$aux1[$j]);
                    $data[] = array('nom'=>$aux2[0],'actiu'=>intval($aux2[1]),'val'=>floatval($aux2[2]));
                }
            }
        }
        
        return $data;
    }

    function decode_carret($quant_str,$sel_p=-1,$sel_pk=-1)
    {   
        $data = array();
        $aux1 = explode(';',$quant_str);
        if(count($aux1)>0)
        {
            for($k=0;$k<count($aux1);$k++)
            {
                if($aux1[$k]!="")
                {
                    $aux2 = explode(':',$aux1[$k]);
                    if(count($aux2)>=3)
                    {
                        if(($sel_p==-1 || $sel_p==$aux2[0]) && ($sel_pk==-1 || $sel_pk==$aux2[1]))
                        {
                            $data[] = array('pid'=>$aux2[0],'pkid'=>$aux2[1],'quant'=>$aux2[2]);
                        }
                    }
                }
            }
        }
        
        return $data;
    }

    function IsCollaborator($id)
    {
        if(file_exists('/php/common.php'))
            include_once '/php/common.php';
        
        global $mysqli;
            
        // i ara miro si existeix (improbable, però no impossible)
        $sql="SELECT COUNT(*) FROM collaboradors WHERE user='$id'";
        $result=$mysqli->query($sql);
        $row = $result->fetch_row();
        $ret = $row[0];

        
        return $ret;
    }

    function PrepararTPV($miObj,$amount,$order,$merchantCode,$currency,$transactionType,$terminal,$merchantURL,$urlOK,$urlKO,$data,$description,$merchantName,$paymethod="C")
    {
        // Se Rellenan los campos
        $miObj->setParameter("DS_MERCHANT_AMOUNT",$amount);
        $miObj->setParameter("DS_MERCHANT_ORDER",strval($order));
        $miObj->setParameter("DS_MERCHANT_MERCHANTCODE",$merchantCode);
        $miObj->setParameter("DS_MERCHANT_CURRENCY",$currency);
        $miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE",$transactionType);
        $miObj->setParameter("DS_MERCHANT_TERMINAL",$terminal);
        $miObj->setParameter("DS_MERCHANT_MERCHANTURL",$merchantURL);
        $miObj->setParameter("DS_MERCHANT_URLOK",$urlOK);		
        $miObj->setParameter("DS_MERCHANT_URLKO",$urlKO);
        $miObj->setParameter("DS_MERCHANT_MERCHANTDATA",$data);
        $miObj->setParameter("DS_MERCHANT_PRODUCTDESCRIPTION",$description);
        $miObj->setParameter("DS_MERCHANT_MERCHANTNAME",$merchantName);
        $miObj->setParameter("DS_MERCHANT_PAYMETHODS",$paymethod);
    }

    function Vota($mysqli,$taula,$val)
    {        
        $sql="SELECT ".$val." FROM `".$taula."` WHERE campanya='nadal_2016'";
        $result=$mysqli->query($sql);
        $row = $result->fetch_row();
        $ret = intval($row[0])+1;
        
        $sql="UPDATE ".$taula." SET `".$val."`='".$ret."' WHERE campanya='nadal_2016'";
        $result = $mysqli->query($sql); 
        
        return $ret;
    }

    function MiniImage($box)
    {        
        // Primer obtinc totes les carpetes d'experiències
        $miniwidth = 300;
        $mediumwidth = 600;
        if(!file_exists("../boxes/" . $box . "/box_image_0_mini.jpg"))
        {
            if(file_exists("../boxes/" . $box . "/box_image_0.jpg"))
            {
                $myimg = new SimpleImage();
                $myimg->load("../boxes/".$box.'/box_image_0.jpg');
                $myimg->resizeToWidth($miniwidth);
                $myimg->save("../boxes/".$box.'/box_image_0_mini.jpg');
                $myimg->clear();
            }
        }
        if(!file_exists("../boxes/" . $box . "/box_image_0_medium.jpg"))
        {
            if(file_exists("../boxes/" . $box . "/box_image_0.jpg"))
            {
                $myimg = new SimpleImage();
                $myimg->load("../boxes/".$box.'/box_image_0.jpg');
                $myimg->resizeToWidth($mediumwidth);
                $myimg->save("../boxes/".$box.'/box_image_0_medium.jpg');
                $myimg->clear();
            }
        }
        
        return 1;
    }

    function GetComptador($mysqli,$box_id)
    {        
        $data = -1;
        
        $result = $mysqli->query("SELECT valor FROM comptadors WHERE box_id='$box_id'");
                
        if($result != null)
        {
            $row = $result->fetch_row();
            $data = intval($row[0]);
        }
            
        return $data;
    }

    function SetComptador($mysqli,$box_id,$value)
    {                
        $sql="UPDATE comptadors SET `valor`='$value' WHERE box_id='$box_id'";
        $mysqli->query($sql);
    }
?>