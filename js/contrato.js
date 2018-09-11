$(document).ready(function(){
  $("#contrato-salvar").click(function(){
        if (($("#id_crianca").val() != "") && ($("#data_inicio_contrato").val() != "") && ($("#data_fim_contrato").val() != "") && ($("#dia_vencimento_mensalidade").val() != "") && ($("#mensalidade").val() != "") && ($("#trecho").val() != "")) {
            if ($("#acao").val()=="CADASTRAR"){
              $("#acao").val("SALVARCADASTRO");
            }
            if ($("#acao").val()=="ALTERAR"){
                $("#acao").val("SALVARUPDATE");
            }
          $( "#contrato" ).submit();
        } else {
          var erro = 0;
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
          if (!($("#trecho").val() != "")) {
            //colocar a borda vermelha no campo
             erro = 1;
          }
          if (erro) {
            alert("Existem campos obrigatorios preenchidos incorretamente");
          }
        }       
    });
});