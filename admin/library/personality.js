// JavaScript Document
function checkPersonalityForm()
{
    with (window.document.frmPersonality) {
		if (isEmpty(txtName, 'Enter personality name')) {
			return;
		} else if (isEmpty(mtxDescription, 'Enter the personality\'s description')) {
			return;
		} else {
			submit();
		}
	}
}

function addPersonality(parentId)
{
	targetUrl = 'index.php?view=add';
	if (parentId != 0) {
		targetUrl += '&parentId=' + parentId;
	}
	
	window.location.href = targetUrl;
}

function modifyPersonality(personalityId)
{
	window.location.href = 'index.php?view=modify&personalityId=' + personalityId;
}

function deletePersonality(personalityId)
{
	if (confirm('Deleting personalitys category will also delete all questions in it.\nContinue anyway?')) {
		window.location.href = 'processPersonality.php?action=delete&personalityId=' + personalityId;
	}
}