<?php
defined('_JEXEC') or die;
$user = JFactory::getUser();
?>
<style>
    .hidden {display: none;}
    .nextButton {background: #ccc;}
</style>
<div class="container">
    <div class="row justify-content-md-center">
        <div class="puzzle__level">            
        </div>
    </div>
    <?php

    ?>
    <?php foreach($this->item->params['questions'] as $key=>$question) : ?>
    <div class="container question-block<?=($key)?' hidden':'';?>" data-question="<?=$key;?>">        
        <div class="row">
	        <div class="level-block__title">
                    <?=$this->item->params['html']['block_title'];?>
                </div>
                <div class="level-block__description">
                    <?=$this->item->params['html']['block_description'];?>
                </div>	
            <div class="col question__title topTitle">
                <?=$question['question_title'];?>
            </div>
        </div>
        <div class="row">
            <div class="col answer_block answer_block__answer1">
                <span class="number">A:</span> <span class="answer"><?=$question['answer1'];?></span>
            </div>
                  <div class="col answer_block answer_block__answer2">
                <span class="number">В:</span> <span class="answer"><?=$question['answer2'];?></span>
            </div>
        </div>
        <div class="row">
            <div class="col answer_block answer_block__answer3">
                <span class="number">Б:</span> <span class="answer"><?=$question['answer3'];?></span>
            </div>
                 <div class="col answer_block answer_block__answer4">
                <span class="number">Г:</span> <span class="answer"><?=$question['answer4'];?></span>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
	<div class="container question-block<?=($key)?' hidden':'';?>" data-question="<?=count($this->item->params['questions']);?>">        
        <div class="row">
            <div class="col">
				Спасибо за Ваши ответы.
            </div>
        </div>        
    </div>
    
</div>


<script>
    var imageLevels = ['/images/level1111.jpg','/images/level222222.jpg','/images/level33333.jpg','/images/level44444.jpg'];
    jQuery(function ($) {
        $(document).ready(function () {
            $('#pass').on('click', function() {
                jQuery.ajax({
                    method: "POST",
                    url: "/index.php?option=com_ajax&plugin=events&task=pass&format=json",
                    dataType: 'json',
                    async: false,
                    data: {eid: <?=$this->item->id;?>}
                }).done(function(data) {
                    if (data.data[0].link != undefined) window.location = data.data[0].link;
                });
            });
            var questionBlock = 0;
            $('#tryAgain').on('click',function() {
	     	    $('#popup-lost').modal('hide');
	            return false;
	        });
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
                        },
						'subid' : <?=$this->subid;?>
                    }
                }).done(function(data) {
                    $('.sppb-btn').addClass('hidden');
                    if (data.data[0].nextQuestion == true) {
			            $('#imgLevel').attr('src',imageLevels[(questionBlock+1)]);
                        $('.question-block[data-question="'+ questionBlock +'"]').addClass('hidden');
	                    $('.question-block[data-question="'+ (questionBlock+1) +'"]').removeClass('hidden');
                    }
                    
                    if (data.data[0].activate == true) {
                        window.location.href = "/done-test";
                    }
                });
            });
            $('#nextQuestion').on('click', function() {
                $('.question-block[data-question="'+ questionBlock +'"]').addClass('hidden');
                $('.question-block[data-question="'+ (questionBlock+1) +'"]').removeClass('hidden');
            });
        });        
    });
</script>

