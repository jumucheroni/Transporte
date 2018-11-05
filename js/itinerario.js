$(document).ready(function(){
	 $('input[type=radio][name=relatorio]').change(function() {
	 	console.log("AAAAAAAa");
          if (this.value == 'T') {
              $("#escolas").hide();
          }
          if (this.value == 'E') {
              $("#escolas").show();
          }
      });
});
