// JavaScript Document
function viewQuestion()
{
	with (window.document.frmListQuestion) {
		if (cboSkill.selectedIndex == 0) {
			window.location.href = 'index.php';
		} else {
			window.location.href = 'index.php?skillId=' + cboSkill.options[cboSkill.selectedIndex].value;
		}
	}
}

function checkAddQuestionForm()
{
	with (window.document.frmAddQuestion) {
		if (cboSkill.selectedIndex == 0) {
			alert('Choose a type of skill');
			cboSkill.focus();
			return;
		} else if (isEmpty(mtxQuestion, 'Enter the question appropriately')) {
			return;
		} else {
			submit();
		}
	}
}

function addQuestion(skillId)
{
	window.location.href = 'index.php?view=add&skillId=' + skillId;
}

function modifyQuestion(questionId)
{
	window.location.href = 'index.php?view=modify&questionId=' + questionId;
}

function deleteQuestion(questionId, skillId)
{
	if (confirm('Delete this question?')) {
		window.location.href = 'processQuestion.php?action=deleteQuestion&questionId=' + questionId + '&skillId=' + skillId;
	}
}
