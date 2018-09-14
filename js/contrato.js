$(document).ready(function(){
  $("#contrato-salvar").click(function(){
        var erro = 0;
        if (($("#id_crianca").val() != "") && ($("#data_inicio_contrato").val() != "") && ($("#data_fim_contrato").val() != "") && ($("#dia_vencimento_mensalidade").val() != "") && ($("#mensalidade").val() != "") && ($("#trecho").val() != null)) {
          if ($("#data_inicio_contrato").val() >= $("#data_fim_contrato").val()){
            //colocar a borda vermelha no campo
             erro = 1;
          }
          if (erro) {
            alert("Data de inicio tem que ser menor que a data de fim");
            return;
          }
            if ($("#acao").val()=="CADASTRAR"){
              $("#acao").val("SALVARCADASTRO");
            }
            if ($("#acao").val()=="ALTERAR"){
                $("#acao").val("SALVARUPDATE");
            }
          $( "#contrato" ).submit();
        } else {
          if (!($("#id_crianca").val() != "")) {
                //colocar a borda vermelha no campo
               erro = 1;
          }
          if (!($("#data_inicio_contrato").val() != "")) {
            //colocar a borda vermelha no campo
             erro = 1;
          }
          if (!($("#data_fim_contrato").val() != "")) {
            //colocar a borda vermelha no campo
             erro = 1;
          }
          if (!($("#dia_vencimento_mensalidade").val() != "")) {
            //colocar a borda vermelha no campo
             erro = 1;
          }
          if (!($("#mensalidade").val() != "")) {
            //colocar a borda vermelha no campo
             erro = 1;
          }
          if (($("#trecho").val() == null)) {
            //colocar a borda vermelha no campo
             erro = 1;
          }
          if (erro) {
            alert("Existem campos obrigatorios preenchidos incorretamente");
          }
        }       
    });

  $("#id_crianca").change(function(){
    $("#trecho").find('option').each(function(i,data){
        trecho = $(this)[0].value.split('-');
        if (trecho[1] == $("#id_crianca").val()) {
          $(this).removeAttr("hidden");
        } else {
          console.log("TESTE");
          $(this).attr("hidden",'hidden');
        }
    });
  });
});