$(document).ready(function(){
    $("#condveic-salvar").click(function(){
        if (($("#veiculo").val() != "") && ($("#condutor").val() != "") && ($("#periodo").val() != "")) {
            if ($("#acao").val()=="CADASTRAR"){
                $("#acao").val("SALVARCADASTRO");
                var dados = $("#condveic").serialize();
                $("#modal").show();
                $.ajax({
                    url: "salvar_condveic.php",
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
                            window.location="visu_condveic.php";
                        },2000);
                    }
                });
            }
            if ($("#acao").val()=="ALTERAR"){
                $("#acao").val("SALVARUPDATE");
                var dados = $("#condveic").serialize();
                $("#modal").show();
                $.ajax({
                    url: "salvar_condveic.php",
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
                            window.location="visu_condveic.php";
                        },2000);
                    }
                });
            }
        } else {
          var erro = 0;
          if (!($("#veiculo").val() != "")) {
              $("#veiculo-form").addClass("has-error");
              erro = 1;
          } else {
              $("#veiculo-form").removeClass("has-error");
          }
          if (!($("#condutor").val() != "")) {
            $("#condutor-form").addClass("has-error");
              erro = 1;
          } else {
              $("#condutor-form").removeClass("has-error");
          }
          if (!($("#periodo").val() != "")) {
            $("#periodo-form").addClass("has-error");
            erro = 1;
          } else {
              $("#periodo-form").removeClass("has-error");
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

    $(".dele-condveic").click(function(){
        $("#modal").show();
        var id = $(this).attr("id");
        id = id.split("-");
        $("#acao").val("SALVARDELETE");
        var dados = $("#"+id[0]+"-"+id[1]+"-"+id[2]).serialize();
        $.ajax({
            url: "salvar_condveic.php",
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
                    window.location="visu_condveic.php";
                },2000);
            }
        });
    }); 
});