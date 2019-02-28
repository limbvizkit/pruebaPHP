//Funciones Para Archivo VistaFarmacia.php
	function rellenar(quien,que){
		cadcero='';
		for(i=0;i<(8-que.length);i++){
			cadcero+='0';
		}
		quien.value=cadcero+que;
	}
//Funciones Para Archivo formulario_Farmacia.php
	//Bloquea/desbloquea los campos para datos basicos
	function mostrar(v){
	  if(v=="1"){
	  	document.getElementById('show_habit').disabled=false;
		document.getElementById('show_alergias').disabled=false;
		document.getElementById('show_peso').disabled=false;
		document.getElementById('show_talla').disabled=false;
		document.getElementById('show_creati').disabled=false;
		document.getElementById('show_fegreso').disabled=false;
		document.getElementById('show_diag').disabled=false;
		document.getElementById('show_enferm').disabled=false;
		document.getElementById('ingresa').disabled=false;
		document.getElementById('conciliacion').disabled=false;
		document.getElementById('traeMedic').disabled=false;
		document.getElementById('medcasa').disabled=false;
		document.getElementById('cultivo').disabled=false;
		document.getElementById('campoCultivo').disabled=false;
		document.getElementById('show_guarda').type='submit';
		document.getElementById('btnMostrar').type='hidden';
		document.getElementById('btnOcultar').type='button';
	  } else {
	  	document.getElementById('show_habit').disabled=true;
	  	document.getElementById('show_alergias').disabled=true;
		document.getElementById('show_peso').disabled=true;
		document.getElementById('show_talla').disabled=true;
		document.getElementById('show_creati').disabled=true;
		document.getElementById('show_fegreso').disabled=true;
		document.getElementById('show_diag').disabled=true;
		document.getElementById('show_enferm').disabled=true;
		document.getElementById('ingresa').disabled=true;
		document.getElementById('conciliacion').disabled=true;
		document.getElementById('traeMedic').disabled=true;
		document.getElementById('medcasa').disabled=true;
		document.getElementById('cultivo').disabled=true;
		document.getElementById('campoCultivo').disabled=true;
		document.getElementById('show_guarda').type='hidden';
		document.getElementById('btnMostrar').type='button';
		document.getElementById('btnOcultar').type='hidden';
	  }
	}

	function blqBtnMost(){
		document.getElementById('btnMostrar').disabled=true;
	}
	function checarC(c){
		if(c=="1"){
			document.getElementById('conciliacion').checked = true;
		} else {
			document.getElementById('conciliacion').checked = false;
		}
	}
	function checarM(m){
		if(m=="1"){
		 	document.getElementById('traeMedic').checked = true;
		} else {
			document.getElementById('traeMedic').checked = false;
		}
	}
	function checarCul(cu){
		if(cu=="1"){
		 	document.getElementById('cultivo').checked = true;
		} else {
			document.getElementById('cultivo').checked = false;
		}
	}
	function reportes(r){
		if(r=="1"){
			document.getElementById('reportes').style.display="block";
		} else {
			document.getElementById('reportes').style.display="none";
		}
	}
	//Bloquea/desbloquea los campos para datos de medicamentos capturados
	function dsblqModifMedic(c){
		document.getElementById("show_finicio"+c).disabled=false;
		document.getElementById("show_dosis"+c).disabled=false;
		document.getElementById("viadmon"+c).disabled=false;
		document.getElementById("show_frecuencia"+c).disabled=false;
		document.getElementById("tipoMed"+c).disabled=false;
		document.getElementById("btnGuardaMed").disabled=false;
		document.getElementById("btnModifMed"+c).style.display="none";
	}
	//Funcion que despliega un aviso para confirmar la eliminacion de un medicamento
	function confirmSubmit()
	{
		var agree=confirm("¿Está seguro de eliminar este registro? !!!EL PROCESO ES IRREVERSIBLE!!!");
		if (agree){
		 	return true ;
		}else{
		 	return false ;
		}
	}
	var clic = 1;
	var clic2 = 1;
	var clic3 = 1;

	function mostrarTb(){ //tbMedicamentos  btExportar
		if(clic == 1){
			document.getElementById('tblBasicos').style.display="block";
			document.getElementById('tblBasicos').style.width="100%";
			clic = clic + 1;
		} else {
			document.getElementById('tblBasicos').style.display="none";
			document.getElementById('tblBasicos').style.width="0%";
			clic = 1;
		}
	}
	function mostrarTbMedic(){
		if(clic2 == 1){
			document.getElementById('tbMedicamentos').style.display="block";
			document.getElementById('btExportar').type="submit";
			clic2 = clic2 + 1;
		} else {
			document.getElementById('tbMedicamentos').style.display="none";
			document.getElementById('btExportar').type="hidden";
			clic2 = 1;
		}
	}
	//Recargar la pagina (No se usa pero por si se usa lo dejamos xD)
	function reload(){
		location.reload();
	}
	
	function opcionesMed() {
		document.getElementById('revisionesMed').style.display="none";
		document.getElementById('dosisMed').style.display="none";
		document.getElementById('histHospMed').style.display="none";
	}