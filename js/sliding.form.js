var $j = jQuery.noConflict();

$j(function() {

	/* number of fieldsets */
	var fieldsetCount = $j('#submitForm').children().length;
	
	/* current position of fieldset / navigation link */
	var current 	= 1;
	
	/* to avoid problems in IE, focus the first input of the form */
	$j('#submitForm').children(':first').find(':input:first').focus();	
	
	/*
	when clicking on a navigation link 
	the form slides to the corresponding fieldset
	*/
    $j('.step-form-nav li').bind('click',function(e){
		var $this	= $j(this);
		var prev	= current;
		$this.closest('ul').find('li').removeClass('selected');
		$this.removeClass('step-error step-passed');
        $this.addClass('selected');
	
		/*
		we store the position of the link
		in the current variable	
		*/
		current = $this.index() + 1;
		
		
		/* slide all content up */
		$j('#submitForm').find('.step').fadeOut(300, "swing");
		
		/* slide this content up */	
		$j('#submitForm').children(':nth-child('+ parseInt(current) +')').fadeIn(300,function(){
			if(current == fieldsetCount)
				validateSteps();
			else
				validateStep(prev);
			$j('#submitForm ul').children(':nth-child('+ parseInt(current) +')').find(':input:first').focus();	
		});
			
        e.preventDefault();
    });
	
	/* button next clicked */
	$j('#submitForm a.step-form-next').bind('click',function(e){
		var prev	= current;

		$j('.step-form-nav ul').children(':nth-child('+ parseInt(current) +')').removeClass('selected');	
		
		current = current + 1;	

		$j('.step-form-nav ul').children(':nth-child('+ parseInt(current) +')').removeClass('step-error step-passed');
		$j('.step-form-nav ul').children(':nth-child('+ parseInt(current) +')').addClass('selected');			
		
		$j('html, body').animate( {  scrollTop: $j("#content").offset().top }, 'slow' );
				
		/* slide all content up */
		$j('#submitForm').find('.step').fadeOut(500, "swing");		
		
		/* slide this content up */	
		$j('#submitForm').children(':nth-child('+ parseInt(current) +')').fadeIn(500,function(){
			if(current == fieldsetCount)
				validateSteps();
			else
				validateStep(prev);
			$j('#submitForm').children(':nth-child('+ parseInt(current) +')').find(':input:first').focus();	
		});
		
        e.preventDefault();
		
	});

	
	/*
	validates errors on all the fieldsets
	records if the Form has errors in $j('#submitForm').data()
	*/
	function validateSteps(){
		var FormErrors = false;
		for(var i = 1; i < fieldsetCount; ++i){
			var error = validateStep(i);
			if(error == -1)
				FormErrors = true;
		}
		
		if (!FormErrors) $j('.step-alert').css('display','none');
		$j('#submitForm').data('errors',FormErrors);
	}
	
	/*
	validates one fieldset
	and returns -1 if errors found, or 1 if not
	*/
	function validateStep(step){
		if(step == fieldsetCount) return;
		
		var error = 1;
		var hasError = false;

		$j('#submitForm').children(':nth-child('+ parseInt(step) +')').find('.required-field').each(function(){			
			var $this 		= $j(this);
			var valueLength = jQuery.trim($this.val()).length;
			
			if(valueLength == '' || $this.val() == -1 || $this.val() == 0 || $this.val == true){
				hasError = true;				
				$this.addClass( 'focus-required-error');
			}
			else
				$this.removeClass( 'focus-required-error');	
		});
		
		
		var $link = $j('.step-form-nav ul li:nth-child(' + parseInt(step) + ')');
		$link.removeClass('step-error step-passed');
		
		var valclass = 'step-passed';
		if(hasError){
			error = -1;
			valclass = 'step-error';
		}
		$link.addClass( valclass );
		
		return error;
	}
	
	/*
	if there are errors don't allow the user to submit
	*/
	$j('#submitButton').bind('click',function(){
		
		$j('.step-alert').css('display','none');
		
		if($j('#submitForm').data('errors')){
		
			$j('.step-alert').css('display','block');
			$j('.step-alert').delay(4000).slideUp(350); 			
			
			return false;
		}	
	});
});