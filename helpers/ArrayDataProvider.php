<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/5/4
 * Time: 23:28
 */

namespace app\helpers;


class ArrayDataProvider extends \yii\data\ArrayDataProvider
{
    /**
     * @inheritdoc
     */
    protected function prepareModels()
    {
        if (($models = $this->allModels) === null) {
            return [];
        }

        if (($sort = $this->getSort()) !== false) {
            $models = $this->sortModels($models, $sort);
        }
        if (($pagination = $this->getPagination()) !== false) {
            $pagination->totalCount = $this->getTotalCount();
        }
        return $models;
    }
}