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

       $pontos = array();
       $pontos2 = array();

      for ($i = 0; $i < sizeof($enderecos)-1; $i++) {
        $pontos[$i] = $enderecos[$i]["origem"];
        if ($i+1 == sizeof($enderecos)-1) {
          $pontos[$i+1] = $enderecos[$i]["destino"];
        }
      } 

      if ($periodo == 'a') {

        for ($i = 0; $i < sizeof($enderecos2)-1; $i++) {
          $pontos2[$i] = $enderecos2[$i]["origem"];
          if ($i+1 == sizeof($enderecos2)-1) {
            $pontos2[$i+1] = $enderecos2[$i]["destino"];
          }
        } 
               
      }

        $pontos = json_encode($pontos);
        $pontos2 = json_encode($pontos2);


    }

    if ($tipo == "T") {

        $sql = "select t.id as id_trecho,t.tipo as Tipo,c.nome as Crianca,c.id as id_crianca,o.nome as Condutor,v.placa as Veiculo,  
        CONCAT(t.cep_origem,',',t.logradouro_origem,',',t.numero_origem,',',t.cidade_origem,',',t.estado_origem) as origem,
        CONCAT(t.cep_destino,',',t.logradouro_destino,',',t.numero_destino,',',t.cidade_destino,',',t.estado_destino) as destino,c.id_escola as escola from criancatrecho ct
        inner join crianca c on c.id = ct.id_crianca
        inner join condutor o on o.cpf = ct.cpf_condutor
        inner join veiculo v on v.placa = ct.placa_veiculo
        inner join trecho t on t.id = ct.id_trecho
        where ct.deletado ='N'".$periodo_conducao." and v.placa = '".$veiculo."'
        order by c.id_escola";
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
                'tipo' => $row["Tipo"],
                'escola' =>$row['escola']
              ];
              $cont2++;
            } else {
              $enderecos[$cont] = [
                'origem' => $LatLng_origem,
                'destino' => $LatLng_destino,
                'tipo' => $row["Tipo"],
                'escola' =>$row['escola']
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

       $pontos = array();
       $pontosfinal = array();
       $pontos2 = array();
       $pontosfinal2 = array();

      for ($i = 0; $i < sizeof($enderecos)-1; $i++) {
        $pontos[$i]['endereco'] = $enderecos[$i]["origem"];
        $pontos[$i]['escola'] = $enderecos[$i]['escola'];
        if ($enderecos[$i]['destino'] != $enderecos[sizeof($enderecos)-1]["destino"]) {
          $pontosfinal[]['endereco'] = $enderecos[$i]['destino'];
          $pontos[]['escola'] = 0;
        }
        if ($i+1 == sizeof($enderecos)-1) {
          $pontosfinal[] = $enderecos[$i+1]["destino"];
          $pontosfinal[]['escola'] = $enderecos[$i+1]['escola'];
        }
      } 

      if ($periodo == 'a') {

        for ($i = 0; $i < sizeof($enderecos2)-1; $i++) {
          $pontos2[$i] = $enderecos2[$i]["origem"];
          if ($i+1 == sizeof($enderecos2)-1) {
            $pontos2[$i+1] = $enderecos2[$i]["destino"];
          }
        } 
               
      }

        $pontos = json_encode($pontos);
        $pontosfinal = json_encode($pontosfinal);
        $pontos2 = json_encode($pontos2);


    }

?>        
            <div class="row">
              <ol class="breadcrumb">
                <li><a href="index.php">
                  <em class="fa fa-home"></em>
                </a></li>
                <li class="active">Mapa de Pontos</li>
              </ol>
            </div>
        <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
            <input type="hidden" id="pontos" value='<?php echo $pontos; ?>'/>
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
  }

var directionsDisplay2;
var directionsService2 = new google.maps.DirectionsService();

var pontos2 = $("#pontos2").val();
if (pontos2) {
  pontos2 = jQuery.parseJSON(pontos2);
}
if (pontos2.length) {
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
  }
}
}
</script>


<?php } ?>


