function obrigatorio(campo) {
	return "Field is required";
}

function imagem(campo) {
	return "Select image from one of this formats: png, jpg, jpeg, gif";
}

function email(campo) {
	return "Field " + campo + " must be a valid e-mail";
}

function minimo(campo, tamanho) {
	return "Field " + campo + " must have at least " + tamanho + " chars";
}

function valorMinimo(campo, tamanho) {
	return "Field " + campo + " must be at least " + tamanho;
}

function valorMaximo(campo, tamanho) {
	return "Field " + campo + " must be at most " + tamanho;
}

function hora(campo) {
    return "Field " + campo + " must be a valid hour";
} 

function data(campo) {
    return "Field " + campo + " must be a valid date";
}

function url(campo) {
	return "Field " + campo + " must contains a valid URL";
}