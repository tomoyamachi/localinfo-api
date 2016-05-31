var exports = exports || {};

(function(exports) {

     'use strict';

     (function() {
          exports.common = exports.common || {};
      }) ();
     /*
      *  @author Gochipon Inc.
      *
      */

     /* jshint -W004 */
     /* jshint -W069 */
     (function() {

          var Config = exports.common.Config = function() {
          };

console.log(Config);
          /*
           *  @const ディスプレイの解像度
           */
          Config.prototype.RATIO = window.devicePixelRatio > 2 ? 2 : window.devicePixelRatio;

          /*
           *  @const 表示領域の横幅(px)
           */
          Config.prototype.WIDTH = document.documentElement.clientWidth;

          /*
           *  @const 表示領域の縦幅(px)
           */
          Config.prototype.HEIGHT = document.documentElement.clientHeight;

          var supportTouch = 'ontouchend' in window;

          Config.prototype.TOUCHSTART = function() {
              var str;
              if (supportTouch) {
                  str = "touchstart";
              } else {
                  str = "mousedown";
              }
              return str;
          };

          Config.prototype.TOUCHMOVE = function() {
              var str;
              if (supportTouch) {
                  str = "touchmove";
              } else {
                  str = "mousemove";
              }
              return str;
          };

          Config.prototype.TOUCHEND = function() {
              var str;
              if (supportTouch) {
                  str = "touchend";
              } else {
                  str = "mouseup";
              }
              return str;
          };


          exports.common.config = new Config();

      }) ();

     (function() {

          var AddComment = function() {
          };

          AddComment.prototype.execute = function(){

              this.add = function (url) {
                  $.ajax({
                             type: 'get',
                             url: url,
                             dataType: 'json'
                         })
                      .success(function(data) {
                                   $.ajax({
                                              type: 'post',
                                              url:  '/template_commentList.html',
                                              data: {
                                                  data: data
                                              }
                                          })
                                       .success(function(html){
                                                    $('#comment_list').append(html);
                                                })
                                       .error(function(){
                                                  exports.common.ajaxModal.error();
                                              });
                               })
                      .error(function(){
                                 exports.common.ajaxModal.error();
                             });
              };

          };

          exports.common.addComment = new AddComment();

      })();
     (function() {

          var AddItem = function() {
          };

          AddItem.prototype.execute = function(){

              this.add = function (url, target) {
                  $.ajax({
                             type: 'get',
                             url: url,
                             dataType: 'json'
                         })
                      .success(function(data) {
                                   $.ajax({
                                              type: 'post',
                                              url:  '/template_item.html',
                                              data: {
                                                  data: data
                                              }
                                          })
                                       .success(function(html){
                                                    target.append(html);
                                                })
                                       .error(function(){
                                                  exports.common.ajaxModal.error();
                                              });
                               })
                      .error(function(){
                                 exports.common.ajaxModal.error();
                             });
              };

          };

          exports.common.addItem = new AddItem();

      })();

     (function() {

          var AjaxModal = function() {
          };

          AjaxModal.prototype.execute = function(){
              $.fn.modal.Constructor.DEFAULTS.backdrop = false;

              var d = $(document);
              var b = $('body');

              function ajaxModal(url, callback) {
                  $.ajax({
                             type: 'POST',
                             url: url,
                             dataType: 'html',
                         })
                      .success(function(data){
                                   exports.common.ajaxModal.show(data, callback);
                               })
                      .error(function(){
                                 exports.common.ajaxModal.error();
                             });
              }

              function ajaxModalForm(url, method, formData, callback) {
                  $.ajax({
                             type: method,
                             url: url,
                             data: formData,
                             processData: false,
                             contentType: false
                         })
                      .success(function(data){
                                   exports.common.ajaxModal.show(data, callback);
                               })
                      .error(function(){
                                 exports.common.ajaxModal.error();
                             });
              }

              var click_flag = false;

              this.on = function(url, elem, e, callback) {
                  e.preventDefault();
                  if (click_flag) {
                      return;
                  }

                  click_flag = true;

                  if($('.modal')[0]){
                      $('.modal').modal('hide');
                      setTimeout(function(){
                                     ajaxModal(url, callback);
                                     setTimeout(function(){
                                                    click_flag = false;
                                                }, 1000);
                                 }, 1000);
                  } else {
                      ajaxModal(url, callback);
                      setTimeout(function(){
                                     click_flag = false;
                                 }, 1000);
                  }

              };

              this.form = function(url, elem, e, callback) {
                  e.preventDefault();
                  if (click_flag) {
                      return;
                  }

                  click_flag = true;

                  var form = $(elem).closest('form');
                  var method = form.attr('method');
                  var formData = new FormData(form.get()[0]);

                  if($('.modal')[0]){
                      $('.modal').modal('hide');
                      setTimeout(function(){
                                     ajaxModalForm(url, method, formData, callback);
                                     setTimeout(function(){
                                                    click_flag = false;
                                                }, 1000);
                                 }, 1000);
                  } else {
                      ajaxModalForm(url, method, formData, callback);
                      setTimeout(function(){
                                     click_flag = false;
                                 }, 1000);
                  }

              };

              this.show = function(data, callback){
                  $('<div class="modal hide fade ajax_modal">' + data + '</div>').modal();
                  if(!(typeof(callback)=="undefined" || !callback || callback===null)) {
                      callback();
                  }
              };

              this.error = function() {
                  var html = '<div class="modal hide fade ajax_modal"><div class="modal_dialog modal_dialog-vCenter"><div class="modal_contents"><div class="modal_close"><a data-dismiss="modal" aria-label="Close"><svg role="image" class="modal_closeIcon"><use xlink:href="/images/svg/icons.svg#icon_close" /></svg></a></div><div class="modal_text">通信エラーが発生しました。通信環境をご確認のうえ、再度実行してください。</div></div></div></div>';
                  if($('.modal')[0]){
                      $('.modal').modal('hide');
                      setTimeout(function(){
                                     $(html).modal();
                                     setTimeout(function(){
                                                    click_flag = false;
                                                }, 1000);
                                 }, 1000);
                  } else {
                      $(html).modal();
                      setTimeout(function(){
                                     click_flag = false;
                                 }, 1000);
                  }

              };

              //ajaxで表示したmodalを閉じる場合は要素を除去する
              d.on('hidden.bs.modal', '.ajax_modal', function(){
                       $(this).remove();
                   });

          };

          exports.common.ajaxModal = new AjaxModal();

      })();
     (function() {

          var Hover = function() {
          };

          Hover.prototype.execute = function(){
              var init = function() {
                  $("a, button").on(exports.common.config.TOUCHSTART() + " " + exports.common.config.TOUCHMOVE() + " " + exports.common.config.TOUCHEND(), touchEventHandler);
              };
              var touchEventHandler = function(e) {
                  if (e.type === "touchstart" || e.type === "mousedown") {
                      $(this).addClass("hover");
                  } else {
                      $(this).removeClass("hover");
                  }
              };
              $(init);

          };

          exports.common.hover = new Hover();

      })();
     (function() {
          exports.common.Ready = function() {
              exports.common.ajaxModal.execute();
              exports.common.hover.execute();
              exports.common.scroll.execute();
              exports.common.addItem.execute();
              exports.common.addComment.execute();
              exports.common.search.execute();
          };
      })();
     (function() {

          var Scroll = function() {
          };

          Scroll.prototype.execute = function(){
              var target = $('#postBtn');
              $(window).scroll(function() {
                                   clearTimeout($.data(this, 'scrollTimer'));
                                   target.addClass('hide');
                                   $.data(this, 'scrollTimer', setTimeout(function() {
                                                                              target.removeClass('hide');
                                                                          }, 250));
                               });
          };

          exports.common.scroll = new Scroll();

      })();
     (function() {

          var Search = function() {
          };

          Search.prototype.execute = function(){
              var d = $(document);
              d.on('change', '.search_input', function() {
                       if($(this).length && $(this).val().length) {
                           $(this).next('label').css('display', 'none');
                       } else {
                           $(this).next('label').css('display', 'block');
                       }
                   });
          };

          exports.common.search = new Search();

      })();

 }) (exports);
