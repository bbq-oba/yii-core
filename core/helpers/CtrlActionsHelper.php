<?php
/**
 * @author oba.ou
 */
namespace app\core\helpers;

class CtrlActionsHelper
{
    private $array;
    public function getArray(){
        return $this->array;
    }
    public function __construct($module){
        $this->getModule($module);
    }
    /*
         *
         * @param $module \yii\app\module
         */
    private function getModule($module){
        foreach($module->getModules() as $key=>$val){
            if (($child = $module->getModule($key)) !== null) {
                $this->getModule($child);
                $class = new \ReflectionClass($child);
                $doc = DocHelper::getDocComment($class->getDocComment());

                $this->array[$child->getUniqueId()]['id'] = $child->getUniqueId();
                $this->array[$child->getUniqueId()]['doc'] = $doc;
                $this->array[$child->getUniqueId()]['class'] = $class->getName();

                $this->getControllerFile($child);
            }
        }
    }

    /*
     *
     * @param $module \yii\app\module
     */
    private function getControllerFile($module){
        $nameSpace = $module->controllerNamespace;
        foreach(new \DirectoryIterator($module->controllerPath) as $file){
            if (!$file->isDot()) {
                $className = $file->getBasename("Controller.php");
                $class = $nameSpace.'\\'.$className."Controller";
                if (strpos($class, '-') === false && class_exists($class) && is_subclass_of($class, 'yii\base\Controller')) {
                    $class = new \ReflectionClass($class);
                    $doc = DocHelper::getDocComment($class->getDocComment());

                    $this->array[$module->getUniqueId()]['controllers'][str_replace("Controller","",$class->getShortName())] = [
                        'doc' => $doc,
                        'id'  => $class->getShortName(),
                        'actions' => $this->getActions($class),
                        'class' => $class->getName()
                    ];
                }
            }
        }
    }

    /**
     * @param $class \ReflectionClass
     * ��ȡController��Action
     */
    private function getActions($class){
        $result = [];
        foreach($class->getMethods(\ReflectionMethod::IS_PUBLIC) as $method){
            $methodName = $method->getName();
            $id = str_replace("action","",$methodName); //只筛选index的action

            if (strpos($methodName, 'action') === 0 && $methodName !== 'actions' && in_array($id,['Index'])) {
                $method = new \ReflectionMethod($class->getName(),$methodName);
                $doc = DocHelper::getDocComment($method->getDocComment());
                $result[$id] = $doc ? $doc : $methodName;
            }
        }
        return $result;
    }
}