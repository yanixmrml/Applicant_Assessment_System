// JavaScript Document
function viewTest()
{
	with (window.document.frmListTest) {
		if (cboPersonality.selectedIndex == 0) {
			window.location.href = 'index.php';
		} else {
			window.location.href = 'index.php?personalityId=' + cboPersonality.options[cboPersonality.selectedIndex].value;
		}
	}
}

function checkAddTestForm()
{
	with (window.document.frmAddTest) {
		if (cboPersonality.selectedIndex == 0) {
			alert('Choose a type of personality');
			cboPersonality.focus();
			return;
		} else if (isEmpty(mtxTest, 'Enter the test item appropriately')) {
			return;
		} else {
			submit();
		}
	}
}

function addTest(personalityId)
{
	window.location.href = 'index.php?view=add&personalityId=' + personalityId;
}

function modifyTest(testId)
{
	window.location.href = 'index.php?view=modify&testId=' + testId;
}

function deleteTest(testId, personalityId)
{
	if (confirm('Delete this test?')) {
		window.location.href = 'processTest.php?action=deleteTest&testId=' + testId + '&personalityId=' + personalityId;
	}
}
