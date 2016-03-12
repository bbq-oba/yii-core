<?php
/**
 * @author oba.ou
 */

namespace app\core\widgets;
use kartik\helpers\Html;
use kartik\widgets\FileInput;
use yii\widgets\InputWidget;

class CoreFileInput extends InputWidget
{
    public function init(){
        echo Html::activeHiddenInput($this->model, $this->attribute, $this->options);
        echo Html::error($this->model, $this->attribute, $this->options);
        $id =  Html::getInputId($this->model,$this->attribute);


        echo FileInput::widget([
            'name' => 'file',
            'options' => ['accept' => 'image/*', 'multiple' => false],
            'pluginEvents' => [
                'fileuploaded' => 'function(event, data, previewId, index) {
                    $("#'.$id.'").val(data.response.url);
                }',
            ],
            'pluginOptions' => [
                'initialPreview'=>$this->model->{$this->attribute} ? [Html::img($this->model->{$this->attribute}, ['class'=>'file-preview-image'])] : false,
                'maxFileCount' => 1,
                'minFileCount' => 1,
                'previewFileType' => 'image',
                'multiple' => false,
                'showPreview' => true,
                'showUploadedThumbs' => false,
                'uploadUrl' => \yii\helpers\Url::to(['/system/image/upload'])
            ]
        ]);
        parent::init();
    }
}