
$('#site-search input[name=keyword]').devbridgeAutocomplete({
    serviceUrl: "/index.php?module=products&view=search&raw=1&task=getAjaxSearch",
    // groupBy:"brand",
    minChars: 2,
    formatResult: function(item, char){
		char = char.replace(/[^a-z0-9\sàáảãạăắằẳẵặâấầẩẫậèéẻẽẹêềếểễệìíỉĩịòóỏõọôồốổỗộơờớởỡợùúủũụưừứửữựỳýỷỹỵ]/gi, "");

        let itemName = item.data.text.split(" ")
		let r = "";

        for (i = 0; i < itemName.length; i++) {
			r += char.toLowerCase().indexOf(itemName[i].toLowerCase()) >= 0 ? `<b>${itemName[i]}</b> ` : `${itemName[i]} `;
		}

        return `
			<a href="${item.value}" class="d-flex gap-2">
				<img src="${item.data.image}" class="img-fluid" />
				<div>
					<div>${r}</div>
					<div class="text-danger">${item.data.price_public}</div>
				</div>
			</a>
		`
    },
    onSelect:function(n){
        $("#keyword").val(n.data.text)
    }
});