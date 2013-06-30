// JavaScript Document
function checkSkillForm()
{
    with (window.document.frmSkill) {
		if (isEmpty(txtName, 'Enter skill name')) {
			return;
		} else if (isEmpty(mtxDescription, 'Enter skill description')) {
			return;
		} else {
			submit();
		}
	}
}

function addSkill(parentId)
{
	targetUrl = 'index.php?view=add';
	if (parentId != 0) {
		targetUrl += '&parentId=' + parentId;
	}
	
	window.location.href = targetUrl;
}

function modifySkill(skillId)
{
	window.location.href = 'index.php?view=modify&skillId=' + skillId;
}

function deleteSkill(skillId)
{
	if (confirm('Deleting skills category will also delete all questions in it.\nContinue anyway?')) {
		window.location.href = 'processSkill.php?action=delete&skillId=' + skillId;
	}
}