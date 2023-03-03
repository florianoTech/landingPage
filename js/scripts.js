/**
 * Function to use with onload event
 *
 * @return {void}
 */
function render() {
	$("#copy").text("\u00A9 Floriano Tecnologia "+ new Date().getFullYear()+". Todos os direitos reservados.");
    $('.toast').toast('show');
	
	window.dataLayer = window.dataLayer || [];
	gtag('js', new Date());
	gtag('config', 'G-N9JR4P8D8V');	
}

/**
 * Function that creates a dynamic behavior to fields
 *
 * @param {object} field
 * @return {void}
 */
function verifyFields(field) {

	if (field.id == "customerName")
		field.value.length > 5 ? $("#emailAddress").prop("disabled", false) : $("#emailAddress").prop("disabled", true);	
	if (field.id == "emailAddress") 
		field.value.length > 5 ? $("#message").prop("disabled", false) : $("#message").prop("disabled", true);
	else if (field.id == "message")
		field.value.length > 5 ? $("#btn-email").prop("disabled", false) : $("#btn-email").prop("disabled", true);		
}

/**
 * Function that sends a message by email
 *
 * @param {string} customerName
 * @param {string} email
 * @param {string} phone 
 * @param {string} message 
 * @return {void}
 */
function sendMessage(customerName='', email='', phone=0, message='') {

	var emailValidation = validateEmail(email);
	
	if (!emailValidation) {
		noticeModal("show","Endereço  de email inválido");
	} else {
		$("#loadEmail").prop("class","load-btn-show");
		$("#btn-email-text").prop("class","load-btn-hide");	
		var paramsFunc = JSON.stringify([customerName,email,phone,message]);
		$.post({
			type: "POST",
			datatype: "json",
			url: "vendor/callFunc_post.php",
			data: {option: 1, 
				   nameFunc: 'sendEmail', 
				   paramsFunc: paramsFunc},
			success: function(result) {
				result = JSON.parse(result);
				$("#loadEmail").prop("class","load-btn-hide");
				$("#btn-email-text").prop("class","load-btn-show");		
				noticeModal("show", result.message);				
				$("#contactModal").modal("hide");						
			}, error: function(xhr, status, error){
				$("#loadEmail").prop("class","load-btn-hide");
				$("#btn-email-text").prop("class","load-btn-show");	
				noticeModal("show","Erro ao enviar mensagem. Por favor tente novamente");
			}
		});			
	}
}

/**
 * Function that controls a modal
 *
 * @param {string} command
 * @param {string} message 
 * @return {void}
 */
function noticeModal(command, message='') {
	$("#notice").text(message);
	$("#noticeModal").modal(command);
	command == "show" ? $("#contactModal").css("opacity",0.5) : $("#contactModal").css("opacity",1);	
}

/**
 * Function used by google for analytics purposes
 *
 * @return {void}
 */
function gtag() {
	dataLayer.push(arguments);
}