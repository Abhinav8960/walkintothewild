<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Operators';
$this->params['title'] = $this->title;


?>
<div class="card">

    <div class="card-body">

        <div id="w1-button" class="mb-3"></div>

        <div class="table-responsive">
            <?php Pjax::begin(['id' => 'operator_list']) ?>
            <?= GridView::widget([
                'dataProvider' => $provider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Business Name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->operator) ? $model->operator->business_name : '';
                        }
                    ],
                    [
                        'label' => 'Registered Name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->operator) ? $model->operator->register_comapany_name : '';
                        }
                    ],

                    [
                        'label' => 'Phone Number',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->operator) ? $model->operator->phone_no : '';
                        }
                    ],

                    // [
                    //     'label' => 'Budget Segment',
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return isset($model->operator) ? $model->operator->business_name : '';
                    //     }
                    // ],


                ],
            ]); ?>
            <?php Pjax::end() ?>
        </div>
    </div>
</div>