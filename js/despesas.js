$(document).ready(function(){
  $("#despesa-salvar").click(function(){
        if (($("#placa_veiculo").val() != "") && ($("#data_gasto").val() != "") && ($("#valor_gasto").val() != "") && ($("#tipo").val() != "")) {
            if ($("#acao").val()=="CADASTRAR"){
                $("#acao").val("SALVARCADASTRO");
                var dados = $("#despesa").serialize();
                $("#modal").show();
                $.ajax({
                    url: "salvar_despesas.php",
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
                            window.location="visu_despesas.php";
                        },2000);
                    }
                });
            }
            if ($("#acao").val()=="ALTERAR"){
                $("#acao").val("SALVARUPDATE");
                var dados = $("#despesa").serialize();
                $("#modal").show();
                $.ajax({
                    url: "salvar_despesas.php",
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
                            window.location="visu_despesas.php";
                        },2000);
                    }
                });
            }
        } else {
          var erro = 0;
          if (!($("#placa_veiculo").val() != "")) {
               $("#placa_veiculo-form").addClass("has-error");
               erro = 1;
          } else {
            $("#placa_veiculo-form").removeClass("has-error");
          }
          if (!($("#data_gasto").val() != "")) {
            $("#data_gasto-form").addClass("has-error");
             erro = 1;
          } else {
            $("#data_gasto-form").removeClass("has-error");
          }
          if (!($("#valor_gasto").val() != "")) {
            $("#valor_gasto-form").addClass("has-error");
             erro = 1;
          } else {
            $("#valor_gasto-form").removeClass("has-error");
          }
          if (!($("#tipo").val() != "")) {
            $("#tipo-form").addClass("has-error");
             erro = 1;
          } else {
            $("#tipo-form").removeClass("has-error");
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

    $(".dele-despesas").click(function(){
        $("#modal").show();
        var id = $(this).attr("id");
        id = id.split("-");
        $("#acao").val("SALVARDELETE");
        var dados = $("#"+id[0]).serialize();
        $.ajax({
            url: "salvar_despesas.php",
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
                    window.location="visu_despesas.php";
                },2000);
            }
        });
    }); 
});