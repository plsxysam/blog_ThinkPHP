function change_code (obj) {
	$("#code").attr("src", verifyURL+'/'+Math.random());
		return false;
}

