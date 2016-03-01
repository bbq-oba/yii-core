<?php
namespace app\modules\admin\models;
use Yii;
use yii\base\Model;
/**
 * LoginForm is the model behind the login form.
 */
class SmsDbForm extends Model
{
    public $host = "localhost";
    public $port = "3306";
    public $user = "root";
    public $pass = "root";
    public $dbname = "dbname";
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['host', 'port','user','pass','dbname'], 'required'],
        ];
    }

    public function save(){

        $base = yii::getAlias("@app/config");
        $handle = fopen($base."/smsdb.php","w+");

        $content = "<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host={$this->host};port={$this->port};dbname={$this->dbname}',
    'username' => '{$this->user}',
    'password' => '{$this->pass}',
    'charset' => 'utf8',
];";

        fwrite($handle,$content);



    }
}