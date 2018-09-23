whole_graph = {};
graph_render = null;
neod3 = null;
nodes_id_name = {};

function Cy2NeoD3(config, graphId, tableId, sourceId, execId, urlSource, renderGraph, cbResult, query, highlight_query) {
	/*
	function createEditor() {
		return CodeMirror.fromTextArea(document.getElementById("cypher"), {
			parserfile: ["codemirror-cypher.js"],
			path: "scripts",
			stylesheet: "styles/codemirror-neo.css",
			autoMatchParens: true,
			lineNumbers: true,
			enterMode: "keep",
			value: "some value"
		});
	}
	*/
	neod3 = new Neod3Renderer();
	var neo = new Neo(urlSource);
	//var editor = createEditor();
	query.replace('&lt', '<').replace('&gt', '>');
	highlight_query.replace('&lt', '<').replace('&gt', '>');

	var _graph_render = function (graph) {
		whole_graph = graph;
		console.log(graph);
		
		if (renderGraph) {
			if (graph) {
				var c = $("#" + graphId);
				c.empty();
				graph_render = neod3.render(graphId, c, graph);
				
				
				/*
				setTimeout(function () {
					var _svg = c.find("svg:first");
					var _layer_nodes = _svg.find("g.layer.nodes").get(0).getBBox();
					
					var _length = Math.max(_layer_nodes.width, _layer_nodes.height) + 10;
					
					_svg.width(_length).height(_length);

				}, 500);
				*/
				//renderResult(tableId, res.table);
			} else {
				if (err) {
					console.log(err);
					if (err.length > 0) {
						//sweetAlert("Cypher error", err[0].code + "\n" + err[0].message, "error");
						window.alert("Cypher error", err[0].code + "\n" + err[0].message, "error");
					} else {
						window.alert("Ajax " + err.statusText, "Status " + err.status + ": " + err.state(), "error");
					}
				}
			}
		}
		if (cbResult) {
			cbResult(res);
		}
	};
	
	graph_draw = function (evt) {
		try {
			//evt.preventDefault();
			//var query = document.getElementById('cypher').innerText;
			//var content =document.getElementById('cypher').innerText;
			// editor.setValue(content);
			//  console.log(content );

			//var query = editor.getValue();
			
			
			//editor.toTextArea();
			//ga_mouse_click_event_trigger($(this), "#cypher", query, "graph_query_search");
			//console.log("Executing Query", query);
			//var execButton = $(this).find('i');
			//execButton.toggleClass('fa-play-circle-o fa-spinner fa-spin')
			
			neo.executeQuery(query, {}, function (err, res) {
				//execButton.toggleClass('fa-spinner fa-spin fa-play-circle-o')
				res = res || {}
				//console.log(res.graph);
				var graph = res.graph;
				
				if (graph === undefined) {
					return;
				}
				
				graph = _filter_number_nodes(graph);
				graph = _filter_saved_relationship(graph);
				graph = _filter_node_name(graph);
				
				neo.executeQuery(highlight_query, {}, function (err, res) {
					var _highlight_graph = res.graph;
					
					if (_highlight_graph !== undefined) {
						var _highlight_nodes_id = [];
						for (var _n in _highlight_graph.nodes) {
							_highlight_nodes_id.push(_highlight_graph.nodes[_n].id);
						}
						
						var _first_highlight_index = null;
						for (var _n in graph.nodes) {
							var _node = graph.nodes[_n];
							if (_highlight_nodes_id.indexOf(_node.id) > -1) {
								_node.labels["0"] = "本部分提及之人物";
								
								if (_first_highlight_index === null) {
									_first_highlight_index = _n;
								}
							}
							else {
								_node.labels["0"] = "其他人物";
							}
						}
						
						if (_first_highlight_index !== null) {
							array_move(graph.nodes, _first_highlight_index, 0);
						}
					}
				
					_graph_render(graph);
				});

			});	// neo.executeQuery(query, {}, function (err, res) {
			
			setTimeout(function () {
				_init_graph_interactable(graphId);
			}, 1000);
			
		} catch (e) {
			console.log(e);
			window.alert("Catched error", e, "error");
		}
		return false;
	}; // graph_draw = function(evt) {


	//$("#"+execId).click(graph_draw);
	return graph_draw();
	//editor.refresh();


}

/**
 * 過濾掉沒有name的nodes，並且過濾掉連線到這些nodes的link
 * @author Pudding 20180505
 */
var _filter_number_nodes = function (_graph) {
	//console.log(_graph);
	if (typeof(_graph.nodes) === "undefined") {
		return _graph;
	}
	
	var _nodes = _graph.nodes;
	var _filtered_nodes = [];
	var _removed_nodes_id = [];
	for (var _n in _nodes) {
		var _node = _nodes[_n];
		if (typeof(_node.name) === "string") {
			_filtered_nodes.push(_node);
		}
		else {
			_removed_nodes_id.push(_node.id);
		}
	}
	_graph.nodes = _filtered_nodes;
	
	// -----------------
	
	var _links = _graph.links;
	var _filtered_links = [];
	for (var _l in _links) {
		var _link = _links[_l];
		var _start = _link.start;
		var _end = _link.end;
		if (_removed_nodes_id.indexOf(_start) === -1
			&& _removed_nodes_id.indexOf(_end) === -1) {
			_filtered_links.push(_link);
		}
	}
	_graph.links = _filtered_links;
	
	return _graph;
};

var _filter_saved_relationship = function (_graph) {
	for (var _l in _graph.links) {
		var _link = _graph.links[_l];
		var _link_id = _link.id;
		var _new_relation = $.cookie("relationship_" + _link_id);
		if (_new_relation !== undefined) {
			_link.type = _new_relation;
		}
	}
	return _graph;
};

var _init_graph_interactable = function (graphId) {
	

	$("#" + graphId).mouseover(function () {
		var svg = $(this);
		if (svg.find("svg g.node").length === 0
			 || svg.hasClass("inited")) {
			return;
		}

		svg.addClass("inited");
		
		_init_relationship_title(svg);
		_init_node_click_event(svg);
		//_init_relationship_click_event(svg);
	});
};

var _init_node_click_event = function (svg) {
	//var _enable_query = false;
	
	var _nodes = svg.find("svg g.node");
	/*
	_nodes.mousedown(function () {
		_enable_query = true;
		setTimeout(function () {
			_enable_query = false;
		}, 100);
	});
	*/
	
	_nodes.click(function () {
		/*
		if (_enable_query === false) {
			return;
		}
		*/
		
		var keyword = $(this).find("text").text().trim();
		
		
		/*
		keyword = keyword.substring(keyword.lastIndexOf("(")+1 , keyword.length-1);
		var url = "https://cbdb.fas.harvard.edu/cbdbapi/person.php?name=" + encodeURIComponent(keyword);
		window.open(url, "_blank", config = 'height=500,width=500');

		ga_mouse_click_event_trigger($(this), "g.node", keyword, "graph_node_search");
		*/
		var _search_raw_text = $(top.document).find("#search_raw_text");
		
		
		if (_search_raw_text.length > 0) {
			//var _raw_keyword = keyword.substr(0, keyword.indexOf("("));
			var _raw_keyword = keyword.substring(keyword.lastIndexOf("(")+1 , keyword.length-1);
			_search_raw_text.find("input:first").val(_raw_keyword); //_raw_keyword
			_search_raw_text.find("button:first").click();
			_search_raw_text.addClass("glowing");
			setTimeout(function () {
				_search_raw_text.removeClass("glowing");
			}, 3000);
			
			var _search_internet = $(top.document).find("#search_internet");
			var _search_keyword = keyword.substr(0, keyword.indexOf("("));
			//var _search_keyword = keyword.substring(keyword.lastIndexOf("(")+1 , keyword.length-1);
			_search_internet.find("input:first").val(_search_keyword);
			_search_internet.addClass("glowing");
			setTimeout(function () {
				_search_internet.removeClass("glowing");
			}, 3000);
		}
		ga_mouse_click_event_trigger($(this), "g.node", keyword, "graph_node_search");
	});
	
	
};

var _init_relationship_title = function(svg) {
	svg.find("svg g.relationship").each(function (_index, _element) {
		var _relation = $(this).find("text:first").text();
		$(this).find("title:first").text(_relation);
	});
};

var _init_relationship_click_event = function (svg) {
	
	svg.find("svg g.relationship").click(function () {
		var _new_relation = window.prompt("他們的關係是？");
		var _abbr_relation = _new_relation;
		if (_abbr_relation.length > 4) {
			_abbr_relation = _abbr_relation.substr(0, 4) + "...";
		}
		
		$(this).find("text:first").text(_abbr_relation)
			.attr("data-relationship", _new_relation);
		
		/*
		var neod3 = new Neod3Renderer();
		var c = $("#graph");
		c.empty();
		for (var _l in whole_graph.links) {
			whole_graph.links[_l].type = _abbr_relation;
		}
		neod3.render("graph", c, whole_graph);
		
		for (var _l in graph_render.links) {
			graph_render.links[_l].type = "aaaa";
		}
		*/
	});
	
	// <text text-anchor="middle" font-size="9px" fill="#000000" x="381.5979520213036" y="443.8514049432044" transform="rotate(79.223742904661 381.5979520213036 440.3514049432044)">11111111111111</text>
};

_filter_node_name = function (graph) {
	for (var _n in graph.nodes) {
		var _node_parts = graph.nodes[_n].name.split("_");
		var _name = _node_parts[1] + "(" + _node_parts[0] + ")"; //本名在外，別名括號在內
		var _name_display = _name;
		
		nodes_id_name[graph.nodes[_n].id] = _name;
		
		graph.nodes[_n].name = _name_display;
	}
	return graph;
};

relationship_click_event = function (_relationship) {
	//console.log(_relationship);
	var _new_relation = window.prompt("他們的關係是？", _relationship.type);
	if (_new_relation === null) {
		return;
	}
	_relationship.type = _new_relation;
	
	var _event_key = "relationship_" + nodes_id_name[parseInt(_relationship.source.id,10)] + "_" + nodes_id_name[parseInt(_relationship.target.id,10)];
	//var _event_key = "relationship_" + _relationship.source.id + "_" + _relationship.target.id;
	
	$.cookie("relationship_" + _relationship.id, _new_relation);
	ga_mouse_click_event_trigger("g.relationship", "g.relationship", _new_relation, _event_key) ;
	
	graph_render.refresh();
};

relationship_mouseover_event = function (_relationship, _link) {
	//$(_link).hide();
	//console.log(_link);
	//console.log(_relationship);
	_link = $(_link);
	if (_link.hasClass("titled")) {
		return;
	}
	
	var _type = _relationship.type;
	var _source_name = nodes_id_name[parseInt(_relationship.source.id,10)];
	var _target_name = nodes_id_name[parseInt(_relationship.target.id,10)];
	var _title = _source_name + " -(" + _type + ")-> " + _target_name;
	_link.find("title:first").text(_title);
	_link.addClass("titled");
};

node_mouseover_event = function (_node, _node_element) {
	_node_element = $(_node_element);
	if (_node_element.hasClass("titled")) {
		return;
	}
	
	//console.log(_node);
	var _title = "[" + _node_element.find("text:first").text() + "]";
	var _id = _node.id;
	var _start_names = [];
	var _end_names = [];
	var _start_overflow = false;
	var _end_overflow = false;
	var _overflow_limit = 10;
	for (var _n in whole_graph.links) {
		var _link_start = whole_graph.links[_n].start;
		if (_link_start === _id && _end_names.length <= _overflow_limit) {
			
			var _link_end = whole_graph.links[_n].end;
			var _link_end_name = nodes_id_name[parseInt(_link_end,10)];
			if (_end_names.indexOf(_link_end_name) === -1) {
				_end_names.push(_link_end_name);
			}
			
			if (_end_names.length > _overflow_limit) {
				_end_overflow = true;
			}
		}
		
		var _link_end = whole_graph.links[_n].end;
		if (_link_end === _id && _start_names.length <= _overflow_limit) {
			
			var _link_start = whole_graph.links[_n].start;
			var _link_start_name = nodes_id_name[parseInt(_link_start,10)];
			if (_start_names.indexOf(_link_start_name) === -1) {
				_start_names.push(_link_start_name);
			}
			
			
			if (_start_names.length > _overflow_limit) {
				_start_overflow = true;
			}
		}
	}
	if (_end_names.length > 0) {
		var _end_names_string = _end_names.join(",");
		if (_end_overflow === true) {
			_end_names_string = _end_names_string + "...";
		}
		_title = _title + "\n↓\n" + _end_names_string;
	}
	if (_start_names.length > 0) {
		var _start_names_string = _start_names.join(",");
		if (_start_overflow === true) {
			_start_names_string = _start_names_string + "...";
		}
		_title = _start_names_string + "\n↓\n" + _title;
	}
	
	
	_node_element.find("title:first").text(_title);
	_node_element.addClass("titled");
};

var array_move = function (arr, old_index, new_index) {
    if (new_index >= arr.length) {
        var k = new_index - arr.length + 1;
        while (k--) {
            arr.push(undefined);
        }
    }
    arr.splice(new_index, 0, arr.splice(old_index, 1)[0]);
    return arr; // for testing
};