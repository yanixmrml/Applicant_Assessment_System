function checkProfileInfo()
{
	with (window.document.frmProfile) {
		if (isEmpty(txtFirst, 'Enter first name')) {
			return false;
		} else if (isEmpty(txtLast, 'Enter last name')) {
			return false;
		} else if (isEmpty(txtMiddle, 'Enter middle address')) {
			return false;
		} else if (isEmpty(txtAge, 'Enter the age')) {
			return false;
		} else if (isEmpty(txtAddress, 'Enter the address')) {
			return false;
		} else if (isEmpty(txtHigh, 'Enter high school campus')) {
			return false;
		} else if (isEmpty(txtHighAddress, 'Enter high school address')) {
			return false;
		} else if (isEmpty(txtHighAwards, 'Enter high school awards')) {
			return false;
		} else if (isEmpty(txtCollege, 'Enter college or university campus')) {
			return false;
		} else if (isEmpty(txtCourse, 'Enter course or degree')) {
			return false;
		}else if (isEmpty(txtCollegeAddress, 'Enter college address')) {
			return false;
		} else {
			return true;
		}
	}
}


