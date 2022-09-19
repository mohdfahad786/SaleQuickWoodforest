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
        //$('.pay-detail input:not(:hidden),.pay-detail select,.bill-address input:not(:hidden),.bill-address select').each(function(){
        //  $(this).val('').attr('disabled','disabled');
        //})
        $('.card-box.new-card-box').data({cardno:"----",mm:"--",yy:"--",src:"https://salequick.com/new_assets/img/cardtypelogo.png",chn:"-"});
    }
    $('.card-inner-sketch .card__no span:last-child').text(SelectedCard.data('cardno'));//cardno
    $('.card-inner-sketch .mycl-wrapper .flex-col:first-child .c__val span:first-child').text(SelectedCard.data('mm'));//mm
    $('.card-inner-sketch .mycl-wrapper .flex-col:first-child .c__val span:last-child').text(SelectedCard.data('yy'));//yy

    //$('.card-inner-sketch .mycl-wrapper  .card-type-logo img').attr('src',SelectedCard.data('src'));//card type
    $('.card-inner-sketch .nameonc').text(SelectedCard.data('chn'));//card holder name
}
$(document)
.on('change','input[name="card_selection_radio"]',function(){
        $('.card_type').html('<div style="width: 35px;"></div>')
    var SelectedCard=$('input[name="card_selection_radio"]:checked').closest('.card-box');
        $('.card-inner-sketch .mycl-wrapper  .card-type-logo img').attr('src',SelectedCard.data('src'));//card type
    changeCardImageDetail(SelectedCard);
        //console.log(SelectedCard)
        var clicked_event = $(this).parent().attr('class');
        //console.log(clicked_event)
        if(clicked_event == 'card-box get_card_box') {
             $('.pay-detail input:not(:hidden),.pay-detail select,.bill-address input:not(:hidden),.bill-address select').each(function(){
         $(this).val('').attr('disabled','disabled');
         })
        } else {
             $('.pay-detail input:not(:hidden),.pay-detail select,.bill-address input:not(:hidden),.bill-address select').each(function(){
         $(this).val('').removeAttr('disabled');
         })
        }
})
.on('keyup','#card__nameoncard',function(){
    // alert()
    //get name
    var newVal=$(this).val();
    newVal=newVal.length > 0 ? newVal : '-';
    $('.nameonc').text(newVal);
    //$('.card-box.new-card-box').data('chn',newVal).find('input[name="card_selection_radio"]').trigger('change');
    $('.card-box.new-card-box').data('chn',newVal);
    var SelectedCard=$('input[name="card_selection_radio"]:checked').closest('.card-box');
    changeCardImageDetail(SelectedCard);
})
.on('keyup blur','#card__cnumber',function(){
    //get type & no
    //GetCardType(number)
    //var newVal='',cardno='----',cardtypelogo='cardtypelogo.png';
    var newVal='',cardno='----';
    newVal=$(this).val();
    newVal=newVal.toString().replace(/\D/g,'');

    if(newVal){
        newVal=newVal.toString().replace(/\s/g,'');
        // console.log(newVal)
        var maxidx=newVal.length;
        cardno=newVal.length > 13 ? newVal.substring(maxidx,maxidx - 4) : cardno;
        // console.log(cardno)
        $('.card__no').find('span:last').text(cardno);
        //cardtypelogo=GetCardType(newVal);
    }
    //console.log(cardtypelogo)
    //$('.card-box.new-card-box').data('src',"https://salequick.com/demo_new/new_assets/img/"+cardtypelogo);
    //$('.card-box.new-card-box').data('cardno',cardno).find('input[name="card_selection_radio"]').trigger('change');
        $('.card-box.new-card-box').data('cardno',cardno);
        var SelectedCard=$('input[name="card_selection_radio"]:checked').closest('.card-box');
        //$('.card-inner-sketch .mycl-wrapper  .card-type-logo img').attr('src',SelectedCard.data('src'));//card type
    changeCardImageDetail(SelectedCard);
})
.on('blur','#card__validutil',function(e){
    var newVal=$(this).val(),mm='--',yy='--';
    var validyrs=$('#card__validutil').data('yr');
    // console.log(validyrs);
    // console.log(typeof validyrs);
    if(newVal){
        newVal=newVal.split('/');
        mm=newVal[0];
        yy=newVal[1];
        if(mm == 0 || mm > 12)
        {
            $(this).val('').trigger('keyup');
        }
        if(yy.length == 2){
            var matched=false;
            $.each(validyrs, function( index, value ) {
              if(value == yy){
                  matched=true;
              }
            });
            // console.log(matched)
            if(!matched){
                $(this).val('').trigger('keyup');
            }
        }
    }
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

        if(!yy)
        yy='--';
    }
    $('.card_exp_mm').text(mm);
    $('.card_exp_yy').text(yy);
    $('.card-box.new-card-box').data('mm',mm).trigger('change');
    //$('.card-box.new-card-box').data('yy',yy).find('input[name="card_selection_radio"]').trigger('change');
    $('.card-box.new-card-box').data('yy',yy);
    var SelectedCard=$('input[name="card_selection_radio"]:checked').closest('.card-box');
    changeCardImageDetail(SelectedCard);
})

$(function(){
//default select card
    //changeCardImageDetail($('input[name="card_selection_radio"]:checked').closest('.card-box'));
        var SelectedCard=$('input[name="card_selection_radio"]:checked').closest('.card-box');
    changeCardImageDetail(SelectedCard);
        $('.card-inner-sketch .mycl-wrapper  .card-type-logo img').attr('src',SelectedCard.data('src'));//card type
//autocomplete states
    var availableTags = [
      "Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","District of Columbia", "Florida","Georgia","Guam","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Carolina","North Dakota","Northern Marianas","Islands","Ohio","Oklahoma","Oregon","Pennsylvania","Puerto Rico","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Virgin Islands","Washington","West Virginia","Wisconsin","Wyoming"
    ];
    $( "#card__state" ).autocomplete({
      source: availableTags
    });
});