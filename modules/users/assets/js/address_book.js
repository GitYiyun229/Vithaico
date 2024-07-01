function edit(){
	$('.tab_content').load("/index.php?module=users&task=edit&raw=1");
}
function add_address(){
	$('.tab_content').load("/index.php?module=users&task=add_address&raw=1");
}
function edit_add_other($id){
	$('.tab_content').load("/index.php?module=users&task=edit_address&id="+$id+"&raw=1");
}