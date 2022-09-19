
String.prototype.replaceAt=function(index, replacement) {
    return this.substr(0, index) + replacement+ this.substr(index + replacement.length);
}
function GetCardType(number)
{
    // visa
    var re = new RegExp("^4");
    if (number.match(re) != null)
        return "visa.png";

    // Mastercard 
    // Updated for Mastercard 2017 BINs expansion
     if (/^(5[1-5][0-9]{14}|2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12}))$/.test(number)) 
        return "mastercard.png";

    // AMEX
    re = new RegExp("^3[47]");
    if (number.match(re) != null)
        return "amx.png";

    // Discover
    re = new RegExp("^(6011|622(12[6-9]|1[3-9][0-9]|[2-8][0-9]{2}|9[0-1][0-9]|92[0-5]|64[4-9])|65)");
    if (number.match(re) != null)
        return "discover.png";

    // Diners
    // re = new RegExp("^36");
    // if (number.match(re) != null)
    //     return "Diners";

    // // Diners - Carte Blanche
    // re = new RegExp("^30[0-5]");
    // if (number.match(re) != null)
    //     return "Diners - Carte Blanche";

    // JCB
    re = new RegExp("^35(2[89]|[3-8][0-9])");
    if (number.match(re) != null)
        return "jcb.png";

    // Visa Electron
    // re = new RegExp("^(4026|417500|4508|4844|491(3|7))");
    // if (number.match(re) != null)
    //     return "Visa-Electron";

    return "cardtypelogo.png";
}
function changeCardImageDetail(SelectedCard){
	if(SelectedCard.hasClass('new-card-box')){
		$('.pay-detail input:not(:hidden),.pay-detail select').removeAttr('disabled');
		$('.bill-address input:not(:hidden),.bill-address select').removeAttr('disabled');
		$('#card__save').removeAttr('disabled');
        if(screen.availWidth <= 575 && $('.pay-detail,.bill-address').is(':hidden')){
            $('.pay-detail,.bill-address').slideDown(300);
        }
	}
	else{
        if(screen.availWidth <= 575 && $('.pay-detail,.bill-address').is(':visible')){
            $('.pay-detail,.bill-address').slideUp(300);
        }
        $('#card__save').attr('disabled','disabled');
		$('.pay-detail input:not(:hidden),.pay-detail select,.bill-address input:not(:hidden),.bill-address select').each(function(){
			$(this).val('').attr('disabled','disabled');
		})
		$('.card-box.new-card-box').data({cardno:"----",mm:"--",yy:"--",src:"https://salequick.com/demo_new/new_assets/img/cardtypelogo.png",chn:"-"});
	}
	$('.card-inner-sketch .card__no span:last-child').text(SelectedCard.data('cardno'));//cardno
	$('.card-inner-sketch .mycl-wrapper .flex-col:first-child .c__val span:first-child').text(SelectedCard.data('mm'));//mm
	$('.card-inner-sketch .mycl-wrapper .flex-col:first-child .c__val span:last-child').text(SelectedCard.data('yy'));//yy
	$('.card-inner-sketch .mycl-wrapper  .card-type-logo img').attr('src',SelectedCard.data('src'));//card type
	$('.card-inner-sketch .nameonc').text(SelectedCard.data('chn'));//card holder name
}
$(document)
.on('change','input[name="card_selection_radio"]',function(){
	var SelectedCard=$('input[name="card_selection_radio"]:checked').closest('.card-box');
	changeCardImageDetail(SelectedCard);
})
.on('keyup','#card__nameoncard',function(){
	//get name
	var newVal=$(this).val();
	newVal=newVal.length > 0 ? newVal : '-';
	$('.card-box.new-card-box').data('chn',newVal).find('input[name="card_selection_radio"]').trigger('change');
})
.on('keyup blur','#card__cnumber',function(){
	//get type & no
	//GetCardType(number)
	var newVal='',cardno='----',cardtypelogo='cardtypelogo.png';
		newVal=$(this).val();
		newVal=newVal.toString().replace(/\D/g,'');
	if(newVal){
		newVal=newVal.toString().replace(/\s/g,'');
		var maxidx=newVal.length;
		cardno=newVal.length > 13 ? newVal.substring(maxidx,maxidx - 4) : cardno;
		cardtypelogo=GetCardType(newVal);
	}
	console.log(cardtypelogo)
	$('.card-box.new-card-box').data('src',"https://salequick.com/demo_new/new_assets/img/"+cardtypelogo);
	$('.card-box.new-card-box').data('cardno',cardno).find('input[name="card_selection_radio"]').trigger('change');
})
// .on('blur','#card__validutil',function(e){
// 	var newVal='',mm='--',yy='--';
// 		newVal=$(this).val();
// 		newValNum=newVal.toString().replace(/\D/g,'');
// 	if(newValNum){
// 		newVal=newVal.toString().replace(/[\s_]/g,'');
// 		newVal=newVal.split('/');
// 		if(newVal[0].length == 2 && newVal[1].length == 2)
// 		{
// 			mm=newVal[0];
// 			yy=newVal[1];
// 		}
// 	}
// 	$('.card-box.new-card-box').data('mm',mm);
// 	$('.card-box.new-card-box').data('yy',yy).find('input[name="card_selection_radio"]').trigger('change');
// })
.on('blur','#card__validutil',function(e){
	var newVal='',mm='--',yy='--';
		newVal=$(this).val();
		newValNum=newVal.toString().replace(/\D/g,'');
	if(newValNum){
		newVal=newVal.toString().replace(/[\s_]/g,'');
		newVal=newVal.split('/');
		if(newVal[0].length == 2 && newVal[1].length == 2)
		{
			var minYY=parseInt($(this).data('yrmin'));
			var maxYY=minYY + 10;
			mm=parseInt(newVal[0]);
			yy=newVal[1];
			mm > 12 ? ($(this).val(''),mm ='--',yy ='--') : '';
			mm < 1 ? ($(this).val(''),mm ='--',yy ='--') : '';
			yy < minYY ? ($(this).val(''),mm ='--',yy ='--') : '';
			yy > maxYY ? ($(this).val(''),mm ='--',yy ='--') : '';
		}
		else if(newVal[0].length == 2)
		{
			parseInt(newVal[0]) > 12 ?( mm ='--') : '';
		}
	}
	// setTimeout(function(){
		// console.log(mm+yy)
		$('.card-box.new-card-box').data('mm',(parseInt(mm) < 10 ? '0'+mm : mm));
		$('.card-box.new-card-box').data('yy',yy).find('input[name="card_selection_radio"]').trigger('change');
	// },50)
})
.on('focus','#card__validutil',function(e){
	$(this).css('color','initial')
})
.on('keyup','#card__validutil',function(e){
	var newVal='',mm='--',yy='--';
	newVal=$(this).val();
	newValNum=newVal.toString().replace(/\D/g,'');
	if(newValNum){
		newVal=newVal.toString().replace(/[\s_]/g,'');
		newVal=newVal.split('/');
		var mmL= newVal[0].length
		var yyL= newVal[1].length
		mm=parseInt(newVal[0]);
		yy=parseInt(newVal[1]);

		var minYY=parseInt($(this).data('yrmin'));
		var maxYY=minYY + 10;
		// console.log(newVal)
		// console.log(mm)
		// console.log(mmL)
		// console.log(mm.length >= 2)
		if(mmL >= 2){
			$(this).css('color','initial');
			mm > 12 ? ($(this).css('color','red'),mm='--',yy='--') : '';
			mm < 1 ? ($(this).css('color','red'),mm='--',yy='--') : '';
		}
		if(yyL >= 2){
			$(this).css('color','initial');
			yy > maxYY ? ($(this).css('color','red'),mm='--',yy='--') : '';
			yy < minYY ? ($(this).css('color','red'),mm='--',yy='--') : '';
		}
		if(!yy)
		yy='--';
		if(yyL >= 2){
			if((mm <= 12 && mm >= 1) && (yy <= maxYY && yy >= minYY)){
				$(this).css('color','initial')
			}
			else{
				$(this).css('color','red');
			}
		}
	}
	$('.card-box.new-card-box').data('mm',(parseInt(mm) < 10 ? '0'+mm : mm)).trigger('change');
	$('.card-box.new-card-box').data('yy',yy).find('input[name="card_selection_radio"]').trigger('change');
})
// .on('keyup','#card__validutil',function(e){
// 	//get mm & yy
// 	var key = event.keyCode || event.charCode;
// 	var newVal=$(this).val(),mm='--',yy='--';

// 	newValL=newVal.length;

// 	newValL == 2? (key != 8? $('#card__validutil').val(newVal + '/') : '') : '';

// 	if(newValL >= 1 && newValL < 3)
// 	{
// 		mm=newVal;
// 	}
// 	else if(newValL >= 3){
// 		newVal=newVal.split('/');
// 		if(newValL.length > 1)
// 		{
// 			mm=newVal[0];
// 			yy=newVal[1];
// 		}
// 		else{
// 			newVal=newVal.toString().replaceAt(2,"/");
// 			$('#card__validutil').val(newVal);
// 			newVal=newVal.split('/');
// 			mm=newVal[0];
// 			yy=newVal[1];
// 		}

// 	}
// 	mml=mm.toString().trim().length ;
// 	yyl=yy.toString().trim().length ;
// 	// console.log(mml)
// 	mm=mml == 1 ? mm+'-' : mm;
// 	yy=yyl == 1 ? yy+'-' : (yyl == 0 ? '--' : yy);



// 	$('.card-box.new-card-box').data('mm',mm);
// 	$('.card-box.new-card-box').data('yy',yy).find('input[name="card_selection_radio"]').trigger('change');
// })

$(function(){
//default select card
	changeCardImageDetail($('input[name="card_selection_radio"]:checked').closest('.card-box'));
//autocomplete states
    var availableTags = [
      "Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","District of Columbia", "Florida","Georgia","Guam","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Carolina","North Dakota","Northern Marianas","Islands","Ohio","Oklahoma","Oregon","Pennsylvania","Puerto Rico","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Virgin Islands","Washington","West Virginia","Wisconsin","Wyoming"
    ];
    $( "#card__state" ).autocomplete({
      source: availableTags
    });
//masking 
	$(".phone").mask("(999) 999-9999");
	$("#card__validutil").mask("99/99");
});