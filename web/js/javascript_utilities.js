function verifyCnpj(CNPJ)
  {
	var erro = new String;
	if (CNPJ.length < 14 || CNPJ.length > 15) erro += "É necessario preencher corretamente o número do CNPJ! \n\n"; 
	var a = [];
	var b = new Number;
	var c = [6,5,4,3,2,9,8,7,6,5,4,3,2];
	for (i=0; i<12; i++){
		a[i] = CNPJ.charAt(i);
		b += a[i] * c[i+1];
	}
	if ((x = b % 11) < 2) { a[12] = 0 } else { a[12] = 11-x }
	b = 0;
	for (y=0; y<13; y++) {
		b += (a[y] * c[y]); 
	}
	if ((x = b % 11) < 2) { a[13] = 0; } else { a[13] = 11-x; }
	if ((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13])){
		erro +="Dígito verificador com problema!";
	}
	if (erro.length > 0){
		alert(erro);
		return false;
	}
	return true;
}

function verifyCpf(cpf)
{
	    if (cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999")
	      {
	        return false;
	      }
	      add = 0;
	      for (i=0; i < 9; i ++)
	      {
	        add += parseInt(cpf.charAt(i)) * (10 - i);
	      }
	      rev = 11 - (add % 11);
	      if (rev == 10 || rev == 11)
	      {
	        rev = 0;
	      }
	      if (rev != parseInt(cpf.charAt(9)))
	      {
	        return false;
	      }
	      add = 0;
	      for (i = 0; i < 10; i ++)
	      {
	        add += parseInt(cpf.charAt(i)) * (11 - i);
	      }
	      rev = 11 - (add % 11);
	      if (rev == 10 || rev == 11)
	      {
	        rev = 0;
	      }
	      if (rev != parseInt(cpf.charAt(10)))
	      {
	        return false;
	      }
	      
	      return true;
}


