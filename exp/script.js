
var _setup_ga  = function () {
	if (typeof(ga_mouse_click_event_trigger) === "function") {
		
		$("#select_volume").change(function(){
			var _val = $(this).find("option:selected").text() + "(" + $(this).val().trim() + ")";
			ga_mouse_click_event_trigger($(this), "#select_volume", _val, "select_volume");
			//console.log(_val);
			
			var _url = "reading/" + $(this).val().trim() + ".html";
			var _iframe = $("iframe#reading");
			if (_iframe.attr("src") !== _url) {
				_iframe.attr("src", _url);
			}
			
			var _sna_url = "/social_index.php?volume=" + $(this).val().trim();
			var _sna_iframe = $("iframe#sna");
			if (_sna_iframe.attr("src") !== _sna_url) {
				_sna_iframe.attr("src", _sna_url);
			}
			
			var _disable_sna = $(this).find("option:selected").attr("data-disable-sna");
			if (_disable_sna === "true") {
				$(".dashboard").addClass("disable-sna");
			}
			else {
				$(".dashboard").removeClass("disable-sna");
			}
		});
		//console.log("b");
	}
	else {
		setTimeout(function () {
			//console.log("a");
			_setup_ga();
		}, 1000);
	}
};

_setup_ga();

$(function () {
	_findText = function (_keyword) {
		var win = top.document.getElementById('reading').contentDocument;
		var _p = $(win).find("p");
		_p.unhighlight();
		if (_keyword !== "") {
			_p.highlight(_keyword);
		}
	};
	
	$("#search_raw_text input").keydown(function (_event) {
		if (_event.keyCode === 13) {
			var _keyword = $(this).val().trim();
			_findText(_keyword);
			ga_mouse_click_event_trigger(null, null, _keyword, "search_raw_text");
		}
	});
	$("#search_raw_text button:last").click(function (_event) {
		var _keyword = $(this).parent().find("input:first").val().trim();
		_findText(_keyword);
		ga_mouse_click_event_trigger(null, null, _keyword, "search_raw_text");
	});
	
	$("#search_internet input").keydown(function (_event) {
		if (_event.keyCode === 13) {
			var _keyword = $(this).val().trim();
			if (_keyword === "") {
				return;
			}
			_findInternet(_keyword);
		}
	});
	$("#search_internet .ui.button:last").click(function (_event) {
		var _keyword = $(this).parent().find("input:first").val().trim();
		if (_keyword === "") {
			return;
		}
		_findInternet(_keyword);
	});
	
	$("nav .navbar-brand").dblclick(function () {
		set_user_id(window.prompt("輸入您的姓名"));
	});
});
	
$('.ui.dropdown').dropdown();

var _findCDBD = function (_keyword) {
	if (_keyword === null || _keyword === undefined || _keyword.trim() === "") {
		return;
	}
	_keyword = _keyword.trim();
	var url = "https://cbdb.fas.harvard.edu/cbdbapi/person.php?name=" + encodeURIComponent(_keyword);
	window.open(url, "_blank", config = 'height=500,width=500');

	ga_mouse_click_event_trigger(null, null, _keyword, "search_cdbd");
};

var _findInternet = function (_keyword) {
	if (_keyword === null || _keyword === undefined || _keyword.trim() === "") {
		return;
	}
	_keyword = _keyword.trim();
	var _target = $("#search_internet select").val();
	console.log(_target);
	
	var url;
	if (_target === "cdbd") {
		url = "https://cbdb.fas.harvard.edu/cbdbapi/person.php?name=" + encodeURIComponent(_keyword);
	}
	else if (_target === "moedict") {
		url = "https://www.moedict.tw/" + encodeURIComponent(_keyword);
	}
	else if (_target === "wiki") {
		url = "http://zh.wikipedia.org/w/index.php?search=" + encodeURIComponent(_keyword);
	}
	else if (_target === "google") {
		url = "http://www.google.com.tw/search?q=" + encodeURIComponent(_keyword);
	}
	else if (_target === "socialnetwork_tool") {
		url = "http://"+location.hostname + ":6990/networkconfirm/index.php?name=" + encodeURIComponent(_keyword);
	}
	else if (_target === "zdic") {
		url = "http://www.zdic.net/search/?q=" + encodeURIComponent(_keyword);
	}
	else if (_target === "kangxi") {
		url = "http://kangxi.adcs.org.tw/kangxizidian/#" + _keyword;
	}
	else if (_target === "chardb") {
		url = "http://chardb.iis.sinica.edu.tw/search.jsp?q=" + encodeURIComponent(_keyword);
	}
	else if (_target === "baidu") {
		url = "https://baike.baidu.com/item/" + encodeURIComponent(_keyword);
	}	
	window.open(url, "_blank", config = 'height=800,width=800');

	ga_mouse_click_event_trigger(null, null, _keyword, "search_" + _target);
};

