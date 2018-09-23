$(function () {
	var _search_internet = $(top.document).find("#search_internet");
	if (_search_internet.length === 0) {
		return;
	}
	var _search = _search_internet.find("input:first");
	$(document).mouseup(function () {
		var _selection;
		if (typeof(document.selection) === "object" &&  typeof(document.selection.createRange) === "function") {
			_selection = document.selection.createRange().text;
		}
		
		if (_selection === undefined && typeof(window.getSelection) === "function") {
			_selection = window.getSelection().toString();
		}
		
		if (_selection !== undefined) {
			_search.val(_selection.trim());
			
			_search_internet.addClass("glowing");
			setTimeout(function () {
				_search_internet.removeClass("glowing");
			}, 3000);
		}
		else {
			//_search.val("");
		}
	});
});