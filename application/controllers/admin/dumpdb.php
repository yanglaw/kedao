<?php
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
/**
 * Dump Database
 *
 * @package LimeSurvey
 * @copyright 2011
 * @version $Id$
 * @access public
 */
class Dumpdb extends Survey_Common_Action {

    function __construct($controller, $id)
    {
        parent::__construct($controller, $id);

        if (Yii::app()->session['USER_RIGHT_SUPERADMIN'] != 1)
        {
            die();
        }

        if (!in_array(Yii::app()->db->getDriverName(), array('mysql', 'mysqli')) || Yii::app()->getConfig('demoMode') == true)
        {
            die($this->getController()->lang->gT('This feature is only available for MySQL databases.'));
        }
    }

    /**
     * Base function
     *
     * This functions receives the request to generate a dump file for the
     * database and does so! Only superadmins are allowed to do this!
     */
    public function index()
    {
        $sDbName = $this->_getDbName();
        $this->_outputHeaders($sDbName);
        $this->_outputDatabase($sDbName);

        exit;
    }

    /**
     * Get the database name
     */
    private function _getDbName() {
        // Yii doesn't give us a good way to get the database name
        preg_match('/dbname=([^;]*)/', Yii::app()->db->getSchema()->getDbConnection()->connectionString, $aMatches);
        $sDbName = $aMatches[1];

        return $sDbName;
    }

    /**
     * Send the headers so that it is shown as a download
     * @param string $sDbName Database Name
     */
    private function _outputHeaders($sDbName)
    {
        $sFileName = 'LimeSurvey_'.$sDbName.'_dump_'.dateShift(date('Y-m-d H:i:s'), 'Y-m-d', Yii::app()->getConfig('timeadjust')).'.sql';

        header('Content-type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$sFileName);
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    }

    /**
     * Outputs a full dump of the current LimeSurvey database
     * @param string $sDbName Database Name
     */
    private function _outputDatabase($sDbName)
    {
        $bAllowExportAllDb = (bool) Yii::app()->getConfig('allowexportalldb');

        $this->_outputDBDescription($sDbName, $bAllowExportAllDb);
        $this->_outputDBData($bAllowExportAllDb);
    }

    private function _outputDBDescription($sDbName, $bAllowExportAllDb)
    {
        echo '--' . "\n";
        echo '-- LimeSurvey Database Dump of `' . $sDbName . '`' . "\n";
        if (!$bAllowExportAllDb) {
            echo '-- Only prefixed tables with: ' . Yii::app()->db->tablePrefix . "\n";
        }
        echo '-- Date of Dump: ' . dateShift(date('d-M-Y'), 'd-M-Y', Yii::app()->getConfig('timeadjust')) . "\n";
        echo '--' . "\n";
    }

    private function _outputDBData($bAllowExportAllDb)
    {
        $aTables = Yii::app()->db->getSchema()->getTables();
        foreach ($aTables as $sTableName => $oTableData)
        {
            if ($bAllowExportAllDb && Yii::app()->db->tablePrefix == substr($sTableName, 0, strlen(Yii::app()->db->tablePrefix))) {
                $this->_outputTableDescription($sTableName);
                $this->_outputTableData($sTableName, $oTableData);
            }
        }
    }

    /**
     * Outputs the table structure in sql format
     */
    private function _outputTableDescription($sTableName)
    {
        echo "\n".'-- --------------------------------------------------------'."\n\n";
        echo '--'."\n";
        echo '-- Table structure for table `'.$sTableName.'`'."\n";
        echo '--'."\n\n";
        echo 'DROP TABLE IF EXISTS `'.$sTableName.'`;'."\n";

        $aCreateTable = Yii::app()->db->createCommand('SHOW CREATE TABLE '.Yii::app()->db->quoteTableName($sTableName))->queryRow();
        echo $aCreateTable['Create Table'].';'."\n\n";
    }

    /**
     * Outputs the table data in sql format
     */
    private function _outputTableData($sTableName, $oTableData)
    {
        echo '--'."\n";
        echo '-- Dumping data for table `'.$sTableName.'`'."\n";
        echo '--'."\n\n";

        $iNbRecords = $this->_countNumberOfEntries($sTableName);
        if ($iNbRecords > 0) {
            $iMaxNbRecords = $this->_getMaxNbRecords();
            $aFieldNames = array_keys($oTableData->columns);

            for ($i = 0; $i < ceil($iNbRecords / $iMaxNbRecords); $i++)
            {
                $aRecords = Yii::app()->db->createCommand()
                        ->select()
                        ->from($sTableName)
                        ->limit(intval($iMaxNbRecords), ($i != 0 ? ($i * $iMaxNbRecords) + 1 : null))
                        ->query()->readAll();

                $aFieldNames = $this->_outputRecords($sTableName, $aFieldNames, $aRecords);

            }
            echo "\n";
        }
    }

    private function _outputRecords($sTableName, $aFieldNames, $aRecords)
    {
        $i=0;
        foreach ($aRecords as $aRecord)
        {
            if ($i==0){
                echo 'INSERT INTO `' . $sTableName . "` VALUES\n";
            }
            echo '(';
            foreach ($aFieldNames as $sFieldName)
            {

                if (isset($aRecord[$sFieldName]) && !is_null($aRecord[$sFieldName])) {
                    $sValue= addslashes($aRecord[$sFieldName]);
                    $sValue = preg_replace("#\n#", "\\n", $sValue);
                    echo '"' . $sValue . '"';
                }
                else
                {
                    echo 'NULL';
                }

                if (end($aFieldNames) != $sFieldName) {
                    echo ', ';
                }
            }
            $i++;
            if ($i==200 || (end($aRecords) == $aRecord))
            {
               echo ');' . "\n";
               $i=0;
            }
            else
            {
                echo '),' . "\n";
            }
        }
        return $aFieldNames;
    }

    private function _countNumberOfEntries($sTableName)
    {
        $aNumRows = Yii::app()->db->createCommand('SELECT COUNT(*) FROM ' . Yii::app()->db->quoteTableName($sTableName))->queryRow();
        $iNumRows = $aNumRows['COUNT(*)'];
        return $iNumRows;
    }

    private function _getMaxNbRecords()
    {
        $iMaxRecords = (int)Yii::app()->getConfig('maxdumpdbrecords');
        if ($iMaxRecords < 1) {
            $iMaxRecords = 2500;
            return $iMaxRecords; // default
        }
        return $iMaxRecords;
    }
}
