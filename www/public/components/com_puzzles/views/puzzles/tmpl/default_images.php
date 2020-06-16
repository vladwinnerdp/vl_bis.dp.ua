<?php
defined('_JEXEC') or die;
?>
<style>
    body{font-family:"Montserrat",arial,sans-serif;font-weight:500;font-size:14px;overflow-y:scroll;overflow-x:hidden;}
    a:hover{text-decoration:none;}
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
    .body_riddle .bounceInUp{animation-duration:1.5s;
        -webkit- animation-duration:1.5s;}
    .main_riddle.shake{animation-duration:1s;
        -webkit- animation-duration:1s;
        animation-delay:3.5s;
        -webkit- animation-delay:3.5s;}

    .topper_riddle .container,.body_riddle .container{max-width:800px;}

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
</style>
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">



<div class="body_riddle">
    <div class="container bounceInUp">
        <div class="row">
            <div class="col-12">

                <h3><?=$this->item->params['images_params']['puzzle_title'];?></h3>
                <div class="text_riddle"><?=$this->item->params['images_params']['puzzle_description'];?></div>
                <div class="choose">Выберите карточку <i class="far fa-hand-point-down"></i></div>
                <form  id="star_trek_quiz">
                <div class="main_riddle shake">

                        <?php foreach($this->item->params['images'] as $key=>$image) :?>
                            <label class="block">
                                <img src="<?=$image['image'];?>">
                                <?=$image['image_title'];?>
                                <input name="puzzle[<?=$this->item->id;?>]" type="radio" value="<?=$key;?>">

                                <span class="checkmark"></span>
                            </label>
                        <?php endforeach; ?>

                </div>

                <div class="btn-wrapper">
                    <button class="btn-check"><i class="fas fa-star"></i> Проверить ответ <i class="fas fa-star"></i></button>
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
        $('button.btn-check').on('click', function() {
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

