<?php

namespace app\models;

use Yii;
use \app\core\models\Model;
use \yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%stat_log_visit}}".
 *
 * @property string $idvisit
 * @property string $idsite
 * @property string $idvisitor
 * @property string $visit_last_action_time
 * @property string $config_id
 * @property string $location_ip
 * @property string $user_id
 * @property string $visit_first_action_time
 * @property integer $visit_goal_buyer
 * @property integer $visit_goal_converted
 * @property integer $visitor_days_since_first
 * @property integer $visitor_days_since_order
 * @property integer $visitor_returning
 * @property integer $visitor_count_visits
 * @property string $visit_entry_idaction_name
 * @property string $visit_entry_idaction_url
 * @property string $visit_exit_idaction_name
 * @property string $visit_exit_idaction_url
 * @property integer $visit_total_actions
 * @property integer $visit_total_searches
 * @property string $referer_keyword
 * @property string $referer_name
 * @property integer $referer_type
 * @property string $referer_url
 * @property string $location_browser_lang
 * @property string $config_browser_engine
 * @property string $config_browser_name
 * @property string $config_browser_version
 * @property string $config_device_brand
 * @property string $config_device_model
 * @property integer $config_device_type
 * @property string $config_os
 * @property string $config_os_version
 * @property integer $visit_total_events
 * @property string $visitor_localtime
 * @property integer $visitor_days_since_last
 * @property string $config_resolution
 * @property integer $config_cookie
 * @property integer $config_director
 * @property integer $config_flash
 * @property integer $config_gears
 * @property integer $config_java
 * @property integer $config_pdf
 * @property integer $config_quicktime
 * @property integer $config_realplayer
 * @property integer $config_silverlight
 * @property integer $config_windowsmedia
 * @property integer $visit_total_time
 * @property string $location_city
 * @property string $location_country
 * @property double $location_latitude
 * @property double $location_longitude
 * @property string $location_region
 * @property string $custom_var_k1
 * @property string $custom_var_v1
 * @property string $custom_var_k2
 * @property integer $custom_var_v2
 * @property string $custom_var_k3
 * @property string $custom_var_v3
 * @property string $custom_var_k4
 * @property string $custom_var_v4
 * @property string $custom_var_k5
 * @property string $custom_var_v5
 * @property integer $example_visit_dimension
 * @property integer $status
 */
class StatLogVisit extends Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stat_log_visit}}';
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idsite', 'idvisitor', 'visit_last_action_time', 'config_id', 'location_ip', 'visit_first_action_time', 'visit_goal_buyer', 'visit_goal_converted', 'visitor_days_since_first', 'visitor_days_since_order', 'visitor_returning', 'visitor_count_visits', 'visit_entry_idaction_name', 'visit_entry_idaction_url', 'visit_exit_idaction_name', 'visit_total_actions', 'visit_total_searches', 'referer_url', 'location_browser_lang', 'config_browser_engine', 'config_browser_name', 'config_browser_version', 'config_os', 'visit_total_events', 'visitor_localtime', 'visitor_days_since_last', 'config_resolution', 'config_cookie', 'config_director', 'config_flash', 'config_gears', 'config_java', 'config_pdf', 'config_quicktime', 'config_realplayer', 'config_silverlight', 'config_windowsmedia', 'visit_total_time', 'location_country'], 'required'],
            [['idsite', 'visit_goal_buyer', 'visit_goal_converted', 'visitor_days_since_first', 'visitor_days_since_order', 'visitor_returning', 'visitor_count_visits', 'visit_entry_idaction_name', 'visit_entry_idaction_url', 'visit_exit_idaction_name', 'visit_exit_idaction_url', 'visit_total_actions', 'visit_total_searches', 'referer_type', 'config_device_type', 'visit_total_events', 'visitor_days_since_last', 'config_cookie', 'config_director', 'config_flash', 'config_gears', 'config_java', 'config_pdf', 'config_quicktime', 'config_realplayer', 'config_silverlight', 'config_windowsmedia', 'visit_total_time', 'custom_var_v1', 'custom_var_v2', 'example_visit_dimension', 'status'], 'integer'],
            [['visit_last_action_time', 'visit_first_action_time', 'visitor_localtime'], 'safe'],
            [['referer_url'], 'string'],
            [['location_latitude', 'location_longitude'], 'number'],
            [['idvisitor', 'config_id'], 'string', 'max' => 8],
            [['location_ip'], 'string', 'max' => 16],
            [['user_id', 'custom_var_k1', 'custom_var_k2', 'custom_var_k3', 'custom_var_v3', 'custom_var_k4', 'custom_var_v4', 'custom_var_k5', 'custom_var_v5'], 'string', 'max' => 200],
            [['referer_keyword', 'location_city'], 'string', 'max' => 255],
            [['referer_name'], 'string', 'max' => 70],
            [['location_browser_lang', 'config_browser_version'], 'string', 'max' => 20],
            [['config_browser_engine', 'config_browser_name'], 'string', 'max' => 10],
            [['config_device_brand', 'config_device_model', 'config_os_version'], 'string', 'max' => 100],
            [['config_os', 'location_country'], 'string', 'max' => 3],
            [['config_resolution'], 'string', 'max' => 9],
            [['location_region'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idvisit' => 'Idvisit',
            'idsite' => 'Idsite',
            'idvisitor' => 'Idvisitor',
            'visit_last_action_time' => 'Visit Last Action Time',
            'config_id' => 'Config ID',
            'location_ip' => 'Location Ip',
            'user_id' => 'User ID',
            'visit_first_action_time' => 'Visit First Action Time',
            'visit_goal_buyer' => 'Visit Goal Buyer',
            'visit_goal_converted' => 'Visit Goal Converted',
            'visitor_days_since_first' => 'Visitor Days Since First',
            'visitor_days_since_order' => 'Visitor Days Since Order',
            'visitor_returning' => 'Visitor Returning',
            'visitor_count_visits' => 'Visitor Count Visits',
            'visit_entry_idaction_name' => 'Visit Entry Idaction Name',
            'visit_entry_idaction_url' => 'Visit Entry Idaction Url',
            'visit_exit_idaction_name' => 'Visit Exit Idaction Name',
            'visit_exit_idaction_url' => 'Visit Exit Idaction Url',
            'visit_total_actions' => 'Visit Total Actions',
            'visit_total_searches' => 'Visit Total Searches',
            'referer_keyword' => 'Referer Keyword',
            'referer_name' => 'Referer Name',
            'referer_type' => 'Referer Type',
            'referer_url' => 'Referer Url',
            'location_browser_lang' => 'Location Browser Lang',
            'config_browser_engine' => 'Config Browser Engine',
            'config_browser_name' => 'Config Browser Name',
            'config_browser_version' => 'Config Browser Version',
            'config_device_brand' => 'Config Device Brand',
            'config_device_model' => 'Config Device Model',
            'config_device_type' => 'Config Device Type',
            'config_os' => 'Config Os',
            'config_os_version' => 'Config Os Version',
            'visit_total_events' => 'Visit Total Events',
            'visitor_localtime' => 'Visitor Localtime',
            'visitor_days_since_last' => 'Visitor Days Since Last',
            'config_resolution' => 'Config Resolution',
            'config_cookie' => 'Config Cookie',
            'config_director' => 'Config Director',
            'config_flash' => 'Config Flash',
            'config_gears' => 'Config Gears',
            'config_java' => 'Config Java',
            'config_pdf' => 'Config Pdf',
            'config_quicktime' => 'Config Quicktime',
            'config_realplayer' => 'Config Realplayer',
            'config_silverlight' => 'Config Silverlight',
            'config_windowsmedia' => 'Config Windowsmedia',
            'visit_total_time' => 'Visit Total Time',
            'location_city' => 'Location City',
            'location_country' => 'Location Country',
            'location_latitude' => 'Location Latitude',
            'location_longitude' => 'Location Longitude',
            'location_region' => 'Location Region',
            'custom_var_k1' => 'Custom Var K1',
            'custom_var_v1' => 'Custom Var V1',
            'custom_var_k2' => 'Custom Var K2',
            'custom_var_v2' => 'Custom Var V2',
            'custom_var_k3' => 'Custom Var K3',
            'custom_var_v3' => 'Custom Var V3',
            'custom_var_k4' => 'Custom Var K4',
            'custom_var_v4' => 'Custom Var V4',
            'custom_var_k5' => 'Custom Var K5',
            'custom_var_v5' => 'Custom Var V5',
            'example_visit_dimension' => 'Example Visit Dimension',
            'status' => 'Status',
        ];
    }


    public static function getNewRecord($limit = 100){
        return self::find()->where([
            'status'=>0,
        ])->andWhere('user_id IS NOT NULL')->orderBy('visit_last_action_time desc')->limit($limit)->asArray()->all();
    }


}
