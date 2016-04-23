<?php
namespace app\models;
use app\helpers\SignLogic;
use Yii;
use yii\base\Model;
/**
 * LoginForm is the model behind the login form.
 */
class SignForm extends Model
{
    public $UserName;
    public $Password;
    public $TrueName;
    public $Phone;
    public $Email;
    public $ReferralCode;



    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['UserName', 'Password','TrueName','Phone'], 'required'],
            // rememberMe must be a boolean value
//            ['Phone', 'mobile'],
            // password is validated by validatePassword()
            ['Email', 'email'],
        ];
    }

    public function signUp(){
        $logic = new SignLogic();
        return $logic->signUp($this->attributes,1);
    }




}