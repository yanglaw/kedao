<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
* surveypermission
*
* @package LimeSurvey
* @copyright 2011
* @version $Id$
* @access public
*/
class surveypermission extends Survey_Common_Action {

    /**
    * Load survey security screen.
    * @param mixed $surveyid
    * @return void
    */
    function index($surveyid)
    {
        $aData['surveyid'] = $surveyid = sanitize_int($surveyid);
        $aViewUrls = array();
        $clang = Yii::app()->lang;
        $imageurl = Yii::app()->getConfig('adminimageurl');

        if(hasSurveyPermission($surveyid,'survey','read'))
        {
            $aBaseSurveyPermissions=Survey_permissions::model()->getBasePermissions();

            $this->getController()->_js_admin_includes(Yii::app()->getConfig('generalscripts') . 'jquery/jquery.tablesorter.min.js');
            $this->getController()->_js_admin_includes(Yii::app()->getConfig('adminscripts') . 'surveysecurity.js');

            $result2 = Survey_permissions::model()->getUserDetails($surveyid);

            $surveysecurity ="<div class='header ui-widget-header'>".$clang->gT("Survey permissions")."</div>\n"
	            . "<table class='surveysecurity'><thead>"
	            . "<tr>\n"
	            . "<th>".$clang->gT("Action")."</th>\n"
	            . "<th>".$clang->gT("Username")."</th>\n"
	            . "<th>".$clang->gT("User group")."</th>\n"
	            . "<th>".$clang->gT("Full name")."</th>\n";
            foreach ($aBaseSurveyPermissions as $sPermission=>$aSubPermissions )
            {
                $surveysecurity.="<th><img src=\"{$imageurl}{$aSubPermissions['img']}_30.png\" alt=\"<span style='font-weight:bold;'>".$aSubPermissions['title']."</span><br />".$aSubPermissions['description']."\" /></th>\n";
            }
            $surveysecurity .= "</tr></thead>\n";

            // Foot first

            if (Yii::app()->getConfig('usercontrolSameGroupPolicy') == true)
            {
                $authorizedGroupsList = getUserGroupList(NULL,'simplegidarray');
            }

            $surveysecurity .= "<tbody>\n";
            if(count($result2) > 0)
            {
                //	output users
                $row = 0;

                foreach ($result2 as $PermissionRow)
                {
                    $result3 = User_in_groups::model()->with('users')->findAll('users.uid = :uid',array(':uid' => $PermissionRow['uid']));
                    foreach ($result3 as $resul3row)
                    {
                        if (Yii::app()->getConfig('usercontrolSameGroupPolicy') == false ||
                        in_array($resul3row->ugid,$authorizedGroupsList))
                        {
                            $group_ids[] = $resul3row->ugid;
                        }
                    }

                    if(isset($group_ids) && $group_ids[0] != NULL)
                    {
                        $group_ids_query = implode(" OR ugid=", $group_ids);
                        unset($group_ids);

                        $result4 = User_groups::model()->findAll('ugid = :ugid',array(':ugid' => $group_ids_query));

                        foreach ($result4 as $resul4row)
                        {
                            $group_names[] = $resul4row->name;
                        }
                        if(count($group_names) > 0)
                            $group_names_query = implode(", ", $group_names);
                    }
                    //                  else {break;} //TODO Commented by lemeur
                    $surveysecurity .= "<tr>\n";

                    $surveysecurity .= "<td>\n";
                    $surveysecurity .= "<form style='display:inline;' method='post' action='".$this->getController()->createUrl('admin/surveypermission/set/surveyid/'.$surveyid)."'>"
                    ."<input type='image' src='{$imageurl}edit_16.png' alt='".$clang->gT("Edit permissions")."' />"
                    ."<input type='hidden' name='action' value='setsurveysecurity' />"
                    ."<input type='hidden' name='user' value='{$PermissionRow['users_name']}' />"
                    ."<input type='hidden' name='uid' value='{$PermissionRow['uid']}' />"
                    ."</form>\n";
                    $surveysecurity .= "<form style='display:inline;' method='post' action='".$this->getController()->createUrl('admin/surveypermission/delete/surveyid/'.$surveyid)."'>"
                    ."<input type='image' src='{$imageurl}/token_delete.png' alt='".$clang->gT("Delete")."' onclick='return confirm(\"".$clang->gT("Are you sure you want to delete this entry?","js")."\")' />"
                    ."<input type='hidden' name='action' value='delsurveysecurity' />"
                    ."<input type='hidden' name='user' value='{$PermissionRow['users_name']}' />"
                    ."<input type='hidden' name='uid' value='{$PermissionRow['uid']}' />"
                    ."</form>";


                    $surveysecurity .= "</td>\n";
                    $surveysecurity .= "<td>{$PermissionRow['users_name']}</td>\n"
                    . "<td>";

                    if(isset($group_names) > 0)
                    {
                        $surveysecurity .= $group_names_query;
                    }
                    else
                    {
                        $surveysecurity .= "---";
                    }
                    unset($group_names);

                    $surveysecurity .= "</td>\n"
                    . "<td>\n{$PermissionRow['full_name']}</td>\n";

                    //Now show the permissions
                    foreach ($aBaseSurveyPermissions as $sPKey=>$aPDetails) {
                        unset($aPDetails['img']);
                        unset($aPDetails['description']);
                        unset($aPDetails['title']);
                        $iCount=0;
                        $iPermissionCount=0;
                        foreach ($aPDetails as $sPDetailKey=>$sPDetailValue)
                        {
                            if ($sPDetailValue && hasSurveyPermission($surveyid,$sPKey,$sPDetailKey,$PermissionRow['uid']) && !($sPKey=='survey' && $sPDetailKey=='read')) $iCount++;
                            if ($sPDetailValue) $iPermissionCount++;
                        }
                        if ($sPKey=='survey')  $iPermissionCount--;
                        if ($iCount==$iPermissionCount) {
                            $insert = "<div class=\"ui-icon ui-icon-check\">&nbsp;</div>";
                        }
                        elseif ($iCount>0){
                            $insert = "<div class=\"ui-icon ui-icon-check mixed\">&nbsp;</div>";
                        }
                        else
                        {
                            $insert = "<div>&nbsp;</div>";
                        }
                        $surveysecurity .= "<td>\n$insert\n</td>\n";
                    }

                    $surveysecurity .= "</tr>\n";
                    $row++;
                }
            } else {
                $surveysecurity .= "<tr><td colspan='16'></td></tr>"; //fix error on empty table
            }

            $surveysecurity .= "</tbody>\n"
            . "</table>\n"
            . "<form class='form44' action='".$this->getController()->createUrl('admin/surveypermission/adduser/surveyid/'.$surveyid)."' method='post'><ul>\n"
            . "<li><label for='uidselect'>".$clang->gT("User").": </label><select id='uidselect' name='uid'>\n"
            . getSurveyUserList(false,false,$surveyid)
            . "</select>\n"
            . "<input style='width: 15em;' type='submit' value='".$clang->gT("Add User")."'  onclick=\"if (document.getElementById('uidselect').value == -1) { alert('".$clang->gT("Please select a user first","js")."'); return false;}\"/>"
            . "<input type='hidden' name='action' value='addsurveysecurity' />"
            . "</li></ul></form>\n"
            . "<form class='form44' action='".$this->getController()->createUrl('admin/surveypermission/addusergroup/surveyid/'.$surveyid)."' method='post'><ul><li>\n"
            . "<label for='ugidselect'>".$clang->gT("Groups").": </label><select id='ugidselect' name='ugid'>\n"
            . getSurveyUserGroupList('htmloptions',$surveyid)
            . "</select>\n"
            . "<input style='width: 15em;' type='submit' value='".$clang->gT("Add user group")."' onclick=\"if (document.getElementById('ugidselect').value == -1) { alert('".$clang->gT("Please select a user group first","js")."'); return false;}\" />"
            . "<input type='hidden' name='action' value='addusergroupsurveysecurity' />\n"
            . "</li></ul></form>";

            $aViewUrls['output'] = $surveysecurity;
        }
        else
        {
            accessDenied();

        }

        $this->_renderWrappedTemplate('authentication', $aViewUrls, $aData);
    }

    /**
    * surveypermission::addusergroup()
    * Function responsible to add usergroup.
    * @param mixed $surveyid
    * @return void
    */
    function addusergroup($surveyid)
    {
        $aData['surveyid'] = $surveyid = sanitize_int($surveyid);
        $aViewUrls = array();

        $action = $_POST['action'];
        $clang = Yii::app()->lang;

        $imageurl = Yii::app()->getConfig('imageurl');

        $postusergroupid = !empty($_POST['ugid']) ? $_POST['ugid'] : false;


        if($action == "addusergroupsurveysecurity")
        {
            $addsummary = "<div class=\"header\">".$clang->gT("Add user group")."</div>\n";
            $addsummary .= "<div class=\"messagebox ui-corner-all\" >\n";

            $result = Survey::model()->findAll('sid = :surveyid AND owner_id = :owner_id',array(':surveyid' => $surveyid, ':owner_id' => Yii::app()->session['loginID']));
            if( (count($result) > 0 && in_array($postusergroupid,getSurveyUserGroupList('simpleugidarray',$surveyid))) ||Yii::app()->session['USER_RIGHT_SUPERADMIN'] == 1)
            {
                if($postusergroupid > 0){
                    $result2 = User::model()->getCommonUID($surveyid, $postusergroupid); //Checked
                    if($result2->getRowCount() > 0)
                    {
                        foreach ($result2->readAll() as $row2 )
                        {
                            $uid_arr[] = $row2['uid'];
                            $isrresult = Survey_permissions::model()->insertSomeRecords(array('sid' => $surveyid,'uid' => $row2['uid'], 'permission' => 'survey', 'read_p' => 1));
                            if (!$isrresult) break;
                        }

                        if($isrresult)
                        {
                            $addsummary .= "<div class=\"successheader\">".$clang->gT("User group added.")."</div>\n";
                            Yii::app()->session['uids'] = $uid_arr;
                            $addsummary .= "<br /><form method='post' action='".$this->getController()->createUrl('admin/surveypermission/set/surveyid/'.$surveyid)."'>"
                            ."<input type='submit' value='".$clang->gT("Set Survey Rights")."' />"
                            ."<input type='hidden' name='action' value='setusergroupsurveysecurity' />"
                            ."<input type='hidden' name='ugid' value='{$postusergroupid}' />"
                            ."</form>\n";
                        }
                        else
                        {
                            // Error while adding user to the database
                            $addsummary .= "<div class=\"warningheader\">".$clang->gT("Failed to add user group.")."</div>\n";
                            $addsummary .= "<br/><input type=\"submit\" onclick=\"window.open('".$this->getController()->createUrl('admin/surveypermission/view/surveyid/'.$surveyid)."', '_top')\" value=\"".$clang->gT("Continue")."\"/>\n";
                        }
                    }
                    else
                    {
                        // no user to add
                        $addsummary .= "<div class=\"warningheader\">".$clang->gT("Failed to add user group.")."</div>\n";
                        $addsummary .= "<br/><input type=\"submit\" onclick=\"window.open('".$this->getController()->createUrl('admin/surveypermission/view/surveyid/'.$surveyid)."', '_top')\" value=\"".$clang->gT("Continue")."\"/>\n";
                    }
                }
                else
                {
                    $addsummary .= "<div class=\"warningheader\">".$clang->gT("Failed to add user.")."</div>\n"
                    . "<br />" . $clang->gT("No Username selected.")."<br />\n";
                    $addsummary .= "<br/><input type=\"submit\" onclick=\"window.open('".$this->getController()->createUrl('admin/surveypermission/view/surveyid/'.$surveyid)."', '_top')\" value=\"".$clang->gT("Continue")."\"/>\n";
                }
            }
            else
            {
                accessDenied();
            }
            $addsummary .= "</div>\n";

            $aViewUrls['output'] = $addsummary;
        }

        $this->_renderWrappedTemplate('authentication', $aViewUrls, $aData);
    }


    /**
    * surveypermission::adduser()
    * Function responsible to add user.
    * @param mixed $surveyid
    * @return void
    */
    function adduser($surveyid)
    {
        $aData['surveyid'] = $surveyid = sanitize_int($surveyid);
        $aViewUrls = array();

        $action = $_POST['action'];

        $clang = Yii::app()->lang;
        $imageurl = Yii::app()->getConfig('imageurl');
        $postuserid = $_POST['uid'];

        if($action == "addsurveysecurity")
        {
            $addsummary = "<div class='header ui-widget-header'>".$clang->gT("Add User")."</div>\n";
            $addsummary .= "<div class=\"messagebox ui-corner-all\">\n";

            $result = Survey::model()->findAll('sid = :sid AND owner_id = :owner_id AND owner_id != :postuserid',array(':sid' => $surveyid, ':owner_id' => Yii::app()->session['loginID'], ':postuserid' => $postuserid));
            if( (count($result) > 0 && in_array($postuserid,getUserList('onlyuidarray'))) ||
            Yii::app()->session['USER_RIGHT_SUPERADMIN'] == 1)
            {

                if($postuserid > 0){

                    $isrresult = Survey_permissions::model()->insertSomeRecords(array('sid' => $surveyid, 'uid' => $postuserid, 'permission' => 'survey', 'read_p' => 1));

                    if($isrresult)
                    {

                        $addsummary .= "<div class=\"successheader\">".$clang->gT("User added.")."</div>\n";
                        $addsummary .= "<br /><form method='post' action='".$this->getController()->createUrl('admin/surveypermission/set/surveyid/'.$surveyid)."'>"
                        ."<input type='submit' value='".$clang->gT("Set survey permissions")."' />"
                        ."<input type='hidden' name='action' value='setsurveysecurity' />"
                        ."<input type='hidden' name='uid' value='{$postuserid}' />"
                        ."</form>\n";
                    }
                    else
                    {
                        // Username already exists.
                        $addsummary .= "<div class=\"warningheader\">".$clang->gT("Failed to add user.")."</div>\n"
                        . "<br />" . $clang->gT("Username already exists.")."<br />\n";
                        $addsummary .= "<br/><input type=\"submit\" onclick=\"window.open('".$this->getController()->createUrl('admin/surveypermission/view/surveyid/'.$surveyid)."', '_top')\" value=\"".$clang->gT("Continue")."\"/>\n";
                    }
                }
                else
                {
                    $addsummary .= "<div class=\"warningheader\">".$clang->gT("Failed to add user.")."</div>\n"
                    . "<br />" . $clang->gT("No Username selected.")."<br />\n";
                    $addsummary .= "<br/><input type=\"submit\" onclick=\"window.open('".$this->getController()->createUrl('admin/surveypermission/view/surveyid/'.$surveyid)."', '_top')\" value=\"".$clang->gT("Continue")."\"/>\n";
                }
            }
            else
            {
                accessDenied();
            }

            $addsummary .= "</div>\n";

            $aViewUrls['output'] = $addsummary;
        }

        $this->_renderWrappedTemplate('authentication', $aViewUrls, $aData);
    }

    /**
    * surveypermission::set()
    * Function responsible to set permissions to a user/usergroup.
    * @param mixed $surveyid
    * @return void
    */
    function set($surveyid)
    {
        $aData['surveyid'] = $surveyid = sanitize_int($surveyid);
        $aViewUrls = array();

        $action = $_POST['action'];

        $clang = Yii::app()->lang;
        $imageurl = Yii::app()->getConfig('adminimageurl');
        $postuserid = !empty($_POST['uid']) ? $_POST['uid'] : null;
        $postusergroupid = !empty($_POST['ugid']) ? $_POST['ugid'] : null;

        if($action == "setsurveysecurity" || $action == "setusergroupsurveysecurity")
        {
            $where = 'sid = :surveyid AND owner_id = :owner_id ';
            $params=array(':surveyid' => $surveyid, ':owner_id' => Yii::app()->session['loginID']);
            if ($action == "setsurveysecurity")
            {
                $where.=  "AND owner_id != :postuserid";
                $params[':postuserid'] = $postuserid;
            }
            $result = Survey::model()->findAll($where,$params);
            if(count($result) > 0 || Yii::app()->session['USER_RIGHT_SUPERADMIN'] == 1)
            {
                //$js_admin_includes[]='../scripts/jquery/jquery.tablesorter.min.js';
                //$js_admin_includes[]='scripts/surveysecurity.js';
                $this->getController()->_js_admin_includes(Yii::app()->getConfig('generalscripts') .'jquery/jquery.tablesorter.min.js');
                $this->getController()->_js_admin_includes(Yii::app()->getConfig('adminscripts') . 'surveysecurity.js');
                if ($action == "setsurveysecurity")
                {
                    $query = "select users_name from {{users}} where uid=:uid";
                    $res = Yii::app()->db->createCommand($query)->bindParam(":uid", $postuserid, PDO::PARAM_INT)->query();
                    $resrow = $res->read();
                    $sUsername=$resrow['users_name'];
                    $usersummary = "<div class='header ui-widget-header'>".sprintf($clang->gT("Edit survey permissions for user %s"),"<span style='font-style:italic'>".$sUsername."</span>")."</div>";
                }
                else
                {
                    $resrow = User_groups::model()->find('ugid = :ugid',array(':ugid' => $postusergroupid));
                    $sUsergroupName=$resrow['name'];
                    $usersummary = "<div class='header ui-widget-header'>".sprintf($clang->gT("Edit survey permissions for group %s"),"<span style='font-style:italic'>".$sUsergroupName."</span>")."</div>";
                }
                $usersummary .= "<br /><form action='".$this->getController()->createUrl('admin/surveypermission/surveyright/surveyid/'.$surveyid)."' method='post'>\n"
                . "<table style='margin:0 auto;' class='usersurveypermissions'><thead>\n";

                $usersummary .= ""
                . "<tr><th></th><th>".$clang->gT("Permission")."</th>\n"
                . "<th><input type='button' id='btnToggleAdvanced' value='<<' /></th>\n"
                . "<th class='extended'>".$clang->gT("Create")."</th>\n"
                . "<th class='extended'>".$clang->gT("View/read")."</th>\n"
                . "<th class='extended'>".$clang->gT("Update")."</th>\n"
                . "<th class='extended'>".$clang->gT("Delete")."</th>\n"
                . "<th class='extended'>".$clang->gT("Import")."</th>\n"
                . "<th class='extended'>".$clang->gT("Export")."</th>\n"
                . "</tr></thead>\n";

                //content
                $aBasePermissions=Survey_permissions::model()->getBasePermissions();

                $oddcolumn=false;
                foreach($aBasePermissions as $sPermissionKey=>$aCRUDPermissions)
                {
                    $oddcolumn=!$oddcolumn;
                    $usersummary .= "<tr><td><img src='{$imageurl}{$aCRUDPermissions['img']}_30.png' alt='{$aCRUDPermissions['description']}'/></td>";
                    $usersummary .= "<td>{$aCRUDPermissions['title']}</td>";
                    $usersummary .= "<td ><input type=\"checkbox\"  class=\"markrow\" name='all_{$sPermissionKey}' /></td>";
                    foreach ($aCRUDPermissions as $sCRUDKey=>$CRUDValue)
                    {
                        if (!in_array($sCRUDKey,array('create','read','update','delete','import','export'))) continue;
                        $usersummary .= "<td class='extended'>";

                        if ($CRUDValue)
                        {
                            if (!($sPermissionKey=='survey' && $sCRUDKey=='read'))
                            {
                                $usersummary .= "<input type=\"checkbox\"  class=\"checkboxbtn\" name='perm_{$sPermissionKey}_{$sCRUDKey}' ";
                                if($action=='setsurveysecurity' && hasSurveyPermission( $surveyid,$sPermissionKey,$sCRUDKey,$postuserid)) {
                                    $usersummary .= ' checked="checked" ';
                                }
                                $usersummary .=" />";
                            }
                        }
                        $usersummary .= "</td>";
                    }
                    $usersummary .= "</tr>";
                }

                $usersummary .= "\n</table>"
                ."<p><input type='submit' value='".$clang->gT("Save Now")."' />"
                ."<input type='hidden' name='perm_survey_read' value='1' />"
                ."<input type='hidden' name='action' value='surveyrights' />";

                if ($action=='setsurveysecurity')
                {
                    $usersummary .="<input type='hidden' name='uid' value='{$postuserid}' />";
                }
                else
                {
                    $usersummary .="<input type='hidden' name='ugid' value='{$postusergroupid}' />";
                }
                $usersummary .= "</form>\n";

                $aViewUrls['output'] = $usersummary;
            }
            else
            {
                include("accessDenied.php");
            }
        }

        $this->_renderWrappedTemplate('authentication', $aViewUrls, $aData);
    }

    /**
    * surveypermission::delete()
    * Function responsible to delete a user/usergroup.
    * @param mixed $surveyid
    * @return void
    */
    function delete($surveyid)
    {

        $aData['surveyid'] = $surveyid = sanitize_int($surveyid);
        $aViewUrls = array();

        $action = $_POST['action'];

        $clang = Yii::app()->lang;
        $imageurl = Yii::app()->getConfig('imageurl');
        $postuserid = !empty($_POST['uid']) ? $_POST['uid'] : false;
        $postusergroupid = !empty($_POST['gid']) ? $_POST['gid'] : false;


        if($action == "delsurveysecurity")
        {
            $addsummary = "<div class=\"header\">".$clang->gT("Deleting User")."</div>\n";
            $addsummary .= "<div class=\"messagebox\">\n";

            $result = Survey::model()->findAll('sid = :sid AND owner_id = :owner_id AND owner_id != :postuserid',array(':sid' => $surveyid, ':owner_id' => Yii::app()->session['loginID'], ':postuserid' => $postuserid));
            if(count($result) > 0 || Yii::app()->session['USER_RIGHT_SUPERADMIN'] == 1)
            {
                if (isset($postuserid))
                {
                    $dbresult = Survey_permissions::model()->deleteAll('uid = :uid AND sid = :sid',array(':uid' => $postuserid, ':sid' => $surveyid));
                    $addsummary .= "<br />".$clang->gT("Username").": ".sanitize_xss_string($_POST['user'])."<br /><br />\n";
                    $addsummary .= "<div class=\"successheader\">".$clang->gT("Success!")."</div>\n";
                }
                else
                {
                    $addsummary .= "<div class=\"warningheader\">".$clang->gT("Could not delete user. User was not supplied.")."</div>\n";
                }
                $addsummary .= "<br/><input type=\"submit\" onclick=\"window.open('".$this->getController()->createUrl('admin/surveypermission/view/surveyid/'.$surveyid)."', '_top')\" value=\"".$clang->gT("Continue")."\"/>\n";
            }
            else
            {
                accessDenied();
            }
            $addsummary .= "</div>\n";

            $aViewUrls['output'] = $addsummary;
        }

        $this->_renderWrappedTemplate('authentication', $aViewUrls, $aData);
    }

    /**
    * surveypermission::surveyright()
    * Function responsible to process setting of permission of a user/usergroup.
    * @param mixed $surveyid
    * @return void
    */
    function surveyright($surveyid)
    {
        $aData['surveyid'] = $surveyid = sanitize_int($surveyid);
        $aViewUrls = array();

        $action = $_POST['action'];
        $clang = Yii::app()->lang;
        $imageurl = Yii::app()->getConfig('imageurl');
        $postuserid = !empty($_POST['uid']) ? $_POST['uid'] : false;
        $postusergroupid = !empty($_POST['ugid']) ? $_POST['ugid'] : false;

        if ($action == "surveyrights")
        {
            $addsummary = "<div class='header ui-widget-header'>".$clang->gT("Edit survey permissions")."</div>\n";
            $addsummary .= "<div class='messagebox ui-corner-all'>\n";
            $where = ' ';
            if($postuserid){
                if (Yii::app()->session['USER_RIGHT_SUPERADMIN'] != 1)
                {
                    $where .= "sid = :surveyid AND owner_id != :postuserid AND owner_id = :owner_id";
                    $resrow = Survey::model()->find($where,array(':sid' => $surveyid, ':owner_id' => Yii::app()->session['loginID'], ':postuserid' => $postuserid));
                }
            }
            else{
                $where .= "sid = :sid";
                $resrow = Survey::model()->find($where,array(':sid' => $surveyid));
                $iOwnerID=$resrow['owner_id'];
            }

            $aBaseSurveyPermissions = Survey_permissions::model()->getBasePermissions();
            $aPermissions=array();
            foreach ($aBaseSurveyPermissions as $sPermissionKey=>$aCRUDPermissions)
            {
                foreach ($aCRUDPermissions as $sCRUDKey=>$CRUDValue)
                {
                    if (!in_array($sCRUDKey,array('create','read','update','delete','import','export'))) continue;

                    if ($CRUDValue)
                    {
                        if(isset($_POST["perm_{$sPermissionKey}_{$sCRUDKey}"])){
                            $aPermissions[$sPermissionKey][$sCRUDKey]=1;
                        }
                        else
                        {
                            $aPermissions[$sPermissionKey][$sCRUDKey]=0;
                        }
                    }
                }
            }
            if (isset($postusergroupid) && $postusergroupid>0)
            {
                $oResult = User_in_groups::model()->findAll('ugid = :ugid AND uid <> :uid AND uid <> :iOwnerID',array(':ugid' => $postusergroupid, ':uid' => Yii::app()->session['loginID'], ':iOwnerID' => $iOwnerID));
                if(count($oResult) > 0)
                {
                    foreach ($oResult as $aRow)
                    {
						Survey_permissions::model()->setPermission($aRow->uid, $surveyid, $aPermissions);
                    }
                    $addsummary .= "<div class=\"successheader\">".$clang->gT("Survey permissions for all users in this group were successfully updated.")."</div>\n";
                }
            }
            else
            {
                if (Survey_permissions::model()->setPermission($postuserid, $surveyid, $aPermissions))
                {
                    $addsummary .= "<div class=\"successheader\">".$clang->gT("Survey permissions were successfully updated.")."</div>\n";
                }
                else
                {
                    $addsummary .= "<div class=\"warningheader\">".$clang->gT("Failed to update survey permissions!")."</div>\n";
                }

            }
            $addsummary .= "<br/><input type=\"submit\" onclick=\"window.open('".$this->getController()->createUrl('admin/surveypermission/view/surveyid/'.$surveyid)."', '_top')\" value=\"".$clang->gT("Continue")."\"/>\n";
            $addsummary .= "</div>\n";
            $aViewUrls['output'] = $addsummary;
        }

        $this->_renderWrappedTemplate('authentication', $aViewUrls, $aData);
    }

    /**
     * Renders template(s) wrapped in header and footer
     *
     * @param string $sAction Current action, the folder to fetch views from
     * @param string|array $aViewUrls View url(s)
     * @param array $aData Data to be passed on. Optional.
     */
    protected function _renderWrappedTemplate($sAction = 'authentication', $aViewUrls = array(), $aData = array())
    {
        $this->getController()->_css_admin_includes(Yii::app()->getConfig('adminstyleurl')."superfish.css");
        parent::_renderWrappedTemplate($sAction, $aViewUrls, $aData);
    }

}
