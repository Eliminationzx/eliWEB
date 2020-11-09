function translit(){
	// Символ, на который будут заменяться все спецсимволы
	var space = '-'; 
	// Берем значение из нужного поля и переводим в нижний регистр
	var text = $('#name').val().toLowerCase();
	//var text = document.getElementById('name').value.toLowerCase();
	// Массив для транслитерации
	var transl = { 
					'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh', 'з': 'z', 'и': 'i',
					'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't',
					'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sh', 'ъ': space, 'ы': 'y',
					'ь': space, 'э': 'e', 'ю': 'yu', 'я': 'ya',
					
					' ': space, '_': space, '`': space, '~': space, '!': space, '@': space, '#': space, '$': space,
					'%': space, '^': space, '&': space, '*': space, '(': space, ')': space, '-': space, '\=': space,
					'+': space, '[': space, ']': space, '\\': space, '|': space, '/': space, '.': space, ',': space,
					'{': space, '}': space, '\'': space, '"': space, ';': space, ':': space, '?': space, '<': space,
					'>': space, '№': space					
				 }
	
    var result = '';
	
	var curent_sim = '';
	
    for(i=0; i < text.length; i++) {
        // Если символ найден в массиве то меняем его
		if(transl[text[i]] != undefined) {			
			if(curent_sim != transl[text[i]] || curent_sim != space){
				result += transl[text[i]];
				curent_sim = transl[text[i]];				
			}					
		}
		// Если нет, то оставляем так как есть
        else {
			result += text[i];
			curent_sim = text[i];
		}		
    }	
	
	result = TrimStr(result);	
	
	// Выводим результат
	$('#seo_url').val(result);
	//document.getElementById('alias').value = result;
    
}
function TrimStr(s) {
	s = s.replace(/^-/, '');
	return s.replace(/-$/, '');
}

// Выполняем транслитерацию при вводе текста в поле
$(function(){
	$('#name').keyup(function(){
		translit();
		return false;
	});
});