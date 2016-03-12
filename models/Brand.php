<?php

namespace app\models;

use app\components\api\BrandApi;
use Yii;

/**
 * This is the model class for table "{{%brand}}".
 *
 * @property string $id
 * @property string $cn_name
 * @property string $en_name
 * @property string $py_name
 * @property string $initial
 * @property integer $show_type_name
 * @property string $logo
 * @property string $sn
 * @property integer $is_show
 * @property string $create_time
 * @property string $update_time
 * @property integer $is_deleted
 */
use \app\core\models\Model;
class Brand extends Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%brand}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['sn','required'],
            [['show_type_name', 'is_show', 'is_deleted'], 'integer'],
            [['cn_name', 'initial', 'sn'], 'string', 'max' => 32],
            [['en_name', 'py_name', 'logo'], 'string', 'max' => 255]
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'cn_name' => '中文名',
            'en_name' => '英文名',
            'py_name' => '拼音名',
            'initial' => '首字母',
            'show_type_name' => '显示字段',
            'viewShowTypeName'=>'显示字段',
            'logo' => 'logo',
            'sn' => 'SN',
            'is_show' => '是否显示',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'is_deleted' => '是否删除',
            'imageLogo'=>'Logo图'
        ];
    }
    public function getImageLogo(){
        if(empty($this->logo)){
            $this->logo = null;
        }
        return $this->logo;
    }
    public static $showTypeNameArray = ['中文&英文','仅中文','仅英文'];
    public function getShowTypeNameItems(){
        $return = [];
        foreach(static::$showTypeNameArray as $k=>$v){
            $return[] = [
                'label' => $v,
                'value' => $k
            ];
        }
        return $return;
    }
    public function getViewShowTypeName(){
        return static::$showTypeNameArray[$this->show_type_name];
    }

    public static function getBrand($word){
        $result = array();
        if (!empty($word)) {
            $search_type = array(
                'brand_name',
                'brand_name_eng',
                'brand_name_pinyin'
            );
            foreach ($search_type as $value) {
                $brand = BrandApi::getBrandBySearch($value, $word);
                if ($brand['code'] == 200 && !empty($brand['result']['amount'])) {
                    $result = array_merge($result, $brand['result']['brands']);
                }
            }
            $word = intval($word);
            if ($word > 0) {
                $brand = BrandApi::getBrandBySn($word);
                if ($brand['code'] == 200 && !empty($brand['result'][$word])) {
                    $result = array_merge($result, $brand['result']);
                }
            }
        }


        $return = [];
        foreach($result as $k=>$v){
            $v['id'] = $v['brand_store_sn'];
            $return[] = $v;
        }
        return ['results'=>$return];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'initial' =>'仅能填写一个字母'
        ];
    }
}
