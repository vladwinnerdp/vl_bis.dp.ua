<?php
defined('_JEXEC') or die;
?>
<style>
    body{font-family:"Montserrat",arial,sans-serif;font-weight:500;font-size:14px;}
    a:hover{text-decoration:none;}
    .body_riddle .bounceInUp{animation-duration:1.5s;
        -webkit- animation-duration:1.5s;}
    .main_riddle.shake{animation-duration:1s;
        -webkit- animation-duration:1s;
        animation-delay:3.5s;
        -webkit- animation-delay:3.5s;}

    .topper_riddle .container,.body_riddle .container{max-width:800px;}
    /* ВЕРХНИЙ БЛОК ДОСТИЖЕНИЙ ЗАГАДКИ */
    .topper_riddle{background:rgba(0,0,0,0.05);padding:8px 0 8px 0;}
    .nav-bar{position:relative;text-align:center;}

    /* КНОПКА НАЗАД */
    .topper_riddle .arrow{background:rgba(0,0,0,0.1);width:25px;height:25px;display:inline-block;font-size:12px;line-height:25px;border-radius:50%;text-align:center;color:#333;transition:.5s;box-shadow:0px 2px 0px rgba(0,0,0,0.3);position:absolute;left:5px;top:-3px;}
    .topper_riddle .arrow-right{background:rgba(0,0,0,0.1);width:25px;height:25px;display:inline-block;font-size:12px;line-height:25px;border-radius:50%;text-align:center;color:#333;transition:.5s;box-shadow:0px 2px 0px rgba(0,0,0,0.3);position:absolute;right:5px;top:-3px;}
    .topper_riddle .arrow:hover{background:#388E3C;box-shadow:0 2px 0 #1e5821;color:white;transform:translateX(-5px);}
    .topper_riddle .arrow-right:hover{background:#388E3C;box-shadow:0 2px 0 #1e5821;color:white;transform:translateX(5px);}

    /* СТАТИСТИКА */
    .topper_riddle .bonuses{padding:0 30px;color:#333;font-size:10px;cursor:pointer !important;}
    .topper_riddle  .number,.topper_riddle .winners{color:#333;font-size:12px;font-weight:700;vertical-align:middle;}
    .topper_riddle .sertificates{vertical-align:middle;color:#333;font-size:12px;cursor:pointer !important;}

    /* БЛОК СЕРТИФИКАТОВ */
    .sertificates .icon-wrapper{display:inline-block;width:20px;margin-right:10px;vertical-align:top;}

    /* БЛОК БОНУСОВ */
    .bonuses .icon-wrapper{display:inline-block;vertical-align:top;width:20px;margin-right:5px;}

    /* БЛОК ПОБЕДИТЕЛЕЙ */
    .winners .icon-wrapper{display:inline-block;vertical-align:top;width:20px;margin-right:5px;}




    @media screen and (max-width:545px){.topper_riddle .winners{display:none;}
        .topper_riddle .text{display:none;}}

    @media screen and (max-width:400px){
        .topper_riddle .bonuses {
            padding: 0 10px 0 30px;}}


    /* Баннер загадки */
    .banner_riddle{min-height:180px;display:block;width:100%;background: #2c2e3b url(https://prizolove.com/images/banner_riddle3.png) no-repeat center center;background-size:cover;}

    /* ТЕЛО ЗАГАДКИ */
    .body_riddle{padding-top:15px;text-align:center;}
    .body_riddle h3{font-size:25px;font-weight:700;}
    .body_riddle .text_riddle{font-size:18px;line-height:1.3em;color:#333;}


    /* Выберите карточку */
    .choose{text-align:center;font-size:18px;line-height:1.3em;margin:15px 0;color:#2ecc71;font-weight:700;}

    /* ФУНКЦИОНАЛ ЗАГАДКИ */
    .main_riddle{text-align:center;}
    .main_riddle .block{width:24%;margin:0px 5px 15px 0px;display:inline-block;padding:5px;box-shadow:0px 2px 6px rgba(0,0,0,0.15);background:white;border-radius:3px;border:2px solid gray;text-align:center;font-size:16px;font-weight:600;font-family:"Montserrat",sans-serif;transition:.2s;position:relative;}
    @media screen and (max-width:600px){
        .main_riddle{text-align:center;}
        .main_riddle .block{width:24%;margin:20px 0px;}}


    .main_riddle .block img{width:75px;text-align:center;display:block;margin:0 auto;margin-bottom:10px;}
    @media screen and (max-width:470px){.main_riddle .block img{width:50px;}}

    .main_riddle .block:hover{transform:scale(1.01);box-shadow:0px 2px 6px rgba(0,0,0,0.3);cursor:pointer;}

    .main_riddle .block input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }


    .main_riddle .checkmark {
        position: absolute;
        top: 5px;
        left: 5px;
        height: 18px;
        width: 18px;
        background-color: #eee;
        border-radius: 50%;
        transition:.2s;
    }


    .main_riddle .block:hover input ~ .checkmark {
        background-color: #ccc;
    }


    .main_riddle .block input:checked ~ .checkmark {
        background-color: #388E3C;
    }


    .main_riddle .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }


    .main_riddle .block input:checked ~ .checkmark:after {
        display: block;
    }



    .main_riddle .block .checkmark:after {
        top: 50%;
        left: 50%;transform:translate(-50%,-50%);
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white;
    }


    /* Кнопка "Проверить ответ" */
    .btn-wrapper{margin-bottom:40px;}
    .btn-wrapper .btn-check{background:#2ecc71;border:none;border-radius:0;max-width:280px;text-align:center;width:100%;display:block;margin:0 auto;padding:8px 0;color:white;font-size:16px;font-weight:bold;box-shadow:0px 2px 0 #27ae60;cursor:pointer;transition:.2s;}
    .btn-wrapper .btn-check i{font-size:10px;transition:.2s}
    .btn-wrapper .btn-check:hover{transform:translateY(-3px);}
    .btn-wrapper .btn-check:hover i:first-child{transform:translateX(-5px) rotate(-90deg);}
    .btn-wrapper .btn-check:hover i:last-child{transform:translateX(5px) rotate(90deg);}


    /* Блок изображения у загадки */
    .body_riddle .image-wrapper{max-width:400px;overflow:hidden;margin:0 auto;height:250px;position:relative;}
    .body_riddle .image-wrapper img{position:absolute;max-width:100%;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);}

    /* Буквы */

    .letters-wrapper{text-align:center;margin-bottom:20px;}
    .letters-wrapper .letter{display:inline-block;width:50px;height:50px;vertical-align:top;background:  #100C54;border-radius:5px;margin:0 3px;font-size:25px;line-height:50px;color:white;text-transform:uppercase;font-weight:700;position:relative;}
    .letters-wrapper .letter input[type=text]{position:absolute;top:0;left:0;width:100%;height:100%;border:none;background:transparent;text-transform:uppercase;color:white;font-size:25px;line-height:50px;font-weight:700;text-align:center;}




    /* Popup-bg */
    #popup-win{display:none;}
    /* Затемненный фон */
    .overlay-bonuses{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.4);}

    /* Стили попапа */
    .popup-bonuses-spis{font-family:"Montserrat",arial,sans-serif;font-weight:500;max-width:500px;background:white;min-height:100px;width:100%;position:absolute;top:0;left:50%;margin-top:20px;transform:translateX(-50%);border-radius:5px;box-shadow:0px 2px 8px rgba(0,0,0,0.15);text-align:center;padding:0 0px 20px 0px;}

    .popup-bonuses-spis .topper{text-align:center;width:100%;padding:10px 0 20px 0;background:url(https://prizolove.com/images/topper_sert.png) no-repeat 0% 120%;background-size:cover;}
    .popup-bonuses-spis .topper img{width:35px;margin-left:-30px;}


    .popup-bonuses-spis .icon-wrapper{display:inline-block;width:20px;vertical-align:middle;margin-right:5px;}
    .popup-bonuses-spis h5{font-size:21px;font-weight:700;margin:0px 0 20px 0;}
    .popup-bonuses-spis .stat{font-size:14px;line-height:21px;margin:10px 0;}
    .popup-bonuses-spis .stat span{font-weight:700;font-size:16px;}
    .popup-bonuses-spis .line{width:100%;height:1px;background:rgba(0,0,0,0.1);margin:20px 0;}

    .popup-bonuses-spis .link{color:#e74c3c;margin-top:20px;display:inline-block;font-size:12px;text-decoration:none;border-bottom:1px solid #e74c3c;padding-bottom:5px;transition:.2s;}
    .popup-bonuses-spis .link:hover{color:#c0392b;border-bottom:1px solid #c0392b;transform:translateY(-3px);}

    .popup-bonuses-spis .button{display:block;max-width:350px;text-align:center;width:100%;margin:0 auto;background:#2ECC71;padding:8px 0;    color: white;
        font-size: 16px;
        font-weight: bold;
        box-shadow: 0px 2px 0 #27ae60;transition:.2s;}

    .popup-bonuses-spis .button:hover {
        transform: translateY(-3px);
    }


    /* Анимация */
    @-webkit-keyframes rotateInUpLeft {
        from {
            -webkit-transform-origin: left bottom;
            transform-origin: left bottom;
            -webkit-transform: rotate3d(0, 0, 1, 45deg);
            transform: rotate3d(0, 0, 1, 45deg);
            opacity: 0;
        }

        to {
            -webkit-transform-origin: left bottom;
            transform-origin: left bottom;
            -webkit-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
            opacity: 1;
        }
    }

    @keyframes rotateInUpLeft {
        from {
            -webkit-transform-origin: left bottom;
            transform-origin: left bottom;
            -webkit-transform: rotate3d(0, 0, 1, 45deg);
            transform: rotate3d(0, 0, 1, 45deg);
            opacity: 0;
        }

        to {
            -webkit-transform-origin: left bottom;
            transform-origin: left bottom;
            -webkit-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
            opacity: 1;
        }
    }

    .rotateInUpLeft {
        -webkit-animation-duration:1s;
        animation-duration:1s;
        -webkit-animation-name: rotateInUpLeft;
        animation-name: rotateInUpLeft;
    }



    /* НОВЫЕ СТИЛИ ДИМА */
    .popup-bonuses-spis .good{    text-align: center;
        font-size: 21px;
        font-weight: bold;
        color: #388E3C;
        font-family: "Montserrat",arial,sans-serif;
        margin-top: 20px;}
    .popup-bonuses-spis .text-good{font-size:14px;}

    .answer-good .fireworks{display:block;width:160px;height:160px;margin:10px auto 10px auto;position:relative;}
    .answer-good .fireworks .ramka{display:block;font-family:"Montserrat",arial,sans-serif;text-align:center;background:url(https://prizolove.com/images/Ramka-1.png) no-repeat center center;width:160px;height:160px;background-size:cover;position:relative; -webkit-animation-name: tada;
        animation-name: tada;
        -webkit-animation-duration: 1s;
        animation-duration: 1s; }

    .answer-good .ramka .icon-block{width:125px;height:125px;text-align:center;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);background:black;border-radius:50%;overflow:hidden;background-color:#388E3C;color:white;}
    .answer-good .ramka .icon-block h5{font-weight:800;font-size:40px;margin-bottom:0px;margin-top:25px;}
    .answer-good .ramka .icon-block span{font-size:16px;font-weight:500;}





    @-webkit-keyframes tada {
        from {
            -webkit-transform: scale3d(1, 1, 1);
            transform: scale3d(1, 1, 1);
        }

        10%,
        20% {
            -webkit-transform: scale3d(0.9, 0.9, 0.9) rotate3d(0, 0, 1, -3deg);
            transform: scale3d(0.9, 0.9, 0.9) rotate3d(0, 0, 1, -3deg);
        }

        30%,
        50%,
        70%,
        90% {
            -webkit-transform: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, 3deg);
            transform: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, 3deg);
        }

        40%,
        60%,
        80% {
            -webkit-transform: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, -3deg);
            transform: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, -3deg);
        }

        to {
            -webkit-transform: scale3d(1, 1, 1);
            transform: scale3d(1, 1, 1);
        }
    }

    @keyframes tada {
        from {
            -webkit-transform: scale3d(1, 1, 1);
            transform: scale3d(1, 1, 1);
        }

        10%,
        20% {
            -webkit-transform: scale3d(0.9, 0.9, 0.9) rotate3d(0, 0, 1, -3deg);
            transform: scale3d(0.9, 0.9, 0.9) rotate3d(0, 0, 1, -3deg);
        }

        30%,
        50%,
        70%,
        90% {
            -webkit-transform: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, 3deg);
            transform: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, 3deg);
        }

        40%,
        60%,
        80% {
            -webkit-transform: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, -3deg);
            transform: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, -3deg);
        }

        to {
            -webkit-transform: scale3d(1, 1, 1);
            transform: scale3d(1, 1, 1);
        }
    }



    .answer-good .fireworks::before,.answer-good .fireworks::after{
        content:"";
        position:absolute;
        display:block;
        width:100px;
        height:100px;
    }
    .answer-good .fireworks::before{left:-150px;top:35px;;background:url(https://prizolove.com/images/firework-left-popup.png) no-repeat center center;background-size:contain;transform:translateX(100px);-webkit-animation-duration: 1s;
        animation-duration: 1s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;    -webkit-animation-name: leftFadeIn;
        animation-name: leftFadeIn;}
    .answer-good .fireworks::after{right:-150px;top:35px;
        background:url(https://prizolove.com/images/firework-right-popup.png) no-repeat center center;background-size:contain;transform:translateX(-100px);-webkit-animation-duration: 1s;
        animation-duration: 1s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;    -webkit-animation-name: rightFadeIn;
        animation-name: rightFadeIn;}

    @-webkit-keyframes leftFadeIn {
        0% {
            opacity: 0;
            transform:translateX(100px);
        }


        100% {
            opacity: 1;
            transform:translateX(25px);
        }
    }

    @keyframes leftFadeIn {
        0% {
            opacity: 0;
            transform:translateX(100px);
        }


        100% {
            opacity: 1;
            transform:translateX(50px);
        }
    }


    @-webkit-keyframes rightFadeIn {
        0% {
            opacity: 0;
            transform:translateX(-100px);
        }


        100% {
            opacity: 1;
            transform:translateX(-25px);
        }
    }

    @keyframes rightFadeIn {
        0% {
            opacity: 0;
            transform:translateX(-100px);
        }


        100% {
            opacity: 1;
            transform:translateX(-50px);
        }
    }



    .title-good .green-text{text-align:center;font-size:21px;font-weight:bold;color:#388E3C;font-family:"Montserrat",arial,sans-serif;margin-top:20px;}
    .text-good{font-size:21px;text-align:center;font-family:"Montserrat",arial,sans-serif;color:#333;font-weight:500;}


    .arrow-down{text-align:center;font-size:21px;font-family:Montserrat,arial,sans-serif;font-weight:500;}
    .arrow-down .arrow{width:40px;height:40px;border-radius:50%;background:red;color:white;line-height:40px;text-align:center;font-size:25px;margin:10px auto 20px auto;animation-name: expandUp;
        -webkit-animation-name: expandUp;

        animation-duration: 2s;
        -webkit-animation-duration: 2s;

        -webkit-animation-iteration-count: infinite;
        animation-iteration-count: infinite;
        animation-timing-function: ease-in-out;
        -webkit-animation-timing-function: ease-in-out;

        visibility: visible !important; }

    @keyframes expandUp {
        0% {
            transform: translateY(0px);
        }
        50%{
            transform: translateY(20px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    @-webkit-keyframes expandUp {
        0% {
            -webkit-transform: translateY(0px);
        }
        50%{
            -webkit-transform: translateY(20px);
        }

        100% {
            -webkit-transform: translateY(0px);
        }
    }
</style>
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">



<div class="body_riddle">
  <div class="container bounceInUp">
    <div class="row">
      <div class="col-12">
      <form>
        <h3><?=$this->item->params['question'];?></h3>
        <div class="image-wrapper"><img src="<?=$this->item->params['image'];?>"></div>
        <div class="choose">Введите ваш ответ <i class="far fa-hand-point-down"></i></div>
        <div class="main_riddle shake">
          <div class="letters-wrapper">
              <?php $chrArray = preg_split('//u', $this->item->params['template'], -1, PREG_SPLIT_NO_EMPTY); ?>
                  <?php
                  foreach($chrArray as $i=>$letter) {
                      if ($letter != '_' && $letter != ' ') {
                          echo '<div class="letter">'.$letter.'</div>';
                      } else {
                          if ($letter == ' ') {
                              echo '&nbsp;';
                          } else {
                              echo '<div class="letter"><input class="letter'.$i.'" type="text" name="puzzle['.$this->item->id.']['.$i.']" maxlength="1" autocomplete="off"></div>';
                          }
                      }
                  }
                  ?>
          </div>
        </div>
        
        
        <div class="btn-wrapper">
          <button class="btn-check" type="submit"><i class="fas fa-star"></i> Проверить ответ <i class="fas fa-star"></i></button>
        </div>
      </form>

      </div>
    </div>
  </div>
</div>
<div id="popup-win" class="modal fade pl-modal" role="dialog">
    <div class="modal-dialog">
        <div class="popup-bonuses-spis bounceInUp">
            <div class="topper">
                <img class="rotateInUpLeft" src="https://prizolove.com/images/diamond_red.png">
            </div>
            <h5 class="good"><i class="fas fa-check-circle"></i> Супер! Ваш ответ верен</h5>
            <div class="text-good">
                <b class="your-sertificate">Сертификат Финалиста на розыгрыш 10 000$ ваш!</b><br/>Что бы он принял участие в розыгрыше нужна одна покупка<br/><br/>Пройдя испытание вы выиграли:
            </div>
            <div class="answer-good">
                <div class="fireworks">
                    <div class="ramka">
                        <div class="icon-block"><h5>1.2 $</h5><span>ваш бонус</span></div>
                    </div>
                </div>
            </div>

            <div class="stat">На эту сумму будет уменьшена стоимость вашего заказа.</div>
            <!-- <a href="#" class="button">Перейти к следующему испытанию</a> -->
            <a href="#" class="link">Потратить бонусы на покупку</a>
        </div>
    </div>
</div>
<div id="popup-lost" class="modal fade pl-modal" role="dialog">
    <div class="modal-dialog">
        <div class="popup-bonuses-spis">
            <div class="topper">
                <img class="rotateInUpLeft" src="https://prizolove.com/images/diamond_red.png">
            </div>
            <h5 class="notgood"><i class="fas fa-times-circle"></i> Ваш ответ не верен</h5>
            <div id="penalty">
                <div class="text-notgood">
                    <b class="your-sertificate"><br/>За непройденное испытание с вас списано:</b>
                </div>
                <div class="answer-notgood">
                  <div class="fireworks">
                  <div class="ramka">
                    <div class="icon-block"><h5>0.1</h5></div>
                  </div>
                  </div>
                </div>
                <div class="text-notgood">
                    <b class="your-sertificate"><br/>c бонусного счета в пользу автора испытания.<br />Автор Испытания: Сергей Малыш.</b>
                </div>
            </div>
            <a href="#" class="button">Попробовать еще</a>
        </div>
    </div>
</div>
<script>
    jQuery(function ($) {
        $(document).ready(function () {
            $('input[name^="puzzle"][class*="letter"]').on('keydown', function (event) {
                var questions = $('input[name*="puzzle"][class*="letter"]');
                var questionIndex = questions.index($(this));
                var key = event.keyCode || event.charCode;
                if (key == 8 || key == 46) {
                    if ((questionIndex - 1) >= 0 && $(this).val() == '') {
                        questions.eq(questionIndex - 1).focus();
                    }
                }
            });
        });
        $('input[name^="puzzle"][class*="letter"]').on('input', function () {
            var questions = $('input[name*="puzzle"][class*="letter"]');
            var questionIndex = questions.index($(this));
            ;
            if ((questionIndex < (questions.length - 1)) && $(this).val() != '') {
                questions.eq(questionIndex + 1).focus();
            }
        });
        $('form').on('submit', function() {
            var curForm = $('form').serialize();
            $.ajax({
                method: "POST",
                url: "/index.php?option=com_ajax&plugin=puzzles&format=json",
                dataType: 'json',
                data: curForm

            }).done(function(data) {
                if (data.data[0].correct == true) {
                    $('#popup-win .icon-block h5').text(data.data[0].bonuses);
                    $('#popup-win').modal('show');
                } else {
                    if (data.data[0].penalty > 0) {
                        $('#popup-lost #penalty').show();
                    } else {
                        $('#popup-lost #penalty').hide();
                    }
                    $('#popup-lost').modal('show');
                }
            });
            return false;
        });
    });
</script>
