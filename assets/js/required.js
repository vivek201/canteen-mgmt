function required() {
	var inputs = $('input[required]');
	var result = true;
	inputs.each(function(index){
		var tex = $(this).val();
		if(/^\s+$/.test(tex)) {
			alert("You cannot enter just spaces as input.");
			result = false;
			return false;
		}
	});
	return result;
}