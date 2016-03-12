<?php
/**
 * @author oba.ou
 */
namespace app\core\helpers;


class DocHelper
{
    /**
     * @param $doc
     * @param string $name
     * @return bool
     * 获取指定前缀的注释内容
     */
    public static function getDocComment($doc,$name = 'name'){
        if(preg_match('/@name(.*?)\n/',$doc,$match)){
            return trim($match[1]);
        };
        return false;
    }

    public static function setDocument($document,$class,$func = NULL)
    {
        if($func == NULL){
            $reflect = new \ReflectionClass($class);
        }else{
            $reflect = new \ReflectionMethod($class,$func);
        }
        $filePath = $reflect->getFileName();

        $startLine = $reflect->getStartLine();

        $doc = $reflect->getDocComment();   //获取注释内容

        $array = file($filePath);

        preg_match("/(\s*)[\w]/",$array[$startLine-1],$spaceMatch);

        $space = $spaceMatch[1];

        $flag = preg_match('/.*@name(.*)/', $doc, $match);//查看是否有注释
        if($flag){
            /*有注释就替换*/

            $docLine = explode("\n",$doc); //查看注释有几行内容
            $docStartLine = $startLine - count($docLine); //注释起始 行数

            for($i = $docStartLine-1; $i< $startLine -1 ; $i++){
                $theDoc = $array[$i];
                if(preg_match('/@name/',$theDoc,$theMatch)){
                    $array[$i] =  preg_replace('/@name.*/','@name '.$document,$array[$i]);
                    break;
                }
            }
        }else{
            //插入注释
            array_splice($array, $startLine - 1, 0, "$space/**\n $space* @name ".$document."\n $space*/\n");
        }

        $handle = fopen($filePath, 'w+');
        fwrite($handle, implode("", $array));
    }
}