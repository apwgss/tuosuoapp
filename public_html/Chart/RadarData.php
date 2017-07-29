<?php
//dezend by http://www.yunlu99.com/
define('ROOT_PATH', '../');
require_once ROOT_PATH . 'Entry/Global.setup.php';
include_once ROOT_PATH . 'Lang/CN/Lang.mgt.inc.php';
include_once ROOT_PATH . 'Functions/Functions.utilities.inc.php';
include_once ROOT_PATH . 'Functions/Functions.dir.inc.php';
include_once ROOT_PATH . 'Functions/Functions.common.inc.php';
include_once ROOT_PATH . 'Functions/Functions.mgt.inc.php';
@set_time_limit(0);
$_GET['surveyID'] = (int) $_GET['surveyID'];
_checkpassport('1|2|3|5|7', $_GET['surveyID']);
$SQL = ' SELECT surveyTitle,isCache,surveyID FROM ' . SURVEY_TABLE . ' WHERE surveyID = \'' . $_GET['surveyID'] . '\' ';
$Row = $DB->queryFirstRow($SQL);
$theSID = $theSurveyID = $Row['surveyID'];
if (($Row['isCache'] == 1) || !file_exists(ROOT_PATH . $Config['cacheDirectory'] . '/' . $Row['surveyID'] . '/' . md5('Qtn' . $Row['surveyID']) . '.php')) {
	require ROOT_PATH . 'Includes/MakeCache.php';
}

require ROOT_PATH . $Config['cacheDirectory'] . '/' . $theSID . '/' . md5('Qtn' . $theSID) . '.php';
if (isset($_GET['dataSourceId']) && ($_GET['dataSourceId'] != '')) {
	$dataSource = getdatasourcesql($_GET['dataSourceId'], $_GET['surveyID']);
	$dataSourceId = $_GET['dataSourceId'];
}
else {
	$dataSource = getdatasourcesql(0, $_GET['surveyID']);
	$dataSourceId = 0;
}

$surveyID = $_GET['surveyID'];
$questionID = $_GET['questionID'];
$Headings = $ObsFreq = array();

switch ($QtnListArray[$questionID]['questionType']) {
case '10':
case '20':
case '15':
case '21':
case '16':
case '22':
	$ModuleName = $Module[$QtnListArray[$questionID]['questionType']];
	require ROOT_PATH . 'PlugIn/' . $ModuleName . '/Admin/' . $ModuleName . '.radar.inc.php';
	break;
}

$ColumnsData = '';

foreach ($Headings as $t => $theHeadings) {
	$ColumnsData .= iconv('gbk', 'UTF-8', $theHeadings);
	$ColumnsData .= ';' . $ObsFreq[$t];
	$ColumnsData .= "\r\n";
}

unset($Headings);
unset($ObsFreq);
echo $ColumnsData;
exit();

?>