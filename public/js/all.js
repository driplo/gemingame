$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

jQuery.fn.extend({
insertAtCaret: function(myValue){
  return this.each(function(i) {
    if (document.selection) {
      //For browsers like Internet Explorer
      this.focus();
      sel = document.selection.createRange();
      sel.text = myValue;
      this.focus();
    }
    else if (this.selectionStart || this.selectionStart == '0') {
      //For browsers like Firefox and Webkit based
      var startPos = this.selectionStart;
      var endPos = this.selectionEnd;
      var scrollTop = this.scrollTop;
      this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
      this.focus();
      this.selectionStart = startPos + myValue.length;
      this.selectionEnd = startPos + myValue.length;
      this.scrollTop = scrollTop;
    } else {
      this.value += myValue;
      this.focus();
    }
  })
}
});
/*DATE*/


$('document').ready(function(){
  
  /*INJECT DAYS LEFT*/
  todayDate = dateFns.format(new Date(), 'YYYY/MM/DD');
  startDate = $('.progress.timeline').attr('data-start-date');
  endDate = $('.progress.timeline').attr('data-end-date');
  daysLeft = dateFns.differenceInCalendarDays(endDate, todayDate);
  
  if (daysLeft < 0){
    $('.time-left-indic').text('0 day left');
  }
  else{
    $('.time-left-indic').text(daysLeft + ' days left');
  }
    
  /*JAUGE*/
  totalDays = dateFns.differenceInCalendarDays(endDate, startDate);
  currentPos = dateFns.differenceInCalendarDays(todayDate, startDate);
  posProgressBar = (currentPos / totalDays) * 100;
  $('.progress-bar').css('width', posProgressBar + '%');
  
  
  
});





$('.color-list li').each(function(index){
  dataColor = $(this).attr('data-color');
  $(this).css('background-color', dataColor);
});

$('.color-list').on('click', 'li', function(){
  $('.color-list li').removeClass('selected');
  $(this).addClass('selected');
  $('.challenge-color').val($(this).attr('data-color'));
});
function checkFirstTime(currentTab){
  console.log(currentTab);
  nbSelected = $('.tabs-scenario .tab-pane').eq(currentTab).find('.panel-element--selected').length;
  if (nbSelected > 0){
    return false;
  }
  else{
    return true;
  }
}

currentTab = 0;
allowNext = false;

$('.js-btn-element-next').on('click', function(){
  $('.js-btn-element-previous').removeAttr('disabled');
  currentTab++;
  
  if (currentTab == 5){
      $('.js-btn-element-next').attr('disabled', 'disabled');
  }

  if (currentTab+1 > $('.ideas-create .tab-pane').length){
    currentTab--;
  }
  else{
    $('.tab-pane--active').next().addClass('in active tab-pane--active');
    $('.tab-pane--active').first().removeClass('in active tab-pane--active');
  }

});

$('.js-btn-element-previous').on('click', function(){
  $('.js-btn-element-next').removeAttr('disabled');
  currentTab--;
  
  if (currentTab == '0'){
    $('.js-btn-element-previous').attr('disabled', 'disabled');
  }

  if (currentTab < 0){
    currentTab++;
  }
  else{
    $('.tab-pane--active').prev().addClass('in active tab-pane--active');
    $('.tabs-scenario .tab-pane').eq(currentTab+1).removeClass('in active tab-pane--active');

  }
});

$('.tabs-scenario .panel-element').on('click', function(){

  $elementText = $(this).find('.panel-body strong').text();
  $elementRating = $(this).find('.panel-footer').children().clone();

  $(this).closest('.tab-pane').find('.panel-element').removeClass('panel-element--selected');
  $(this).addClass('panel-element--selected');
  $('.element-recap').eq(currentTab).find('.panel-element').removeClass('panel-element--filling').addClass('panel-element--filled');

  /*CLEAN DIV*/
  $('.element-recap').eq(currentTab).find('.panel-element .placeholder-plus').remove();
  $('.element-recap').eq(currentTab).find('.panel-element .panel-body').children().remove();
  $('.element-recap').eq(currentTab).find('.panel-element .panel-footer').children().remove();


  /*INSERT DATA*/
  $('.element-recap').eq(currentTab).find('.panel-element .panel-body').html('<strong>' + $elementText +'</strong>');
  $('.story').eq(currentTab).text($elementText);
  $('.element-recap').eq(currentTab).find('.panel-element .panel-footer').html($elementRating);

  /*Fill form elements hidden input*/
  $('.elements-form input').eq(currentTab).val($elementText);
  $('input[name=rebound]').val(false);

  var elementsFilled = $('.panel-element--filled').length;

  if (elementsFilled === $('.element-recap').length){
      $('.js-btn-switch-write').attr('disabled', false).removeClass('btn-main--disabled');
    }

});


$('.js-btn-switch-write').on('click', function(){
  $('.ideas-create').hide('fast');
  $('.ideas-propose').show('fast');
  $(this).hide('fast');
});

$('.js-modify-elements').on('click', function(){
  $('.ideas-propose').hide('fast');
  $('.ideas-create').show('fast');
  $('.js-btn-switch-write').show('fast');
});

//rebound

//# sourceMappingURL=all.js.map
