/**
 * Function that prevents the typing of non-numeric characters by the user
 *
 * @param {object} e
 * @return {boolean}
 */
function onlyNumbers(e) {
	var tecla=(window.event)?event.keyCode:e.which;   
	if((tecla>47 && tecla<58)) 
		return true;
	else {
		if (tecla==8 || tecla==0) 
			return true;
		else 
			return false;
	}
}

/**
 * Function that creates a mask to format phone number
 *
 * @param {object} field
 * @return {void}
 */
function phoneMask(field) {
	var v = field.value;
	var input = document.getElementById(field.id);

    v=v.replace(/\D/g,"");
    v=v.replace(/^(\d\d)(\d)/g,"($1) $2");

	if (v.charAt(5) == '9') {
		v=v.replace(/(\d{5})(\d)/,"$1-$2");
		input.maxLength = 15;
	} else {
		v=v.replace(/(\d{4})(\d)/,"$1-$2");
		input.maxLength = 14;
	}
	
    field.value = v;
}

/**
 * Function that validates an email address
 *
 * @param {string} email
 * @return {boolean}
 */
function validateEmail(email) {
	user = email.substring(0, email.indexOf("@"));
	domain = email.substring(email.indexOf("@")+ 1, email.length);
	if ((user.length >=1) &&
		(domain.length >=3) &&
		(user.search("@")==-1) &&
		(domain.search("@")==-1) &&
		(user.search(" ")==-1) &&
		(domain.search(" ")==-1) &&
		(domain.search(".")!=-1) &&
		(domain.indexOf(".") >=1)&&
		(domain.lastIndexOf(".") < domain.length - 1)) {
		return true;
	} else {
		return false;
	}
}