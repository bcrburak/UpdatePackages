<?php
/* +***********************************************************************************************************************************
 * The contents of this file are subject to the YetiForce Public License Version 1.1 (the "License"); you may not use this file except
 * in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations under the License.
 * The Original Code is YetiForce.
 * The Initial Developer of the Original Code is YetiForce. Portions created by YetiForce are Copyright (C) www.yetiforce.com. 
 * All Rights Reserved.
 * *********************************************************************************************************************************** */

class Users_Colors_Model extends Vtiger_Record_Model
{

	public static function getAllField()
	{
		$modulesFields['marketing'][] = ['module' => 'Leads', 'nameField' => 'leadstatus'];
		$modulesFields['support'][] = ['module' => 'HelpDesk', 'nameField' => 'ticketpriorities'];
		$modulesFields['support'][] = ['module' => 'HelpDesk', 'nameField' => 'ticketstatus'];
		$modulesFields['realization'][] = ['module' => 'Project', 'nameField' => 'projectstatus'];
		$modulesFields['financial'][] = [];
		$modulesFields['timecontrol'][] = ['module' => 'OSSTimeControl', 'nameField' => 'timecontrol_type'];
		return $modulesFields;
	}

	public static function getTablesAll()
	{
		$modulesFields = self::getAllField();
		foreach ($modulesFields AS $key => $fields) {
			foreach ($fields AS $field) {
				$instance[$key][] = vtlib\Functions::getModuleFieldInfo(\includes\Modules::getModuleId($field['module']), $field['nameField']);
			}
		}
		return $instance;
	}

	public static function getUserColors()
	{
		$adb = PearDatabase::getInstance();
		$result = $adb->query('SELECT * FROM vtiger_users');

		$userColors = [];
		while ($activityTypes = $adb->getRow($result)) {
			$userColors[] = array(
				'id' => $activityTypes['id'],
				'first' => $activityTypes['first_name'],
				'last' => $activityTypes['last_name'],
				'color' => $activityTypes['cal_color']
			);
		}
		return $userColors;
	}

	public static function updateUserColor($params)
	{
		$adb = PearDatabase::getInstance();
		$adb->pquery('UPDATE vtiger_users SET cal_color = ? WHERE id = ?;', array($params['color'], $params['id']));
	}
	
	public static function getColor(){
		$colors = ['FF4848', 'FF68DD', 'FF62B0', 'FE67EB', 'E469FE', 'D568FD', '9669FE', 'FF7575', 'FF79E1', 'FF73B9', 'FE67EB', 'E77AFE', 'D97BFD', 'A27AFE', 'FF8A8A', 'FF86E3', 'FF86C2', 'FE8BF0', 'EA8DFE', 'DD88FD', 'AD8BFE', 'FF9797', 'FF97E8', 'FF97CB', 'FE98F1', 'ED9EFE', 'E29BFD', 'B89AFE', 'FFA8A8', 'FFACEC', 'FFA8D3', 'FEA9F3', 'EFA9FE', 'E7A9FE', 'C4ABFE', 'FFBBBB', 'FFACEC', 'FFBBDD', 'FFBBF7', 'F2BCFE', 'EDBEFE', 'D0BCFE', 'FFCECE', 'FFC8F2', 'FFC8E3', 'FFCAF9', 'F5CAFF', 'F0CBFE', 'DDCEFF', 'FFDFDF', 'FFDFF8', 'FFDFEF', 'FFDBFB', 'F9D9FF', 'F4DCFE', 'E6DBFF', 'FFECEC', 'FFEEFB', 'FFECF5', 'FFEEFD', 'FDF2FF', 'FAECFF', 'F1ECFF', 'FFF2F2', 'FFFEFB', 'FFF9FC', 'FFF9FE', 'FFFDFF', 'FDF9FF', 'FBF9FF', '800080', '872187', '9A03FE', '892EE4', '3923D6', '2966B8', '23819C', 'BF00BF', 'BC2EBC', 'A827FE', '9B4EE9', '6755E3', '2F74D0', '2897B7', 'DB00DB', 'D54FD5', 'B445FE', 'A55FEB', '8678E9', '4985D6', '2FAACE', 'F900F9', 'DD75DD', 'BD5CFE', 'AE70ED', '9588EC', '6094DB', '44B4D5', 'FF4AFF', 'DD75DD', 'C269FE', 'AE70ED', 'A095EE', '7BA7E1', '57BCD9', 'FF86FF', 'E697E6', 'CD85FE', 'C79BF2', 'B0A7F1', '8EB4E6', '7BCAE1', 'FFA4FF', 'EAA6EA', 'D698FE', 'CEA8F4', 'BCB4F3', 'A9C5EB', '8CD1E6', 'FFBBFF', 'EEBBEE', 'DFB0FF', 'DBBFF7', 'CBC5F5', 'BAD0EF', 'A5DBEB', 'FFCEFF', 'F0C4F0', 'E8C6FF', 'E1CAF9', 'D7D1F8', 'CEDEF4', 'B8E2EF', 'FFDFFF', 'F4D2F4', 'EFD7FF', 'EDDFFB', 'E3E0FA', 'E0EAF8', 'C9EAF3', 'FFECFF', 'F4D2F4', 'F9EEFF', 'F5EEFD', 'EFEDFC', 'EAF1FB', 'DBF0F7', 'FFF9FF', 'FDF9FD', 'FEFDFF', 'FEFDFF', 'F7F5FE', 'F8FBFE', 'EAF7FB', '5757FF', '62A9FF', '62D0FF', '06DCFB', '01FCEF', '03EBA6', '01F33E', '6A6AFF', '75B4FF', '75D6FF', '24E0FB', '1FFEF3', '03F3AB', '0AFE47', '7979FF', '86BCFF', '8ADCFF', '3DE4FC', '5FFEF7', '33FDC0', '4BFE78', '8C8CFF', '99C7FF', '99E0FF', '63E9FC', '74FEF8', '62FDCE', '72FE95', '9999FF', '99C7FF', 'A8E4FF', '75ECFD', '92FEF9', '7DFDD7', '8BFEA8', 'AAAAFF', 'A8CFFF', 'BBEBFF', '8CEFFD', 'A5FEFA', '8FFEDD', 'A3FEBA', 'BBBBFF', 'BBDAFF', 'CEF0FF', 'ACF3FD', 'B5FFFC', 'A5FEE3', 'B5FFC8', 'CACAFF', 'D0E6FF', 'D9F3FF', 'C0F7FE', 'CEFFFD', 'BEFEEB', 'CAFFD8', 'E1E1FF', 'DBEBFF', 'ECFAFF', 'C0F7FE', 'E1FFFE', 'BDFFEA', 'EAFFEF', 'EEEEFF', 'ECF4FF', 'F9FDFF', 'E6FCFF', 'F2FFFE', 'CFFEF0', 'EAFFEF', 'F9F9FF', 'F9FCFF', 'FDFEFF', 'F9FEFF', 'FDFFFF', 'F7FFFD', 'F9FFFB', '1FCB4A', '59955C', '48FB0D', '2DC800', '59DF00', '9D9D00', 'B6BA18', '27DE55', '6CA870', '79FC4E', '32DF00', '61F200', 'C8C800', 'CDD11B', '4AE371', '80B584', '89FC63', '36F200', '66FF00', 'DFDF00', 'DFE32D', '7CEB98', '93BF96', '99FD77', '52FF20', '95FF4F', 'FFFFAA', 'EDEF85', '93EEAA', 'A6CAA9', 'AAFD8E', '6FFF44', 'ABFF73', 'FFFF84', 'EEF093', 'A4F0B7', 'B4D1B6', 'BAFEA3', '8FFF6F', 'C0FF97', 'FFFF99', 'F2F4B3', 'BDF4CB', 'C9DECB', 'CAFEB8', 'A5FF8A', 'D1FFB3', 'FFFFB5', 'F5F7C4', 'D6F8DE', 'DBEADC', 'DDFED1', 'B3FF99', 'DFFFCA', 'FFFFC8', 'F7F9D0', 'E3FBE9', 'E9F1EA', 'EAFEE2', 'D2FFC4', 'E8FFD9', 'FFFFD7', 'FAFBDF', 'E3FBE9', 'F3F8F4', 'F1FEED', 'E7FFDF', 'F2FFEA', 'FFFFE3', 'FCFCE9', 'FAFEFB', 'FBFDFB', 'FDFFFD', 'F5FFF2', 'FAFFF7', 'FFFFFD', 'FDFDF0', 'BABA21', 'C8B400', 'DFA800', 'DB9900', 'FFB428', 'FF9331', 'FF800D', 'E0E04E', 'D9C400', 'F9BB00', 'EAA400', 'FFBF48', 'FFA04A', 'FF9C42', 'E6E671', 'E6CE00', 'FFCB2F', 'FFB60B', 'FFC65B', 'FFAB60', 'FFAC62', 'EAEA8A', 'F7DE00', 'FFD34F', 'FFBE28', 'FFCE73', 'FFBB7D', 'FFBD82', 'EEEEA2', 'FFE920', 'FFDD75', 'FFC848', 'FFD586', 'FFC48E', 'FFC895', 'F1F1B1', 'FFF06A', 'FFE699', 'FFD062', 'FFDEA2', 'FFCFA4', 'FFCEA2', 'F4F4BF', 'FFF284', 'FFECB0', 'FFE099', 'FFE6B5', 'FFD9B7', 'FFD7B3', 'F7F7CE', 'FFF7B7', 'FFF1C6', 'FFEAB7', 'FFEAC4', 'FFE1C6', 'FFE2C8', 'F9F9DD', 'FFF9CE', 'FFF5D7', 'FFF2D2', 'FFF2D9', 'FFEBD9', 'FFE6D0', 'FBFBE8', 'FFFBDF', 'FFFAEA', 'FFF9EA', 'FFF7E6', 'FFF4EA', 'FFF1E6', 'FEFEFA', 'FFFEF7', 'FFFDF7', 'FFFDF9', 'FFFDF9', 'FFFEFD', 'FFF9F4', 'D1D17A', 'C0A545', 'C27E3A', 'C47557', 'B05F3C', 'C17753', 'B96F6F', 'D7D78A', 'CEB86C', 'C98A4B', 'CB876D', 'C06A45', 'C98767', 'C48484', 'DBDB97', 'D6C485', 'D19C67', 'D29680', 'C87C5B', 'D0977B', 'C88E8E', 'E1E1A8', 'DECF9C', 'DAAF85', 'DAA794', 'CF8D72', 'DAAC96', 'D1A0A0', 'E9E9BE', 'E3D6AA', 'DDB791', 'DFB4A4', 'D69E87', 'E0BBA9', 'D7ACAC', 'EEEECE', 'EADFBF', 'E4C6A7', 'E6C5B9', 'DEB19E', 'E8CCBF', 'DDB9B9', 'E9E9C0', 'EDE4C9', 'E9D0B6', 'EBD0C7', 'E4C0B1', 'ECD5CA', 'E6CCCC', 'EEEECE', 'EFE7CF', 'EEDCC8', 'F0DCD5', 'EACDC1', 'F0DDD5', 'ECD9D9', 'F1F1D6', 'F5EFE0', 'F2E4D5', 'F5E7E2', 'F0DDD5', 'F5E8E2', 'F3E7E7', 'F5F5E2', 'F9F5EC', 'F9F3EC', 'F9EFEC', 'F5E8E2', 'FAF2EF', 'F8F1F1', 'FDFDF9', 'FDFCF9', 'FCF9F5', 'FDFAF9', 'FDFAF9', 'FCF7F5', 'FDFBFB', 'F70000', 'B9264F', '990099', '74138C', '0000CE', '1F88A7', '4A9586', 'FF2626', 'D73E68', 'B300B3', '8D18AB', '5B5BFF', '25A0C5', '5EAE9E', 'FF5353', 'DD597D', 'CA00CA', 'A41CC6', '7373FF', '29AFD6', '74BAAC', 'FF7373', 'E37795', 'D900D9', 'BA21E0', '8282FF', '4FBDDD', '8DC7BB', 'FF8E8E', 'E994AB', 'FF2DFF', 'CB59E8', '9191FF', '67C7E2', 'A5D3CA', 'FFA4A4', 'EDA9BC', 'F206FF', 'CB59E8', 'A8A8FF', '8ED6EA', 'C0E0DA', 'FFB5B5', 'F0B9C8', 'FF7DFF', 'D881ED', 'B7B7FF', 'A6DEEE', 'CFE7E2', 'FFC8C8', 'F4CAD6', 'FFA8FF', 'EFCDF8', 'C6C6FF', 'C0E7F3', 'DCEDEA', 'FFEAEA', 'F8DAE2', 'FFC4FF', 'EFCDF8', 'DBDBFF', 'D8F0F8', 'E7F3F1', 'FFEAEA', 'FAE7EC', 'FFE3FF', 'F8E9FC', 'EEEEFF', 'EFF9FC', 'F2F9F8', 'FFFDFD', 'FEFAFB', 'FFFDFF', 'FFFFFF', 'FDFDFF', 'FAFDFE', 'F7FBFA'];
		return '#' . $colors[array_rand($colors)];
	}
	public function generateColor($params)
	{
		$color = self::getColor();
		$params['color'] = $color;
		if ('generateGroupColor' == $params['mode'])
			self::updateGroupColor($params);
		elseif ('generateColorForProcesses' == $params['mode'])
			self::updateColor($params);
		elseif ('generateModuleColor' == $params['mode'])
			self::updateModuleColor($params);
		else
			self::updateUserColor($params);
		return $color;
	}

	public static function getGroupColors()
	{
		$adb = PearDatabase::getInstance();
		$result = $adb->query('SELECT * FROM vtiger_groups');

		$groupColors = [];
		while ($activityTypes = $adb->getRow($result)) {
			$groupColors[] = array(
				'id' => $activityTypes['groupid'],
				'groupname' => $activityTypes['groupname'],
				'color' => $activityTypes['color']
			);
		}
		return $groupColors;
	}

	public static function updateGroupColor($params)
	{
		$adb = PearDatabase::getInstance();
		$adb->pquery('UPDATE vtiger_groups SET color = ? WHERE groupid = ?;', array($params['color'], $params['id']));
	}

	public static function updateColor($params)
	{
		$adb = PearDatabase::getInstance();
		$primaryKey = Vtiger_Util_Helper::getPickListId($params['field']);
		$adb->update($params['table'], ['color' => $params['color']], $primaryKey . ' = ?', [$params['id']]);
	}

	public static function getValuesFromField($fieldName)
	{
		$db = PearDatabase::getInstance();

		$primaryKey = Vtiger_Util_Helper::getPickListId($fieldName);
		$query = 'SELECT * FROM vtiger_%s order by sortorderid';
		$query = sprintf($query, $fieldName);
		$groupColors = [];
		$result = $db->query($query);
		while ($row = $db->getRow($result)) {
			//Need to decode the picklist values twice which are saved from old ui
			$groupColors[] = array(
				'id' => $row[$primaryKey],
				'value' => decode_html(decode_html($row[$fieldName])),
				'color' => $row['color']
			);
		}
		return $groupColors;
	}

	public static function getModulesColors($active = false)
	{
		$allModules = \vtlib\Functions::getAllModules(false, false, false, $active);

		$modules = [];
		foreach ($allModules as $tabid => $module) {
			$modules[] = array(
				'id' => $tabid,
				'module' => $module['name'],
				'color' => $module['color'] != '' ? '#' . $module['color'] : '',
				'active' => $module['coloractive'],
			);
		}
		return $modules;
	}

	public function activeColor($params)
	{
		$adb = PearDatabase::getInstance();
		$sqlParams = [];
		$sql = '';
		if ($params['color'] == '') {
			$color = self::getColor();
			$sql = ' color = ?,';
			$sqlParams[] = str_replace("#", "", $color);
		}
		$sqlParams[] = $params['status'] == 'true' ? 1 : 0;
		$sqlParams[] = $params['id'];
		$adb->pquery("UPDATE vtiger_tab SET $sql coloractive = ? WHERE tabid = ?;", $sqlParams);
		return $color;
	}

	public function updateModuleColor($params)
	{
		$adb = PearDatabase::getInstance();
		$color = str_replace("#", "", $params['color']);
		$adb->pquery('UPDATE vtiger_tab SET color = ? WHERE tabid = ?;', array($color, $params['id']));
	}
}
