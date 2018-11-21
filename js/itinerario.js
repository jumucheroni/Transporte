$(document).ready(function(){
	$("#gerar").click(function(){
		$("#modal").show();
	});
	 $('input[type=radio][name=relatorio]').change(function() {
          if (this.value == 'T') {
              $("#escolas").hide();
          }
          if (this.value == 'E') {
              $("#escolas").show();
          }
      });

	if ($('input[type=radio][name=relatorio]').val() == 'E'){
		$("#escolas").show();
	}

	 var roteiro = {};
	 var nroteiro = {};
	 var roteirizado = [];
	 var pontos = [];
	 var escolasnoroteiro = [];

	 comboelement = document.getElementById('combo');
	 if (comboelement) {
		 for (i = 0; i< comboelement.length; i++) {
		 	c = comboelement.options[i].value.split("_");
		 	nroteiro[c[0]] = comboelement.options[i].text;
		 }
	}

	 $("#adicionar").click(function(){
	 	var select = $("#combo option:selected").val();
	 	var escola = 0;
	 	var selecionado = 0;
	 	if (select.indexOf('_') > -1) {
	 		select = select.split("_");
	 		selecionado = select[0];
	 		escola = select[1];
	 		if (escola) {
	 			escolasnoroteiro[roteirizado.length] = escola;
	 		}
	 	} else {
	 		selecionado = select;
	 	}
	 	if ((nroteiro[selecionado])) {
	 		$("#roteiro").append("<p id=end"+selecionado+">"+nroteiro[selecionado]+"</p>");
	 		roteiro[selecionado] = nroteiro[selecionado];
	 		nroteiro[selecionado] = "";
	 		roteirizado.push(roteiro[selecionado]);
	 		escolas = $("#enderecosescolas").val();
	 		if (escolas) {
	 			escolas = jQuery.parseJSON(escolas);
	 		}
	 		escolas2 = $("#enderecos2escolas").val();
	 		if (escolas2) {
	 			escolas2 = jQuery.parseJSON(escolas2);
	 		}
	 		periodo = $("#periodo").val(); 
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
				 			maparoteiro(roteirizado,pontos,escolas,escolas2,periodo,escolasnoroteiro);
				 		}
                    }
                });
	 	} else {
	 		alert("Ponto já incluído");
	 	}
	 });
	 $("#remover").click(function(){
	 	var select = $("#combo option:selected").val();
	 	var escola = 0;
	 	var selecionado = 0;
	 	if (select.indexOf('_') > -1) {
	 		select = select.split("_");
	 		selecionado = select[0];
	 		escola = select[1];
	 		if (escola > 0) {
	 			for (i = 0; i< escolasnoroteiro.length; i++) {
	 				if (escolasnoroteiro[i] == escola) {
	 					escolasnoroteiro.splice(i,1);
	 				}
	 			}
	 		} else {
	 			for (i = 0; i < roteirizado.length; i++) {
	 				if (roteirizado[i] === roteiro[selecionado]) {
	 					indice = i;
	 				}
	 			}
	 			for (i = 0; i< escolasnoroteiro.length; i++) {
	 				if (indice < i){
	 					escolasnoroteiro[i-1] = escolasnoroteiro[i];
	 					escolasnoroteiro.splice(i,1);
	 					i = escolasnoroteiro.length;
	 				}
	 				if (indice == i) {
	 					escolasnoroteiro.splice(i,1);
	 				}
	 			}
	 		}
	 	} else {
	 		selecionado = select;
	 	}
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
	 		escolas = $("#enderecosescolas").val();
	 		if (escolas) {
	 			escolas = jQuery.parseJSON(escolas);
	 		}
	 		escolas2 = $("#enderecos2escolas").val();
	 		if (escolas2) {
	 			escolas2 = jQuery.parseJSON(escolas2);
	 		}
	 		periodo = $("#periodo").val(); 
	 		if (roteirizado.length > 1) {
	 			maparoteiro(roteirizado,pontos,escolas,escolas2,periodo,escolasnoroteiro);
	 		}

	 	} else {
	 		alert("Ponto não está no roteiro");
	 	}
	 });



	 function maparoteiro(roteiro,pontoslatlong,escolas = null, escolas2 = null, periodo = null, escolasnoroteiro = null) {
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
		      var panel = document.getElementById("panel");
		      panel.innerHTML = ""; 
		      var rotas = result.routes[0].legs.length;
		      var tempototal = 0;
		      var distanciatotal = 0;
		      var j = labelIndex-rotas-1;
		      var hIni,hIni2,timetotal,timetotal2;
		      console.log(escolasnoroteiro);
		      for (i=0;i<rotas;i++) {
		        panel.innerHTML += "<p>Caminho "+labels[j % labels.length]+" - "+result.routes[0].legs[i].start_address+"  para "+labels[++j % labels.length]+" - "+result.routes[0].legs[i].end_address+": Distância - "+ result.routes[0].legs[i].distance.text + "; Tempo - "+result.routes[0].legs[i].duration.text+"</p>";

		        tempototal += result.routes[0].legs[i].duration.value;
		        distanciatotal += result.routes[0].legs[i].distance.value;

		        if (escolasnoroteiro[i+1] > 0) {
		        	if (periodo == 'm' || periodo == 'a') {
				        if (periodo == 'm') {
				          for (p = 0; p < escolas.length; p++) {
				          	if (escolas[p]['escola'] == escolasnoroteiro[i+1]) {
				          		hIni = escolas[p]['horario'][0].split(':'); 
				          		esc = escolas[p]['completo'].split(" - ");
				          	}
				          }
				        }
				        if (periodo == 'a') {
				          for (p = 0; p < escolas.length; p++) {
				          	if (escolas[p]['escola'] == escolasnoroteiro[i+1]) {
				          		hIni = escolas[p]['horario'][2].split(':'); 
				          		esc = escolas[p]['completo'].split(" - ");
				          	}
				          }
				          for (q = 0; q < escolas.length; q++) {
				          	if (escolas[q]['escola'] == escolasnoroteiro[i+1]) {
				          		hIni2 = escolas[q]['horario'][1].split(':'); 
				          		esc2 = escolas[q]['completo'].split(" - ");
				          	}
				          }
				        }
				        if (hIni) {
					        minutosTotal = parseInt(hIni[1], 10) - parseInt(tempototal / 60); 
					        horasTotal = parseInt(hIni[0], 10); 
					        if(minutosTotal < 0)
					        { 
					          minutosTotal += 60; 
					          horasTotal -= 1; 
					        }
					        if (minutosTotal < 10) {
					          minutosTotal = "0"+minutosTotal;
					        }
					        if (horasTotal < 10) {
					          horasTotal = "0"+horasTotal;
					        }
					        timetotal = horasTotal+":"+minutosTotal;
					    }
				        if (hIni2) {
				        	minutosTotal2 = parseInt(hIni2[1], 10) - parseInt(tempototal / 60); 
					        horasTotal2 = parseInt(hIni2[0], 10); 
					        if(minutosTotal2 < 0)
					        { 
					          minutosTotal2 += 60; 
					          horasTotal2 -= 1; 
					        }
					        if (minutosTotal2 < 10) {
					          minutosTotal2 = "0"+minutosTotal2;
					        }
					        if (horasTotal2 < 10) {
					          horasTotal2 = "0"+horasTotal2;
					        }
					        timetotal2 = horasTotal2+":"+minutosTotal2;
					    }
				        if (timetotal) {
				        	panel.innerHTML += "<p> Para chegar na escola "+esc[0]+" no horário da entrada o condutor deve sair no máximo: "+timetotal+ " </p>" ;
		        		} 
		        		if (timetotal2) {
		        			panel.innerHTML += "<p> Para chegar na escola "+esc2[0]+" no horário da saída o condutor deve sair no máximo: "+timetotal2+ " </p>" ;
		        		}
		        	}
		        	if (periodo == 't') {
				        for (p = 0; p < escolas.length; p++) {
				          	if (escolas[p]['escola'] == escolasnoroteiro[i+1]) {
				          		hIni = escolas[p]['horario'][3].split(':'); 
				          		esc = escolas[p]['completo'].split(" - ");
				          	}
				        }
				        minutosTotal = parseInt(hIni[1], 10) - parseInt(tempototal / 60); 
				        horasTotal = parseInt(hIni[0], 10); 
				        if(minutosTotal < 0)
				        { 
				          minutosTotal += 60; 
				          horasTotal -= 1; 
				        }
				        if (minutosTotal < 10) {
				          minutosTotal = "0"+minutosTotal;
				        }
				        if (horasTotal < 10) {
				          horasTotal = "0"+horasTotal;
				        }
				        timetotal = horasTotal+":"+minutosTotal;
				        panel.innerHTML += "<p> Para chegar na escola "+esc[0]+" no horário da saída o condutor deve sair no máximo: "+timetotal+ " </p>" ;
		        	}
		      	}
		      }
		      distanciatotal = distanciatotal / 1000;
		      distanciatotal = distanciatotal.toFixed(1);

		      tempototal = tempototal / 60;
		      tempototal = tempototal.toFixed(0);
		      panel.innerHTML += "<p> Caminho Total: Distancia - "+distanciatotal+" km; Tempo - "+tempototal+ " minutos</p>" ;
		    }
		  });
		}
	 }

	function export_to_pdf() {
		var	roteiro = $("#panel").html();
		var img = $("#show_img").html();
		var condutor = $("#condutor").val();
		var ajudante = $("#ajudante").val();
		$.ajax({
            url: "downloadpdf.php",
            type: "post",
            data: {
            	'html': roteiro,
            	'img': img,
            	'condutor': condutor,
            	'ajudante': ajudante
            },
            success: function(result){
            	window.open("http://localhost/Transporte/"+result,'_blank');
            }
        });
	}

	$("#epdf").click(function() { 
        html2canvas($("#maproteiros"), {
	        useCORS: true,
	        onrendered: function (canvas) {
					
		        var img = canvas.toDataURL("image/png");

	          $('#img_val').val(canvas.toDataURL("image/png"));
	          $('#show_img').html("");
		        $("#show_img").append('<img src="' + img + '"/>');
		        $("#show_img").hide();
		       export_to_pdf();
	        }
	    });
    });

    $("#epdf_otimizado").click(function() { 
        html2canvas($("#maps"), {
	        useCORS: true,
	        onrendered: function (canvas) {
					
		        var img = canvas.toDataURL("image/png");

	          $('#img_val').val(canvas.toDataURL("image/png"));
	          $('#show_img').html("");
		        $("#show_img").append('<img src="' + img + '"/>');
		        $("#show_img").hide();
		        export_to_pdf();
	        }
	    });
    });
});
