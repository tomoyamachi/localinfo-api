$(function(){
      var d = $(document);

      //いいねボタンを押した時
      $('#btn_uploadLike').on('click', function(){
                                  var checked = $('#check_uploadLike').is(':checked');//bool

                                  // いいねの追加/削除をメソッドで分ける
                                  if (checked) {
                                      var httpType = 'POST';
                                  } else {
                                      var httpType = 'DELETE';
                                  }
                                  var count = Number($('#upload_likeCountNum').html());


                                  $.ajax({type: httpType,
                                          dataType: 'json',
                                          url: post_like_api_url,//いいねボタンURL
                                          xhrFields: {
                                              withCredentials: true
                                          }
                                         }).success(function(data){
                                                        //戻りがtrueの場合
                                                        console.log(data);
                                                        if(data) {
                                                            if(checked) {
                                                                $('#check_uploadLike').removeAttr('checked');
                                                                $('#upload_likeCountNum').html(count - 1);
                                                            } else {
                                                                $('#check_uploadLike').prop('checked','checked');
                                                                $('#upload_likeCountNum').html(count + 1);
                                                            }
                                                        }

                                                    }
                                                   );

                              }
                             );

      //コメントした時
      $('#form_uploadComment').on('submit', function(e){
                                      e.preventDefault();
                                      var val = $('#text_uploadComment').val();
                                      if (!val.match(/\S/g)) {
                                          return false;
                                      }
                                      var target = $('#upload_commentList');
                                      var comment_count = Number($('#upload_commentNum').html());
                                      $.ajax({
                                                 type: 'POST',
                                                 url: 'photo/commentSubmit',//コメントテンプレート
                                                 dataType: 'html',
                                                 data: {
                                                     id: id,
                                                     val: val
                                                 }
                                             })
                                          .success(function(data){
                                                       if(data) {
                                                           $('#upload_commentNum').html(comment_count + 1);
                                                           target.prepend(data);
                                                       }
                                                   });
                                      $(this)[0].reset();
                                  });
      //コメント削除
      d.on('click', '.upload_commentDeleteBtn', function(){
               var target = $(this).closest('li');
               var comment_id = $(this).data('comment_id');
               var comment_count = Number($('#upload_commentNum').html());
               $.ajax({
                          type: 'POST',
                          url: 'photo/commentDeleteSubmit',//ここでコメント削除処理
                          data: {
                              comment_id: comment_id
                          }
                      })
                   .success(function(data){
                                if (data) {
                                    $('#upload_commentNum').html(comment_count - 1);
                                    target.remove();
                                }
                            });
           });
      //バリデーション
      // $('#form_uploadComment').validate({
      //                                       rules: {
      //                                           text_uploadComment: {
      //                                               required: true,
      //                                               maxlength: 200
      //                                           }
      //                                       },
      //                                       messages: {
      //                                           text_uploadComment: {
      //                                               required: '感想を入力してください',
      //                                               maxlength: 'コメントは200文字以内で入力してください'
      //                                           }
      //                                       },
      //                                       errorElement: 'div',
      //                                       errorClass: 'form_error',
      //                                       errorPlacement: function(error, element) {
      //                                           error.insertAfter(element);
      //                                       }
      //                                   });

      $('#btn_uploadConfirm').on('click', function(){
                                     if($("#form_uploadComment").valid()){
                                         $("#form_uploadComment").submit();
                                         //submit後にエラー文を削除
                                         $("#text_uploadComment-error").html('');
                                         return false;
                                     }
                                     return true;
                                 });
  });


//過去にコメントされたものの表示
function showComment(object) {
    //配列の中身が無かったら
    if (typeof comment_id_arrays[0] === "undefined") {
        $('#watch_more').remove();
        return;
    }
    var target = $('#show_commentList');
    $.ajax({
               type: 'POST',
               url: 'photo/showCommentList',//コメントテンプレート
               dataType: 'html',
               data: {
                   comment_id_arrays: comment_id_arrays
               }
           })
        .success(function(data){
                     if(data) {
                         target.append(data);
                     }
                 });
    object.splice(0,5);
}

