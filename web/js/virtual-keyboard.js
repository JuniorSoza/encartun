if (window.innerWidth > 1000) {

	$('#cocheTicketBuscar').keyboard({
		layout: 'custom',
		customLayout: {
			'normal' : [
				'8 9 C',
				'4 5 6 7',
				'0 1 2 3',
				'{bksp} {a} {c}'
			]
		},
		maxLength : 10,
		restrictInput : true, // Prevent keys not in the displayed keyboard from being typed in
		// include lower case characters (added v1.25.7)
		restrictInclude : 'a b c d e f',
		useCombos : false, // don't want A+E to become a ligature
		acceptValid: true,
		validate: function(keyboard, value, isClosing){
			// only make valid if input is 6 characters in length
			//console.log("validando");
			if (isClosing == true)
			{
				buscarCochesTicket(value);
			}			
			return value.length > 0;
		}
	});

	
  $('#cant-latas-danadas ,#text-numeroDocumento').keyboard({
    layout: 'custom',
    customLayout: {
      'normal' : [
        '8 9',
        '4 5 6 7',
        '0 1 2 3',
        '{bksp} {a} {c}'
      ]
    },
    maxLength : 10,
    restrictInput : true, 
    restrictInclude : 'a b c d e f',
    useCombos : false, // don't want A+E to become a ligature
    acceptValid: true,
    validate: function(keyboard, value, isClosing){
      // only make valid if input is 6 characters in length
      //console.log("validando");  
      return value.length > 0;

    }
  });  


  $('#observacion-documento , #observacion-para').keyboard({
    lockInput: true, // prevent manual keyboard entry
    layout: 'custom',
    customLayout: {
      'normal': [
        '` 1 2 3 4 5 6 7 8 9 0 - = {bksp}',
        '{tab} q w e r t y u i o p [ ] \\',
        'a s d f g h j k l ñ ; \' {enter}',
        '{shift} z x c v b n m , . / {shift}',
        '{accept} {space} {left} {right}'
      ],
      'shift': [
        '~ ! @ # $ % ^ & * ( ) _ + {bksp}',
        '{tab} Q W E R T Y U I O P { } |',
        'A S D F G H J K L : " {enter}',
        '{shift} Z X C V B N M < > ? {shift}',
        '{accept} {space} {left} {right}'
      ]
    },
    acceptValid: true,
    validate: function(keyboard, value, isClosing){ 
      return value.length > 0;

    }    
  })

  $('#text-para-buscar')
  .keyboard({ layout: 'alpha',
    acceptValid: true,
    validate: function(keyboard, value, isClosing){
      if (isClosing == true)
      {
        //var paraBuscar = $("#text-para-buscar").val();
        Buscarparasprogramadasnoprogramadas(value);
      }  
      return value.length >= 0;

    }    
  })


  $('#login-username , #login-password').keyboard({
    lockInput: true, // prevent manual keyboard entry
    layout: 'custom',
    customLayout: {
      'normal': [
        '` 1 2 3 4 5 6 7 8 9 0 - = {bksp}',
        '{tab} q w e r t y u i o p [ ] \\',
        'a s d f g h j k l ñ ; \' {enter}',
        '{shift} z x c v b n m , . / {shift}',
        '{accept} {space} {left} {right}'
      ],
      'shift': [
        '~ ! @ # $ % ^ & * ( ) _ + {bksp}',
        '{tab} Q W E R T Y U I O P { } |',
        'A S D F G H J K L : " {enter}',
        '{shift} Z X C V B N M < > ? {shift}',
        '{accept} {space} {left} {right}'
      ]
    },
    acceptValid: true,
    validate: function(keyboard, value, isClosing){ 
      return value.length > 0;

    }    
  })
}