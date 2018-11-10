$(document).ready(function(){
	 $('input[type=radio][name=relatorio]').change(function() {
          if (this.value == 'T') {
              $("#escolas").hide();
          }
          if (this.value == 'E') {
              $("#escolas").show();
          }
      });

	 var roteiro = {};
	 var nroteiro = {};
	 var roteirizado = [];
	 var pontos = [];

	 comboelement = document.getElementById('combo');
	 if (comboelement) {
		 for (i = 0; i< comboelement.length; i++) {
		 	nroteiro[comboelement.options[i].value] = comboelement.options[i].text;
		 }
	}

	 $("#adicionar").click(function(){
	 	var selecionado = $("#combo option:selected").val();
	 	if ((nroteiro[selecionado])) {
	 		$("#roteiro").append("<p id=end"+selecionado+">"+nroteiro[selecionado]+"</p>");
	 		roteiro[selecionado] = nroteiro[selecionado];
	 		nroteiro[selecionado] = "";
	 		roteirizado.push(roteiro[selecionado]);
	 		$.ajax({
                    url: "geo.php",
                    type: "post",
                    dataType: "json",
                    data: {
                    	'roteiro':roteirizado[roteirizado.length-1]
                    },
                    success: function(result){
                    	if (result) {
                       		pontos[roteirizado.length-1] = result;
                       	}
				 		if (roteirizado.length > 1) {
				 			maparoteiro(roteirizado,pontos);
				 		}
                    }
                });
	 	} else {
	 		alert("Ponto já incluído");
	 	}
	 });
	 $("#remover").click(function(){
	 	var selecionado = $("#combo option:selected").val();
	 	if ((roteiro[selecionado])) {
	 		$("#end"+selecionado).remove();
	 		for (i = 0; i < roteirizado.length; i++) {
	 			if (roteirizado[i] === roteiro[selecionado]) {
	 				roteirizado.splice(i,1);
	 				pontos.splice(i,1);
	 			}
	 		}
	 		nroteiro[selecionado] = roteiro[selecionado];
	 		roteiro[selecionado] = "";
	 		if (roteirizado.length > 1) {
	 			maparoteiro(roteirizado,pontos);
	 		}

	 	} else {
	 		alert("Ponto não está no roteiro");
	 	}
	 });



	 function maparoteiro(roteiro,pontoslatlong) {
	 	var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		var pinColor = ['000080','FFFF00','00CED1','CD5C5C','006400','2E8B57']
		var labelIndex = 0;
		var map;
		var directionsDisplay;
		var directionsService = new google.maps.DirectionsService();
		var infowindow = new google.maps.InfoWindow();

		var pontos = roteiro;
		
		  directionsDisplay = new google.maps.DirectionsRenderer({
		    polylineOptions: {
		      strokeColor: "blue"
		    }, suppressMarkers: true
		  });
		if (pontos.length){
		  var map = new google.maps.Map(document.getElementById('maproteiros'), {
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
		  for (var i = 0; i < tamanho; i++) {
			marker = new google.maps.Marker({
		      position: new google.maps.LatLng(pontoslatlong[i][0]["lat"], pontoslatlong[i][0]["long"]),
		      label: labels[labelIndex++ % labels.length],
	  		  map: map
		    });

		    google.maps.event.addListener(marker, 'click', (function(marker, i) {
		      return function() {
		        infowindow.setContent(pontos[i]);
		        infowindow.open(map, marker);
		      }
		    })(marker, i));

		    if (i == 0) {
		      request.origin = marker.getPosition();
		    } else {
		      if (i == tamanho-1) {
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
});
