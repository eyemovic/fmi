
 jQuery(function($){
//メールでの問い合わせ  購入 or セミナー　選択
var $selectQues = $('.js-select-ques');
var $selectAns = $('.js-select-ans');

$selectQues.on('change', function() {
    $selectAns.removeClass('form-inquiry form-seminar');

    var selectNum = $(this).val();
    if(selectNum == 0) {
        $selectAns.addClass('form-inquiry');
    } else if (selectNum == 1) {
        $selectAns.addClass('form-seminar');
    }
});


//日付選択カレンダー （希望日選択）
if($('.mail-form-date').length){
    flatpickr('.mail-form-date', {
        dateFormat: "Y-m-d",
    });
}


//電話でのお問い合わせ 場所選ぶリスト
 // var $telSelectBtn = $('.js-tel-select-btn');
 // var $telSelectUl = $('.js-tel-select-ul');
 // var $telSelectList = $('.js-tel-select-list');
 // var $telPlaceAns = $('.js-tel-place-ans');

//ボタン押したらメニュー表示
 // $telSelectBtn.on('click', function(){
 //    $telSelectUl.slideDown(200, 'swing');

    //リストをクリック ボタンテキスト変更
    // $telSelectList.each(function (){
    //     $(this).off('click');
    //     $(this).on('click', function(){
    //         var listValue = $(this).text();
    //         $telSelectBtn.text(listValue);
    //         $telSelectUl.slideUp(200, 'swing');

    //         //リスト対応の電話番号を表示
    //         $telPlaceAns.css('display', 'none');
    //         var selectIndex = $(this).index();
    //         $telPlaceAns.eq(selectIndex).slideDown(200, 'swing');
    //     });
    // });

    //ボタンクリック リストslideup
 //    $telSelectBtn.off('click');
 //    $telSelectBtn.on('click', function(){
 //        $telSelectUl.slideToggle();
 //    });
 // });


//メール、電話タブ表示切り替え
var urlPrarm = location.search.substring(1);
var $contactTabMenu = $('.js-contact-tabMenu');
var $contactTabInput = $contactTabMenu.find('input');

if(urlPrarm == "tel") {
    $contactTabInput.prop('checked', false);
    $contactTabInput.eq(1).prop("checked", true);
}

});
