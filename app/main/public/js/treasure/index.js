//画面オブジェクト
var obj = $(this);
$(function(){
      showMainImages();
  });

//スクロールで表示されるコレクション(一回15件)
$(function () {
      $(window).bottom({proximity: 0.02});
      $(window).bind('bottom', function () {
                         if (data_end_flag == false) {

                             if (!obj.data('loading')) {
                                 obj.data('loading', true);
                                 //ロード中を表すGIF画像
                                 $('#loading').html('Loading...');
                                 setTimeout(function () {
                                                showMainImages();
                                            }, 1000); //追加表示を行うまで1秒間待機する
                             }
                         };
                         //$('html,body').animate({scrollTop: 0}, '1');
                     });
  }
 );

function response_output_html(object) {
    var html = '';
    for(var number = 0; number < object.length; number++) {
        html += '<li>';
        html += '<a href="/treasure/detail/' + object[number]['id'] + '">';
        html += '<img src="' + object[number]['thumbnail_url'] + '"/>';
        html += '</a>';
        html += '</li>';
    }
    return html;
}

function showMainImages()
{
    $.ajax({
               url: api_url,
               type: 'GET',
               dataType: 'json',
               data: {'limit' : limit, 'offset': offset, 'fields': 'id,thumbnail_url'}
           }).done(function(data){
                       if (data['count'] == 0) {
                           data_end_flag = true;
                           $('#load_navi').html('すべて表示したよ');
                       }

                       var object = data['result'];
                       var scroll_output_htmls = response_output_html(object);
                       $("#html").append(scroll_output_htmls);
                       //「Loading...」gifを消す
                       $('#loading').html('');
                       obj.data('loading', false);
                       offset += limit;
                   }).fail(function(data){
                               console.log("error");
                           });
}
