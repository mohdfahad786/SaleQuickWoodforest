//sign up leaveFirstGoNextStp 
function leaveFirstGoNextStp(){
	$('.steps-wrapper .row').removeClass('active');
	$('.steps-wrapper .row.second-step').addClass('active');
	$('.sign-up-form .form-steps').slideDown(300);
	$('.sign-up-form .form-steps .step').removeClass('active');
	$('.sign-up-form .form-steps .step[data-fStep="2"]').addClass('active');
	$('.sign-up-form .form-steps .step[data-fStep="1"] span').html('').addClass('fa fa-check');
	$('.sign-up-form .form-steps .step[data-fStep="1"]').addClass('completed');
}
function leave2ndGoNextStp(){
	$('.steps-wrapper .row').removeClass('active');
	$('.steps-wrapper .row.third-step').addClass('active');
	// $('.sign-up-form .form-steps').slideDown(300);
	$('.sign-up-form .form-steps .step').removeClass('active')
	$('.sign-up-form .form-steps .step[data-fStep="3"]').addClass('active')
	$('.sign-up-form .form-steps .step[data-fStep="2"] span').html('').addClass('fa fa-check');
	$('.sign-up-form .form-steps .step[data-fStep="2"]').addClass('completed')
}
function leave3rdGoNextStp(){
	$('.steps-wrapper .row').removeClass('active');
	$('.steps-wrapper .row.fourth-step').addClass('active');
	// $('.sign-up-form .form-steps').slideDown(300);
	$('.sign-up-form .form-steps .step').removeClass('active');
	$('.sign-up-form .form-steps .step[data-fStep="4"]').addClass('active');
	$('.sign-up-form .form-steps .step[data-fStep="3"] span').html('').addClass('fa fa-check');
	$('.sign-up-form .form-steps .step[data-fStep="3"]').addClass('completed');
}

//stepper form check validation
function signUpStepFirst($wrapper) {
	var phone = /[0-9]/;// Email address
	var trueFalse = 1;
	$wrapper.find('.form-control[required]').each(function() {
		var txtVal=$(this).val();
		// console.log(txtVal)
		//check empty
		if(!txtVal.length) {
			// console.log('run')
			$(this).closest('.form-group').addClass('mandatory');
			$(this).focus();
			trueFalse=0;
			return false;
		}
		//check if email
		if($(this).hasClass('email')) {
			if(!emailRegx.test(txtVal)) {
				$(this).closest('.form-group').addClass('incorrect');
				$(this).focus();
				trueFalse=0;
				return false;
			}
		}
		//check if email
		if($(this).hasClass('phone')) {
			if(!phone.test(txtVal)) {
				$(this).closest('.form-group').addClass('incorrect');
				$(this).focus();
				trueFalse=0;
				return false;
			}
		}
		//check if password
		if($(this).hasClass('p2')) {
			var p1=$wrapper.find('.password.p1').val();
			var p2=$wrapper.find('.password.p2').val();
			if(p1 != p2) {
				$(this).focus();
				$(this).closest('.form-group').addClass('not-match');
				console.log('false');
				trueFalse=0;
				return false;
			} else {
				console.log('matched')
				$(this).closest('.form-group').removeClass('not-match');
			}
		}
	})
	return trueFalse;
}

function signUpStepSecond($wrapper){
	var trueFalse= 1;
	$wrapper.find('.form-control[required]').each(function(){
			var txtVal=$(this).val();
			//check empty
				if(!txtVal.length)
				{
					// console.log('run')
					$(this).closest('.form-group').addClass('mandatory');
					$(this).focus();
					trueFalse=0;
					return false;
				}
			//check if email
				if($(this).hasClass('email'))
				{
					if(!emailRegx.test(txtVal))
					{
						$(this).closest('.form-group').addClass('incorrect');
						$(this).focus();
						trueFalse=0;
						return false;
					}
				}
			//check if email
				if($(this).hasClass('us-routing-c'))
				{
					if(txtVal != $('.us-routing').val().trim())
					{
						$(this).closest('.form-group').addClass('not-match');
						$(this).focus();
						trueFalse=0;
						return false;
					}
				}
			//check if email
				if($(this).hasClass('us-acc-no-c'))
				{
					if(txtVal != $('.us-acc-no').val().trim())
					{
						$(this).closest('.form-group').addClass('not-match');
						$(this).focus();
						trueFalse=0;
						return false;
					}
				}
	})
	return trueFalse;
}

function signUpStepThird($wrapper){
	var trueFalse= 1;
	$wrapper.find('.form-control[required]').each(function(){
		// console.log($(this));
		var txtVal=$(this).val();
		//check empty
		if(!txtVal.length)
		{
			// console.log('run')
			$(this).closest('.form-group').addClass('mandatory');
			$(this).focus();
			trueFalse=0;
			return false;
		}
		//check if email
		if($(this).hasClass('email'))
		{
			if(!emailRegx.test(txtVal))
			{
				$(this).closest('.form-group').addClass('incorrect');
				$(this).focus();
				trueFalse=0;
				return false;
			}
		}
	})
	return trueFalse;
}

function signUpStepFourth($wrapper){
	var trueFalse= 1;
	$wrapper.find('.form-control[required]').each(function(){
			var txtVal=$(this).val();
			//check empty
				if(!txtVal.length)
				{
					// console.log('run')
					$(this).closest('.form-group').addClass('mandatory');
					$(this).focus();
					trueFalse=0;
					return false;
				}
				//check if email
					if($(this).hasClass('email'))
					{
						if(!emailRegx.test(txtVal))
						{
							$(this).closest('.form-group').addClass('incorrect');
							$(this).focus();
							trueFalse=0;
							return false;
						}
					}
				if($(this).hasClass('acc2'))
				{
					var p1=$wrapper.find('.form-control.acc1').val();
					var p2=$wrapper.find('.form-control.acc2').val();
					if(p1 != p2)
					{
						$(this).focus();
						$(this).closest('.form-group').addClass('not-match');
						console.log('false');
						trueFalse=0;
						return false;
					}
					else{
						console.log('matched')
						$(this).closest('.form-group').removeClass('not-match');
					}
				}
			//check if routing
				if($(this).hasClass('us-routing-c'))
				{
					if(txtVal != $('.us-routing').val().trim())
					{
						$(this).closest('.form-group').addClass('not-match');
						$(this).focus();
						trueFalse=0;
						return false;
					}
				}
			//check if acc-no
				if($(this).hasClass('us-acc-no-c'))
				{
					if(txtVal != $('.us-acc-no').val().trim())
					{
						$(this).closest('.form-group').addClass('not-match');
						$(this).focus();
						trueFalse=0;
						return false;
					}
				}
	})
	return trueFalse;
}

//live events
$(document)
	//stepper form function
	.on('click','.custom-stepper-form .first-step .stepper-submit',function(e){
		// console.log('hello');return false;
		var $wrapper=$(this).closest('.first-step');
		// console.log(signUpStepFirst($wrapper));
		if(signUpStepFirst($wrapper)) {
			// console.log('1');return false;
			//call ajax &  submit step first
			var mSignupStepF={};
			// mSignupStepF.f_name=$wrapper.find('.form-control[name="mbname"]').val();
			mSignupStepF.email=$wrapper.find('.form-control[name="memail"]').val();
			// mSignupStepF.mobile=$wrapper.find('.form-control[name="mphone"]').val();
			mSignupStepF.password=$wrapper.find('.form-control[name="mpass"]').val();
			mSignupStepF.mconfpass=$wrapper.find('.form-control[name="mconfpass"]').val();
			// console.log(mSignupStepF)
			// var dataString = 'name='+ name + '&email=' + email + '&phone=' + phone;
			//alert (dataString);return false;
			$(this).find('span').addClass('fa fa-spinner fa-spin');
			mSignupStep1Fn(mSignupStepF);

		} else {
			//stay at first
		}
		//completed first step
	})
	.on('click','.custom-stepper-form .second-step .next-step',function(e){
		var $wrapper=$(this).closest('.second-step');
		// console.log(signUpStepSecond($wrapper));
		if(signUpStepSecond($wrapper))
		{
			//call ajax &  submit step first
			//go to third step
			var mSignupStepS={};
			$('.custom-stepper-form .second-step input,.custom-stepper-form .second-step select').each(function(){
			var newval=$(this).val();
			if($(this).hasClass('us-phone-no')){
			newval=newval.replace(/[\(\)-\s]/g,'');
			}
			mSignupStepS[$(this).attr('name')]= newval;
			})
			$(this).find('span').addClass('fa fa-spinner fa-spin');
			mSignupStep2Fn(mSignupStepS);
			// leave2ndGoNextStp();
		}
		else{
			//stay at first
		}
		//completed first step
	})
	.on('click','.custom-stepper-form .third-step .next-step',function(e){
		// var $wrapper=$(this).closest('.third-step');
		var $wrapper=$(this).closest('.third-step').children('.busi_owner_inputs').children('.pointer');
		// console.log($wrapper);return false;
		// var mSignupStepTh = [];
		 // console.log(signUpStepthird($wrapper));
		if(signUpStepThird($wrapper)) {
			// alert('hello1');
			//call ajax &  submit step first
			// console.log()
			//go to fourth step
			var mSignupStepTh={};
			var ownerArr = [];
			var checkIndexCount = 0;
			$('.custom-stepper-form .third-step .first_busi_owner_section').each(function() {
				// console.log($(this).length);
				if( checkIndexCount == 0 ) {
					$(this).find('input, select').each(function(){
						var newval=$(this).val();
						if($(this).hasClass('us-phone-no')){
							newval=newval.replace(/[\(\)-\s]/g,'');

						} else if($(this).hasClass('us-ssn-no-enc')){
							newval=$(this).data('val');
						}
						mSignupStepTh[$(this).attr('name')]= newval;
					})
					checkIndexCount++;

				} else {
					var singleOwner = {};
					// console.log($(this));
					$(this).find('input, select').each(function() {
						var newval=$(this).val();
						// console.log($(this).attr('name'), newval);
						if($(this).attr('name') == 'fo_phone_arr'){
							newval=newval.replace(/[\(\)-\s]/g,'');
							// console.log(newval);

						} else if($(this).attr('name') == 'fossn_arr'){
							newval=$(this).data('val');
						}
						singleOwner[$(this).attr('name')] = newval;
					})
					// console.log(singleOwner);
					ownerArr.push(singleOwner);
				}
			})
			// return false;
			$(this).find('span').addClass('fa fa-spinner fa-spin');
			mSignupStepTh['ownerArr'] = ownerArr;
			// console.log(mSignupStepTh);return false;
			mSignupStep3FnNew(mSignupStepTh);

		} else {
			//stay at first
		}
		//completed first step
	})
	.on('click','.custom-stepper-form .fourth-step .submit-step',function(e){
		var $wrapper=$(this).closest('.fourth-step');
		// console.log(signUpStepFourth($wrapper));
		if(signUpStepFourth($wrapper))
		{
			//call ajax &  submit step first
			var mSignupStepFth={};
				$('.custom-stepper-form .fourth-step input,.custom-stepper-form .fourth-step select').each(function(){
					var newval=$(this).val();
							if($(this).hasClass('us-phone-no')){
								newval=newval.replace(/[\(\)-\s]/g,'');
							}
					mSignupStepFth[$(this).attr('name')]= newval;
				})
				$(this).find('span').addClass('fa fa-spinner fa-spin');

				mSignupStep4Fn(mSignupStepFth);
			//go to fourth step
			// console.log('false-run');
		}
		else{
			//stay at first
		}
		//completed first step
	})
	.on('click','.custom-stepper-form .third-step .back-step',function(e){
		var $wrapper=$(this).closest('.third-step');
		if(signUpStepThird($wrapper))
		{
			$('.sign-up-form .form-steps .step[data-fStep="2"]').addClass('active');
			$('.sign-up-form .form-steps .step[data-fStep="3"]').removeClass('active').addClass('completed')
		}
		else{
			$('.sign-up-form .form-steps .step[data-fStep="3"]').removeClass('active completed');
		}
			$('.sign-up-form .steps-wrapper  >.row').removeClass('active');
			$('.sign-up-form .steps-wrapper  >.row[data-fStep="2"]').addClass('active');
	})
	.on('click','.custom-stepper-form .fourth-step .back-step',function(e){
		var $wrapper=$(this).closest('.fourth-step');
		if(signUpStepFourth($wrapper))
		{
			$('.sign-up-form .form-steps .step[data-fStep="3"]').addClass('active');
			$('.sign-up-form .form-steps .step[data-fStep="4"] span').html('').addClass('fa fa-check');
			$('.sign-up-form .form-steps .step[data-fStep="4"]').removeClass('active').addClass('completed');
		}
		else{
			$('.sign-up-form .form-steps .step[data-fStep="4"]').removeClass('active completed');
		}
		$('.sign-up-form .steps-wrapper >.row').removeClass('active');
		$('.sign-up-form .steps-wrapper >.row[data-fStep="3"]').addClass('active');
	})
	.on('focus','input.encrypted-field',function(){
		$(this).val($(this).data('val'));
	})
	.on('blur','input.encrypted-field',function(){
		var inpVal=$(this).val(),encPlaceh='';
		if(inpVal.length)
		{
			$(this).data('val',$(this).val().trim());
			var ttlL=$(this).val().trim().length;
			// console.log(ttlL)
			for (var i = 0; i < ttlL; i++) 
			{
				if(!$(this).hasClass('no-dash')){
					if(i != 3 && i != 6)
					encPlaceh+='x';
					else
					encPlaceh+='-';
				}
				else{
					encPlaceh+='x';
				}
			}
			// console.log(encPlaceh)
			$(this).val(encPlaceh);
		}
		else{
			$(this).data('val','');
		}
	})
	.on('keydown click','.sign-up-form .steps-wrapper .form-group .form-control',function(){
		$('.sign-up-form .steps-wrapper .form-group').removeClass('not-match mandatory incorrect');
	})
	//sidebar menu toggle
	.on('focus','input.us-ssn-no-enc',function(){
		$(this).attr('maxlength',9);
		$(this).val($(this).data('val'));
	})
	.ready(function(){
		$('input.us-ssn-no-enc').each(function(){
			if($(this).val()){
				$(this).trigger('blur');
			}
		})
	})
	.on('blur','input.us-ssn-no-enc',function(){
		$(this).attr('maxlength',11);
		var inpVal=$(this).val(),encPlaceh='';
		if(inpVal.length)
		{
			$(this).data('val',$(this).val().trim());
			var ttlL=$(this).val().trim().length;
			// console.log(ttlL)
			for (var i = 0; i < ttlL; i++) 
			{
				if(i == 3 || i == 6)
				{
					encPlaceh+='-';
				}
				else if(i<= 5)
				{
					encPlaceh+='x';
				}
				else{
					i = ttlL;
					encPlaceh+=inpVal.substr(5, ttlL-1);
				}
			}
			// console.log(encPlaceh)
			$(this).val(encPlaceh);
		}
		else{
			$(this).data('val','');
		}
	})