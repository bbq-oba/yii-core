<?php
/**
 * @author oba.ou
 */
namespace app\core\gii\crud;

use Yii;
use yii\db\Schema;
use yii\helpers\Inflector;

class Generator extends \yii\gii\generators\crud\Generator
{
    public $enableI18N = true;

    public $generatorControllerPath = [];


    public $template = 'adminLte';
    public $templates = [ //setting for out templates
        'adminLte' => '@app/core/gii/crud/adminLte', // 模板
    ];

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'core.Crud生成器';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return '生成CRUD<code>(*￣(エ)￣)</code>';
    }

    public $controllerNamespace = [];

    public $modelClassHelper, $controllerNameSpaceHelper, $helpField;

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),
            [
                'modelClassHelper' => '选择Model',
                'controllerNameSpaceHelper' => '选择controller',
            ]
        );
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['modelClassHelper', 'controllerNameSpaceHelper','messageCategory', 'helpField'], 'safe']
        ]);
    }

    public function hints()
    {
        return array_merge(parent::hints(),
            [
                'controllerName' => '用于生成控制器的名称<code>(*￣(エ)￣)</code>',
            ]
        );
    }
    public function stickyAttributes()
    {
        return ['baseControllerClass', 'indexWidgetType']; // 去掉了默认的Message Category 的默认选项
    }

    public function getMessageCategoryData()
    {
        $t = yii::$app->i18n->translations;
        $array = [];
        foreach ($t as $k => $v) {
            if (is_array($v) && isset($v['fileMap']) && $v['fileMap'] && is_array($v['fileMap'])) {
                $array = array_merge($array, array_keys($v['fileMap']));
            }
        }
        return array_combine($array,$array);
    }


    public function getControllerNameSpaceHelperData()
    {
        return $this->generatorControllerPath;
    }

    public $modelsPath = [];



    public function getModelClassHelperData()
    {
        $paths = $this->modelsPath;
        $paths = array_unique($paths);
        $return = [];
        foreach ($paths as $path) {
            $namespace = str_replace(["@", "/"], ["\\", "\\"], $path);
            $realPath = Yii::getAlias($path);
            $files = \app\core\helpers\FileHelper::findFiles($realPath, [
                'only' => ['*.php'],
                'except' => [
                    '*Search.php',
                    '*Query.php',
                    '*Form.php'
                ]
            ]);
            foreach ($files as $file) {
                $file = new \SplFileObject($file);
                $className = substr($file->getFilename(), 0, strlen($file->getFilename()) - (strlen($file->getExtension()) + 1));
                $class = new \ReflectionClass($namespace . '\\' . $className);
                $return[ltrim($namespace, '\\')][$class->getShortName() . "|" . Inflector::camel2id($class->getShortName())] = $class->getName();
            }
        }
        return $return;
    }


    /**
     * Generates search conditions
     * @return array
     */
    public function generateSearchConditions()
    {
        $columns = [];
        if (($table = $this->getTableSchema()) === false) {
            $class = $this->modelClass;
            /* @var $model \yii\base\Model */
            $model = new $class();
            foreach ($model->attributes() as $attribute) {
                $columns[$attribute] = 'unknown';
            }
        } else {
            foreach ($table->columns as $column) {
                $columns[$column->name] = $column->type;
            }
        }

        $likeConditions = [];
        $hashConditions = [];
        foreach ($columns as $column => $type) {
            switch ($type) {
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                case Schema::TYPE_BOOLEAN:
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                case Schema::TYPE_DATE:
                case Schema::TYPE_TIME:
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                    if($column == 'is_deleted'){
                        $hashConditions[] = "'{$column}' => 0,";        //不显示软删除的数据
                    }else{
                        $hashConditions[] = "'{$column}' => \$this->{$column},";
                    }
                    break;
                default:
                    $likeConditions[] = "->andFilterWhere(['like', '{$column}', \$this->{$column}])";
                    break;
            }
        }

        $conditions = [];
        if (!empty($hashConditions)) {
            $conditions[] = "\$query->andFilterWhere([\n"
                . str_repeat(' ', 12) . implode("\n" . str_repeat(' ', 12), $hashConditions)
                . "\n" . str_repeat(' ', 8) . "]);\n";
        }
        if (!empty($likeConditions)) {
            $conditions[] = "\$query" . implode("\n" . str_repeat(' ', 12), $likeConditions) . ";\n";
        }

        return $conditions;
    }
}
