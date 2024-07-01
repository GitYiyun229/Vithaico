function changeCity22($city_id,$id){
    $.ajax({
		type : 'get',
		url : 'index.php?module=address&view=address&raw=1&task=loadDistricts',
		dataType : 'html',
		data: {city_id:$city_id},
		success : function(data){
            location.reload();
        },
		error : function(XMLHttpRequest, textStatus, errorThrown) {}
	});
    return false;
}

function changeDistrict($city_id,$id){
    $.ajax({
		type : 'get',
		url : 'index.php?module=address&view=address&raw=1&task=get_agency',
		dataType : 'html',
		data: {district_id:$city_id},
		success : function(data){
            location.reload();
        },
		error : function(XMLHttpRequest, textStatus, errorThrown) {}
	});
    return false;
}

$(window).on("load",function(){
        $(".wrapper-list-agency").mCustomScrollbar({
                theme:"minimal"
        });
    });
function get_info($city_id,$id){
    $.ajax({
		type : 'get',
		url : 'index.php?module=address&view=address&raw=1&task=get_agency',
		dataType : 'html',
		data: {district_id:$city_id},
		success : function(data){
                $("#"+id).append(data);
        },
		error : function(XMLHttpRequest, textStatus, errorThrown) {}
	});
    return false;
}    