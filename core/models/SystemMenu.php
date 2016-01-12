<?php
/**
 * @author oba.ou
 */
namespace app\core\models;

use app\models\User;
use Yii;
use app\models\PreQuery;

class SystemMenu extends \kartik\tree\models\Tree
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['url', 'safe'];
        return $rules;
    }

    public static function find()
    {
        return new PreQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->upid = yii::$app->request->post('parentKey', 0);
            $this->url = rtrim($this->url);
            $this->upid = $this->upid == 'root' ? 0 : $this->upid;
        }
        return parent::beforeSave($insert);
    }


    public static function getMenus($forceUpdate = false)
    {
        $array = yii::$app->cache->get(SERVER_ENV_PREFIX.':admin_menu');
        if ($array == null || $forceUpdate) {
            $array = self::buildCache();
        }

        foreach ($array as $key => $value) {
            $upid = $value['upid'];
            $array[$key]['itemVisible'] = self::isItemVisible($value['url']);
            if ($upid && isset($array[$upid])) {
                $array[$upid]['children'][] = $key;
                if (isset($array[$key]['itemVisible']) && $array[$key]['itemVisible']) {
                    $array[$upid]['itemVisible'] = true;
                }
                while ($upid && isset($array[$upid])) {
                    $upid = $array[$upid]['upid'];
                }
            }
        }

        $items = [];
        foreach ($array as $k1 => $v1) {
            if ($v1['upid'] == 0) {
                $v1Items = [];
                if (isset($v1['children'])) {
                    foreach ($v1['children'] as $k2 => $v2) {
                        $v2Items = [];
                        if (isset($array[$v2]['children'])) {
                            foreach ($array[$v2]['children'] as $v3) {
                                $v2Items[] = [
                                    'label' => $array[$v3]['name'],
                                    'url' => [$array[$v3]['url']],
                                    'icon' => 'fa fa-' . $array[$v3]['icon'],
                                    'visible' => $array[$v3]['itemVisible'],
                                ];
                            }
                        }
                        $item = [];
                        $item['url'] = [$array[$v2]['url']];
                        $item['icon'] = 'fa fa-' . $array[$v2]['icon'];
                        $item['label'] = $array[$v2]['name'];
                        $item['visible'] = $array[$v2]['itemVisible'];
                        if ($v2Items) {
                            $item['items'] = $v2Items;
                        }
                        $v1Items[] = $item;
                    }
                }
                $item = [];
                $item['label'] = $v1['name'];
                $item['url'] = [$v1['url']];
                $item['visible'] = $v1['itemVisible'];
                $item['icon'] = 'fa fa-' . $v1['icon'];
                if ($v1Items) {
                    $item['items'] = $v1Items;
                }
                $items[] = $item;
            }
        }

        return $items;
    }



    public static function isItemVisible($url)
    {
        if(User::checkIsSuperAdmin()){
            return true;
        }
        $url = explode('/', ltrim($url, '/'));
        $routeArray = [];
        foreach ($url as $k => $r) {
            $routeArray[] = $r;
            $route = implode('/', $routeArray);
            $route = '/' . ltrim($route, '/');

            if (yii::$app->user->can($route . "/*")) {
                return true;
            }
            if (yii::$app->user->can($route)) {
                return true;
            }
        }
        return false;
    }

    /**
     * 生成菜单用缓存
     */
    private static function buildCache()
    {
        $nodes = SystemMenu::find()->orderBy('root,lft,sort')->all();
        $array = [];
        foreach ($nodes as $node) {
            $array[$node->id] = $node->attributes;
        }
        yii::$app->cache->set(SERVER_ENV_PREFIX.':admin_menu', $array);
        return $array;
    }


    public function afterSave($insert, $changedAttributes)
    {
        self::buildCache();
        parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        self::buildCache();
        parent::afterDelete();
    }
}

?>