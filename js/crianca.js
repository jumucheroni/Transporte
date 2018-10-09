$(document).ready(function(){
  $("#crianca-salvar").click(function(){
        if (($("#nome").val() != "") && ($("#cpf_responsavel").val() != "") && ($("#n_ident_escola").val() != "") && ($("#data_nascimento").val() != "")) {
            if ($("#acao").val()=="CADASTRAR"){
                $("#acao").val("SALVARCADASTRO");
                var dados = $("#crianca").serialize();
                $("#modal").show();
                $.ajax({
                    url: "salvar_crianca.php",
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
                            window.location="visu_crianca.php";
                        },2000);
                    }
                });
            }
            if ($("#acao").val()=="ALTERAR"){
                $("#acao").val("SALVARUPDATE");
                var dados = $("#crianca").serialize();
                $("#modal").show();
                $.ajax({
                    url: "salvar_crianca.php",
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
                            window.location="visu_crianca.php";
                        },2000);
                    }
                });
            }
        } else {
          var erro = 0;
          if (!($("#nome").val() != "")) {
              $("#nome-form").addClass("has-error");
              erro = 1;
          } else {
              $("#nome-form").removeClass("has-error");
          }
          if (!($("#cpf_responsavel").val() != "")) {
              $("#cpf_responsavel-form").addClass("has-error");
              erro = 1;
          } else {
              $("#cpf_responsavel-form").removeClass("has-error");
          }
          if (!($("#n_ident_escola").val() != "")) {
              $("#n_ident_escola-form").addClass("has-error");
              erro = 1;
          } else {
              $("#n_ident_escola-form").removeClass("has-error");
          }
          if (!($("#data_nascimento").val() != "")) {
              $("#data_nascimento-form").addClass("has-error");
              erro = 1;
          } else {
              $("#data_nascimento-form").removeClass("has-error");
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

    $(".dele-crianca").click(function(){
        $("#modal").show();
        var id = $(this).attr("id");
        id = id.split("-");
        $("#acao").val("SALVARDELETE");
        var dados = $("#"+id[0]).serialize();
        $.ajax({
            url: "salvar_crianca.php",
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
                    window.location="visu_crianca.php";
                },2000);
            }
        });
    }); 
});