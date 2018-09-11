$(document).ready(function(){
	$("#trecho-salvar").click(function(){
        if (($("#tipo").val() != "") && ($("#crianca").val() != "") && ($("#conducao").val() != "") && ($("#cep_origem").val() != "") && ($("#logradouro_origem").val() != "") && ($("#numero_origem").val() != "") && ($("#bairro_origem").val() != "") && ($("#estado_origem").val() != "") && ($("#cidade_origem").val() != "") && ($("#cep_destino").val() != "") && ($("#logradouro_destino").val() != "") && ($("#numero_destino").val() != "") && ($("#bairro_destino").val() != "") && ($("#estado_destino").val() != "") && ($("#cidade_destino").val() != ""))  {
            if ($("#acao").val()=="CADASTRAR"){
              	$("#acao").val("SALVARCADASTRO");
            }
            if ($("#acao").val()=="ALTERAR"){
              	$("#acao").val("SALVARUPDATE");
            }
	        $("#cidade").attr("disabled",false);
	        $("#estado").attr("disabled",false);
            $("#tipo").attr("disabled",false);
            $( "#trecho" ).submit();
        } else {
        	var erro = 0;
        	if (!($("#tipo").val() != "")) {
        		//colocar a borda vermelha no campo
	           erro = 1;
        	}
        	if (!($("#crianca").val() != "")) {
        		//colocar a borda vermelha no campo
	           erro = 1;
        	}
            if (!($("#conducao").val() != "")) {
                //colocar a borda vermelha no campo
               erro = 1;
            }
        	if (!($("#cep_origem").val() != "")) {
        		//colocar a borda vermelha no campo
	           erro = 1;
        	}
        	if (!($("#logradouro_origem").val() != "")) {
        		//colocar a borda vermelha no campo
	           erro = 1;
        	}
        	if (!($("#numero_origem").val() != "")) {
        		//colocar a borda vermelha no campo
	           erro = 1;
        	}
        	if (!($("#bairro_origem").val() != "")) {
        		//colocar a borda vermelha no campo
	           erro = 1;
        	}
        	if (!($("#estado_origem").val() != "")) {
        		//colocar a borda vermelha no campo
	           erro = 1;
        	}
        	if (!($("#cidade_origem").val() != "")) {
        		//colocar a borda vermelha no campo
	           erro = 1;
        	}
            if (!($("#cep_destino").val() != "")) {
                //colocar a borda vermelha no campo
               erro = 1;
            }
            if (!($("#logradouro_destino").val() != "")) {
                //colocar a borda vermelha no campo
               erro = 1;
            }
            if (!($("#numero_destino").val() != "")) {
                //colocar a borda vermelha no campo
               erro = 1;
            }
            if (!($("#bairro_destino").val() != "")) {
                //colocar a borda vermelha no campo
               erro = 1;
            }
            if (!($("#estado_destino").val() != "")) {
                //colocar a borda vermelha no campo
               erro = 1;
            }
            if (!($("#cidade_destino").val() != "")) {
                //colocar a borda vermelha no campo
               erro = 1;
            }
        	if (erro) {
        		alert("Existem campos obrigatorios preenchidos incorretamente");
        	}
        }       
    });

    $("#conducao").change(function(){
        var conducao = ($("#conducao").val());
        conducao = conducao.split(';');
        $("#tipo").val(conducao[2]);
    });

     // Limpa valores do formulário de cep.
    function limpa_formulário_cep_origem() {
        $("#cep_origem").val("");
        $("#logradouro_origem").val("");
        $("#bairro_origem").val("");
        $("#cidade_origem").val("");
        $("#estado_origem").val("");
        $("#cidade_origem").html("");

        $("#cidade_origem").attr("disabled",false);
        $("#estado_origem").attr("disabled",false);
    }

    $("#cep_origem").blur(function() {
        var cep = $(this).val().replace(/\D/g, '');

        if (cep != "") {
            var validacep = /^[0-9]{8}$/;

            if(validacep.test(cep)) {
                $("#logradouro_origem").val("...");
                $("#bairro_origem").val("...");
                $("#cidad_origeme").val("...");
                $("#estado_origem").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                    if (!("erro" in dados)) {
                        $.getJSON('estados_cidades.json', function (data) {
        
                            var options_cidades = '';
                            var str = "";                   
                            
                            $("#estado_origem option:selected").each(function () {
                                str += $(this).text();
                            });
                            
                            $.each(data, function (key, val) {
                                if(val.nome == str) {                           
                                    $.each(val.cidades, function (key_city, val_city) {
                                        if (val_city == dados.localidade){
                                            options_cidades += '<option selected="true" value="' + val_city + '">' + val_city + '</option>';
                                        } else {
                                            options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
                                        }
                                    });                         
                                }
                            });
                            $("#cidade_origem").html(options_cidades);
                        });

                        $("#logradouro_origem").val(dados.logradouro);
                        $("#bairro_origem").val(dados.bairro);
                        $("#cidade_origem").val(dados.localidade);
                        $("#estado_origem").val(dados.uf);

                        $("#cidade_origem").attr("disabled",true);
                        $("#estado_origem").attr("disabled",true);
                                
                    } 
                    else {
                        limpa_formulário_cep_origem();
                        alert("CEP não encontrado.");
                    }
                });
            } 
            else {
                limpa_formulário_cep_origem();
                alert("Formato de CEP inválido.");
            }
        } 
        else {
            limpa_formulário_cep_origem();
        }
    });

    // Limpa valores do formulário de cep.
    function limpa_formulário_cep_destino() {
        $("#cep_destino").val("");
        $("#logradouro_destino").val("");
        $("#bairro_destino").val("");
        $("#cidade_destino").val("");
        $("#estado_destino").val("");
        $("#cidade_destino").html("");

        $("#cidade_destino").attr("disabled",false);
        $("#estado_destino").attr("disabled",false);
    }

    $("#cep_destino").blur(function() {
        var cep = $(this).val().replace(/\D/g, '');

        if (cep != "") {
            var validacep = /^[0-9]{8}$/;

            if(validacep.test(cep)) {
                $("#logradouro_destino").val("...");
                $("#bairro_destino").val("...");
                $("#cidad_destinoe").val("...");
                $("#estado_destino").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                    if (!("erro" in dados)) {
                        $.getJSON('estados_cidades.json', function (data) {
        
                            var options_cidades = '';
                            var str = "";                   
                            
                            $("#estado_destino option:selected").each(function () {
                                str += $(this).text();
                            });
                            
                            $.each(data, function (key, val) {
                                if(val.nome == str) {                           
                                    $.each(val.cidades, function (key_city, val_city) {
                                        if (val_city == dados.localidade){
                                            options_cidades += '<option selected="true" value="' + val_city + '">' + val_city + '</option>';
                                        } else {
                                            options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
                                        }
                                    });                         
                                }
                            });
                            $("#cidade_destino").html(options_cidades);
                        });

                        $("#logradouro_destino").val(dados.logradouro);
                        $("#bairro_destino").val(dados.bairro);
                        $("#cidade_destino").val(dados.localidade);
                        $("#estado_destino").val(dados.uf);

                        $("#cidade_destino").attr("disabled",true);
                        $("#estado_destino").attr("disabled",true);
                                
                    } 
                    else {
                        limpa_formulário_cep_destino();
                        alert("CEP não encontrado.");
                    }
                });
            } 
            else {
                limpa_formulário_cep_destino();
                alert("Formato de CEP inválido.");
            }
        } 
        else {
            limpa_formulário_cep_destino();
        }
    });

    window.carregaestadocidade_origem = function(cep,estado,cidade) {   
        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
            if (!("erro" in dados)) {
                $.getJSON('estados_cidades.json', function (data) {

                    var options_cidades = '';
                    var str = "";                   
                    
                    $("#estado_origem option:selected").each(function () {
                        str += $(this).text();
                    });
                    
                    $.each(data, function (key, val) {
                        if(val.nome == str) {                           
                            $.each(val.cidades, function (key_city, val_city) {
                                if (val_city == dados.localidade){
                                    options_cidades += '<option selected="true" value="' + val_city + '">' + val_city + '</option>';
                                } else {
                                    options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
                                }
                            });                         
                        }
                    });
                    $("#cidade_origem").html(options_cidades);
                });

                $("#estado_origem").val(dados.uf);                     
            } 
            else {
                limpa_formulário_cep();
                alert("CEP não encontrado.");
            }
        });
    }

    window.carregaestadocidade_destino = function(cep,estado,cidade) {   
        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
            if (!("erro" in dados)) {
                $.getJSON('estados_cidades.json', function (data) {

                    var options_cidades = '';
                    var str = "";                   
                    
                    $("#estado_destino option:selected").each(function () {
                        str += $(this).text();
                    });
                    
                    $.each(data, function (key, val) {
                        if(val.nome == str) {                           
                            $.each(val.cidades, function (key_city, val_city) {
                                if (val_city == dados.localidade){
                                    options_cidades += '<option selected="true" value="' + val_city + '">' + val_city + '</option>';
                                } else {
                                    options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
                                }
                            });                         
                        }
                    });
                    $("#cidade_destino").html(options_cidades);
                });

                $("#estado_destino").val(dados.uf);                     
            } 
            else {
                limpa_formulário_cep();
                alert("CEP não encontrado.");
            }
        });
    }
});