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
<script src="exp_scripts/bootbox.min.js"></script>

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
var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) RETURN DISTINCT p;";
		<?php
		break;
	case 'reading2':
		?>
var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) "
	+ "WHERE r.章節 = '序002-1' OR  r.章節 = '序002-2' OR  r.章節 = '序003-1' OR  r.章節 = '序003-2' OR  r.章節 = '序004-1' OR  r.章節 = '序004-2' OR  r.章節 = '序005-1' OR  r.章節 = '序005-2' OR  r.章節 = '序006-1' OR  r.章節 = '序006-2' OR  r.章節 = '序007-1' OR  r.章節 = '序007-2' OR  r.章節 = '序008-1' OR  r.章節 = '序008-2' OR  r.章節 = '序009-1' OR  r.章節 = '序009-2' OR  r.章節 = '序009-2' OR  r.章節 = '序010-1' OR  r.章節 = '序010-2' OR  r.章節 = '序011-1' OR  r.章節 = '序011-2' OR  r.章節 = '序012-1' OR  r.章節 = '序012-2' OR  r.章節 = '序013-1' OR  r.章節 = '序013-2' OR  r.章節 = '序014-1' OR  r.章節 = '序014-2' OR  r.章節 = '序015-1' OR  r.章節 = '序015-2' OR  r.章節 = '序016-1' OR  r.章節 = '序016-2' OR  r.章節 = '序017-1' OR  r.章節 = '序017-2' OR  r.章節 = '序018-1' OR  r.章節 = '序018-2' OR  r.章節 = '序019-1' OR  r.章節 = '序019-2' OR  r.章節 = '序020-1' OR  r.章節 = '序020-2' OR  r.章節 = '序021-1' RETURN DISTINCT p;";
		<?php
		break;
	case 'reading3':
		?>
var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) "
	+ "WHERE  r.章節 = '詩集卷一001-2' OR  r.章節 = '詩集卷一002-1' OR  r.章節 = '詩集卷一002-2' OR  r.章節 = '詩集卷一003-1' OR  r.章節 = '詩集卷一003-2' OR  r.章節 = '詩集卷一004-1' OR  r.章節 = '詩集卷一004-2' OR  r.章節 = '詩集卷一005-1' OR  r.章節 = '詩集卷一005-2' OR  r.章節 = '詩集卷一006-1' OR  r.章節 = '詩集卷一006-2' OR  r.章節 = '詩集卷一007-1' OR  r.章節 = '詩集卷一007-2' OR  r.章節 = '詩集卷一008-1' OR  r.章節 = '詩集卷一008-2' OR  r.章節 = '詩集卷一009-1' OR  r.章節 = '詩集卷一009-2' OR  r.章節 = '詩集卷一010-1' OR  r.章節 = '詩集卷一010-2' OR  r.章節 = '詩集卷一011-1' OR  r.章節 = '詩集卷一011-2' OR  r.章節 = '詩集卷一012-1' OR  r.章節 = '詩集卷一012-2' OR  r.章節 = '詩集卷一013-1' OR  r.章節 = '詩集卷一013-2' OR  r.章節 = '詩集卷一014-1' OR  r.章節 = '詩集卷一014-2' OR  r.章節 = '詩集卷一015-1' OR  r.章節 = '詩集卷一015-2' OR  r.章節 = '詩集卷一016-1' OR  r.章節 = '詩集卷一016-2' OR  r.章節 = '詩集卷一017-1' OR  r.章節 = '詩集卷一017-2' OR  r.章節 = '詩集卷一018-1' OR  r.章節 = '詩集卷一018-2' OR  r.章節 = '詩集卷一019-1' OR  r.章節 = '詩集卷一019-2' OR  r.章節 = '詩集卷一020-1' RETURN DISTINCT p;";
		<?php
		break;
	case 'reading4':
		?>
var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) "
	+ "WHERE  r.章節 = '詩集卷二001-2' OR  r.章節 = '詩集卷二002-1' OR  r.章節 = '詩集卷二002-2' OR  r.章節 = '詩集卷二003-1' OR  r.章節 = '詩集卷二003-2' OR  r.章節 = '詩集卷二004-1' OR  r.章節 = '詩集卷二004-2' OR  r.章節 = '詩集卷二005-1' OR  r.章節 = '詩集卷二005-2' OR  r.章節 = '詩集卷二006-1' OR  r.章節 = '詩集卷二006-2' OR  r.章節 = '詩集卷二007-1' OR  r.章節 = '詩集卷二007-2' OR  r.章節 = '詩集卷二008-1' OR  r.章節 = '詩集卷二008-2' OR  r.章節 = '詩集卷二009-1' OR  r.章節 = '詩集卷二009-2' OR  r.章節 = '詩集卷二010-1' OR  r.章節 = '詩集卷二010-2' OR  r.章節 = '詩集卷二011-1' OR  r.章節 = '詩集卷二011-2' OR  r.章節 = '詩集卷二012-1' OR  r.章節 = '詩集卷二012-2' OR  r.章節 = '詩集卷二013-1' OR  r.章節 = '詩集卷二013-2' OR  r.章節 = '詩集卷二014-1' OR  r.章節 = '詩集卷二014-2' OR  r.章節 = '詩集卷二015-1' OR  r.章節 = '詩集卷二015-2' OR  r.章節 = '詩集卷二016-1' OR  r.章節 = '詩集卷二016-2' OR  r.章節 = '詩集卷二017-1' OR  r.章節 = '詩集卷二017-2' OR  r.章節 = '詩集卷二018-1' OR  r.章節 = '詩集卷二018-2' OR  r.章節 = '詩集卷二019-1' OR  r.章節 = '詩集卷二019-2' OR  r.章節 = '詩集卷二020-1' OR  r.章節 = '詩集卷二020-2' OR  r.章節 = '詩集卷二021-1' OR  r.章節 = '詩集卷二021-2' OR  r.章節 = '詩集卷二022-1' OR  r.章節 = '詩集卷二022-2' OR  r.章節 = '詩集卷二023-1' OR  r.章節 = '詩集卷二023-2' OR  r.章節 = '詩集卷二024-1' OR  r.章節 = '詩集卷二024-2' OR  r.章節 = '詩集卷二025-1' OR  r.章節 = '詩集卷二025-2' RETURN DISTINCT p;";
		<?php
		break;
	case 'reading5':
    ?>
 var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) "
  + "WHERE  r.章節 = '詩集卷三001-2' OR  r.章節 = '詩集卷三002-1' OR  r.章節 = '詩集卷三002-2' OR  r.章節 = '詩集卷三003-1' OR  r.章節 = '詩集卷三003-2' OR  r.章節 = '詩集卷三004-1' OR  r.章節 = '詩集卷三004-2' OR  r.章節 = '詩集卷三005-1' OR  r.章節 = '詩集卷三005-2' OR  r.章節 = '詩集卷三006-1' OR  r.章節 = '詩集卷三006-2' OR  r.章節 = '詩集卷三007-1' OR  r.章節 = '詩集卷三007-2' OR  r.章節 = '詩集卷三008-1' OR  r.章節 = '詩集卷三008-2' OR  r.章節 = '詩集卷三009-1' OR  r.章節 = '詩集卷三009-2' OR  r.章節 = '詩集卷三010-1' OR  r.章節 = '詩集卷三010-2' OR  r.章節 = '詩集卷三011-1' OR  r.章節 = '詩集卷三011-2' OR  r.章節 = '詩集卷三012-1' OR  r.章節 = '詩集卷三012-2' OR  r.章節 = '詩集卷三013-1' OR  r.章節 = '詩集卷三013-2' OR  r.章節 = '詩集卷三014-1' OR  r.章節 = '詩集卷三014-2' OR  r.章節 = '詩集卷三015-1' OR  r.章節 = '詩集卷三015-2' OR  r.章節 = '詩集卷三016-1' OR  r.章節 = '詩集卷三016-2' OR  r.章節 = '詩集卷三017-1' OR  r.章節 = '詩集卷三017-2' OR  r.章節 = '詩集卷三018-1' OR  r.章節 = '詩集卷三018-2' OR  r.章節 = '詩集卷三019-1' RETURN DISTINCT p;"; 
      <?php
    break;
  case 'reading6':
    ?>

var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) "
  + "WHERE  r.章節 = '詩集卷四001-2' OR  r.章節 = '詩集卷四002-1' OR  r.章節 = '詩集卷四002-2' OR  r.章節 = '詩集卷四003-1' OR  r.章節 = '詩集卷四003-2' OR  r.章節 = '詩集卷四004-1' OR  r.章節 = '詩集卷四004-2' OR  r.章節 = '詩集卷四005-1' OR  r.章節 = '詩集卷四005-2' OR  r.章節 = '詩集卷四006-1' OR  r.章節 = '詩集卷四006-2' OR  r.章節 = '詩集卷四007-1' OR  r.章節 = '詩集卷四007-2' OR  r.章節 = '詩集卷四008-1' OR  r.章節 = '詩集卷四008-2' OR  r.章節 = '詩集卷四009-1' OR  r.章節 = '詩集卷四009-2' OR  r.章節 = '詩集卷四010-1' OR  r.章節 = '詩集卷四010-2' OR  r.章節 = '詩集卷四011-1' OR  r.章節 = '詩集卷四011-2' OR  r.章節 = '詩集卷四012-1' OR  r.章節 = '詩集卷四012-2' OR  r.章節 = '詩集卷四013-1' OR  r.章節 = '詩集卷四013-2' OR  r.章節 = '詩集卷四014-1' OR  r.章節 = '詩集卷四014-2' OR  r.章節 = '詩集卷四015-1' OR  r.章節 = '詩集卷四015-2' OR  r.章節 = '詩集卷四016-1' OR  r.章節 = '詩集卷四016-2' OR  r.章節 = '詩集卷四017-1' OR  r.章節 = '詩集卷四017-2' OR  r.章節 = '詩集卷四018-1' OR  r.章節 = '詩集卷四018-2' OR  r.章節 = '詩集卷四019-1' OR  r.章節 = '詩集卷四019-2' OR  r.章節 = '詩集卷四020-1' OR  r.章節 = '詩集卷四020-2' OR  r.章節 = '詩集卷四021-1' RETURN DISTINCT p;"; 
       <?php
    break;
  case 'reading7':
    ?>

var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) "
  + "WHERE r.章節 = '詩集卷五001-2' OR  r.章節 = '詩集卷五002-1' OR  r.章節 = '詩集卷五002-2' OR  r.章節 = '詩集卷五003-1' OR  r.章節 = '詩集卷五003-2' OR  r.章節 = '詩集卷五004-1' OR  r.章節 = '詩集卷五004-2' OR  r.章節 = '詩集卷五005-1' OR  r.章節 = '詩集卷五005-2' OR  r.章節 = '詩集卷五006-1' OR  r.章節 = '詩集卷五006-2' OR  r.章節 = '詩集卷五007-1' OR  r.章節 = '詩集卷五007-2' OR  r.章節 = '詩集卷五008-1' OR  r.章節 = '詩集卷五008-2' OR  r.章節 = '詩集卷五009-1' OR  r.章節 = '詩集卷五009-2' OR  r.章節 = '詩集卷五010-1' OR  r.章節 = '詩集卷五010-2' OR  r.章節 = '詩集卷五011-1' OR  r.章節 = '詩集卷五011-2' OR  r.章節 = '詩集卷五012-1' OR  r.章節 = '詩集卷五012-2' OR  r.章節 = '詩集卷五013-1' OR  r.章節 = '詩集卷五013-2' OR  r.章節 = '詩集卷五014-1' OR  r.章節 = '詩集卷五014-2' OR  r.章節 = '詩集卷五015-1' OR  r.章節 = '詩集卷五015-2' OR  r.章節 = '詩集卷五016-1' OR  r.章節 = '詩集卷五016-2' OR  r.章節 = '詩集卷五017-1' OR  r.章節 = '詩集卷五017-2' OR  r.章節 = '詩集卷五018-1' OR  r.章節 = '詩集卷五018-2' OR  r.章節 = '詩集卷五019-1' OR  r.章節 = '詩集卷五019-2' OR  r.章節 = '詩集卷五020-1' OR  r.章節 = '詩集卷五020-2' OR  r.章節 = '詩集卷五021-1' OR  r.章節 = '詩集卷五021-2' OR  r.章節 = '詩集卷五022-1' OR  r.章節 = '詩集卷五022-2' OR  r.章節 = '詩集卷五023-1' OR  r.章節 = '詩集卷五023-2' OR  r.章節 = '詩集卷五024-1' OR  r.章節 = '詩集卷五024-2' OR  r.章節 = '詩集卷五025-1' OR  r.章節 = '詩集卷五025-2' OR  r.章節 = '詩集卷五026-1' OR  r.章節 = '詩集卷五026-2' OR  r.章節 = '詩集卷五027-1' OR  r.章節 = '詩集卷五027-2' OR  r.章節 = '詩集卷五028-1' OR  r.章節 = '詩集卷五028-2' OR  r.章節 = '詩集卷五029-1' OR  r.章節 = '詩集卷五029-2' OR  r.章節 = '詩集卷五030-2' OR  r.章節 = '詩集卷五031-1' OR  r.章節 = '詩集卷五031-2' OR  r.章節 = '詩集卷五032-1' RETURN DISTINCT p;"; 
    <?php
    break;
  case 'reading8':
    ?>


var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) "
  + "WHERE r.章節 = '卷一001-2' OR  r.章節 = '卷一002-1' OR  r.章節 = '卷一002-2' OR  r.章節 = '卷一003-1' OR  r.章節 = '卷一003-2' OR  r.章節 = '卷一004-1' OR  r.章節 = '卷一004-2' OR  r.章節 = '卷一005-1' OR  r.章節 = '卷一005-2' OR  r.章節 = '卷一006-1' OR  r.章節 = '卷一006-2' OR  r.章節 = '卷一007-1' OR  r.章節 = '卷一007-2' OR  r.章節 = '卷一008-2' OR  r.章節 = '卷一009-1' OR  r.章節 = '卷一009-2' OR  r.章節 = '卷一010-1' OR  r.章節 = '卷一010-2' OR  r.章節 = '卷一011-1' OR  r.章節 = '卷一011-2' OR  r.章節 = '卷一012-1' OR  r.章節 = '卷一012-2' OR  r.章節 = '卷一013-1' OR  r.章節 = '卷一013-2' OR  r.章節 = '卷一014-1' OR  r.章節 = '卷一014-2' OR  r.章節 = '卷一015-1' OR  r.章節 = '卷一015-2' OR  r.章節 = '卷一016-1' OR  r.章節 = '卷一016-2' OR  r.章節 = '卷一017-1' OR  r.章節 = '卷一017-2' OR  r.章節 = '卷一018-1' OR  r.章節 = '卷一018-2' OR  r.章節 = '卷一019-1' OR  r.章節 = '卷一019-2' OR  r.章節 = '卷一020-1' OR  r.章節 = '卷一020-2' OR  r.章節 = '卷一021-1' OR  r.章節 = '卷一021-2' OR  r.章節 = '卷一022-1' OR  r.章節 = '卷一022-2' OR  r.章節 = '卷一023-1' OR  r.章節 = '卷一023-2' OR  r.章節 = '卷一024-1' OR  r.章節 = '卷一024-2' OR  r.章節 = '卷一025-1' OR  r.章節 = '卷一025-2' OR  r.章節 = '卷一026-1' OR  r.章節 = '卷一026-2' OR  r.章節 = '卷一027-1' OR  r.章節 = '卷一027-2' OR  r.章節 = '卷一028-1' OR  r.章節 = '卷一028-2' OR  r.章節 = '卷一029-1' OR  r.章節 = '卷一029-2' OR  r.章節 = '卷一030-1' OR  r.章節 = '卷一030-2' OR  r.章節 = '卷一031-1' OR  r.章節 = '卷一031-2' OR  r.章節 = '卷一032-1' OR  r.章節 = '卷一032-2' OR  r.章節 = '卷一033-1' OR  r.章節 = '卷一033-2' OR  r.章節 = '卷一034-1' OR  r.章節 = '卷一034-2' OR  r.章節 = '卷一035-1' OR  r.章節 = '卷一035-2' OR  r.章節 = '卷一036-1' OR  r.章節 = '卷一036-2' OR  r.章節 = '卷一037-1' OR  r.章節 = '卷一037-2' OR  r.章節 = '卷一038-1' OR  r.章節 = '卷一038-2' OR  r.章節 = '卷一039-1' OR  r.章節 = '卷一039-2' OR  r.章節 = '卷一040-1' OR  r.章節 = '卷一040-2' OR  r.章節 = '卷一041-1' OR  r.章節 = '卷一041-2' OR  r.章節 = '卷一042-1' OR  r.章節 = '卷一042-2' OR  r.章節 = '卷一043-1' OR  r.章節 = '卷一043-2' OR  r.章節 = '卷一044-1' OR  r.章節 = '卷一044-2' OR  r.章節 = '卷一045-1' OR  r.章節 = '卷一045-2' OR  r.章節 = '卷一046-1' OR  r.章節 = '卷一046-2' OR  r.章節 = '卷一047-1' OR  r.章節 = '卷一047-2' OR  r.章節 = '卷一048-1' OR  r.章節 = '卷一048-2' OR  r.章節 = '卷一049-1' OR  r.章節 = '卷一049-2' OR  r.章節 = '卷一050-1' OR  r.章節 = '卷一050-2' OR  r.章節 = '卷一051-1' OR  r.章節 = '卷一051-2' OR  r.章節 = '卷一052-1' OR  r.章節 = '卷一052-2' OR  r.章節 = '卷一053-1' OR  r.章節 = '卷一053-2' OR  r.章節 = '卷一054-1' OR  r.章節 = '卷一054-2' OR  r.章節 = '卷一055-1' OR  r.章節 = '卷一055-2' OR  r.章節 = '卷一056-1' OR  r.章節 = '卷一056-2' OR  r.章節 = '卷一057-1' OR  r.章節 = '卷一057-2' OR  r.章節 = '卷一058-1' OR  r.章節 = '卷一058-2' OR  r.章節 = '卷一059-1' OR  r.章節 = '卷一059-2' OR  r.章節 = '卷一060-1' OR  r.章節 = '卷一060-2' OR  r.章節 = '卷一061-1' OR  r.章節 = '卷一061-2' OR  r.章節 = '卷一062-1' OR  r.章節 = '卷一062-2' OR  r.章節 = '卷一063-1' OR  r.章節 = '卷一063-2' OR  r.章節 = '卷一064-1' OR  r.章節 = '卷一064-2' OR  r.章節 = '卷一065-1' OR  r.章節 = '卷一065-2' OR  r.章節 = '卷一066-1' OR  r.章節 = '卷一066-2' OR  r.章節 = '卷一067-1' OR  r.章節 = '卷一067-2' OR  r.章節 = '卷一068-1' OR  r.章節 = '卷一068-2' OR  r.章節 = '卷一069-1' RETURN DISTINCT p;"; 
        <?php
    break;
  case 'reading9':
    ?>
var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) "
  + "WHERE r.章節 = '卷二001-2' OR  r.章節 = '卷二002-1' OR  r.章節 = '卷二002-2' OR  r.章節 = '卷二003-1' OR  r.章節 = '卷二003-2' OR  r.章節 = '卷二004-1' OR  r.章節 = '卷二004-2' OR  r.章節 = '卷二005-1' OR  r.章節 = '卷二005-2' OR  r.章節 = '卷二006-1' OR  r.章節 = '卷二006-2' OR  r.章節 = '卷二007-1' OR  r.章節 = '卷二007-2' OR  r.章節 = '卷二008-1' OR  r.章節 = '卷二008-2' OR  r.章節 = '卷二009-1' OR  r.章節 = '卷二009-2' OR  r.章節 = '卷二010-1' OR  r.章節 = '卷二010-2' OR  r.章節 = '卷二011-1' OR  r.章節 = '卷二011-2' OR  r.章節 = '卷二012-1' OR  r.章節 = '卷二012-2' OR  r.章節 = '卷二013-1' OR  r.章節 = '卷二013-2' OR  r.章節 = '卷二014-1' OR  r.章節 = '卷二014-2' OR  r.章節 = '卷二015-1' OR  r.章節 = '卷二015-2' OR  r.章節 = '卷二016-1' OR  r.章節 = '卷二016-2' OR  r.章節 = '卷二017-1' OR  r.章節 = '卷二017-2' OR  r.章節 = '卷二018-1' OR  r.章節 = '卷二018-2' OR  r.章節 = '卷二019-1' OR  r.章節 = '卷二019-2' OR  r.章節 = '卷二020-1' OR  r.章節 = '卷二020-2' OR  r.章節 = '卷二021-1' OR  r.章節 = '卷二021-2' OR  r.章節 = '卷二022-1' OR  r.章節 = '卷二022-2' OR  r.章節 = '卷二023-1' OR  r.章節 = '卷二023-2' OR  r.章節 = '卷二024-1' OR  r.章節 = '卷二024-2' OR  r.章節 = '卷二025-1' OR  r.章節 = '卷二025-2' OR  r.章節 = '卷二026-1' OR  r.章節 = '卷二026-2' OR  r.章節 = '卷二027-1' OR  r.章節 = '卷二027-2' OR  r.章節 = '卷二028-1' OR  r.章節 = '卷二028-2' OR  r.章節 = '卷二029-1' OR  r.章節 = '卷二029-2' OR  r.章節 = '卷二030-1' OR  r.章節 = '卷二030-2' OR  r.章節 = '卷二031-1' OR  r.章節 = '卷二031-2' OR  r.章節 = '卷二032-1' OR  r.章節 = '卷二032-2' RETURN DISTINCT p;"; 
    <?php
    break;
  case 'reading10':
    ?>
var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) "
  + "WHERE r.章節 = '卷三002-1' OR  r.章節 = '卷三002-2' OR  r.章節 = '卷三003-1' OR  r.章節 = '卷三003-2' OR  r.章節 = '卷三004-1' OR  r.章節 = '卷三004-2' OR  r.章節 = '卷三005-1' OR  r.章節 = '卷三005-2' OR  r.章節 = '卷三006-1' OR  r.章節 = '卷三006-2' OR  r.章節 = '卷三007-1' OR  r.章節 = '卷三007-2' OR  r.章節 = '卷三008-1' OR  r.章節 = '卷三008-2' OR  r.章節 = '卷三009-1' OR  r.章節 = '卷三009-2' OR  r.章節 = '卷三010-1' OR  r.章節 = '卷三010-2' OR  r.章節 = '卷三011-1' OR  r.章節 = '卷三011-2' OR  r.章節 = '卷三012-1' OR  r.章節 = '卷三012-2' OR  r.章節 = '卷三013-1' OR  r.章節 = '卷三013-2' OR  r.章節 = '卷三014-1' OR  r.章節 = '卷三014-2' OR  r.章節 = '卷三015-1' OR  r.章節 = '卷三015-2' OR  r.章節 = '卷三016-1' OR  r.章節 = '卷三016-2' OR  r.章節 = '卷三017-1' OR  r.章節 = '卷三017-2' OR  r.章節 = '卷三018-1' OR  r.章節 = '卷三018-2' OR  r.章節 = '卷三019-1' OR  r.章節 = '卷三019-2' OR  r.章節 = '卷三020-1' OR  r.章節 = '卷三020-2' OR  r.章節 = '卷三021-1' OR  r.章節 = '卷三021-2' OR  r.章節 = '卷三022-1' OR  r.章節 = '卷三022-2' OR  r.章節 = '卷三023-1' RETURN DISTINCT p;"; 
  <?php
    break;
  case 'reading11':
    ?>
var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) "
  + "WHERE r.章節 = '卷四001-2' OR  r.章節 = '卷四002-1' OR  r.章節 = '卷四002-2' OR  r.章節 = '卷四003-1' OR  r.章節 = '卷四003-2' OR  r.章節 = '卷四004-1' OR  r.章節 = '卷四004-2' OR  r.章節 = '卷四005-1' OR  r.章節 = '卷四005-2' OR  r.章節 = '卷四006-1' OR  r.章節 = '卷四006-2' OR  r.章節 = '卷四007-1' OR  r.章節 = '卷四007-2' OR  r.章節 = '卷四008-1' OR  r.章節 = '卷四008-2' OR  r.章節 = '卷四009-1' OR  r.章節 = '卷四009-2' OR  r.章節 = '卷四010-1' OR  r.章節 = '卷四010-2' OR  r.章節 = '卷四011-1' OR  r.章節 = '卷四011-2' OR  r.章節 = '卷四012-1' OR  r.章節 = '卷四012-2' OR  r.章節 = '卷四013-1' OR  r.章節 = '卷四013-2' OR  r.章節 = '卷四014-1' OR  r.章節 = '卷四014-2' OR  r.章節 = '卷四015-1' OR  r.章節 = '卷四015-2' OR  r.章節 = '卷四016-1' OR  r.章節 = '卷四016-2' OR  r.章節 = '卷四017-1' OR  r.章節 = '卷四017-2' OR  r.章節 = '卷四018-1' OR  r.章節 = '卷四018-2' OR  r.章節 = '卷四019-1' OR  r.章節 = '卷四019-2' OR  r.章節 = '卷四020-1' OR  r.章節 = '卷四020-2' OR  r.章節 = '卷四021-1' OR  r.章節 = '卷四021-2' OR  r.章節 = '卷四022-1' OR  r.章節 = '卷四022-2' OR  r.章節 = '卷四023-1' OR  r.章節 = '卷四023-2' OR  r.章節 = '卷四024-1' OR  r.章節 = '卷四024-2' OR  r.章節 = '卷四025-1' OR  r.章節 = '卷四025-2' OR  r.章節 = '卷四026-1' OR  r.章節 = '卷四026-2' OR  r.章節 = '卷四027-1' OR  r.章節 = '卷四027-2' OR  r.章節 = '卷四028-1' OR  r.章節 = '卷四028-2' OR  r.章節 = '卷四029-1' OR  r.章節 = '卷四029-2' RETURN DISTINCT p;"; 
     <?php
    break;
  case 'reading12':
    ?>

var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) "
  + "WHERE r.章節 = '卷五001-2' OR  r.章節 = '卷五002-1' OR  r.章節 = '卷五002-2' OR  r.章節 = '卷五003-1' OR  r.章節 = '卷五003-2' OR  r.章節 = '卷五004-1' OR  r.章節 = '卷五004-2' OR  r.章節 = '卷五005-1' OR  r.章節 = '卷五005-2' OR  r.章節 = '卷五006-1' OR  r.章節 = '卷五006-2' OR  r.章節 = '卷五007-1' OR  r.章節 = '卷五007-2' OR  r.章節 = '卷五008-1' OR  r.章節 = '卷五008-2' OR  r.章節 = '卷五009-1' OR  r.章節 = '卷五009-2' OR  r.章節 = '卷五010-1' OR  r.章節 = '卷五010-2' OR  r.章節 = '卷五011-1' OR  r.章節 = '卷五011-2' OR  r.章節 = '卷五012-1' OR  r.章節 = '卷五012-2' OR  r.章節 = '卷五013-1' OR  r.章節 = '卷五013-2' OR  r.章節 = '卷五014-1' OR  r.章節 = '卷五014-2' OR  r.章節 = '卷五015-1' OR  r.章節 = '卷五015-2' OR  r.章節 = '卷五016-1' OR  r.章節 = '卷五016-2' OR  r.章節 = '卷五017-1' OR  r.章節 = '卷五017-2' OR  r.章節 = '卷五018-1' OR  r.章節 = '卷五018-2' OR  r.章節 = '卷五019-1' OR  r.章節 = '卷五019-2' OR  r.章節 = '卷五020-1' OR  r.章節 = '卷五020-2' OR  r.章節 = '卷五021-1' OR  r.章節 = '卷五021-2' OR  r.章節 = '卷五022-1' OR  r.章節 = '卷五022-2' OR  r.章節 = '卷五023-1' OR  r.章節 = '卷五023-2' OR  r.章節 = '卷五024-1' OR  r.章節 = '卷五024-2' OR  r.章節 = '卷五025-1' OR  r.章節 = '卷五025-2' OR  r.章節 = '卷五026-1' OR  r.章節 = '卷五026-2' OR  r.章節 = '卷五027-1' OR  r.章節 = '卷五027-2' OR  r.章節 = '卷五028-1' RETURN DISTINCT p;"; 
     <?php
           break;
      case 'reading13':
    ?>
var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) "
  + "WHERE  r.章節 = '卷六001-2' OR  r.章節 = '卷六002-1' OR  r.章節 = '卷六002-2' OR  r.章節 = '卷六003-1' OR  r.章節 = '卷六003-2' OR  r.章節 = '卷六004-1' OR  r.章節 = '卷六004-2' OR  r.章節 = '卷六005-1' OR  r.章節 = '卷六005-2' OR  r.章節 = '卷六006-1' OR  r.章節 = '卷六006-2' OR  r.章節 = '卷六007-1' OR  r.章節 = '卷六007-2' OR  r.章節 = '卷六008-1' OR  r.章節 = '卷六008-2' OR  r.章節 = '卷六009-1' OR  r.章節 = '卷六009-2' OR  r.章節 = '卷六010-1' OR  r.章節 = '卷六010-2' OR  r.章節 = '卷六011-1' OR  r.章節 = '卷六011-2' OR  r.章節 = '卷六012-1' OR  r.章節 = '卷六012-2' OR  r.章節 = '卷六013-1' OR  r.章節 = '卷六013-2' OR  r.章節 = '卷六014-1' OR  r.章節 = '卷六014-2' OR  r.章節 = '卷六015-1' OR  r.章節 = '卷六015-2' OR  r.章節 = '卷六016-1' OR  r.章節 = '卷六016-2' OR  r.章節 = '卷六017-1' OR  r.章節 = '卷六017-2' OR  r.章節 = '卷六018-1' OR  r.章節 = '卷六018-2' OR  r.章節 = '卷六019-1' OR  r.章節 = '卷六019-2' OR  r.章節 = '卷六020-1' OR  r.章節 = '卷六020-2' RETURN DISTINCT p;"; 

 <?php
     break;
      case 'reading14':
    ?>
var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) "
  + "WHERE  r.章節 = '卷七001-2' OR  r.章節 = '卷七002-1' OR  r.章節 = '卷七002-2' OR  r.章節 = '卷七003-1' OR  r.章節 = '卷七003-2' OR  r.章節 = '卷七004-1' OR  r.章節 = '卷七004-2' OR  r.章節 = '卷七005-1' OR  r.章節 = '卷七005-2' OR  r.章節 = '卷七006-1' OR  r.章節 = '卷七006-2' OR  r.章節 = '卷七007-1' OR  r.章節 = '卷七007-2' OR  r.章節 = '卷七008-1' OR  r.章節 = '卷七008-2' OR  r.章節 = '卷七009-1' OR  r.章節 = '卷七009-2' OR  r.章節 = '卷七010-1' OR  r.章節 = '卷七010-2' OR  r.章節 = '卷七011-1' OR  r.章節 = '卷七011-2' OR  r.章節 = '卷七012-1' OR  r.章節 = '卷七012-2' OR  r.章節 = '卷七013-1' OR  r.章節 = '卷七013-2' OR  r.章節 = '卷七014-1' OR  r.章節 = '卷七014-2' OR  r.章節 = '卷七015-1' OR  r.章節 = '卷七015-2' OR  r.章節 = '卷七016-1' OR  r.章節 = '卷七016-2' OR  r.章節 = '卷七017-1' OR  r.章節 = '卷七017-2' OR  r.章節 = '卷七018-1' OR  r.章節 = '卷七018-2' OR  r.章節 = '卷七019-1' OR  r.章節 = '卷七019-2' OR  r.章節 = '卷七020-1' OR  r.章節 = '卷七020-2' OR  r.章節 = '卷七021-1' OR  r.章節 = '卷七021-2' OR  r.章節 = '卷七022-1' OR  r.章節 = '卷七022-2' OR  r.章節 = '卷七023-1' OR  r.章節 = '卷七023-2' OR  r.章節 = '卷七024-1' RETURN DISTINCT p;"; 
  <?php
     break;
      case 'reading15':
    ?>
var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) "
  + "WHERE  r.章節 = '卷八001-2' OR  r.章節 = '卷八002-1' OR  r.章節 = '卷八002-2' OR  r.章節 = '卷八003-1' OR  r.章節 = '卷八003-2' OR  r.章節 = '卷八004-1' OR  r.章節 = '卷八004-2' OR  r.章節 = '卷八005-1' OR  r.章節 = '卷八005-2' OR  r.章節 = '卷八006-1' OR  r.章節 = '卷八006-2' OR  r.章節 = '卷八007-1' OR  r.章節 = '卷八007-2' OR  r.章節 = '卷八008-1' OR  r.章節 = '卷八008-2' OR  r.章節 = '卷八009-1' OR  r.章節 = '卷八009-2' OR  r.章節 = '卷八010-1' OR  r.章節 = '卷八010-2' OR  r.章節 = '卷八011-1' OR  r.章節 = '卷八011-2' OR  r.章節 = '卷八012-1' OR  r.章節 = '卷八012-2' OR  r.章節 = '卷八013-1' OR  r.章節 = '卷八013-2' OR  r.章節 = '卷八014-1' OR  r.章節 = '卷八014-2' OR  r.章節 = '卷八015-1' OR  r.章節 = '卷八015-2' OR  r.章節 = '卷八016-1' OR  r.章節 = '卷八016-2' OR  r.章節 = '卷八017-1' OR  r.章節 = '卷八017-2' OR  r.章節 = '卷八018-1' OR  r.章節 = '卷八018-2' OR  r.章節 = '卷八019-1' OR  r.章節 = '卷八019-2' OR  r.章節 = '卷八020-1' OR  r.章節 = '卷八020-2' OR  r.章節 = '卷八021-1' OR  r.章節 = '卷八021-2' OR  r.章節 = '卷八022-1' OR  r.章節 = '卷八022-2' OR  r.章節 = '卷八023-1' OR  r.章節 = '卷八023-2' OR  r.章節 = '卷八024-1' OR  r.章節 = '卷八024-2' OR  r.章節 = '卷八025-1' OR  r.章節 = '卷八025-2' OR  r.章節 = '卷八026-1' OR  r.章節 = '卷八026-2' OR  r.章節 = '卷八027-1' OR  r.章節 = '卷八027-2' OR  r.章節 = '卷八028-1' OR  r.章節 = '卷八028-2' OR  r.章節 = '卷八029-1' OR  r.章節 = '卷八029-2' OR  r.章節 = '卷八030-1' RETURN DISTINCT p;"; 
<?php
     break;
      case 'reading16':
    ?>

var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) "
  + "WHERE r.章節 = '附錄一001-2' OR  r.章節 = '附錄一002-1' OR  r.章節 = '附錄一002-2' OR  r.章節 = '附錄一003-1' OR  r.章節 = '附錄一003-2' OR  r.章節 = '附錄一004-1' OR  r.章節 = '附錄一004-2' OR  r.章節 = '附錄一005-1' OR  r.章節 = '附錄一005-2' OR  r.章節 = '附錄一006-1' OR  r.章節 = '附錄一006-2' OR  r.章節 = '附錄一007-1' OR  r.章節 = '附錄一007-2' OR  r.章節 = '附錄一008-1' OR  r.章節 = '附錄一008-2' OR  r.章節 = '附錄一009-1' OR  r.章節 = '附錄一009-2' OR  r.章節 = '附錄一010-1' OR  r.章節 = '附錄一010-2' OR  r.章節 = '附錄一011-1' OR  r.章節 = '附錄一011-2' OR  r.章節 = '附錄一012-1' OR  r.章節 = '附錄一012-2' OR  r.章節 = '附錄一013-1' OR  r.章節 = '附錄一013-2' OR  r.章節 = '附錄一014-1' OR  r.章節 = '附錄一014-2' OR  r.章節 = '附錄一015-1' OR  r.章節 = '附錄一015-2' OR  r.章節 = '附錄一016-1' OR  r.章節 = '附錄一016-2' OR  r.章節 = '附錄一017-1' OR  r.章節 = '附錄一017-2' OR  r.章節 = '附錄一018-1' OR  r.章節 = '附錄一018-2' OR  r.章節 = '附錄一019-1' RETURN DISTINCT p;"; 
<?php
      break;
      case 'reading17':
    ?>
var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) "
  + "WHERE r.章節 = '附錄二001-2' OR  r.章節 = '附錄二002-1' OR  r.章節 = '附錄二002-2' OR  r.章節 = '附錄二003-1' OR  r.章節 = '附錄二003-2' OR  r.章節 = '附錄二004-1' OR  r.章節 = '附錄二004-2' OR  r.章節 = '附錄二005-1' OR  r.章節 = '附錄二005-2' OR  r.章節 = '附錄二006-1' OR  r.章節 = '附錄二006-2' OR  r.章節 = '附錄二007-1' OR  r.章節 = '附錄二007-2' OR  r.章節 = '附錄二008-1' OR  r.章節 = '附錄二008-2' OR  r.章節 = '附錄二009-1' OR  r.章節 = '附錄二009-2' OR  r.章節 = '附錄二010-1' OR  r.章節 = '附錄二010-2' OR  r.章節 = '附錄二011-1' OR  r.章節 = '附錄二011-2' OR  r.章節 = '附錄二012-1' OR  r.章節 = '附錄二012-2' OR  r.章節 = '附錄二013-1' OR  r.章節 = '附錄二013-2' OR  r.章節 = '附錄二014-1' OR  r.章節 = '附錄二014-2' OR  r.章節 = '附錄二015-1' OR  r.章節 = '附錄二015-2' OR  r.章節 = '附錄二016-1' OR  r.章節 = '附錄二016-2' OR  r.章節 = '附錄二017-1' OR  r.章節 = '附錄二017-2' OR  r.章節 = '附錄二018-1' OR  r.章節 = '附錄二018-2' OR  r.章節 = '附錄二019-1' OR  r.章節 = '附錄二019-2' OR  r.章節 = '附錄二020-1' OR  r.章節 = '附錄二020-2' OR  r.章節 = '附錄二021-1' OR  r.章節 = '附錄二021-2' OR  r.章節 = '附錄二022-1' OR  r.章節 = '附錄二022-2' OR  r.章節 = '附錄二023-1' OR  r.章節 = '附錄二023-2' OR  r.章節 = '附錄二024-1' OR  r.章節 = '附錄二024-2' OR  r.章節 = '附錄二025-1' OR  r.章節 = '附錄二025-2' OR  r.章節 = '附錄二026-1' OR  r.章節 = '附錄二026-2' OR  r.章節 = '附錄二027-1' OR  r.章節 = '附錄二027-2' OR  r.章節 = '附錄二028-1' OR  r.章節 = '附錄二028-2' OR  r.章節 = '附錄二029-1' OR  r.章節 = '附錄二029-2' OR  r.章節 = '附錄二030-1' OR  r.章節 = '附錄二030-2' OR  r.章節 = '附錄二031-1' OR  r.章節 = '附錄二031-2' OR  r.章節 = '附錄二032-1' OR  r.章節 = '附錄二032-2' OR  r.章節 = '附錄二033-1' OR  r.章節 = '附錄二033-2' OR  r.章節 = '附錄二034-1' OR  r.章節 = '附錄二034-2' OR  r.章節 = '附錄二035-1' OR  r.章節 = '附錄二035-2' OR  r.章節 = '附錄二036-1' OR  r.章節 = '附錄二036-2' OR  r.章節 = '附錄二037-1' OR  r.章節 = '附錄二037-2' OR  r.章節 = '附錄二038-1' OR  r.章節 = '附錄二038-2' OR  r.章節 = '附錄二039-1' OR  r.章節 = '附錄二039-2' OR  r.章節 = '附錄二040-1' OR  r.章節 = '附錄二040-2' OR  r.章節 = '附錄二041-1' OR  r.章節 = '附錄二041-2' OR  r.章節 = '附錄二042-1' OR  r.章節 = '附錄二042-2' OR  r.章節 = '附錄二043-1' OR  r.章節 = '附錄二043-2' OR  r.章節 = '附錄二044-1' OR  r.章節 = '附錄二044-2' OR  r.章節 = '附錄二045-1' OR  r.章節 = '附錄二045-2' OR  r.章節 = '附錄二046-1' OR  r.章節 = '附錄二046-2' OR  r.章節 = '附錄二047-1' OR  r.章節 = '附錄二047-2' OR  r.章節 = '附錄二048-1' OR  r.章節 = '附錄二048-2' OR  r.章節 = '附錄二049-1' OR  r.章節 = '附錄二049-2' RETURN DISTINCT p;"; 
  <?php
   break;
  default:
		?>
var _highlight_query = "MATCH p= (a:MingExp)-[r:待確認{文集名:'校刻具茨先生詩集'}]->(c:MingExp) RETURN DISTINCT p;";
    //var _highlight_query = "START p= (a:MingExp8) RETURN p;";
		<?php
		break;
}
?>
















Cy2NeoD3({},"graph","datatable","cypher","execute", _connection , true, null, _total_query, _highlight_query);
</script>

</body>
</html>