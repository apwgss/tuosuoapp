<?php
//dezend by http://www.yunlu99.com/
if (!defined('ROOT_PATH')) {
	exit('EnableQ Security Violation');
}

require_once ROOT_PATH . 'Functions/Functions.check.inc.php';
$lastProg = 'DesignSurvey.php?surveyID=' . $_GET['surveyID'] . '&surveyTitle=' . urlencode($_GET['surveyTitle']) . '&isPre=' . $_GET['isPre'];
$EnableQCoreClass->replace('addURL', $lastProg . '&DO=Add');
$EnableQCoreClass->replace('listURL', $lastProg);
$EnableQCoreClass->replace('questionListURL', $lastProg);
$EnableQCoreClass->replace('surveyID', $_GET['surveyID']);

if ($_POST['Action'] == 'AddAutoMultipleSubmit') {
	if (!isset($_SESSION['PageToken28']) || ($_SESSION['PageToken28'] != session_id())) {
		_showerror('��ȫ����', '��ȫ����ϵͳ��鵽���ı��������Ѿ��ύ��������Ҫ��β�����');
	}

	if ($_POST['questionID'] == '') {
		$questionName = qnoreturnchar($_POST['questionName']);
		$SQL = ' INSERT INTO ' . QUESTION_TABLE . ' SET questionName =\'' . $questionName . '\',questionNotes=\'' . trim($_POST['questionNotes']) . '\',alias=\'' . trim($_POST['alias']) . '\',surveyID=\'' . $_POST['surveyID'] . '\',administratorsID=\'' . $_SESSION['administratorsID'] . '\',questionType=\'28\',isRequired=\'' . $_POST['isRequired'] . '\',isSelect=\'' . $_POST['isSelect'] . '\',minOption=\'' . $_POST['minOption'] . '\',maxOption=\'' . $_POST['maxOption'] . '\',baseID=\'' . $_POST['baseID'] . '\',isNeg=\'' . $_POST['isNeg'] . '\',requiredMode=\'' . $_POST['requiredMode'] . '\',isCheckType=\'' . $_POST['isCheckType'] . '\' ';
		$DB->query($SQL);
		$lastQuestionID = $DB->_GetInsertID();
		updateorderid('question');
		$optionAnswer = explode("\n", $_POST['optionAnswer']);
		$i = 0;

		for (; $i < count($optionAnswer); $i++) {
			$optionAnswer[$i] = str_replace("\r", '', $optionAnswer[$i]);

			if ($optionAnswer[$i] != '') {
				$SQL = ' INSERT INTO ' . QUESTION_RANGE_ANSWER_TABLE . ' SET surveyID=\'' . $_POST['surveyID'] . '\',administratorsID=\'' . $_SESSION['administratorsID'] . '\',questionID=\'' . $lastQuestionID . '\',optionAnswer=\'' . qnoreturnchar($optionAnswer[$i]) . '\' ';
				$DB->query($SQL);
			}
		}

		unset($_SESSION['PageToken28']);
		$questionName = qnohtmltag(stripslashes($_POST['questionName']), 1);
		writetolog($lang['add_automultiple_question'] . ':' . $questionName);
		_showmessage($lang['add_automultiple_question'] . ':' . $questionName, true, 1);
	}
	else {
		$questionName = qnoreturnchar($_POST['questionName']);
		$SQL = ' UPDATE ' . QUESTION_TABLE . ' SET questionName =\'' . $questionName . '\',questionNotes=\'' . trim($_POST['questionNotes']) . '\',alias=\'' . trim($_POST['alias']) . '\',isRequired=\'' . $_POST['isRequired'] . '\',isSelect=\'' . $_POST['isSelect'] . '\',minOption=\'' . $_POST['minOption'] . '\',maxOption=\'' . $_POST['maxOption'] . '\',baseID=\'' . $_POST['baseID'] . '\',isNeg=\'' . $_POST['isNeg'] . '\',requiredMode=\'' . $_POST['requiredMode'] . '\',isCheckType=\'' . $_POST['isCheckType'] . '\' WHERE questionID=\'' . $_POST['questionID'] . '\' ';
		$DB->query($SQL);
		$theOriAnswerID = substr($_POST['theOriAnswerID'], 0, -1);
		$theOriAnswerIDList = explode('|', $theOriAnswerID);
		$optionAnswer = explode("\n", $_POST['optionAnswer']);
		$j = 0;
		$i = 0;

		for (; $i < count($optionAnswer); $i++) {
			$optionAnswer[$i] = str_replace("\r", '', $optionAnswer[$i]);

			if ($optionAnswer[$i] != '') {
				if (($j < count($theOriAnswerIDList)) && !empty($theOriAnswerIDList[$j])) {
					$SQL = ' UPDATE ' . QUESTION_RANGE_ANSWER_TABLE . ' SET optionAnswer=\'' . qnoreturnchar($optionAnswer[$i]) . '\' WHERE question_range_answerID =\'' . $theOriAnswerIDList[$j] . '\' ';
					$DB->query($SQL);
					$j++;
				}
				else {
					$SQL = ' INSERT INTO ' . QUESTION_RANGE_ANSWER_TABLE . ' SET surveyID=\'' . $_POST['surveyID'] . '\',administratorsID=\'' . $_SESSION['administratorsID'] . '\',questionID=\'' . $_POST['questionID'] . '\',optionAnswer=\'' . qnoreturnchar($optionAnswer[$i]) . '\' ';
					$DB->query($SQL);
				}
			}
		}

		if ($j < count($theOriAnswerIDList)) {
			$i = $j;

			for (; $i < count($theOriAnswerIDList); $i++) {
				if (($theOriAnswerIDList[$i] != '') && ($theOriAnswerIDList[$i] != 0)) {
					$SQL = ' DELETE FROM ' . CONDITIONS_TABLE . ' WHERE condOnID=\'' . $_POST['questionID'] . '\' AND optionID =\'' . $theOriAnswerIDList[$i] . '\' ';
					$DB->query($SQL);
					$SQL = ' DELETE FROM ' . ASSOCIATE_TABLE . ' WHERE ( questionID=\'' . $_POST['questionID'] . '\' AND optionID =\'' . $theOriAnswerIDList[$i] . '\') OR (condOnID=\'' . $_POST['questionID'] . '\' AND condOptionID =\'' . $theOriAnswerIDList[$i] . '\') ';
					$DB->query($SQL);
					checkvaluerelation($_POST['surveyID'], $_POST['questionID'], 28, 0, $theOriAnswerIDList[$i], 0, 2);
					$SQL = ' DELETE FROM ' . QUESTION_RANGE_ANSWER_TABLE . ' WHERE question_range_answerID =\'' . $theOriAnswerIDList[$i] . '\' ';
					$DB->query($SQL);
				}
			}
		}

		unset($_SESSION['PageToken28']);
		$questionName = qnohtmltag(stripslashes($_POST['questionName']), 1);
		writetolog($lang['add_automultiple_question'] . ':' . $questionName);
		$nextURL = _getnexturl($_POST['surveyID'], $_POST['questionID'], $_POST['orderByID']);

		if ($nextURL == '') {
			_showmessage($lang['add_automultiple_question'] . ':' . $questionName, true, $_POST['questionID']);
		}
		else {
			_showsucceed($lang['add_automultiple_question'] . ':' . $questionName, $nextURL);
		}
	}
}

if ($_POST['Action'] == 'AddAutoMultipleOver') {
	if (!isset($_SESSION['PageToken28']) || ($_SESSION['PageToken28'] != session_id())) {
		_showerror('��ȫ����', '��ȫ����ϵͳ��鵽���ı��������Ѿ��ύ��������Ҫ��β�����');
	}

	if ($_POST['questionID'] == '') {
		$questionName = qnoreturnchar($_POST['questionName']);
		$SQL = ' INSERT INTO ' . QUESTION_TABLE . ' SET questionName =\'' . $questionName . '\',questionNotes=\'' . trim($_POST['questionNotes']) . '\',alias=\'' . trim($_POST['alias']) . '\',surveyID=\'' . $_POST['surveyID'] . '\',administratorsID=\'' . $_SESSION['administratorsID'] . '\',questionType=\'28\',isRequired=\'' . $_POST['isRequired'] . '\',isSelect=\'' . $_POST['isSelect'] . '\',minOption=\'' . $_POST['minOption'] . '\',maxOption=\'' . $_POST['maxOption'] . '\',baseID=\'' . $_POST['baseID'] . '\',isNeg=\'' . $_POST['isNeg'] . '\',requiredMode=\'' . $_POST['requiredMode'] . '\',isCheckType=\'' . $_POST['isCheckType'] . '\' ';
		$DB->query($SQL);
		$lastQuestionID = $DB->_GetInsertID();
		updateorderid('question');
		$optionAnswer = explode("\n", $_POST['optionAnswer']);
		$i = 0;

		for (; $i < count($optionAnswer); $i++) {
			$optionAnswer[$i] = str_replace("\r", '', $optionAnswer[$i]);

			if ($optionAnswer[$i] != '') {
				$SQL = ' INSERT INTO ' . QUESTION_RANGE_ANSWER_TABLE . ' SET surveyID=\'' . $_POST['surveyID'] . '\',administratorsID=\'' . $_SESSION['administratorsID'] . '\',questionID=\'' . $lastQuestionID . '\',optionAnswer=\'' . qnoreturnchar($optionAnswer[$i]) . '\' ';
				$DB->query($SQL);
			}
		}

		unset($_SESSION['PageToken28']);
		$questionName = qnohtmltag(stripslashes($_POST['questionName']), 1);
		writetolog($lang['add_automultiple_question'] . ':' . $questionName);
		_showmessage($lang['add_automultiple_question'] . ':' . $questionName, true, $lastQuestionID);
	}
	else {
		$questionName = qnoreturnchar($_POST['questionName']);
		$SQL = ' UPDATE ' . QUESTION_TABLE . ' SET questionName =\'' . $questionName . '\',questionNotes=\'' . trim($_POST['questionNotes']) . '\',alias=\'' . trim($_POST['alias']) . '\',isRequired=\'' . $_POST['isRequired'] . '\',isSelect=\'' . $_POST['isSelect'] . '\',minOption=\'' . $_POST['minOption'] . '\',maxOption=\'' . $_POST['maxOption'] . '\',baseID=\'' . $_POST['baseID'] . '\',isNeg=\'' . $_POST['isNeg'] . '\',requiredMode=\'' . $_POST['requiredMode'] . '\',isCheckType=\'' . $_POST['isCheckType'] . '\' WHERE questionID=\'' . $_POST['questionID'] . '\' ';
		$DB->query($SQL);
		$theOriAnswerID = substr($_POST['theOriAnswerID'], 0, -1);
		$theOriAnswerIDList = explode('|', $theOriAnswerID);
		$optionAnswer = explode("\n", $_POST['optionAnswer']);
		$j = 0;
		$i = 0;

		for (; $i < count($optionAnswer); $i++) {
			$optionAnswer[$i] = str_replace("\r", '', $optionAnswer[$i]);

			if ($optionAnswer[$i] != '') {
				if (($j < count($theOriAnswerIDList)) && !empty($theOriAnswerIDList[$j])) {
					$SQL = ' UPDATE ' . QUESTION_RANGE_ANSWER_TABLE . ' SET optionAnswer=\'' . qnoreturnchar($optionAnswer[$i]) . '\' WHERE question_range_answerID =\'' . $theOriAnswerIDList[$j] . '\' ';
					$DB->query($SQL);
					$j++;
				}
				else {
					$SQL = ' INSERT INTO ' . QUESTION_RANGE_ANSWER_TABLE . ' SET surveyID=\'' . $_POST['surveyID'] . '\',administratorsID=\'' . $_SESSION['administratorsID'] . '\',questionID=\'' . $_POST['questionID'] . '\',optionAnswer=\'' . qnoreturnchar($optionAnswer[$i]) . '\' ';
					$DB->query($SQL);
				}
			}
		}

		if ($j < count($theOriAnswerIDList)) {
			$i = $j;

			for (; $i < count($theOriAnswerIDList); $i++) {
				if (($theOriAnswerIDList[$i] != '') && ($theOriAnswerIDList[$i] != 0)) {
					$SQL = ' DELETE FROM ' . CONDITIONS_TABLE . ' WHERE condOnID=\'' . $_POST['questionID'] . '\' AND optionID =\'' . $theOriAnswerIDList[$i] . '\' ';
					$DB->query($SQL);
					$SQL = ' DELETE FROM ' . ASSOCIATE_TABLE . ' WHERE ( questionID=\'' . $_POST['questionID'] . '\' AND optionID =\'' . $theOriAnswerIDList[$i] . '\') OR (condOnID=\'' . $_POST['questionID'] . '\' AND condOptionID =\'' . $theOriAnswerIDList[$i] . '\') ';
					$DB->query($SQL);
					checkvaluerelation($_POST['surveyID'], $_POST['questionID'], 28, 0, $theOriAnswerIDList[$i], 0, 2);
					$SQL = ' DELETE FROM ' . QUESTION_RANGE_ANSWER_TABLE . ' WHERE question_range_answerID =\'' . $theOriAnswerIDList[$i] . '\' ';
					$DB->query($SQL);
				}
			}
		}

		unset($_SESSION['PageToken28']);
		$questionName = qnohtmltag(stripslashes($_POST['questionName']), 1);
		writetolog($lang['add_automultiple_question'] . ':' . $questionName);
		_showmessage($lang['add_automultiple_question'] . ':' . $questionName, true, $_POST['questionID']);
	}
}

$EnableQCoreClass->setTemplateFile('AutoMultipleEditFile', 'AutoMultipleEdit.html');

if ($_GET['questionID'] != '') {
	$SQL = ' SELECT * FROM ' . QUESTION_TABLE . ' WHERE questionID=\'' . $_GET['questionID'] . '\' ';
	$Row = $DB->queryFirstRow($SQL);

	if ($Row['isRequired'] == '1') {
		$EnableQCoreClass->replace('isRequired', 'checked');
	}
	else {
		$EnableQCoreClass->replace('isRequired', '');
	}

	if ($Row['requiredMode'] == '2') {
		$EnableQCoreClass->replace('requiredMode', 'checked');
	}
	else {
		$EnableQCoreClass->replace('requiredMode', '');
	}

	if ($Row['isCheckType'] == '1') {
		$EnableQCoreClass->replace('isCheckType', 'checked');
	}
	else {
		$EnableQCoreClass->replace('isCheckType', '');
	}

	if ($Row['minOption'] == 0) {
		$EnableQCoreClass->replace('minOption', '');
	}
	else {
		$EnableQCoreClass->replace('minOption', $Row['minOption']);
	}

	if ($Row['maxOption'] == 0) {
		$EnableQCoreClass->replace('maxOption', '');
	}
	else {
		$EnableQCoreClass->replace('maxOption', $Row['maxOption']);
	}

	if ($Row['isSelect'] == '1') {
		$EnableQCoreClass->replace('isSelect', 'checked');
	}
	else {
		$EnableQCoreClass->replace('isSelect', '');
	}

	$EnableQCoreClass->replace('questionID', $Row['questionID']);
	$EnableQCoreClass->replace('orderByID', $Row['orderByID']);
	$EnableQCoreClass->replace('questionName', $Row['questionName']);
	$EnableQCoreClass->replace('questionNotes', $Row['questionNotes']);
	$EnableQCoreClass->replace('alias', $Row['alias']);

	switch ($Row['isNeg']) {
	case 0:
		$EnableQCoreClass->replace('isNeg0', 'checked');
		$EnableQCoreClass->replace('isNeg1', '');
		break;

	case 1:
		$EnableQCoreClass->replace('isNeg1', 'checked');
		$EnableQCoreClass->replace('isNeg0', '');
		break;
	}

	$AnswerSQL = ' SELECT question_range_answerID,optionAnswer FROM ' . QUESTION_RANGE_ANSWER_TABLE . ' WHERE questionID=\'' . $_GET['questionID'] . '\'  ORDER BY question_range_answerID ASC ';
	$AnswerResult = $DB->query($AnswerSQL);
	$AnswerCount = $DB->_getNumRows($AnswerResult);
	$optionAnswer = '';
	$j = 0;
	$theOriAnswerID = '';

	while ($AnswerRow = $DB->queryArray($AnswerResult)) {
		$j++;

		if ($j == $AnswerCount) {
			$optionAnswer .= $AnswerRow['optionAnswer'];
		}
		else {
			$optionAnswer .= $AnswerRow['optionAnswer'] . "\n";
		}

		$theOriAnswerID .= $AnswerRow['question_range_answerID'] . '|';
	}

	$EnableQCoreClass->replace('optionAnswer', $optionAnswer);
	$EnableQCoreClass->replace('theOriAnswerID', $theOriAnswerID);
	$SQL = ' SELECT questionID,questionName FROM ' . QUESTION_TABLE . ' WHERE (questionType=3 OR questionType=25) AND surveyID=\'' . $_GET['surveyID'] . '\' AND orderByID < \'' . $Row['orderByID'] . '\' ORDER BY orderByID ASC ';
	$Result = $DB->query($SQL);
	$baseQuestionList = '';

	while ($baseRow = $DB->queryArray($Result)) {
		$baseQuestionName = qnohtmltag($baseRow['questionName'], 1);

		if ($Row['baseID'] == $baseRow['questionID']) {
			$baseQuestionList .= '<option value=\'' . $baseRow['questionID'] . '\' selected>' . $baseQuestionName . '</option>';
		}
		else {
			$baseQuestionList .= '<option value=\'' . $baseRow['questionID'] . '\'>' . $baseQuestionName . '</option>';
		}
	}

	$EnableQCoreClass->replace('baseQuestionList', $baseQuestionList);
}
else {
	$EnableQCoreClass->replace('isRequired', '');
	$EnableQCoreClass->replace('isSelect', '');
	$EnableQCoreClass->replace('optionAnswer', '');
	$EnableQCoreClass->replace('theOriAnswerID', '');
	$EnableQCoreClass->replace('questionID', '');
	$EnableQCoreClass->replace('orderByID', '');
	$EnableQCoreClass->replace('minOption', '');
	$EnableQCoreClass->replace('maxOption', '');
	$EnableQCoreClass->replace('questionName', $lang['default_questionname']);
	$EnableQCoreClass->replace('questionNotes', '');
	$EnableQCoreClass->replace('alias', '');
	$EnableQCoreClass->replace('isNeg0', 'checked');
	$EnableQCoreClass->replace('isNeg1', '');
	$SQL = ' SELECT questionID,questionName FROM ' . QUESTION_TABLE . ' WHERE (questionType=3 OR questionType=25) AND surveyID=\'' . $_GET['surveyID'] . '\' ORDER BY orderByID ASC ';
	$Result = $DB->query($SQL);
	$baseQuestionList = '';

	while ($baseRow = $DB->queryArray($Result)) {
		$baseQuestionName = qnohtmltag($baseRow['questionName'], 1);
		$baseQuestionList .= '<option value=\'' . $baseRow['questionID'] . '\'>' . $baseQuestionName . '</option>';
	}

	$EnableQCoreClass->replace('baseQuestionList', $baseQuestionList);
	$EnableQCoreClass->replace('requiredMode', '');
	$EnableQCoreClass->replace('isCheckType', '');
}

$_SESSION['PageToken28'] = session_id();
$EnableQCoreClass->parse('AutoMultipleEdit', 'AutoMultipleEditFile');
$EnableQCoreClass->output('AutoMultipleEdit');

?>