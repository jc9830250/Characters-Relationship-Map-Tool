<!DOCTYPE html>
<html>

<head>
    <title>
        通用型人物關係分析工具
    </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="icon" type="image/png" href="user_group.png" />
    <!-- Script Here -->
    <script src="jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="control.js" type="text/javascript"></script>
    <script src="semantic-ui/semantic.min.js" type="text/javascript"></script>
    <script src="/GA-project-master/config/socialnetworktool.js" type="text/javascript"></script>

    <!-- CSS Here -->
    <link rel="stylesheet" href="main.css" />
    <link rel="stylesheet" type="text/css" href="semantic-ui/semantic.min.css">
    <!-- bootstrap Here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<script src="jquery.highlight.js" type="text/javascript"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light ui form grid" 
		style="padding-left: 50px;padding-right: 35px;padding-top: 10px;">
			<div class="four wide column">
				<a class="navbar-brand">
					<img class="ui avatar image" src="user_group.png">
					通用型人物關係分析工具
			    </a>
			</div>
			<div class="three wide column">
			    <div class="field">
				
				  <select id="select_volume">
					<option value="reading1" data-disable-sna="false">全文</option>
					<option value="reading2" data-disable-sna="false">序</option>
					<option value="reading3" data-disable-sna="false">詩集卷一</option>
					<option value="reading4" data-disable-sna="false">詩集卷二</option>
					<option value="reading5" data-disable-sna="false">詩集卷三</option>
					<option value="reading6" data-disable-sna="false">詩集卷四</option>
					<option value="reading7" data-disable-sna="false">詩集卷五</option>
					<option value="reading8" data-disable-sna="false">第一卷</option>
					<option value="reading9" data-disable-sna="false">第二卷</option>
					<option value="reading10" data-disable-sna="false">第三卷</option>
					<option value="reading11" data-disable-sna="false">第四卷</option>
					<option value="reading12" data-disable-sna="false">第五卷</option>
					<option value="reading13" data-disable-sna="false">第六卷</option>
					<option value="reading14" data-disable-sna="false">第七卷</option>
					<option value="reading15" data-disable-sna="false">第八卷</option>
					<option value="reading16" data-disable-sna="false">附錄一</option>
					<option value="reading17" data-disable-sna="false">附錄二</option>
				  </select>	
				
				  
				</div>
			</div>
			<div class="nine wide column right aligned">
				
				<a class="  ui button " href="20180815數位人文社會網絡使用說明.pdf" target="_blank" >操作說明</a>
				

				<div class="ui action input search-div" id="search_raw_text">
				  <input type="text" placeholder="搜尋原始史料..." value="">
				  <button class="ui button">搜尋全文</button>
				</div>
				
				<div class="ui right labeled input search-div" id="search_internet">
					<select class="ui compact selection dropdown">
						<option selected="" value="cdbd">CBDB</option>
						<option value="moedict">萌典</option>
						<option value="wiki">維基</option>
						<option value="baidu">百度</option>
						<option value="google">Google</option>
						<option value="zdic">漢典</option>
						<option value="chardb">異體字</option>
						<option value="kangxi">康熙字典</option>

						<!--<option value="socialnetwork_tool">文集</option>-->
					</select>
				  <input type="text" placeholder="搜尋網際網路" value="">
				  <div class="ui button">搜尋</div>
				</div>
			</div>
    </nav>

    <div class="main-container ui grid">
		<div class="eight wide column dashboard <?php if ($_GET["mode"] == "2") echo "disable-sna"; ?>">
			<div class="ui fluid image sna">
				<div class="ui green ribbon label">
					文集人物關係圖 
					<span style="font-size: smaller;display: block;">(可拖曳移動畫面、滑鼠滾輪放大縮小)</span>
				</div>
				<iframe id="sna" src="/social_index.php"></iframe>
			</div>
			<div class="ui fluid image">
				<div class="ui blue ribbon label">
					記事本
				</div>
				<iframe id="note" src="note/"></iframe>
			</div>
			
		</div>
		<div class="eight wide column">
			<div class="ui fluid image">
				<div class="ui teal right ribbon label">
					王立道 校刻具茨先生詩集
				</div>
				<iframe id="reading" src="reading/reading1.html"></iframe>
			</div>
			
		</div>
    </div>


    <!-- bootstrap js Here -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous" type="text/javascript"></script> -->
	<script src="script.js"></script>
</body>

</html>
