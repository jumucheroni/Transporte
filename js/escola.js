$(document).ready(function(){
  $("#escola-salvar").click(function(){
        if (($("#tipo").val() != "") && ($("#nome").val() != "") && ($("#cep").val() != "") && ($("#logradouro").val() != "") && ($("#numero").val() != "") && ($("#bairro").val() != "") && ($("#estado").val() != "") && ($("#cidade").val() != ""))  {
            $("#cidade").attr("disabled",false);
            $("#estado").attr("disabled",false);
            if ($("#acao").val()=="CADASTRAR"){
                $("#acao").val("SALVARCADASTRO");
                var dados = $("#escola").serialize();
                $("#modal").show();
                $.ajax({
                    url: "salvar_escola.php",
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
                            window.location="visu_escola.php";
                        },2000);
                    }
                });
            }
            if ($("#acao").val()=="ALTERAR"){
                $("#acao").val("SALVARUPDATE");
                var dados = $("#escola").serialize();
                $("#modal").show();
                $.ajax({
                    url: "salvar_escola.php",
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
                            window.location="visu_escola.php";
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
          if (!($("#nome").val() != "")) {
            $("#nome-form").addClass("has-error");
             erro = 1;
          } else {
            $("#nome-form").removeClass("has-error");
          }
          if (!($("#cep").val() != "")) {
            $("#cep-form").addClass("has-error");
             erro = 1;
          } else {
            $("#cep-form").removeClass("has-error");
          }
          if (!($("#logradouro").val() != "")) {
            $("#logradouro-form").addClass("has-error");
             erro = 1;
          } else {
            $("#logradouro-form").removeClass("has-error");
          }
          if (!($("#numero").val() != "")) {
            $("#numero-form").addClass("has-error");
             erro = 1;
          } else {
            $("#numero-form").removeClass("has-error");
          }
          if (!($("#bairro").val() != "")) {
            $("#bairro-form").addClass("has-error");
             erro = 1;
          } else {
            $("#bairro-form").removeClass("has-error");
          }
          if (!($("#estado").val() != "")) {
            $("#estado-form").addClass("has-error");
             erro = 1;
          } else {
            $("#estado-form").removeClass("has-error");
          }
          if (!($("#cidade").val() != "")) {
            $("#cidade-form").addClass("has-error");
             erro = 1;
          } else {
            $("#cidade-form").removeClass("has-error");
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

    $(".dele-escola").click(function(){
        $("#modal").show();
        var id = $(this).attr("id");
        id = id.split("-");
        $("#acao").val("SALVARDELETE");
        var dados = $("#"+id[0]).serialize();
        $.ajax({
            url: "salvar_escola.php",
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
                    window.location="visu_escola.php";
                },2000);
            }
        });
    }); 

    var cep = $("#cep").val();
    if (cep) {
      cep = cep.replace("-","");
      var estado = $("#uf").val();
      var cidade = $("#cid").val();
      carregaestadocidade(cep,estado,cidade);
    }
});