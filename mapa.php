<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
  define('INFI',9999999999);
    include './inc/header.php';
    include './inc/conexao.php';

    $tipo = @$_POST["relatorio"];
    $periodo = @$_POST["periodo"];
    $veiculo = @$_POST["veiculo"];

    if ($periodo == 'm') {
      $periodo_conducao = " and ct.periodo_conducao in ('im')"; 
    } 
    if ($periodo == "a") {
      $periodo_conducao = " and ct.periodo_conducao in ('vm','it')"; 
    }
    if ($periodo == "t") {
      $periodo_conducao = " and ct.periodo_conducao in ('vt')"; 
    }
    if ($tipo == "E") {
        $valor = @$_POST['valor'];

        $sql = "select t.id as id_trecho,t.tipo as Tipo,c.nome as Crianca,c.id as id_crianca,o.nome as Condutor,v.placa as Veiculo,  
        CONCAT(t.cep_origem,',',t.logradouro_origem,',',t.numero_origem,',',t.cidade_origem,',',t.estado_origem) as origem,
        CONCAT(t.cep_destino,',',t.logradouro_destino,',',t.numero_destino,',',t.cidade_destino,',',t.estado_destino) as destino from criancatrecho ct
        inner join crianca c on c.id = ct.id_crianca
        inner join condutor o on o.cpf = ct.cpf_condutor
        inner join veiculo v on v.placa = ct.placa_veiculo
        inner join trecho t on t.id = ct.id_trecho
        where ct.deletado ='N'".$periodo_conducao." and c.id_escola = ".$valor." and v.placa = '".$veiculo."'";
        $result = $conexao->query($sql);

        $sqlveiculo = "select cpf_ajudante from veiculo where placa = '".$veiculo."'";
        $resultveiculo = $conexao->query($sqlveiculo);
        $rowveiculo = @mysqli_fetch_array($resultveiculo);

        if ($rowveiculo['cpf_ajudante']) {
            $enderecos = array();

            $sqlajudante = "select CONCAT(cep,',',logradouro,',',numero,',',cidade,',',estado) as ajudante from ajudante where cpf = '".$rowveiculo['cpf_ajudante']."'";
            $resultajudante = $conexao->query($sqlajudante); 

            $rowajudante = @mysqli_fetch_array($resultajudante);
            $address_ajudante = urlencode($rowajudante['ajudante']);
            $request_url_ajudante = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyC-2bniFa-QuG1YD6Il7TV3SLBYiqXrpQg&address=".$address_ajudante."&sensor=false";
             $status_ajudante = @file_get_contents($request_url_ajudante);
            $data_ajudante = json_decode($status_ajudante,true);
            $LatLng_ajudante = "";
            if ($data_ajudante){
                $Lat_ajudante = $data_ajudante['results'][0]['geometry']['location']['lat'];
                $Lon_ajudante = $data_ajudante['results'][0]['geometry']['location']['lng'];
                $LatLng_ajudante = $Lat_ajudante.",".$Lon_ajudante;
            }
        } else {
            $sqlcondutor = "select CONCAT(c.cep,',',c.logradouro,',',c.numero,',',c.cidade,',',c.estado) as condutor from condutor c INNER JOIN condveic cv ON cv.cpf_condutor = c.cpf where cv.placa = '".$veiculo."'".$periodo_condutor;
            $resultcondutor = $conexao->query($sqlcondutor);
            $rowcondutor = @mysqli_fetch_array($resultcondutor);
            $address_condutor = urlencode($rowcondutor['condutor']);
            $request_url_condutor = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyC-2bniFa-QuG1YD6Il7TV3SLBYiqXrpQg&address=".$address_condutor."&sensor=false";
             $status_condutor = @file_get_contents($request_url_condutor);
            $data_condutor = json_decode($status_condutor,true);
            $LatLng_condutor = "";
            if ($data_condutor){
                $Lat_condutor = $data_condutor['results'][0]['geometry']['location']['lat'];
                $Lon_condutor = $data_condutor['results'][0]['geometry']['location']['lng'];
                $LatLng_condutor = $Lat_condutor.",".$Lon_condutor;
            }
        }

        $cont  = 0;
        $cont2 = 0;
        
        if ($periodo == "m" || $periodo == 'a') {
          $enderecos[$cont] = [
            'origem' => $LatLng_ajudante ? $LatLng_ajudante : $LatLng_condutor,
            'destino' => ""
          ];
        } 
        if ($periodo == 't' || $periodo == 'a') {
          $sqlescola = "select CONCAT(e.cep,',',e.logradouro,',',e.numero,',',e.cidade,',',e.estado) as escola from escola e where id = ".$valor;
          $resultescola = $conexao->query($sqlescola);
          $rowescola = @mysqli_fetch_array($resultescola);
          $address_escola = urlencode($rowescola['escola']);
            $request_url_escola = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyC-2bniFa-QuG1YD6Il7TV3SLBYiqXrpQg&address=".$address_escola."&sensor=false";
             $status_escola = @file_get_contents($request_url_escola);
            $data_escola = json_decode($status_escola,true);
            $LatLng_escola = "";
            if ($data_escola){
                $Lat_escola = $data_escola['results'][0]['geometry']['location']['lat'];
                $Lon_escola = $data_escola['results'][0]['geometry']['location']['lng'];
                $LatLng_escola = $Lat_escola.",".$Lon_escola;
            }
          if ($periodo == 't') {
            $enderecos[$cont] = [
              'origem' => $LatLng_escola,
              'destino' => ""
            ];
          } 
          if ($periodo == 'a') {
            $enderecos2[$cont2] = [
              'origem' => $LatLng_escola,
              'destino' => ""
            ];
            $cont2++;
          }
        }

        $cont++;

        while ($row = @mysqli_fetch_array($result)) {
            $address_origem = urlencode($row['origem']);
            $request_url_origem = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyC-2bniFa-QuG1YD6Il7TV3SLBYiqXrpQg&address=".$address_origem."&sensor=false";
             $status_origem = @file_get_contents($request_url_origem);
            $data_origem = json_decode($status_origem,true);
            $LatLng_origem = "";
            if ($data_origem){
                $Lat_origem = $data_origem['results'][0]['geometry']['location']['lat'];
                $Lon_origem = $data_origem['results'][0]['geometry']['location']['lng'];
                $LatLng_origem = $Lat_origem.",".$Lon_origem;
            }

            $address_destino = urlencode($row['destino']);
            $request_url_destino = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyC-2bniFa-QuG1YD6Il7TV3SLBYiqXrpQg&address=".$address_destino."&sensor=false";
             $status_destino = @file_get_contents($request_url_destino);
            $data_destino = json_decode($status_destino,true);
            $LatLng_destino = "";
            if ($data_destino){
                $Lat_destino = $data_destino['results'][0]['geometry']['location']['lat'];
                $Lon_destino = $data_destino['results'][0]['geometry']['location']['lng'];
                $LatLng_destino = $Lat_destino.",".$Lon_destino;
            }

            if ($periodo == "a" && $row["Tipo"] == 'vm') {
              $enderecos2[$cont2] = [
                'origem' => $LatLng_origem,
                'destino' => $LatLng_destino,
                'tipo' => $row["Tipo"]
              ];
              $cont2++;
            } else {
              $enderecos[$cont] = [
                'origem' => $LatLng_origem,
                'destino' => $LatLng_destino,
                'tipo' => $row["Tipo"]
              ];
              $cont++;
            }  
        }

        if ($periodo == 'm') {
          $enderecos[$cont] = [
              'origem' => "",
              'destino' => $LatLng_destino
          ];
        }
        if ($periodo == 'a') {
          $enderecos[$cont] = [
              'origem' => "",
              'destino' => $LatLng_destino
          ];
          $enderecos2[$cont2] = [
              'origem' => "",
              'destino' => $LatLng_ajudante ? $LatLng_ajudante : $LatLng_condutor
          ];
        }
        if ($periodo == 't') {
          $enderecos[$cont] = [
              'origem' => "",
              'destino' => $LatLng_ajudante ? $LatLng_ajudante : $LatLng_condutor
          ];
        }
        $distancias = array();

        if ($periodo == 'm') {
          // calcular a distancia entre o ponto inicial e entre os pontos do caminho
          for ($i=0; $i < sizeof($enderecos);$i++){
            for ($j=0;$j < sizeof($enderecos)-1;$j++) {
              $LatLng_origem = explode(",", $enderecos[$i]["origem"]);

              if (isset($LatLng_origem[0]))
                $Lat_origem = $LatLng_origem[0];
              if (isset($LatLng_origem[1]))
               $Lng_origem = $LatLng_origem[1];

              $LatLng_destino = explode(",", $enderecos[$j]["origem"]);

              if (isset($LatLng_destino[0]))
                $Lat_destino = $LatLng_destino[0];
              if (isset($LatLng_destino[1]))
                $Lng_destino = $LatLng_destino[1];

              if ($Lat_origem && $Lng_origem && $Lat_destino && $Lng_destino)
                $d = sqrt(pow(($Lat_origem-$Lat_destino),2) + pow(($Lng_origem-$Lng_destino),2));
              if ($j == 0) {
                $d = INFI;
              }
              if ($i == (sizeof($enderecos) - 1)) {
                $d = INFI;
              }
              if ($i == $j) {
                $d = INFI;
              }
              $distancias[$i][$j]['distancia'] = $d;
              $distancias[$i][$j]['origem'] = $enderecos[$i]["origem"];
              $distancias[$i][$j]['destino'] = $enderecos[$j]["origem"];
            }
          }
          // calcular a distancia entre os pontos do caminho e o destino
          for ($i = 0 ;$i < sizeof($enderecos);$i++){
              $LatLng_origem = explode(",", $enderecos[$i]["origem"]);

              if (isset($LatLng_origem[0]))
                $Lat_origem = $LatLng_origem[0];
              if (isset($LatLng_origem[1]))
                $Lng_origem = $LatLng_origem[1];

              $LatLng_destino = explode(",", $enderecos[$i]["destino"]);

              if (isset($LatLng_destino[0]))
                $Lat_destino = $LatLng_destino[0];
              if (isset($LatLng_destino[1]))
                $Lng_destino = $LatLng_destino[1];

              if ($Lat_origem && $Lng_origem && $Lat_destino && $Lng_destino)
                $d = sqrt(pow(($Lat_origem-$Lat_destino),2) + pow(($Lng_origem-$Lng_destino),2));
              if ($i == sizeof($enderecos)-1){
                $d = 0;
              }
              if ($i == 0) {
                $d = INFI;
              }
              $distancias[$i][sizeof($enderecos)-1]["distancia"] = $d;
              $distancias[$i][sizeof($enderecos)-1]["origem"] = $enderecos[$i]["origem"];
              $distancias[$i][sizeof($enderecos)-1]["destino"] = $enderecos[$i]["destino"];
          }
        }


        if ($periodo == 'a') {
          // calcular a distancia entre o ponto inicial e entre os pontos do caminho
          for ($i=0; $i < sizeof($enderecos);$i++){
            for ($j=0;$j < sizeof($enderecos)-1;$j++) {
                $LatLng_origem = explode(",", $enderecos[$i]["origem"]);

                if (isset($LatLng_origem[0]))
                  $Lat_origem = $LatLng_origem[0];
                if (isset($LatLng_origem[1]))
                 $Lng_origem = $LatLng_origem[1];

                $LatLng_destino = explode(",", $enderecos[$j]["origem"]);

                if (isset($LatLng_destino[0]))
                  $Lat_destino = $LatLng_destino[0];
                if (isset($LatLng_destino[1]))
                  $Lng_destino = $LatLng_destino[1];

                if ($Lat_origem && $Lng_origem && $Lat_destino && $Lng_destino)
                  $d = sqrt(pow(($Lat_origem-$Lat_destino),2) + pow(($Lng_origem-$Lng_destino),2));
                if ($j == 0) {
                  $d = INFI;
                }
                if ($i == (sizeof($enderecos) - 1)) {
                  $d = INFI;
                }
                if ($i == $j) {
                  $d = INFI;
                }
                $distancias[$i][$j]['distancia'] = $d;
                $distancias[$i][$j]['origem'] = $enderecos[$i]["origem"];
                $distancias[$i][$j]['destino'] = $enderecos[$j]["origem"];
            }
          }
          // calcular a distancia entre os pontos do caminho e o destino
          for ($i = 0 ;$i < sizeof($enderecos);$i++){
              $LatLng_origem = explode(",", $enderecos[$i]["origem"]);

              if (isset($LatLng_origem[0]))
                $Lat_origem = $LatLng_origem[0];
              if (isset($LatLng_origem[1]))
                $Lng_origem = $LatLng_origem[1];

              $LatLng_destino = explode(",", $enderecos[$i]["destino"]);

              if (isset($LatLng_destino[0]))
                $Lat_destino = $LatLng_destino[0];
              if (isset($LatLng_destino[1]))
                $Lng_destino = $LatLng_destino[1];

              if ($Lat_origem && $Lng_origem && $Lat_destino && $Lng_destino)
                $d = sqrt(pow(($Lat_origem-$Lat_destino),2) + pow(($Lng_origem-$Lng_destino),2));
              if ($i == sizeof($enderecos)-1){
                $d = 0;
              }
              if ($i == 0) {
                $d = INFI;
              }
              $distancias[$i][sizeof($enderecos)-1]["distancia"] = $d;
              $distancias[$i][sizeof($enderecos)-1]["origem"] = $enderecos[$i]["origem"];
              $distancias[$i][sizeof($enderecos)-1]["destino"] = $enderecos[$i]["destino"];
          }

          // calcular entre os pontos do caminho
          for ($i=0; $i < sizeof($enderecos2)-1 ;$i++){
            for ($j=0;$j < sizeof($enderecos2);$j++) {
                $LatLng_origem = explode(",", $enderecos2[$i]["destino"]);

                if (isset($LatLng_origem[0]))
                  $Lat_origem = $LatLng_origem[0];
                if (isset($LatLng_origem[1]))
                 $Lng_origem = $LatLng_origem[1];

                $LatLng_destino = explode(",", $enderecos2[$j]["destino"]);

                if (isset($LatLng_destino[0]))
                  $Lat_destino = $LatLng_destino[0];
                if (isset($LatLng_destino[1]))
                  $Lng_destino = $LatLng_destino[1];

                if ($Lat_origem && $Lng_origem && $Lat_destino && $Lng_destino)
                  $d = sqrt(pow(($Lat_origem-$Lat_destino),2) + pow(($Lng_origem-$Lng_destino),2));
                if ($i == $j) {
                  $d = INFI;
                }
                if ($j == 0) {
                  $d = INFI;
                }
                $distancias2[$i][$j]['distancia'] = $d;
                $distancias2[$i][$j]['origem'] = $enderecos2[$i]["destino"];
                $distancias2[$i][$j]['destino'] = $enderecos2[$j]["destino"];
            }
          }
          // calcular a distancia entre os pontos do caminho e o inicio
          for ($i=0; $i < sizeof($enderecos2) ;$i++){
              $LatLng_origem = explode(",", $enderecos2[0]["origem"]);

              if (isset($LatLng_origem[0]))
                $Lat_origem = $LatLng_origem[0];
              if (isset($LatLng_origem[1]))
                $Lng_origem = $LatLng_origem[1];

              $LatLng_destino = explode(",", $enderecos2[$i]["destino"]);

              if (isset($LatLng_destino[0]))
                $Lat_destino = $LatLng_destino[0];
              if (isset($LatLng_destino[1]))
                $Lng_destino = $LatLng_destino[1];

              if ($Lat_origem && $Lng_origem && $Lat_destino && $Lng_destino)
                $d = sqrt(pow(($Lat_origem-$Lat_destino),2) + pow(($Lng_origem-$Lng_destino),2));
              if ($i == sizeof($enderecos2)-1){
                $d = INFI;
              }
              if ($i == 0) {
                $d = INFI;
              }
              $distancias2[0][$i]["distancia"] = $d;
              $distancias2[0][$i]["origem"] = $enderecos2[0]["origem"];
              $distancias2[0][$i]["destino"] = $enderecos2[$i]["destino"];
          }
          // calcular a distancia entre os pontos do caminho e o destino
          for ($i = 0 ;$i < sizeof($enderecos2);$i++){
              $LatLng_origem = explode(",", $enderecos2[$i]["destino"]);

              if (isset($LatLng_origem[0]))
                $Lat_origem = $LatLng_origem[0];
              if (isset($LatLng_origem[1]))
                $Lng_origem = $LatLng_origem[1];

              $LatLng_destino = explode(",", $enderecos2[sizeof($enderecos2)-1]["destino"]);

              if (isset($LatLng_destino[0]))
                $Lat_destino = $LatLng_destino[0];
              if (isset($LatLng_destino[1]))
                $Lng_destino = $LatLng_destino[1];

              if ($Lat_origem && $Lng_origem && $Lat_destino && $Lng_destino)
                $d = sqrt(pow(($Lat_origem-$Lat_destino),2) + pow(($Lng_origem-$Lng_destino),2));
              if ($i == 0) {
                $d = INFI;
              }
              $distancias2[sizeof($enderecos2)-1][$i]["distancia"] = $d;
              $distancias2[sizeof($enderecos2)-1][$i]["origem"] = $enderecos2[$i]["destino"];
              $distancias2[sizeof($enderecos2)-1][$i]["destino"] = $enderecos2[sizeof($enderecos2)-1]["destino"];
          }
        }

        if ($periodo == 't') {
          // calcular entre os pontos do caminho
          for ($i=0; $i < sizeof($enderecos)-1 ;$i++){
            for ($j=0;$j < sizeof($enderecos);$j++) {
              $LatLng_origem = explode(",", $enderecos[$i]["destino"]);

              if (isset($LatLng_origem[0]))
                $Lat_origem = $LatLng_origem[0];
              if (isset($LatLng_origem[1]))
               $Lng_origem = $LatLng_origem[1];

              $LatLng_destino = explode(",", $enderecos[$j]["destino"]);

              if (isset($LatLng_destino[0]))
                $Lat_destino = $LatLng_destino[0];
              if (isset($LatLng_destino[1]))
                $Lng_destino = $LatLng_destino[1];

              if ($Lat_origem && $Lng_origem && $Lat_destino && $Lng_destino)
                $d = sqrt(pow(($Lat_origem-$Lat_destino),2) + pow(($Lng_origem-$Lng_destino),2));
              if ($i == $j) {
                $d = INFI;
              }
              if ($j == 0) {
                $d = INFI;
              }
              $distancias[$i][$j]['distancia'] = $d;
              $distancias[$i][$j]['origem'] = $enderecos[$i]["destino"];
              $distancias[$i][$j]['destino'] = $enderecos[$j]["destino"];
            }
          }
          // calcular a distancia entre os pontos do caminho e o inicio
          for ($i=0; $i < sizeof($enderecos) ;$i++){
              $LatLng_origem = explode(",", $enderecos[0]["origem"]);

              if (isset($LatLng_origem[0]))
                $Lat_origem = $LatLng_origem[0];
              if (isset($LatLng_origem[1]))
                $Lng_origem = $LatLng_origem[1];

              $LatLng_destino = explode(",", $enderecos[$i]["destino"]);

              if (isset($LatLng_destino[0]))
                $Lat_destino = $LatLng_destino[0];
              if (isset($LatLng_destino[1]))
                $Lng_destino = $LatLng_destino[1];

              if ($Lat_origem && $Lng_origem && $Lat_destino && $Lng_destino)
                $d = sqrt(pow(($Lat_origem-$Lat_destino),2) + pow(($Lng_origem-$Lng_destino),2));
              if ($i == sizeof($enderecos)-1){
                $d = INFI;
              }
              if ($i == 0) {
                $d = INFI;
              }
              $distancias[0][$i]["distancia"] = $d;
              $distancias[0][$i]["origem"] = $enderecos[0]["origem"];
              $distancias[0][$i]["destino"] = $enderecos[$i]["destino"];
          }
          // calcular a distancia entre os pontos do caminho e o destino
          for ($i = 0 ;$i < sizeof($enderecos);$i++){
              $LatLng_origem = explode(",", $enderecos[$i]["destino"]);

              if (isset($LatLng_origem[0]))
                $Lat_origem = $LatLng_origem[0];
              if (isset($LatLng_origem[1]))
                $Lng_origem = $LatLng_origem[1];

              $LatLng_destino = explode(",", $enderecos[sizeof($enderecos)-1]["destino"]);

              if (isset($LatLng_destino[0]))
                $Lat_destino = $LatLng_destino[0];
              if (isset($LatLng_destino[1]))
                $Lng_destino = $LatLng_destino[1];

              if ($Lat_origem && $Lng_origem && $Lat_destino && $Lng_destino)
                $d = sqrt(pow(($Lat_origem-$Lat_destino),2) + pow(($Lng_origem-$Lng_destino),2));
              if ($i == 0) {
                $d = INFI;
              }
              $distancias[sizeof($enderecos)-1][$i]["distancia"] = $d;
              $distancias[sizeof($enderecos)-1][$i]["origem"] = $enderecos[$i]["destino"];
              $distancias[sizeof($enderecos)-1][$i]["destino"] = $enderecos[sizeof($enderecos)-1]["destino"];
          }
        }

       $menor = array();
       $pontos = array();
       if ($periodo == 'a') {
         $pontos2 = array();
         $menor2 = array();
       } else {
         $pontos2 = "";
         $menor2 = "";
       }
        for ($i=0; $i<  sizeof($enderecos)-1; $i++) {
            $menor[$i] = [
                'distancia' => 9999999999,
                'origem' => '',
                'destino' => ''
            ];

        }

        $n = sizeof($distancias)-1;
        $visitados = array();
        $otimizado = array();
        $peso = INFI;

        for($i = 0; $i < sizeof($distancias); $i++){
          if($distancias[0][$i]["distancia"] > 0 && $distancias[0][$i]["distancia"] < $peso){
            $peso = $distancias[0][$i]["distancia"];
            $v2 = $i;
          } 
        }
        $visitados[0] = 0;
        array_push($otimizado, 0);
        $visitados[$v2] = $v2;
        array_push($otimizado, $v2);

        $distancias[0][$v2]["distancia"] = -1;
        $distancias[$v2][0]["distancia"] = -1;

        while(sizeof($visitados) < $n){ 
          $p = INFI;
            foreach ($visitados as $locais) {
              $v = -1;
              $peso2 = INFI;
             
              for($j = 0; $j < sizeof($distancias)-1; $j++){
                if($distancias[$locais][$j]["distancia"] > 0 && $distancias[$locais][$j]["distancia"] < $peso2){
                  if(!in_array($j, $visitados)){
                    $peso2 = $distancias[$locais][$j]["distancia"];
                    $v = $j;  
                  }
                }
              }

              if($v > -1){ 
                $peso = $distancias[$locais][$v]['distancia'];
                if($peso < $p && $peso > 0 && !in_array($v, $visitados)){
                  $v1 = $locais;
                  $v2 = $v;
                  $p = $peso;

                  $distancias[$v1][$v2]["distancia"] = -1; //marco como aresta escolhida
                  $distancias[$v2][$v1]["distancia"] = -1; //fazer isso pq a matriz é simétrica
                  $visitados[$v2] = $v2; //Adiciono os vértices na lista de vértices visitados
                  array_push($otimizado, $v2);
                }
              }             
            }
        }
        array_push($otimizado, sizeof($distancias)-1);

        for ($i = 0; $i < sizeof($distancias)-1; $i++) {
          $indice = $otimizado[$i];
          $proximo = $otimizado[$i+1];
          $menor[$indice]['origem'] = $distancias[$indice][$proximo]['origem'];
          $menor[$indice]['destino'] = $distancias[$indice][$proximo]['destino']; 
          $pontos[$i] = $distancias[$indice][$proximo]["origem"];
          if ($proximo == sizeof($distancias)-1) {
            $pontos[$proximo] = $distancias[$indice][$proximo]["destino"];
          }
        } 

        if ($periodo == 'a') {
            for ($i=0; $i<  sizeof($enderecos2)-1; $i++) {
                $menor2[$i] = [
                    'distancia' => 9999999999,
                    'origem' => '',
                    'destino' => ''
                ];

            }

            $n2 = sizeof($distancias2)-1;
            $visitados2 = array();
            $otimizado2 = array();
            $peso3 = INFI;

            for($i = 0; $i < sizeof($distancias2); $i++){
              if($distancias2[0][$i]["distancia"] > 0 && $distancias2[0][$i]["distancia"] < $peso3){
                $peso3 = $distancias2[0][$i]["distancia"];
                $v2 = $i;
              } 
            }
            $visitados2[0] = 0;
            array_push($otimizado2, 0);
            $visitados2[$v2] = $v2;
            array_push($otimizado2, $v2);

            $distancias2[0][$v2]["distancia"] = -1;
            $distancias2[$v2][0]["distancia"] = -1;

            while(sizeof($visitados2) < $n2){ 
              $p = INFI;
                foreach ($visitados2 as $locais) {
                  $v = -1;
                  $peso4 = INFI;
                 
                  for($j = 0; $j < sizeof($distancias2)-1; $j++){
                    if($distancias2[$locais][$j]["distancia"] > 0 && $distancias2[$locais][$j]["distancia"] < $peso4){
                      if(!in_array($j, $visitados2)){
                        $peso4 = $distancias2[$locais][$j]["distancia"];
                        $v = $j;  
                      }
                    }
                  }

                  if($v > -1){ 
                    $peso3 = $distancias2[$locais][$v]['distancia'];
                    if($peso3 < $p && $peso3 > 0 && !in_array($v, $visitados2)){
                      $v1 = $locais;
                      $v2 = $v;
                      $p = $peso3;

                      $distancias2[$v1][$v2]["distancia"] = -1; //marco como aresta escolhida
                      $distancias2[$v2][$v1]["distancia"] = -1; //fazer isso pq a matriz é simétrica
                      $visitados2[$v2] = $v2; //Adiciono os vértices na lista de vértices visitados
                      array_push($otimizado2, $v2);
                    }
                  }             
                }
            }
            array_push($otimizado2, sizeof($distancias2)-1);

            for ($i = 0; $i < sizeof($distancias2)-1; $i++) {
              $indice = $otimizado2[$i];
              $proximo = $otimizado2[$i+1];
              $menor2[$indice]['origem'] = $distancias2[$indice][$proximo]['origem'];
              $menor2[$indice]['destino'] = $distancias2[$indice][$proximo]['destino']; 
              $pontos2[$i] = $distancias2[$indice][$proximo]["origem"];
              if ($proximo == sizeof($distancias2)-1) {
                $pontos2[$proximo] = $distancias2[$indice][$proximo]["destino"];
              }
            }

            $pontos2 = json_encode($pontos2);
            $menor2 = json_encode($menor2);
        }

        $menor = json_encode($menor);
        $pontos = json_encode($pontos);
    }

?>        
            <div class="row">
              <ol class="breadcrumb">
                <li><a href="index.php">
                  <em class="fa fa-home"></em>
                </a></li>
                <li class="active">Itinerário</li>
              </ol>
            </div>
        <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
            <input type=hidden id="address" value='<?php echo $menor; ?>' />
            <input type="hidden" id="pontos" value='<?php echo $pontos; ?>'/>
            <input type=hidden id="address2" value='<?php echo $menor2; ?>' />
            <input type="hidden" id="pontos2" value='<?php echo $pontos2; ?>'/>
            <h1 class="page-header">Mapa</h1>
				<div id="map" style="height: 500px"></div>
        <div id="map2" style="height: 500px"></div>
        <div id="right-panel"></div>
			</div>
		</div>

<?php include './inc/footer.php'; ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-2bniFa-QuG1YD6Il7TV3SLBYiqXrpQg&callback=initMap"
    async defer></script>
<script type="text/javascript">

function initMap() {
var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
var labelIndex = 0;
var map;
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var infowindow = new google.maps.InfoWindow();

var locations = $("#address").val();
if (locations) {
  locations = jQuery.parseJSON(locations);
}

var pontos = $("#pontos").val();
if (pontos) {
  pontos = jQuery.parseJSON(pontos);
}
  directionsDisplay = new google.maps.DirectionsRenderer({
    polylineOptions: {
      strokeColor: "blue"
    }, suppressMarkers: true
  });


  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 10,
    center: new google.maps.LatLng(-22.331980, -49.029568),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  directionsDisplay.setMap(map);

  var marker, i;
  var request = {
    travelMode: google.maps.TravelMode.DRIVING
  };

  var tamanho = Object.keys(pontos).length;
  for (i = 0; i < tamanho; i++) {
    var ponto = pontos[i].split(",");
    marker = new google.maps.Marker({
      position: new google.maps.LatLng(ponto[0], ponto[1]),
      label: labels[labelIndex++ % labels.length],
      map: map
    });

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
      return function() {
        infowindow.setContent(locations[i][0]);
        infowindow.open(map, marker);
      }
    })(marker, i));

    if (i == 0) {
      request.origin = marker.getPosition();
    } else {
      if (i == locations.length) {
        request.destination = marker.getPosition();
      } else {
        if (!request.waypoints) request.waypoints = [];
        request.waypoints.push({
          location: marker.getPosition(),
          stopover: true
        });
      }
    }

  }
  directionsService.route(request, function(result, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(result);
      var panel = document.getElementById("right-panel");
      var rotas = result.routes[0].legs.length;
      var tempototal = 0;
      var distanciatotal = 0;
      for (i=0;i<rotas;i++) {
        panel.innerHTML += "<li>Caminho "+labels[i % labels.length]+" para "+labels[i+1 % labels.length]+": Distância - "+ result.routes[0].legs[i].distance.text + "; Tempo - "+result.routes[0].legs[i].duration.text+"</li>";

        tempototal += result.routes[0].legs[i].duration.value;
        distanciatotal += result.routes[0].legs[i].distance.value;
      }
      distanciatotal = distanciatotal / 1000;
      distanciatotal = distanciatotal.toFixed(1);

      tempototal = tempototal / 60;
      tempototal = tempototal.toFixed(0);
      panel.innerHTML += "<li> Caminho Total: Distancia - "+distanciatotal+" km; Tempo - "+tempototal+ " minutos</li>" ;
    }
  });


var directionsDisplay2;
var directionsService2 = new google.maps.DirectionsService();

var locations2 = $("#address2").val();
if (locations2) {
  locations2 = jQuery.parseJSON(locations2);
}

var pontos2 = $("#pontos2").val();
if (pontos2) {
  pontos2 = jQuery.parseJSON(pontos2);
}

if (pontos2) {

   var map2 = new google.maps.Map(document.getElementById('map2'), {
    zoom: 10,
    center: new google.maps.LatLng(-22.331980, -49.029568),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });

  directionsDisplay2 = new google.maps.DirectionsRenderer({
    polylineOptions: {
      strokeColor: "red"
    }, suppressMarkers: true
  });

  directionsDisplay2.setMap(map2);

  var marker, i;
  var request = {
    travelMode: google.maps.TravelMode.DRIVING
  };

  var tamanho = Object.keys(pontos2).length;
  for (i = 0; i < tamanho; i++) {
    var ponto = pontos2[i].split(",");
    marker = new google.maps.Marker({
      position: new google.maps.LatLng(ponto[0], ponto[1]),
      label: labels[labelIndex++ % labels.length],
      map: map2
    });

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
      return function() {
        infowindow.setContent(locations2[i][0]);
        infowindow.open(map2, marker);
      }
    })(marker, i));

    if (i == 0) {
      request.origin = marker.getPosition();
    } else {
      if (i == locations2.length) {
        request.destination = marker.getPosition();
      } else {
        if (!request.waypoints) request.waypoints = [];
        request.waypoints.push({
          location: marker.getPosition(),
          stopover: true
        });
      }
    }

  }
  directionsService2.route(request, function(result, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay2.setDirections(result);
      var panel = document.getElementById("right-panel");
      var rotas = result.routes[0].legs.length;
      var tempototal = 0;
      var distanciatotal = 0;
      var j = labelIndex-rotas-1;
      for (i=0;i<rotas;i++) {
        panel.innerHTML += "<li>Caminho "+labels[j % labels.length]+" para "+labels[++j % labels.length]+": Distância - "+ result.routes[0].legs[i].distance.text + "; Tempo - "+result.routes[0].legs[i].duration.text+"</li>";

        tempototal += result.routes[0].legs[i].duration.value;
        distanciatotal += result.routes[0].legs[i].distance.value;
      }
      distanciatotal = distanciatotal / 1000;
      distanciatotal = distanciatotal.toFixed(1);

      tempototal = tempototal / 60;
      tempototal = tempototal.toFixed(0);
      panel.innerHTML += "<li> Caminho Total: Distancia - "+distanciatotal+" km; Tempo - "+tempototal+ " minutos</li>" ;
    }
  });
}
}
</script>


<?php } ?>


