<?php
defined('_JEXEC') or die;
?>
<style>
    .hidden {display: none;}
</style>
<div class="container">
    <div class="row justify-content-md-center">
        <div class="puzzle__level">
            <img class="sppb-img-responsive" src="/images/level1111.jpg" alt="Image" title="">
        </div>
    </div>
    <?php

    ?>
    <?php foreach($this->item->params['questions'] as $key=>$question) : ?>
    <div class="container question-block<?=($key)?' hidden':'';?>" data-question="<?=$key;?>">
        <div class="row">
            <div class="col">
                <img src="<?=$question['image'];?>" alt="">
            </div>
            <div class="col">
                <div class="level-block__title">
                    <?=$question['block_title'];?>
                </div>
                <div class="level-block__description">
                    <?=$question['block_description'];?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col question__title topTitle">
                <?=$question['question_title'];?>
            </div>
        </div>
        <div class="row">
            <div class="col answer_block answer_block__answer1">
                <span>A:</span> <span class="answer"><?=$question['answer1'];?></span>
            </div>
            <div class="col answer_block answer_block__answer2">
                <span>В:</span> <span class="answer"><?=$question['answer2'];?></span>
            </div>
        </div>
        <div class="row">
            <div class="col answer_block answer_block__answer3">
                <span>Б:</span> <span class="answer"><?=$question['answer3'];?></span>
            </div>
            <div class="col answer_block answer_block__answer4">
                <span>Г:</span> <span class="answer"><?=$question['answer4'];?></span>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <div class="row">
        <div class="col">
            <a id="errorButton" class="sppb-btn buttonNext_error sppb-btn-custom sppb-btn-lg sppb-btn-round hidden">Вы ответили не правильно! Попробуйте еще раз!</a>
            <a id="nextQuestion" class="sppb-btn  buttonNext sppb-btn-custom sppb-btn-lg sppb-btn-round hidden">Следующий вопрос <i class="fa fa-angle-double-right"></i></a>
            <a href="/366" id="activateCertificate" class="sppb-btn buttonNext3 sppb-btn-custom sppb-btn-lg sppb-btn-round hidden">Перейти к активации сертификата <i class="fa fa-angle-double-right"></i></a>
        </div>
    </div>
</div>
<script>
    jQuery(function ($) {
        $(document).ready(function () {
            var questionBlock = 0;
            $('.answer_block').on('click', function() {
                var curAnswer = $(this).find('span.answer').text();
                questionBlock = $(this).parents('.question-block').data('question');
                $.ajax({
                    method: "POST",
                    url: "/index.php?option=com_ajax&plugin=puzzles&format=json",
                    dataType: 'json',
                    data: {
                        'puzzle' : {
                                <?=$this->item->id;?>:{
                                    'questionId': questionBlock,
                                    'answer': curAnswer
                                }
                        }
                    }
                }).done(function(data) {
                    $('.sppb-btn').addClass('hidden');
                    if (data.data[0].nextQuestion == true) {
                        $('#nextQuestion').removeClass('hidden');

                    }
                    if (data.data[0].nextQuestion == false) {
                        $('#errorButton').removeClass('hidden');
                    }
                    if (data.data[0].activate == true) {
                        $('#activateCertificate').removeClass('hidden');
                    }
                });
            });
            $('#nextQuestion').on('click', function() {
                $('.question-block[data-question="'+ questionBlock +'"]').addClass('hidden');
                $('.question-block[data-question="'+ (questionBlock+1) +'"]').removeClass('hidden');
            });
        });
        /*
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
        }); */
    });
</script>

