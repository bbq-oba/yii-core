<?php
/**
 * @author oba.ou
 */
namespace app\core\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class RedisManageForm extends Model
{

    public $commands;
    public $params;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['commands', 'params'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'commands' => '命令',
            'params' => '参数',
        ];
    }
    public function attributeHints(){
        return [
            'commands' => '请选择一条命令执行，慎重选择，谢谢！！！',
            'params' => '<span class="badge bg-red">一行一条参数，程序不处理空行多一行不行，少一行也不行，程序不会检测参数个数，慎重填写</span><br/>
如 HSET
应填写三行如下
<ol>
    <li>KEY</li>
    <li>NAME</li>
    <li>VALUE</li>
</ol>
将执行 \yii::$app->redis->executeCommand(HSET,[KEY,NAME,VALUE]);
',
        ];
    }
}
