function Neo(urlSource) {
	function txUrl() {
		var connection = urlSource();
		var url = (connection.url || "http://localhost:7474").replace(/\/db\/data.*/,"");
		return url + "/db/data/transaction/commit";
	}
	var me = {
		executeQuery: function(query, params, cb) {
			var connection = urlSource();
			var auth = ((connection.user || "") == "") ? "" : "Basic " + btoa(connection.user + ":" + connection.pass);
			$.ajax(txUrl(), {
				type: "POST",
				data: JSON.stringify({
					statements: [{
						statement: query,
						parameters: params || {},
						resultDataContents: ["row", "graph"]
					}]
				}),
				contentType: "application/json",
				error: function(err) {
					cb(err);
				},
				beforeSend: function (xhr) {
				    if (auth && auth.length) xhr.setRequestHeader ("Authorization", auth);
				},
				success: function(res) {

					if (res.errors.length > 0) {
						cb(res.errors);
					} else {
						var cols = res.results[0].columns;
						var rows = res.results[0].data.map(function(row) {
							var r = {};
							cols.forEach(function(col, index) {
								r[col] = row.row[index];
							});
							return r;
						});
						var nodes = [];
						var rels = [];
						var labels = [];
					    function findNode(nodes, id) {
						   for (var i=0;i<nodes.length;i++) {
						      if (nodes[i].id == id) return i;
						   }
						   return -1;
					    }

					    var relationships_merged = {};

						res.results[0].data.forEach(function(row) {
							row.graph.nodes.forEach(function(n) {
							   var found = nodes.filter(function (m) { return m.id == n.id; }).length > 0;
							   if (!found) {
								  //n.props=n.properties;
								  for(var p in n.properties||{}) { n[p]=n.properties[p];delete n.properties[p];} 
								  delete n.properties;
								  nodes.push(n);
								  labels=labels.concat(n.labels.filter(function(l) { labels.indexOf(l) == -1 }))
							   }
							});
							//console.log("!");
							//console.log(row.graph.relationships);
							// [{id:"15555", type:"unknown", startNode:"507162", endNode: "487645", properties: {...}}]

							var r = row.graph.relationships[0];
							var key_start_end = r.startNode + "_" + r.endNode;

							if (typeof(relationships_merged[key_start_end]) === "undefined") {
								relationships_merged[key_start_end] = row.graph.relationships;
							}
							else {
								var prev_type = relationships_merged[key_start_end][0].type;
								var next_type = r.type;

								var prev_type_array = prev_type.split(",");
								if (prev_type_array.indexOf(next_type) === -1) {
									prev_type_array.push(next_type);
								}
								prev_type = prev_type_array.join(",");
								relationships_merged[key_start_end][0].type = prev_type;
							}
							

						});

						for (var i in relationships_merged) {
							rels = rels.concat(relationships_merged[i].map(
								function(r) { 	
								   return { id: r.id, start:r.startNode, end:r.endNode, type: r.type } }
								));
							//console.log(rels);
						}

						cb(null,{table:rows,graph:{nodes:nodes, links:rels},labels:labels});
					}
				}
			});
		}
	};
	return me;
}
