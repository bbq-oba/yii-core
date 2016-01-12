<?php
/**
 * @author oba.ou
 */

namespace app\core\behaviors;
class TimestampBehavior extends \yii\behaviors\TimestampBehavior
{
    public $createdAtAttribute = 'create_time';
    public $updatedAtAttribute = 'update_time';
    public function getValue($event){
        return CURRENT_DATETIME;
    }
}