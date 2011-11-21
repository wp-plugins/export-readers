function v39v (data){
	this.data = jQuery.extend(v39v_data,data);
};

v39v.prototype.log = function(value) {
	if(this.data.dodebug==1)
	{
		console.log(value);
	}
}
v39v.prototype.json = function(url,data,success) {
	jQuery.ajax({
			type:'POST',
			url:url,
			data:data,
			success:success,
			dataType:'json'
	});
}
v39v.prototype.void = function(value,def_value) {
	var retval =  '';
	if(typeof(def_value) == 'undefined')
	{
		retval =  typeof(value) == 'undefined';
	}
	else
	{
		if(typeof(value) == 'undefined')
		{
			retval = def_value;
		}
		else
		{
			retval = value;
		}
	}
	return retval;
}
v39v.prototype.entitydecode = function(encodedStr) {
	return jQuery("<div/>").html(encodedStr).text();
}