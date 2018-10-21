$(document).ready(function(){
  $("#contrato-salvar").click(function(){
      var erro = 0;
      if (($("#id_crianca").val() != "") && ($("#data_inicio_contrato").val() != "") && ($("#data_fim_contrato").val() != "") && ($("#dia_vencimento_mensalidade").val() != "") && ($("#mensalidade").val() != "") && ($("#trecho").val() != null)) {
          if ($("#data_inicio_contrato").val() >= $("#data_fim_contrato").val()){
            $("#data_inicio_contrato").addClass("has-error");
             erro = 1;
          } else {
            $("#data_inicio_contrato").removeClass("has-error");
          }
          if (erro) {
              $("#alert").html('<div class="alert bg-danger" role="alert"> Data de inicio tem que ser menor que a data de fim <a type="button" id="close-alert" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');
              $("#alert").show();
              setTimeout(function(){
                  $("#alert").hide();
              },2000);
              return;
          }
          if ($("#acao").val()=="CADASTRAR"){
              $("#acao").val("SALVARCADASTRO");
              var dados = $("#contrato").serialize();
              $("#modal").show();
              $.ajax({
                  url: "salvar_contrato.php",
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
                          window.location="visu_contrato.php";
                      },2000);
                  }
              });
          }
        } else {
          if (!($("#id_crianca").val() != "")) {
              $("#id_crianca").addClass("has-error");
              erro = 1;
          } else {
              $("#id_crianca").removeClass("has-error");
          }
          if (!($("#data_inicio_contrato").val() != "")) {
            $("#data_inicio_contrato").addClass("has-error");
             erro = 1;
          } else {
            $("#data_inicio_contrato").removeClass("has-error");
          }
          if (!($("#data_fim_contrato").val() != "")) {
              $("#data_fim_contrato").addClass("has-error");
              erro = 1;
          } else {
              $("#data_fim_contrato").removeClass("has-error");
          }
          if (!($("#dia_vencimento_mensalidade").val() != "")) {
              $("#dia_vencimento_mensalidade").addClass("has-error");
              erro = 1;
          } else {
              $("#dia_vencimento_mensalidade").removeClass("has-error");
          }
          if (!($("#mensalidade").val() != "")) {
              $("#mensalidade").addClass("has-error");
              erro = 1;
          } else {
              $("#mensalidade").removeClass("has-error");
          }
          if (($("#trecho").val() == null)) {
              $("#trecho").addClass("has-error");
              erro = 1;
          } else {
              $("#trecho").removeClass("has-error");
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

    $("#contrato-alterar").click(function(){
          var erro = 0;     
          if ($("#dia_vencimento_mensalidade").val() != "") { 
              if ($("#acao").val()=="ALTERAR"){
                    $("#acao").val("SALVARUPDATE");
                    var dados = $("#contrato").serialize();
                    $("#modal").show();
                    $.ajax({
                        url: "salvar_contrato.php",
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
                                window.location="visu_contrato.php";
                            },2000);
                        }
                    });
                }
            } else {
              if (!($("#dia_vencimento_mensalidade").val() != "")) {
                  $("#dia_vencimento_mensalidade").addClass("has-error");
                  erro = 1;
              } else {
                  $("#dia_vencimento_mensalidade").removeClass("has-error");
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

  $(".dele-contrato").click(function(){
        $("#modal").show();
        var id = $(this).attr("id");
        id = id.split("-");
        $("#acao").val("SALVARDELETE");
        var dados = $("#"+id[0]).serialize();
        $.ajax({
            url: "salvar_contrato.php",
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
                    window.location="visu_contrato.php";
                },2000);
            }
        });
    }); 

  $("#id_crianca").change(function(){
    $("#trecho").find('option').each(function(i,data){
        trecho = $(this)[0].value.split('-');
        if (trecho[1] == $("#id_crianca").val()) {
          $(this).removeAttr("hidden");
        } else {
          $(this).attr("hidden",'hidden');
        }
    });
  });
});