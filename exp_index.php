<!DOCTYPE html>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="styles/codemirror.css"/>
<link rel="stylesheet" href="styles/codemirror-neo.css"/>
<link rel="stylesheet" href="styles/cy2neo.css"/>
<link rel="stylesheet" href="styles/neod3.css">
<link rel="stylesheet" href="styles/datatable.css"/>
<link rel="stylesheet" href="styles/vendor.css"> <!-- bootstrap-->
<link rel="stylesheet" href="styles/sweet-alert.css"/>
<link rel="stylesheet" href="styles/gh-fork-ribbon.css"/>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"/>
<link rel="stylesheet" href="semantic-ui/semantic.min.css" /> 
<script src="exp/jquery-3.3.1.min.js"></script>

<script   src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
  integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
  crossorigin="anonymous"></script>
  <script src="/GA-project-master/config/socialnetworktool.js"></script>

<script src="semantic-ui/semantic.min.js"></script>

<style type="text/css">
#p_scents .ui.grid {
    margin-bottom: -3rem;
}


#showdegree{
    width: 100%;
    height: calc(100vh - 250px);
}
</style>


<title>明代文集社會網絡圖</title>
</head>
<body>
<div class="ui form">
<div class="ui top">
<div class="ui grid"  style="display:none">
  
<div class="twelve wide column" style="visibility:hidden">

  <div class="field" style="visibility:hidden">
 <select name="cypherselect" id="cypherselect" class="code select ui search dropdown" onchange="changed(this)" style="visibility:hidden">
   <option value="MATCH p=(n:personmingtest9)-[r:unknown]->(c:personmingtest9) RETURN p ;">社會網絡圖</option> 

 <option value="MATCH p=(n:personmingtest8)-[r:writing{文集名:'陶學士集'}]->(c:personmingtest8) RETURN p ;">陶學士集</option>
 <option value="MATCH p=(n:personmingtest8)-[r:writing{文集名:'邊華泉集'}]->(c:personmingtest8) RETURN p ;">邊華泉集</option>
<option value="MATCH p=(n:personmingtest8)-[r:writing{文集名:'蘇門集'}]->(c:personmingtest9) RETURN p ;">蘇門集</option>
<option value="MATCH p=(n:personmingtest8)-[r:writing{文集名:'登州集'}]->(c:personmingtest9) RETURN p ;">登州集</option>
<option value="MATCH p=(n:personmingtest8)-[r{文集名:'滄螺集'}]->(c:personmingtest9) RETURN p ;">滄螺集</option>
<option value="MATCH p=(n:personmingtest8)-[r:writing{文集名:'方齋詩文集'}]->(c:personmingtest8) RETURN p ;">方齋詩文集</option>
 <option value=" MATCH p= (a:personmingtest8)-[r ]->(c:personmingtest8)  WHERE r.文集名='陶學士集' OR r.文集名='登州集' return * LIMIT 200;">陶學士集和登州集</option> 
<option value="MATCH p=(n:personmingtest8)-[r]->(c:personmingtest8) WHERE r.文集名='蘇門集' OR r.文集名='邊華泉集'  RETURN p ,r ;">蘇門集和邊華泉集</option>
<option value="MATCH p= (a:personmingtest9)-[r{文集名:'滄螺集'}]-()  RETURN count(p), a.name,count(distinct r) as degree order by degree;">滄螺集</option>
<option value="MATCH p= (a:MingExp1)-[r:待確認{文集名:'校刻具茨先生詩集' ,章節:'附錄二044-2'}]->(c:MingExp1)RETURN p;">實驗網絡</option>

 </select>
</div>  <!-- <div class="field"> -->
</div> <!-- <div class="twelve wide column"> -->

<div class="four wide column" style="visibility:hidden">
<button type="button" class="ui primary button" title="Execute" id="execute" style="visibility:hidden">
  <i class="fa fa-play-circle-o"></i>
</button>

<a href="networkconfirm/" title="社會網絡編輯頁面" target="_blank" style="visibility:hidden">
  <button type="button" class="ui primary button" id = "socialnetwork_link"> <i class="fa fa-link" aria-hidden="true"></i></button>      
</a>

</div> <!-- <div class="four wide column"> -->
 
</div> <!-- <div class="two fields"> -->




<div id="p_scents" class="ui form" style="visibility:hidden;display: none;"">  
    <div class ="ui grid">
      <div  class="ten wide column field">
        <div class ="ui input focus">
         <input type="text" class="p_scnt query ui input"  name="p_scnt" value="" placeholder="輸入文集" />
         </div><!-- <div class="ui input"> -->
       </div>
       <div  class="six wide column field">
         <button id="addScnt" type="button" class="ui primary button">新增自訂查詢文集 </button>
       </div>
    </div><!--<grid">--> 
</div><!--<div class="four wide column">-->

  

<!--
<p>
  <label for="amount">點度:</label>
  <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
</p>
<div id="slider-range"></div> -->
<!--
<p>
  <label for="weightamount">權重:</label>
  <input type="text" id="weightamount" readonly style="border:0; color:#f6931f; font-weight:bold;">
</p>
<div id="slider-weightrange"></div>
-->
   <div   style="display:none";>
  <input type="hidden" class="form-control" type="url" value="http://dev-neo4j-2017.dlll.nccu.edu.tw:6991" id="neo4jUrl" type="hidden"/><br/>
  <input type="hidden" class="form-control" type="text" size="8" value="neo4j" id="neo4jUser" type="hidden"/>
  <input type="hidden" class="form-control" type="password" size="8" placeholder="password" value="neo4j" id="neo4jPass" /><br/>
  <textarea name="cypher" id="cypher" rows="4" cols="60" data-lang="cypher" class="code form-control" >MATCH p=(n:personmingtest8)-[r:writing{文集名:'蘇門集'}]->(c:personmingtest8) RETURN p ;</textarea>

  </div>

<div role="tabpanel" style="display:none">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"  ><a href="#graph" aria-controls="home" role="tab" data-toggle="tab">社會網絡圖</a></li>
    <li role="presentation" style="visibility:hidden"><a href="#table" aria-controls="table" role="tab" data-toggle="tab">詳細資訊</a></li>
    <li role="presentation" style="visibility:hidden"><a href="#degree" aria-controls="table" role="tab" data-toggle="tab">點度</a></li>
  </ul>
</div><!--250-->
  <!-- Tab panes -->
  <div class="tab-content" style="display: none;">
    <div role="tabpanel" class="tab-pane active">
    	<div class="tab-pane active" style="border: 1px solid red;">&nbsp;</div>
    </div>
    <div role="tabpanel" class="tab-pane" id="table" style="visibility:hidden">
    	
    </div>
    <div role="tabpanel" class="tab-pane" id="degree" style="visibility:hidden">
    </div>  



  </div>

 

</div>

<!--
<div style="overflow-x: auto;max-width: 100vw;overflow-y: auto; max-height: 100vh;">
	<div id="graph" style="width: calc(100vh - 20px); height: calc(100vh - 20px);margin: 0 auto; min-width: 850px; min-height: 850px;">&nbsp;</div>
</div>
-->
<div style="overflow-x: hidden;max-width: 100vw;overflow-y: hidden; max-height: 100vh;">
	<div id="graph" style="width: calc(100vh - 20px); height: calc(100vh - 20px);margin: 0 auto; min-width: 850px; min-height: 850px;">&nbsp;</div>
</div>

<div id="datatable" style="display:none;"></div>

<script src="exp_scripts/codemirror.js"></script>
<script src="exp_scripts/codemirror-cypher.js"></script>
<script src="exp_scripts/vendor.js"></script>
<script src="exp_scripts/sweet-alert.min.js"></script>
<script src="exp_scripts/neod3.js"></script>
<script src="exp_scripts/neod3-visualization.js"></script>
<script src="exp_scripts/neo4d3.js"></script>
<script src="exp_scripts/cy2neod3.js"></script>
<script src="exp_scripts/jquery.dataTables.min.js"></script>
<script src="exp_scripts/cypher.datatable.js"></script>
<script src="exp_scripts/jquery.cookie.js"></script>


<script type="text/javascript">
var _connection = function () {
	return {
		url: "http://" + location.hostname + ":6991",
		user: "neo4j",
		password: "neo4j"
	};
};
var _total_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) RETURN DISTINCT p;";

<?php
switch ($_GET["volume"]) {
	case 'reading1':
		?>
var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) "
	+ "WHERE r.章節 = '卷一002-1' OR r.章節 = '卷一011-2' OR r.章節 = '卷一024-1' RETURN DISTINCT p;";
		<?php
		break;
	case 'reading2':
		?>
var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) "
	+ "WHERE r.章節 = '卷一039-1' OR r.章節 = '卷一048-1' OR r.章節 = '卷一052-2' OR r.章節 = '卷一060-2' OR r.章節 = '卷二011-2' RETURN DISTINCT p;";
		<?php
		break;
	case 'reading3':
		?>
var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) "
	+ "WHERE r.章節 = '卷三003-2' OR r.章節 = '卷三013-1' OR r.章節 = '卷四013-2' OR r.章節 = '卷四023-1' OR r.章節 = '卷四024-2' RETURN DISTINCT p;";
		<?php
		break;
	case 'reading4':
		?>
var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) "
	+ "WHERE r.章節 = '卷五005-2' OR r.章節 = '卷五019-2' OR r.章節 = '卷五022-1' OR r.章節 = '卷五023-2' OR r.章節 = '卷五024-2' OR r.章節 = '卷八008-1' RETURN DISTINCT p;";
		<?php
		break;
	default:
		?>
var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) "
	+ "WHERE r.章節 = '卷一002-1' OR r.章節 = '卷一011-2' OR r.章節 = '卷一024-1' RETURN  DISTINCT p;";
    //var _highlight_query = "START p= (a:MingExp8) RETURN p;";
		<?php
		break;
}
?>
Cy2NeoD3({},"graph","datatable","cypher","execute", _connection , true, null, _total_query, _highlight_query);
</script>

</body>
</html>