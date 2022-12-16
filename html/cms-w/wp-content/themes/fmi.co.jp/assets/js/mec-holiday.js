jQuery(function($){
  let $days;
  var observer = new MutationObserver(function(){
    $days = $('.fc-daygrid-day');
    console.log('change');
    $.getJSON('https://holidays-jp.github.io/api/v1/date.json', function(holidaysData){
      let holidays = Object.keys(holidaysData);
      let date;
      $days.each(function(i, elem){
        date = $(this).data('date');
        if($.inArray(date, holidays) !== -1){
          $(this).addClass('is-holiday');
        }
      });
    });
  });
  const calendar = document.querySelector('.fc-scrollgrid-sync-table');
  const config = {
    attributes: true,
    subtree: true
  };
  observer.observe(calendar, config);
});