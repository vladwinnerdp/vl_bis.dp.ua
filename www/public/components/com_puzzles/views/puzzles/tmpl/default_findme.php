<?php
defined('_JEXEC') or die;
$imgParams = getimagesize(JUri::root().$this->item->params['findme']['image']);
$rightOffset = ceil(($this->item->params['findme']['left'])/ ($imgParams[0]/100));
$topOffset = ceil($this->item->params['findme']['top'] / ($imgParams[1]/100))-3;
$selectionWidth = ceil(($this->item->params['findme']['width'])/ ($imgParams[0]/100));
$selectionHeight = ceil(($this->item->params['findme']['height'])/ ($imgParams[0]/100));

?>
<style>

</style>
<div class="container puzzle">
    <div class="row">
        <div class="col">
            <div class="puzzle__title">
                <?=$this->item->params['findme']['question'];?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="puzzle__image">
                <img width="100%" src="<?=$this->item->params['findme']['image'];?>" alt="">
                <div id="findMe"></div>
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
                        <div class="icon-block"><h5><?=$this->item->bonuses;?> $</h5><span>ваш бонус</span></div>
                    </div>
                </div>
            </div>

            <div class="stat">На эту сумму будет уменьшена стоимость вашего заказа.</div>
            <!-- <a href="#" class="button">Перейти к следующему испытанию</a> -->
            <a href="#" class="link">Потратить бонусы на покупку</a>
        </div>
    </div>
</div>
<style>
    .puzzle__image {
        position: relative;
    }
    .puzzle__image img {
        widht: 100%;
        display: inline;
    }
    #findMe {
        position: absolute;
        bottom: <?=$topOffset;?>%;
        right: <?=$rightOffset?>%;
        z-index: 10;
        width:  <?=$selectionWidth;?>%;
        height: <?=$selectionHeight;?>%;
    }
</style>
<script>
    jQuery(function ($) {
        $(document).ready(function () {
            $('#findMe').on('click', function() {
                verifyEventAnswer(<?=$this->item->id;?>);
                $('#popup-win').modal('show');
            });
        });

    });
</script>

