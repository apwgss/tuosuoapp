<?php
//dezend by http://www.yunlu99.com/
if (!defined('ROOT_PATH')) {
	exit('EnableQ Security Violation');
}

$tmp = 1;

foreach ($OptionListArray[$questionID] as $question_range_optionID => $OptRow) {
	$OptRow = qbr2nl(qquoteconvertstring($OptRow));
	$OptRow = qaddslashes($OptRow, 1);
	if (($OptRow['optionOptionID'] == '0') || ($OptRow['optionOptionID'] == '')) {
		$optionOptionID = $tmp;
	}
	else {
		$optionOptionID = $OptRow['optionOptionID'];
	}

	$SQL = ' INSERT INTO ' . QUESTION_RANGE_OPTION_TABLE . ' SET surveyID=\'' . $theNewSurveyID . '\',administratorsID=\'' . $_SESSION['administratorsID'] . '\',questionID=\'' . $newQuestionID . '\',optionName=\'' . $OptRow['optionName'] . '\',isRequired=\'' . $OptRow['isRequired'] . '\',minOption=\'' . $OptRow['minOption'] . '\',maxOption=\'' . $OptRow['maxOption'] . '\',optionOptionID=\'' . $optionOptionID . '\',isLogicAnd=\'' . $OptRow['isLogicAnd'] . '\' ';
	$DB->query($SQL);
	$tmp++;
	$rangeArray[$OptRow['question_range_optionID']] = $DB->_GetInsertID();
}

foreach ($AnswerListArray[$questionID] as $question_range_answerID => $AnwRow) {
	$AnwRow = qbr2nl(qquoteconvertstring($AnwRow));
	$AnwRow = qaddslashes($AnwRow, 1);
	$SQL = ' INSERT INTO ' . QUESTION_RANGE_ANSWER_TABLE . ' SET surveyID=\'' . $theNewSurveyID . '\',administratorsID=\'' . $_SESSION['administratorsID'] . '\',questionID=\'' . $newQuestionID . '\',optionAnswer=\'' . $AnwRow['optionAnswer'] . '\',optionCoeff=\'' . $AnwRow['optionCoeff'] . '\',optionValue=\'' . $AnwRow['optionValue'] . '\',itemCode=\'' . $AnwRow['itemCode'] . '\',isLogicAnd=\'' . $AnwRow['isLogicAnd'] . '\',isNA=\'' . $AnwRow['isNA'] . '\' ';
	$DB->query($SQL);
	$answerArray[$AnwRow['question_range_answerID']] = $DB->_GetInsertID();
}

?>
