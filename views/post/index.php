<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\sortinput\SortableInput;
use app\models\SortPosition;
use app\models\Post;
use yii\helpers\Url;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  
    <?php 
     $model = SortPosition::findOne(['user_id'=>Yii::$app->user->id]);
     if(!isset($model)){
        echo "У вас пока нет записей. Нажмите на кнопку создать рядом с вашим логином";
     }else {
        Pjax::begin(['id' => 'posts']);
        echo SortableInput::widget([
        'name'=> 'sort_list_post',
        'value'=>$model->post_id_position,
        'items' => Post::getPostsByUserId(Yii::$app->user->id),
        'hideInput' => true,
        'options'=>[
        'onchange'=>'changePosition(this.value);'
        ],
        ]); 
        Pjax::end();

    }
    ?>
</div>


<script>
    function changePosition($val) {
        // alert($val);
         $.ajax({
            type: "POST",
            url: "<?= Url::toRoute(['change-post-position'])?>",
            dataType: "html",
            data: {position:$val},
            success: function(data){

            },
            error: function () {
                 alert("Что-то пошло не так");
            }
        });

    }


    function isDel(event){
        var del = confirm("Вы действительно хотите удалить данный пост?");
        if(del==true){
            $.ajax({
            type: "POST",
            url: "<?= Url::toRoute(['delete'])?>",
            dataType: "html",
            data: {post:$(event.target).data('post_id')},
            success: function(data){
            $.pjax.reload({container:"#posts"})
            },
          
        });
        }
       
    }
</script>