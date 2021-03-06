<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');
/*
 * LimeSurvey
 * Copyright (C) 2007-2011 The LimeSurvey Project Team / Carsten Schmitz
 * All rights reserved.
 * License: GNU/GPL License v2 or later, see LICENSE.php
 * LimeSurvey is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 *
 *	$Id$
 */
class Surveys_languagesettings extends CActiveRecord
{
	/**
	 * Returns the table's name
	 *
	 * @access public
	 * @return string
	 */
	public function tableName()
	{
		return '{{surveys_languagesettings}}';
	}

	/**
	 * Returns the table's primary key
	 *
	 * @access public
	 * @return array
	 */
	public function primaryKey()
	{
		return array('surveyls_survey_id', 'surveyls_language');
	}

	/**
	 * Returns the static model of Settings table
	 *
	 * @static
	 * @access public
     * @param string $class
	 * @return CActiveRecord
	 */
	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	/**
	 * Returns the relations of this model
	 *
	 * @access public
	 * @return array
	 */
	public function relations()
	{
		return array(
			'survey' => array(self::BELONGS_TO, 'Survey', '', 'on' => 't.surveyls_survey_id = survey.sid'),
            'owner' => array(self::BELONGS_TO, 'User', '', 'on' => 'survey.owner_id = owner.uid'),
		);
	}


    /**
    * Returns this model's validation rules
    *
    */
    public function rules()
    {
        return array(
            array('surveyls_email_invite_subj','lsdefault'),
            array('surveyls_email_invite','lsdefault'),
            array('surveyls_email_remind_subj','lsdefault'),
            array('surveyls_email_remind','lsdefault'),
            array('surveyls_email_confirm_subj','lsdefault'),
            array('surveyls_email_confirm','lsdefault'),
            array('surveyls_email_register_subj','lsdefault'),
            array('surveyls_email_register','lsdefault'),
            array('email_admin_notification_subj','lsdefault'),
            array('email_admin_notification','lsdefault'),
            array('email_admin_responses_subj','lsdefault'),
            array('email_admin_responses','lsdefault'),

            array('surveyls_email_invite_subj','xssfilter'),
            array('surveyls_email_invite','xssfilter'),
            array('surveyls_email_remind_subj','xssfilter'),
            array('surveyls_email_remind','xssfilter'),
            array('surveyls_email_confirm_subj','xssfilter'),
            array('surveyls_email_confirm','xssfilter'),
            array('surveyls_email_register_subj','xssfilter'),
            array('surveyls_email_register','xssfilter'),
            array('email_admin_notification_subj','xssfilter'),
            array('email_admin_notification','xssfilter'),
            array('email_admin_responses_subj','xssfilter'),
            array('email_admin_responses','xssfilter'),

            array('surveyls_title','xssfilter'),
            array('surveyls_description','xssfilter'),
            array('surveyls_welcometext','xssfilter'),
            array('surveyls_endtext','xssfilter'),
            array('surveyls_urldescription','xssfilter'),
            
            array('surveyls_dateformat', 'numerical', 'integerOnly'=>true, 'min'=>'1', 'max'=>'12', 'allowEmpty'=>true), 
            array('surveyls_numberformat', 'numerical', 'integerOnly'=>true, 'min'=>'0', 'max'=>'1', 'allowEmpty'=>true), 
        );
    }


    /**
    * Defines the customs validation rule lsdefault
    *
    * @param mixed $attribute
    * @param mixed $params
    */
    public function lsdefault($attribute,$params)
    {

        $oLanguageTranslator = new Limesurvey_lang($this->surveyls_language);
        $aDefaultTexts=templateDefaultTexts($oLanguageTranslator,'unescaped');

         $aDefaultTextData=array('surveyls_email_invite_subj' => $aDefaultTexts['invitation_subject'],
                        'surveyls_email_invite' => $aDefaultTexts['invitation'],
                        'surveyls_email_remind_subj' => $aDefaultTexts['reminder_subject'],
                        'surveyls_email_remind' => $aDefaultTexts['reminder'],
                        'surveyls_email_confirm_subj' => $aDefaultTexts['confirmation_subject'],
                        'surveyls_email_confirm' => $aDefaultTexts['confirmation'],
                        'surveyls_email_register_subj' => $aDefaultTexts['registration_subject'],
                        'surveyls_email_register' => $aDefaultTexts['registration'],
                        'email_admin_notification_subj' => $aDefaultTexts['admin_notification_subject'],
                        'email_admin_notification' => $aDefaultTexts['admin_notification'],
                        'email_admin_responses_subj' => $aDefaultTexts['admin_detailed_notification_subject'],
                        'email_admin_responses' => $aDefaultTexts['admin_detailed_notification']);
        if (getEmailFormat($this->surveyls_survey_id) == "html")
        {
            $aDefaultTextData['admin_detailed_notification']=$aDefaultTexts['admin_detailed_notification_css'].$aDefaultTexts['admin_detailed_notification'];
        }

         if (empty($this->$attribute)) $this->$attribute=$aDefaultTextData[$attribute];
    }


    /**
    * Defines the customs validation rule xssfilter
    *
    * @param mixed $attribute
    * @param mixed $params
    */
    public function xssfilter($attribute,$params)
    {
        if(Yii::app()->getConfig('filterxsshtml') && Yii::app()->session['USER_RIGHT_SUPERADMIN'] != 1)
        {
            $filter = new CHtmlPurifier();
            $filter->options = array('URI.AllowedSchemes'=>array(
            'http' => true,
            'https' => true,
            ));
            $this->$attribute = $filter->purify($this->$attribute);
        }
    }


    /**
     * Returns the token's captions
     *
     * @access public
     * @return array
     */
    public function getAttributeCaptions()
    {
        $captions = @unserialize($this->surveyls_attributecaptions);
        return $captions !== false ? $captions : array();
    }

	function getAllRecords($condition=FALSE, $return_query = TRUE)
	{
		$query = Yii::app()->db->createCommand()->select('*')->from('{{surveys_languagesettings}}');
		if ($condition != FALSE)
		{
			$query->where($condition);
		}
        return ( $return_query ) ? $query->queryAll() : $query;
	}

    function getDateFormat($surveyid,$languagecode)
    {
		return Yii::app()->db->createCommand()->select('surveyls_dateformat')
            ->from('{{surveys_languagesettings}}')
            ->join('{{surveys}}','{{surveys}}.sid = {{surveys_languagesettings}}.surveyls_survey_id AND surveyls_survey_id = :surveyid')
            ->where('surveyls_language = :langcode')
            ->bindParam(":langcode", $languagecode, PDO::PARAM_STR)
			->bindParam(":surveyid", $surveyid, PDO::PARAM_INT)
            ->queryScalar();
    }

    function getAllSurveys($hasPermission = FALSE)
    {
        $this->db->select('a.*, surveyls_title, surveyls_description, surveyls_welcometext, surveyls_url');
        $this->db->from('surveys AS a');
        $this->db->join('surveys_languagesettings','surveyls_survey_id=a.sid AND surveyls_language=a.language');

        if ($hasPermission)
        {
            $this->db->where('a.sid IN (SELECT sid FROM {{survey_permissions}} WHERE uid=:uid AND permission=\'survey\' and read_p=1) ')->bindParam(":uid", $this->session->userdata("loginID"), PDO::PARAM_INT);
        }
        $this->db->order_by('active DESC, surveyls_title');
        return $this->db->get();
    }

    function getAllData($sid,$lcode)
    {
    	$query = 'SELECT * FROM {{surveys}}, {{surveys_languagesettings}} WHERE sid=? AND surveyls_survey_id=? AND surveyls_language=?';
        return $this->db->query($query, array($sid, $sid, $lcode));
    }

    function insertNewSurvey($data)
    {
        if (isset($data['surveyls_url']) && $data['surveyls_url']== 'http://') {$data['surveyls_url']="";}
		return $this->insertSomeRecords($data);
    }


    function getSurveyNames($surveyid)
    {
        $lang = Yii::app()->session['adminlang'];
        return Yii::app()->db->createCommand()->select('surveyls_title')->from('{{surveys_languagesettings}}')->where('surveyls_language = :adminlang AND surveyls_survey_id = :surveyid')->bindParam(":adminlang", $lang, PDO::PARAM_STR)->bindParam(":surveyid", $surveyid, PDO::PARAM_INT)->queryAll();
    }

    function updateRecords($data,$condition=FALSE, $xssfiltering = false)
    {
        if ($condition != FALSE)
        {
            $this->db->where($condition);
        }
        if (isset($data['surveyls_url']) && $data['surveyls_url']== 'http://') {$data['surveyls_url']="";}
		if($xssfiltering)
		{
			$filter = new CHtmlPurifier();
			$filter->options = array('URI.AllowedSchemes'=>array(
  				'http' => true,
  				'https' => true,
			));
			if (isset($data["description"]))
				$data["description"] = $filter->purify($data["description"]);
			if (isset($data["title"]))
				$data["title"] = $filter->purify($data["title"]);
			if (isset($data["welcome"]))
				$data["welcome"] = $filter->purify($data["welcome"]);
			if (isset($data["endtext"]))
				$data["endtext"] = $filter->purify($data["endtext"]);
		}

        $this->db->update('surveys_languagesettings',$data);

        if ($this->db->affected_rows() <= 0)
        {
            return false;
        }

        return true;
    }

	function insertSomeRecords($data)
    {
        $lang = new self;
		foreach ($data as $k => $v)
			$lang->$k = $v;
		return $lang->save();
    }
}
