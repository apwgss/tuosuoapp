<?php
//dezend by http://www.yunlu99.com/
echo 'function _GetSurveyValueRelationCond( questionID,surveyID )' . "\r\n" . '{	' . "\r\n" . '    //�Ƿ���ڱ��������ϵ' . "\r\n" . '    var theQtnRelArray = [];' . "\r\n" . '	var theFocusObjId = [];' . "\r\n" . '	var theQtnValueRelArray = [];' . "\r\n" . '	for( var relationID in ValueRelArray )' . "\r\n" . '	{' . "\r\n" . '		var theQtnRelArray = ValueRelArray[relationID];' . "\r\n" . '		if( theQtnRelArray.relationMode == 1 )  //�̶�ֵ' . "\r\n" . '		{' . "\r\n" . '			//����$theQtnRelArray[\'list\'],�ҳ����OrderByID������' . "\r\n" . '			var theMaxArray = [];' . "\r\n" . '			for( var listID in theQtnRelArray[\'list\'] )' . "\r\n" . '			{' . "\r\n" . '				var theListArray =  theQtnRelArray[\'list\'][listID];' . "\r\n" . '				theMaxArray[listID] = QtnListArray[theListArray.questionID].orderByID;' . "\r\n" . '			}' . "\r\n" . '			var theLastListID = array_search(max(theMaxArray),theMaxArray);' . "\r\n" . '			theMaxArray = null;' . "\r\n" . '			var theLastQtnID = theQtnRelArray[\'list\'][theLastListID].questionID;' . "\r\n" . '			if( parseInt(theLastQtnID) == parseInt(questionID) )' . "\r\n" . '			{' . "\r\n" . '				theQtnValueRelArray.push(relationID);' . "\r\n" . '				theFocusObjId[relationID] = questionID;' . "\r\n" . '			}' . "\r\n" . '			else' . "\r\n" . '			{' . "\r\n" . '				continue;' . "\r\n" . '			}' . "\r\n" . '		}' . "\r\n" . '		else  //�ظ�ֵ' . "\r\n" . '		{' . "\r\n" . '			if( parseInt(theQtnRelArray.questionID) == parseInt(questionID) )' . "\r\n" . '			{' . "\r\n" . '				theQtnValueRelArray.push(relationID);' . "\r\n" . '				theFocusObjId[relationID] = questionID;' . "\r\n" . '			}' . "\r\n" . '			else' . "\r\n" . '			{' . "\r\n" . '				continue;' . "\r\n" . '			}' . "\r\n" . '		}' . "\r\n" . '	}' . "\r\n" . '	if( count(theQtnValueRelArray) == 0 ) return \'\';' . "\r\n" . '' . "\r\n" . '    //��װ�������еĹ�����ϵ����' . "\r\n" . '	var endConList = \'\';' . "\r\n" . '	for( var tmp in theQtnValueRelArray )' . "\r\n" . '	{' . "\r\n" . '		var theRelID = theQtnValueRelArray[tmp];' . "\r\n" . '		endConList += ValueRelArray[theRelID].relationDefine+"######";' . "\r\n" . '		if( ValueRelArray[theRelID].relationDefine == 2 ) //����' . "\r\n" . '		{' . "\r\n" . '			endConList += "\\temptyCheckStr += \'s1*"+ValueRelArray[theRelID].opertion;' . "\r\n" . '		}' . "\r\n" . '		else' . "\r\n" . '		{' . "\r\n" . '			endConList += "\\t\\tthisCheckStr += \'s1*"+ValueRelArray[theRelID].opertion;' . "\r\n" . '		}' . "\r\n" . '		switch(ValueRelArray[theRelID].opertion )' . "\r\n" . '		{' . "\r\n" . '			case 1:' . "\r\n" . '				theOpertionText = \' = \';' . "\r\n" . '			break;' . "\r\n" . '			case 2:' . "\r\n" . '				theOpertionText = \' < \';' . "\r\n" . '			break;' . "\r\n" . '			case 3:' . "\r\n" . '				theOpertionText = \' <= \';' . "\r\n" . '			break;' . "\r\n" . '			case 4:' . "\r\n" . '				theOpertionText = \' > \';' . "\r\n" . '			break;' . "\r\n" . '			case 5:' . "\r\n" . '				theOpertionText = \' >= \';' . "\r\n" . '			break;' . "\r\n" . '			case 6:' . "\r\n" . '				theOpertionText = \' != \';' . "\r\n" . '			break;' . "\r\n" . '		}' . "\r\n" . '		var theMainFieldsList = \'\';' . "\r\n" . '		if( ValueRelArray[theRelID].relationMode == 1 )  //�̶�ֵ' . "\r\n" . '		{' . "\r\n" . '			endConList += \'*\'+ValueRelArray[theRelID].relationNum;' . "\r\n" . '			theOpertionText += ValueRelArray[theRelID].relationNum+\' \';' . "\r\n" . '		}' . "\r\n" . '		else' . "\r\n" . '		{' . "\r\n" . '			endConList += \'*m2\';' . "\r\n" . '			var theQtnId = ValueRelArray[theRelID].questionID;' . "\r\n" . '			var theSubQtnId = ValueRelArray[theRelID].qtnID;' . "\r\n" . '			var theOptionId = ValueRelArray[theRelID].optionID;' . "\r\n" . '			var theLabelId = ValueRelArray[theRelID].labelID;' . "\r\n" . '			' . "\r\n" . '			switch(QtnListArray[theQtnId].questionType)' . "\r\n" . '			{' . "\r\n" . '				case 1:  //�Ƿ�' . "\r\n" . '				case 24: //����' . "\r\n" . '					theMainFieldsList += \'1-option_\'+theQtnId+\'$\';' . "\r\n" . '					theOpertionText += \'(\'+QtnListArray[theQtnId].questionName+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 2:  //��ѡ' . "\r\n" . '					if( QtnListArray[theQtnId].isSelect == 1 ) //select' . "\r\n" . '					{' . "\r\n" . '						theMainFieldsList += \'3-option_\'+theQtnId+\'$\';' . "\r\n" . '					}' . "\r\n" . '					else' . "\r\n" . '					{' . "\r\n" . '						theMainFieldsList += \'1-option_\'+theQtnId+\'$\';' . "\r\n" . '					}' . "\r\n" . '					theOpertionText += \'(\'+QtnListArray[theQtnId].questionName+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 3:  //��ѡ' . "\r\n" . '				case 25: //���϶�ѡ' . "\r\n" . '					if( QtnListArray[theQtnId].isSelect == 1 ) //select' . "\r\n" . '					{' . "\r\n" . '						theMainFieldsList += \'3-option_\'+theQtnId+\'-\'+theOptionId+\'$\';' . "\r\n" . '					}' . "\r\n" . '					else' . "\r\n" . '					{' . "\r\n" . '						theMainFieldsList += \'2-option_\'+theQtnId+\'-\'+theOptionId+\'$\';' . "\r\n" . '					}' . "\r\n" . '					theOpertionText += \'(\'+QtnListArray[theQtnId].questionName+\' - \';' . "\r\n" . '					switch(theOptionId)' . "\r\n" . '					{' . "\r\n" . '						case 0:' . "\r\n" . '							var optionName = QtnListArray[theQtnId].otherText;' . "\r\n" . '						break;' . "\r\n" . '						case 99999:' . "\r\n" . '							var optionName = ( QtnListArray[theQtnId].allowType == \'\' ) ? \'���϶�����\' : QtnListArray[theQtnId].allowType;' . "\r\n" . '						break;' . "\r\n" . '						default:' . "\r\n" . '							var optionName = CheckBoxListArray[theQtnId][theOptionId].optionName;' . "\r\n" . '						break;' . "\r\n" . '					}' . "\r\n" . '					theOpertionText += optionName+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 4:  //���' . "\r\n" . '					theMainFieldsList += \'3-option_\'+theQtnId+\'$\';' . "\r\n" . '					theOpertionText += \'(\'+QtnListArray[theQtnId].questionName+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 17: //Auto' . "\r\n" . '					if( QtnListArray[theQtnId].isSelect == 1 )  //��ѡ' . "\r\n" . '					{' . "\r\n" . '						theMainFieldsList += \'1-option_\'+theQtnId+\'$\';' . "\r\n" . '						theOpertionText += \'(\'+QtnListArray[theQtnId].questionName+\') \';' . "\r\n" . '					}' . "\r\n" . '					else' . "\r\n" . '					{' . "\r\n" . '						theMainFieldsList += \'2-option_\'+theQtnId+\'-\'+theOptionId+\'$\';' . "\r\n" . '						theOpertionText += \'(\'+QtnListArray[theQtnId].questionName+\' - \';' . "\r\n" . '						//��Դ��ѡ' . "\r\n" . '						var theBaseID = QtnListArray[theQtnId].baseID;' . "\r\n" . '						switch(theOptionId)' . "\r\n" . '						{' . "\r\n" . '							case 0:' . "\r\n" . '								var optionName = QtnListArray[theBaseID].otherText;	' . "\r\n" . '							break;' . "\r\n" . '							case 99999:' . "\r\n" . '								var optionName = ( QtnListArray[theQtnId].allowType == \'\' ) ? \'���϶�����\' : QtnListArray[theQtnId].allowType;' . "\r\n" . '							break;' . "\r\n" . '							default:' . "\r\n" . '								var optionName = CheckBoxListArray[theBaseID][theOptionId].optionName;' . "\r\n" . '							break;' . "\r\n" . '						}' . "\r\n" . '						theOpertionText += optionName+\') \';' . "\r\n" . '					}' . "\r\n" . '				break;' . "\r\n" . '				case 18: //Cond' . "\r\n" . '					if( QtnListArray[theQtnId].isSelect == 1 )  //��ѡ' . "\r\n" . '					{' . "\r\n" . '						theMainFieldsList += \'3-option_\'+theQtnId+\'-\'+theOptionId+\'$\';' . "\r\n" . '						theOpertionText += \'(\'+QtnListArray[theQtnId].questionName+\' - \';' . "\r\n" . '						theOpertionText += YesNoListArray[theQtnId][theOptionId].optionName+\')\';' . "\r\n" . '					}' . "\r\n" . '					else' . "\r\n" . '					{' . "\r\n" . '						theMainFieldsList += \'3-option_\'+theQtnId+\'$\';' . "\r\n" . '						theOpertionText += \'(\'+QtnListArray[theQtnId].questionName+\') \';' . "\r\n" . '					}' . "\r\n" . '				break;' . "\r\n" . '				case 6:  //����ѡ' . "\r\n" . '					theMainFieldsList += \'1-option_\'+theQtnId+\'_\'+theSubQtnId+\'$\';' . "\r\n" . '					theOpertionText += \'(\'+QtnListArray[theQtnId].questionName+\' - \'+OptionListArray[theQtnId][theSubQtnId].optionName+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 7:  //�����ѡ' . "\r\n" . '					theMainFieldsList += \'2-option_\'+theQtnId+\'_\'+theSubQtnId+\'-\'+theOptionId+\'$\';' . "\r\n" . '					theOpertionText += \'(\'+QtnListArray[theQtnId].questionName+\' - \'+OptionListArray[theQtnId][theSubQtnId].optionName+\' - \'+AnswerListArray[theQtnId][theOptionId].optionAnswer+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 19: //AutoRange' . "\r\n" . '				case 21: //AutoRating' . "\r\n" . '				case 22: //AutoWeight' . "\r\n" . '					switch(QtnListArray[theQtnId].questionType)' . "\r\n" . '					{' . "\r\n" . '						case 19:' . "\r\n" . '							theMainFieldsList += \'1-option_\'+theQtnId+\'_\'+theSubQtnId+\'$\';' . "\r\n" . '						break;' . "\r\n" . '						case 21:' . "\r\n" . '							switch(QtnListArray[theQtnId].isSelect)' . "\r\n" . '							{' . "\r\n" . '								case 0://��ѡ' . "\r\n" . '									theMainFieldsList += \'1-option_\'+theQtnId+\'_\'+theSubQtnId+\'$\';' . "\r\n" . '								break;' . "\r\n" . '								case 1://���Żظ�' . "\r\n" . '								case 2://������' . "\r\n" . '									theMainFieldsList += \'3-option_\'+theQtnId+\'_\'+theSubQtnId+\'$\';' . "\r\n" . '								break;' . "\r\n" . '							}' . "\r\n" . '						break;' . "\r\n" . '						case 22:' . "\r\n" . '							theMainFieldsList += \'3-option_\'+theQtnId+\'_\'+theSubQtnId+\'$\';' . "\r\n" . '						break;' . "\r\n" . '					}' . "\r\n" . '					theOpertionText += \'(\'+QtnListArray[theQtnId].questionName+\' - \';' . "\r\n" . '					var theBaseID = QtnListArray[theQtnId].baseID;' . "\r\n" . '					switch(theSubQtnId)' . "\r\n" . '					{' . "\r\n" . '						case 0:' . "\r\n" . '							var optionName = QtnListArray[theBaseID].otherText;		' . "\r\n" . '						break;' . "\r\n" . '						default:' . "\r\n" . '							var optionName = CheckBoxListArray[theBaseID][theSubQtnId].optionName;' . "\r\n" . '						break;' . "\r\n" . '					}' . "\r\n" . '					theOpertionText += optionName+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 15: //����' . "\r\n" . '					switch(QtnListArray[theQtnId].isSelect)' . "\r\n" . '					{' . "\r\n" . '						case 0://��ѡ' . "\r\n" . '							theMainFieldsList += \'1-option_\'+theQtnId+\'_\'+theOptionId+\'$\';' . "\r\n" . '						break;' . "\r\n" . '						case 1://���Żظ�' . "\r\n" . '						case 2://������' . "\r\n" . '							theMainFieldsList += \'3-option_\'+theQtnId+\'_\'+theOptionId+\'$\';' . "\r\n" . '						break;' . "\r\n" . '					}' . "\r\n" . '					theOpertionText += \'(\'+QtnListArray[theQtnId].questionName+\' - \';' . "\r\n" . '					theOpertionText += RankListArray[theQtnId][theOptionId].optionName+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 16: //����' . "\r\n" . '					theMainFieldsList += \'3-option_\'+theQtnId+\'_\'+theOptionId+\'$\';' . "\r\n" . '					theOpertionText += \'(\'+QtnListArray[theQtnId].questionName+\' - \';' . "\r\n" . '					theOpertionText += RankListArray[theQtnId][theOptionId].optionName+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 23:  //������' . "\r\n" . '					theMainFieldsList += \'3-option_\'+theQtnId+\'_\'+theOptionId+\'$\';' . "\r\n" . '					theOpertionText += \'(\'+QtnListArray[theQtnId].questionName+\' - \';' . "\r\n" . '					theOpertionText += YesNoListArray[theQtnId][theOptionId].optionName+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 26:  //���Ͼ���ѡ' . "\r\n" . '					theMainFieldsList += \'3-option_\'+theQtnId+\'_\'+theSubQtnId+\'_\'+theOptionId+\'$\';' . "\r\n" . '					theOpertionText += \'(\'+QtnListArray[theQtnId].questionName+\' - \';' . "\r\n" . '					theOpertionText += OptionListArray[theQtnId][theSubQtnId].optionName+\' - \';' . "\r\n" . '					theOpertionText += LabelListArray[theQtnId][theOptionId].optionLabel+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 27:  //�������' . "\r\n" . '					theMainFieldsList += \'3-option_\'+theQtnId+\'_\'+theOptionId+\'_\'+theLabelId+\'$\';' . "\r\n" . '					theOpertionText += \'(\'+QtnListArray[theQtnId].questionName+\' - \';' . "\r\n" . '					theOpertionText += OptionListArray[theQtnId][theOptionId].optionName+\' - \';' . "\r\n" . '					theOpertionText += LabelListArray[theQtnId][theLabelId].optionLabel+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 28: //�Զ������ѡ' . "\r\n" . '					theMainFieldsList += \'2-option_\'+theQtnId+\'_\'+theSubQtnId+\'-\'+theOptionId+\'$\';' . "\r\n" . '					theOpertionText += \'(\'+QtnListArray[theQtnId].questionName+\' - \';' . "\r\n" . '					var theBaseID = QtnListArray[theQtnId].baseID;' . "\r\n" . '					switch(theSubQtnId)' . "\r\n" . '					{' . "\r\n" . '						case 0:' . "\r\n" . '							var optionName = QtnListArray[theBaseID].otherText;							' . "\r\n" . '						break;' . "\r\n" . '						default:' . "\r\n" . '							var optionName = CheckBoxListArray[theBaseID][theSubQtnId].optionName;' . "\r\n" . '						break;' . "\r\n" . '					}' . "\r\n" . '					theOpertionText += optionName+\' - \';' . "\r\n" . '					theOpertionText += AnswerListArray[theQtnId][theOptionId].optionAnswer+\') \';' . "\r\n" . '				break;' . "\r\n" . '			}' . "\r\n" . '		}' . "\r\n" . '' . "\r\n" . '		//��ʼƴװ��һ��������ı���ʽ' . "\r\n" . '		var theFieldsList = \'\';' . "\r\n" . '		var theOpertionsList = \'\';' . "\r\n" . '		var theTitleList = \'\';' . "\r\n" . '' . "\r\n" . '		var j =0;' . "\r\n" . '		if( count(ValueRelArray[theRelID][\'list\']) >= 2 )' . "\r\n" . '		{' . "\r\n" . '			theTitleList += \'(\';' . "\r\n" . '		}' . "\r\n" . '		for( var listID in ValueRelArray[theRelID][\'list\'] )' . "\r\n" . '		{' . "\r\n" . '			var theValueRelArray = ValueRelArray[theRelID][\'list\'][listID];' . "\r\n" . '			if( j != 0 )' . "\r\n" . '			{' . "\r\n" . '				theOpertionsList += theValueRelArray.opertion+\'$\';' . "\r\n" . '				switch( theValueRelArray.opertion )' . "\r\n" . '				{' . "\r\n" . '					case 1:' . "\r\n" . '						theTitleList += \' + \';' . "\r\n" . '					break;' . "\r\n" . '					case 2:' . "\r\n" . '						theTitleList += \' - \';' . "\r\n" . '					break;' . "\r\n" . '					case 3:' . "\r\n" . '						theTitleList += \' * \';' . "\r\n" . '					break;' . "\r\n" . '					case 4:' . "\r\n" . '						theTitleList += \' / \';' . "\r\n" . '					break;' . "\r\n" . '				}' . "\r\n" . '			}' . "\r\n" . '' . "\r\n" . '			var theOQtnId = theValueRelArray.questionID;' . "\r\n" . '			var theOSubQtnId = theValueRelArray.qtnID;' . "\r\n" . '			var theOOptionId = theValueRelArray.optionID;' . "\r\n" . '			var theOLabelId = theValueRelArray.labelID;' . "\r\n" . '' . "\r\n" . '			switch(QtnListArray[theOQtnId].questionType)' . "\r\n" . '			{' . "\r\n" . '				case 1:  //�Ƿ�' . "\r\n" . '				case 24: //����' . "\r\n" . '					if( IsSamePage(questionID,theOQtnId) )' . "\r\n" . '					{' . "\r\n" . '						theFieldsList += \'1-option_\'+theOQtnId+\'$\';' . "\r\n" . '					}' . "\r\n" . '					else' . "\r\n" . '					{' . "\r\n" . '						theFieldsList += \'3-option_\'+theOQtnId+\'$\';' . "\r\n" . '					}' . "\r\n" . '					theTitleList += \'(\'+QtnListArray[theOQtnId].questionName+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 2:  //��ѡ' . "\r\n" . '					if( IsSamePage(questionID,theOQtnId) )' . "\r\n" . '					{' . "\r\n" . '						if(QtnListArray[theOQtnId].isSelect == 1 ) //select' . "\r\n" . '						{' . "\r\n" . '							theFieldsList += \'3-option_\'+theOQtnId+\'$\';' . "\r\n" . '						}' . "\r\n" . '						else' . "\r\n" . '						{' . "\r\n" . '							theFieldsList += \'1-option_\'+theOQtnId+\'$\';' . "\r\n" . '						}' . "\r\n" . '					}' . "\r\n" . '					else' . "\r\n" . '					{' . "\r\n" . '						theFieldsList += \'3-option_\'+theOQtnId+\'$\';' . "\r\n" . '					}' . "\r\n" . '					theTitleList += \'(\'+QtnListArray[theOQtnId].questionName+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 3:  //��ѡ' . "\r\n" . '				case 25: //���϶�ѡ' . "\r\n" . '					if( IsSamePage(questionID,theOQtnId) )' . "\r\n" . '					{' . "\r\n" . '						if(QtnListArray[theOQtnId].isSelect == 1 ) //select' . "\r\n" . '						{' . "\r\n" . '							theFieldsList += \'3-option_\'+theOQtnId+\'-\'+theOOptionId+\'$\';' . "\r\n" . '						}' . "\r\n" . '						else' . "\r\n" . '						{' . "\r\n" . '							theFieldsList += \'2-option_\'+theOQtnId+\'-\'+theOOptionId+\'$\';' . "\r\n" . '						}' . "\r\n" . '					}' . "\r\n" . '					else' . "\r\n" . '					{' . "\r\n" . '						theFieldsList += \'3-option_\'+theOQtnId+\'-\'+theOOptionId+\'$\';' . "\r\n" . '					}' . "\r\n" . '					theTitleList += \'(\'+QtnListArray[theOQtnId].questionName+\' - \';' . "\r\n" . '					switch(theOOptionId)' . "\r\n" . '					{' . "\r\n" . '						case 0:' . "\r\n" . '							var optionName = QtnListArray[theOQtnId].otherText;' . "\r\n" . '						break;' . "\r\n" . '						case 99999:' . "\r\n" . '							var optionName = (QtnListArray[theOQtnId].allowType == \'\' ) ? \'���϶�û��\' : QtnListArray[theOQtnId].allowType;' . "\r\n" . '						break;' . "\r\n" . '						default:' . "\r\n" . '							var optionName = CheckBoxListArray[theOQtnId][theOOptionId].optionName;' . "\r\n" . '						break;' . "\r\n" . '					}' . "\r\n" . '					theTitleList += optionName+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 4:  //���' . "\r\n" . '					theFieldsList += \'3-option_\'+theOQtnId+\'$\';' . "\r\n" . '					theTitleList += \'(\'+QtnListArray[theOQtnId].questionName+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 17: //Auto' . "\r\n" . '					if( QtnListArray[theOQtnId].isSelect == 1 )  //��ѡ' . "\r\n" . '					{' . "\r\n" . '						if( IsSamePage(questionID,theOQtnId) )' . "\r\n" . '						{' . "\r\n" . '							theFieldsList += \'1-option_\'+theOQtnId+\'$\';' . "\r\n" . '						}' . "\r\n" . '						else' . "\r\n" . '						{' . "\r\n" . '							theFieldsList += \'3-option_\'+theOQtnId+\'$\';' . "\r\n" . '						}' . "\r\n" . '						theTitleList += \'(\'+QtnListArray[theOQtnId].questionName+\') \';' . "\r\n" . '					}' . "\r\n" . '					else' . "\r\n" . '					{' . "\r\n" . '						if( IsSamePage(questionID,theOQtnId) )' . "\r\n" . '						{' . "\r\n" . '							theFieldsList += \'2-option_\'+theOQtnId+\'-\'+theOOptionId+\'$\';' . "\r\n" . '						}' . "\r\n" . '						else' . "\r\n" . '						{' . "\r\n" . '							theFieldsList += \'3-option_\'+theOQtnId+\'-\'+theOOptionId+\'$\';' . "\r\n" . '						}' . "\r\n" . '						theTitleList += \'(\'+QtnListArray[theOQtnId].questionName+\' - \';' . "\r\n" . '						//��Դ��ѡ' . "\r\n" . '						var theBaseID = QtnListArray[theOQtnId].baseID;' . "\r\n" . '						switch(theOOptionId)' . "\r\n" . '						{' . "\r\n" . '							case 0:' . "\r\n" . '								var optionName = QtnListArray[theBaseID].otherText;							' . "\r\n" . '							break;' . "\r\n" . '							case 99999:' . "\r\n" . '								var optionName = (QtnListArray[theOQtnId].allowType == \'\' ) ? \'���϶�û��\' : QtnListArray[theOQtnId].allowType;' . "\r\n" . '							break;' . "\r\n" . '							default:' . "\r\n" . '								var optionName = CheckBoxListArray[theBaseID][theOOptionId].optionName;' . "\r\n" . '							break;' . "\r\n" . '						}' . "\r\n" . '						theTitleList += optionName+\') \';' . "\r\n" . '					}' . "\r\n" . '				break;' . "\r\n" . '				case 18: //Cond' . "\r\n" . '					if( QtnListArray[theOQtnId].isSelect == 1 )  //��ѡ' . "\r\n" . '					{' . "\r\n" . '						theFieldsList += \'3-option_\'+theOQtnId+\'-\'+theOOptionId+\'$\';' . "\r\n" . '						theTitleList += \'(\'+QtnListArray[theOQtnId].questionName+\' - \';' . "\r\n" . '						theTitleList += YesNoListArray[theOQtnId][theOOptionId].optionName+\')\';' . "\r\n" . '					}' . "\r\n" . '					else' . "\r\n" . '					{' . "\r\n" . '						theFieldsList += \'3-option_\'+theOQtnId+\'$\';' . "\r\n" . '						theTitleList += \'(\'+QtnListArray[theOQtnId].questionName+\') \';' . "\r\n" . '					}' . "\r\n" . '				break;' . "\r\n" . '				case 6:  //����ѡ' . "\r\n" . '					if( IsSamePage(questionID,theOQtnId) )' . "\r\n" . '					{' . "\r\n" . '						theFieldsList += \'1-option_\'+theOQtnId+\'_\'+theOSubQtnId+\'$\';' . "\r\n" . '					}' . "\r\n" . '					else' . "\r\n" . '					{' . "\r\n" . '						theFieldsList += \'3-option_\'+theOQtnId+\'_\'+theOSubQtnId+\'$\';' . "\r\n" . '					}' . "\r\n" . '					theTitleList += \'(\'+QtnListArray[theOQtnId].questionName+\' - \'+OptionListArray[theOQtnId][theOSubQtnId].optionName+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 7:  //�����ѡ' . "\r\n" . '					if( IsSamePage(questionID,theOQtnId) )' . "\r\n" . '					{' . "\r\n" . '						theFieldsList += \'2-option_\'+theOQtnId+\'_\'+theOSubQtnId+\'-\'+theOOptionId+\'$\';' . "\r\n" . '					}' . "\r\n" . '					else' . "\r\n" . '					{' . "\r\n" . '						theFieldsList += \'3-option_\'+theOQtnId+\'_\'+theOSubQtnId+\'-\'+theOOptionId+\'$\';' . "\r\n" . '					}' . "\r\n" . '					theTitleList += \'(\'+QtnListArray[theOQtnId].questionName+\' - \'+OptionListArray[theOQtnId][theOSubQtnId].optionName+\' - \'+AnswerListArray[theOQtnId][theOOptionId].optionAnswer+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 19: //AutoRange' . "\r\n" . '				case 21: //AutoRating' . "\r\n" . '				case 22: //AutoWeight' . "\r\n" . '					switch(QtnListArray[theOQtnId].questionType)' . "\r\n" . '					{' . "\r\n" . '						case 19:' . "\r\n" . '							if( IsSamePage(questionID,theOQtnId) )' . "\r\n" . '							{' . "\r\n" . '								theFieldsList += \'1-option_\'+theOQtnId+\'_\'+theOSubQtnId+\'$\';' . "\r\n" . '							}' . "\r\n" . '							else' . "\r\n" . '							{' . "\r\n" . '								theFieldsList += \'3-option_\'+theOQtnId+\'_\'+theOSubQtnId+\'$\';' . "\r\n" . '							}' . "\r\n" . '						break;' . "\r\n" . '						case 21:' . "\r\n" . '							switch(QtnListArray[theOQtnId].isSelect)' . "\r\n" . '							{' . "\r\n" . '								case 0://��ѡ' . "\r\n" . '									if( IsSamePage(questionID,theOQtnId) )' . "\r\n" . '									{' . "\r\n" . '										theFieldsList += \'1-option_\'+theOQtnId+\'_\'+theOSubQtnId+\'$\';' . "\r\n" . '									}' . "\r\n" . '									else' . "\r\n" . '									{' . "\r\n" . '										theFieldsList += \'3-option_\'+theOQtnId+\'_\'+theOSubQtnId+\'$\';' . "\r\n" . '									}' . "\r\n" . '								break;' . "\r\n" . '								case 1://���Żظ�' . "\r\n" . '								case 2://������' . "\r\n" . '									theFieldsList += \'3-option_\'+theOQtnId+\'_\'+theOSubQtnId+\'$\';' . "\r\n" . '								break;' . "\r\n" . '							}' . "\r\n" . '						break;' . "\r\n" . '						case 22:' . "\r\n" . '							theFieldsList += \'3-option_\'+theOQtnId+\'_\'+theOSubQtnId+\'$\';' . "\r\n" . '						break;' . "\r\n" . '					}' . "\r\n" . '					theTitleList += \'(\'+QtnListArray[theOQtnId].questionName+\' - \';' . "\r\n" . '					var theBaseID = QtnListArray[theOQtnId].baseID;' . "\r\n" . '					switch(theOSubQtnId)' . "\r\n" . '					{' . "\r\n" . '						case 0:' . "\r\n" . '							var optionName = QtnListArray[theBaseID].otherText;							' . "\r\n" . '						break;' . "\r\n" . '						default:' . "\r\n" . '							var optionName = CheckBoxListArray[theBaseID][theOSubQtnId].optionName;' . "\r\n" . '						break;' . "\r\n" . '					}					' . "\r\n" . '					theTitleList += optionName+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 15: //����' . "\r\n" . '					switch(QtnListArray[theOQtnId].isSelect)' . "\r\n" . '					{' . "\r\n" . '						case 0://��ѡ' . "\r\n" . '							if( IsSamePage(questionID,theOQtnId) )' . "\r\n" . '							{' . "\r\n" . '								theFieldsList += \'1-option_\'+theOQtnId+\'_\'+theOOptionId+\'$\';' . "\r\n" . '							}' . "\r\n" . '							else' . "\r\n" . '							{' . "\r\n" . '								theFieldsList += \'3-option_\'+theOQtnId+\'_\'+theOOptionId+\'$\';' . "\r\n" . '							}' . "\r\n" . '						break;' . "\r\n" . '						case 1://���Żظ�' . "\r\n" . '						case 2://������' . "\r\n" . '							theFieldsList += \'3-option_\'+theOQtnId+\'_\'+theOOptionId+\'$\';' . "\r\n" . '						break;' . "\r\n" . '					}' . "\r\n" . '					theTitleList += \'(\'+QtnListArray[theOQtnId].questionName+\' - \';' . "\r\n" . '					theTitleList += RankListArray[theOQtnId][theOOptionId].optionName+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 16: //����' . "\r\n" . '					theFieldsList += \'3-option_\'+theOQtnId+\'_\'+theOOptionId+\'$\';' . "\r\n" . '					theTitleList += \'(\'+QtnListArray[theOQtnId].questionName+\' - \';' . "\r\n" . '					theTitleList += RankListArray[theOQtnId][theOOptionId].optionName+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 23:  //������' . "\r\n" . '					theFieldsList += \'3-option_\'+theOQtnId+\'_\'+theOOptionId+\'$\';' . "\r\n" . '					theTitleList += \'(\'+QtnListArray[theOQtnId].questionName+\' - \';' . "\r\n" . '					theTitleList += YesNoListArray[theOQtnId][theOOptionId].optionName+\')\';' . "\r\n" . '				break;' . "\r\n" . '				case 26:  //���Ͼ���ѡ' . "\r\n" . '					theFieldsList += \'3-option_\'+theOQtnId+\'_\'+theOSubQtnId+\'_\'+theOOptionId+\'$\';' . "\r\n" . '					theTitleList += \'(\'+QtnListArray[theOQtnId].questionName+\' - \';' . "\r\n" . '					theTitleList += OptionListArray[theOQtnId][theOSubQtnId].optionName+\' - \';' . "\r\n" . '					theTitleList += LabelListArray[theOQtnId][theOOptionId].optionLabel+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 28: //�Զ������ѡ' . "\r\n" . '					if( IsSamePage(questionID,theOQtnId) )' . "\r\n" . '					{' . "\r\n" . '						theFieldsList += \'2-option_\'+theOQtnId+\'_\'+theOSubQtnId+\'-\'+theOOptionId+\'$\';' . "\r\n" . '					}' . "\r\n" . '					else' . "\r\n" . '					{' . "\r\n" . '						theFieldsList += \'3-option_\'+theOQtnId+\'_\'+theOSubQtnId+\'-\'+theOOptionId+\'$\';' . "\r\n" . '					}' . "\r\n" . '					theTitleList += \'(\'+QtnListArray[theOQtnId].questionName+\' - \';' . "\r\n" . '					var theBaseID = QtnListArray[theOQtnId].baseID;' . "\r\n" . '					switch(theOSubQtnId)' . "\r\n" . '					{' . "\r\n" . '						case 0:' . "\r\n" . '							theTitleList += QtnListArray[theBaseID].otherText+\' - \';							' . "\r\n" . '						break;' . "\r\n" . '						default:' . "\r\n" . '							theTitleList += CheckBoxListArray[theBaseID][theOSubQtnId].optionName+\' - \';' . "\r\n" . '						break;' . "\r\n" . '					}' . "\r\n" . '					theTitleList += AnswerListArray[theOQtnId][theOOptionId].optionAnswer+\') \';' . "\r\n" . '				break;' . "\r\n" . '				case 27:  //�������' . "\r\n" . '					theFieldsList += \'3-option_\'+theOQtnId+\'_\'+theOOptionId+\'_\'+theOLabelId+\'$\';' . "\r\n" . '					theTitleList += \'(\'+QtnListArray[theOQtnId].questionName+\' - \';' . "\r\n" . '					theTitleList += OptionListArray[theOQtnId][theOOptionId].optionName+\' - \';' . "\r\n" . '					theTitleList += LabelListArray[theOQtnId][theOLabelId].optionLabel+\') \';' . "\r\n" . '				break;' . "\r\n" . '			}' . "\r\n" . '			j++;' . "\r\n" . '		} //End for foreach' . "\r\n" . '		if( count(ValueRelArray[theRelID][\'list\']) >= 2 )' . "\r\n" . '		{' . "\r\n" . '			theTitleList += \')\';' . "\r\n" . '		}' . "\r\n" . '		theTitleList += theOpertionText;' . "\r\n" . '		endConList += \'*\'+substr(theMainFieldsList+theFieldsList,0,-1)+\'*\'+substr(theOpertionsList,0,-1)+\'*\'+theFocusObjId[theRelID]+\'*\'+base64_encode(theTitleList);' . "\r\n" . '		if( ValueRelArray[theRelID].relationDefine == 2 ) //����' . "\r\n" . '		{' . "\r\n" . '			endConList += \'*\'+ parseInt(ValueRelArray[theRelID].defineList);' . "\r\n" . '		}' . "\r\n" . '		endConList += "|\';$$$$$$";	' . "\r\n" . '	} //End for foreach' . "\r\n" . '	return substr(endConList,0,-6);' . "\r\n" . '}' . "\r\n" . '';

?>