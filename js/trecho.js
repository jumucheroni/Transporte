$(document).ready(function(){
	$("#trecho-salvar").click(function(){
        if (($("#tipo").val() != "") && ($("#crianca").val() != "") && ($("#conducao").val() != "") && ($("#cep_origem").val() != "") && ($("#logradouro_origem").val() != "") && ($("#numero_origem").val() != "") && ($("#bairro_origem").val() != "") && ($("#estado_origem").val() != "") && ($("#cidade_origem").val() != "") && ($("#cep_destino").val() != "") && ($("#logradouro_destino").val() != "") && ($("#numero_destino").val() != "") && ($("#bairro_destino").val() != "") && ($("#estado_destino").val() != "") && ($("#cidade_destino").val() != ""))  {
            $("#cidade").attr("disabled",false);
            $("#estado").attr("disabled",false);
            $("#tipo").attr("disabled",false);
            if ($("#acao").val()=="CADASTRAR"){
                $("#acao").val("SALVARCADASTRO");
                var dados = $("#trecho").serialize();
                $("#modal").show();
                $.ajax({
                    url: "salvar_trecho.php",
                    type: "post",
                    dataType: "json",
                    data: dados,
                    success: function(result){
                        $("#modal").hide();
                        if (result.success){
                            $("#alert").html('<div class="alert bg-success" role="alert">'+result.mensagem+'<a type="button" id="close-alert" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');
                        } else {
                            $("#alert").html('<div class="alert bg-danger" role="alert">'+result.mensagem+'<a type="button" id="close-alert" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');  
                        }
                        $("#alert").show();
                        setTimeout(function(){
                            $("#alert").hide();
                            window.location="visu_trecho.php";
                        },2000);
                    }
                });
            }
            if ($("#acao").val()=="ALTERAR"){
                $("#acao").val("SALVARUPDATE");
                var dados = $("#trecho").serialize();
                $("#modal").show();
                $.ajax({
                    url: "salvar_trecho.php",
                    type: "post",
                    dataType: "json",
                    data: dados,
                    success: function(result){
                        $("#modal").hide();
                        if (result.success){
                            $("#alert").html('<div class="alert bg-success" role="alert">'+result.mensagem+'<a type="button" id="close-alert" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');
                        } else {
                            $("#alert").html('<div class="alert bg-danger" role="alert">'+result.mensagem+'<a type="button" id="close-alert" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');  
                        }
                        $("#alert").show();
                        setTimeout(function(){
                            $("#alert").hide();
                            window.location="visu_trecho.php";
                        },2000);
                    }
                });
            }
        } else {
        	var erro = 0;
        	if (!($("#tipo").val() != "")) {
        		$("#tipo-form").addClass("has-error");
	           erro = 1;
        	} else {
                $("#tipo-form").removeClass("has-error");
            }
        	if (!($("#crianca").val() != "")) {
        		$("#crianca-form").addClass("has-error");
	           erro = 1;
        	} else {
                $("#crianca-form").removeClass("has-error");
            }
            if (!($("#conducao").val() != "")) {
                $("#conducao-form").addClass("has-error");
               erro = 1;
            } else {
                $("#conducao-form").removeClass("has-error");
            }
        	if (!($("#cep_origem").val() != "")) {
        		$("#cep_origem-form").addClass("has-error");
	           erro = 1;
        	} else {
                $("#cep_origem-form").removeClass("has-error");
            }
        	if (!($("#logradouro_origem").val() != "")) {
        		$("#logradouro_origem-form").addClass("has-error");
	           erro = 1;
        	} else {
                $("#logradouro_origem-form").removeClass("has-error");
            }
        	if (!($("#numero_origem").val() != "")) {
        		$("#numero_origem-form").addClass("has-error");
	           erro = 1;
        	} else {
                $("#numero_origem-form").removeClass("has-error");
            }
        	if (!($("#bairro_origem").val() != "")) {
        		$("#bairro_origem-form").addClass("has-error");
	           erro = 1;
        	} else {
                $("#bairro_origem-form").removeClass("has-error");
            }
        	if (!($("#estado_origem").val() != "")) {
        		$("#estado_origem-form").addClass("has-error");
	           erro = 1;
        	} else {
                $("#estado_origem-form").removeClass("has-error");
            }
        	if (!($("#cidade_origem").val() != "")) {
        		$("#cidade_origem-form").addClass("has-error");
	           erro = 1;
        	} else {
                $("#cidade_origem-form").removeClass("has-error");
            }
            if (!($("#cep_destino").val() != "")) {
                $("#cep_destino-form").addClass("has-error");
               erro = 1;
            } else {
                $("#cep_destino-form").removeClass("has-error");
            }
            if (!($("#logradouro_destino").val() != "")) {
                $("#logradouro_destino-form").addClass("has-error");
               erro = 1;
            } else {
                $("#logradouro_destino-form").removeClass("has-error");
            }
            if (!($("#numero_destino").val() != "")) {
                $("#numero_destino-form").addClass("has-error");
               erro = 1;
            } else {
                $("#numero_destino-form").removeClass("has-error");
            }
            if (!($("#bairro_destino").val() != "")) {
                $("#bairro_destino-form").addClass("has-error");
               erro = 1;
            } else {
                $("#bairro_destino-form").removeClass("has-error");
            }
            if (!($("#estado_destino").val() != "")) {
                $("#estado_destino-form").addClass("has-error");
               erro = 1;
            } else {
                $("#estado_destino-form").removeClass("has-error");
            }
            if (!($("#cidade_destino").val() != "")) {
                $("#cidade_destino-form").addClass("has-error");
               erro = 1;
            } else {
                $("#cidade_destino-form").removeClass("has-error");
            }
        	if (erro) {
                $("#alert").html('<div class="alert bg-danger" role="alert"> Existem campos obrigatorios preenchidos incorretamente <a type="button" id="close-alert" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');
                $("#alert").show();
                setTimeout(function(){
                    $("#alert").hide();
                },2000);
            }
        }       
    });

    $(".dele-trecho").click(function(){
        $("#modal").show();
        var id = $(this).attr("id");
        id = id.split("-");
        $("#acao").val("SALVARDELETE");
        var dados = $("#"+id[0]).serialize();
        $.ajax({
            url: "salvar_trecho.php",
            type: "post",
            dataType: "json",
            data: dados,
            success: function(result){
                $("#modal").hide();
                if (result.success){
                    $("#alert").html('<div class="alert bg-success" role="alert">'+result.mensagem+'<a type="button" id="close-alert" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');
                } else {
                    $("#alert").html('<div class="alert bg-danger" role="alert">'+result.mensagem+'<a type="button" id="close-alert" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');  
                }
                $("#alert").show();
                setTimeout(function(){
                    $("#alert").hide();
                    window.location="visu_trecho.php";
                },2000);
            }
        });
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
                        $("#alert").html('<div class="alert bg-danger" role="alert"> CEP não encontrado <a type="button" id="close-alert" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');
                        $("#alert").show();
                        setTimeout(function(){
                            $("#alert").hide();
                        },2000);
                    }
                });
            } 
            else {
                limpa_formulário_cep_origem();
                $("#alert").html('<div class="alert bg-danger" role="alert"> Formato de CEP inválido <a type="button" id="close-alert" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');
                $("#alert").show();
                setTimeout(function(){
                    $("#alert").hide();
                },2000);
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
                        $("#alert").html('<div class="alert bg-danger" role="alert"> CEP não encontrado <a type="button" id="close-alert" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');
                        $("#alert").show();
                        setTimeout(function(){
                            $("#alert").hide();
                        },2000);
                    }
                });
            } 
            else {
                limpa_formulário_cep_destino();
                $("#alert").html('<div class="alert bg-danger" role="alert"> Formato de CEP inválido <a type="button" id="close-alert" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');
                $("#alert").show();
                setTimeout(function(){
                    $("#alert").hide();
                },2000);
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
                $("#alert").html('<div class="alert bg-danger" role="alert"> CEP não encontrado <a type="button" id="close-alert" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');
                $("#alert").show();
                setTimeout(function(){
                    $("#alert").hide();
                },2000);
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
                $("#alert").html('<div class="alert bg-danger" role="alert"> CEP não encontrado <a type="button" id="close-alert" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');
                $("#alert").show();
                setTimeout(function(){
                    $("#alert").hide();
                },2000);
            }
        });
    }

    var cep_origem = $("#cep_origem").val();
    if (cep_origem) {
      cep_origem = cep_origem.replace("-","");
      var estado_origem = $("#uf_origem").val();
      var cidade_origem = $("#cid_origem").val();
      carregaestadocidade_origem(cep_origem,estado_origem,cidade_origem);
    }

    var cep_destino = $("#cep_destino").val();
    if (cep_destino) {
      cep_destino = cep_destino.replace("-","");
      var estado_destino = $("#uf_destino").val();
      var cidade_destino = $("#cid_destino").val();
      carregaestadocidade_destino(cep_destino,estado_destino,cidade_destino);
    }
});