/**
 * 適用網頁：http://vinson.rd.ssic.nccu.edu.tw/
 * 事件查詢表：https://docs.google.com/spreadsheets/d/1MtMtw9lKLDTUzfBd6Ld0fAe_FGe5u-Mlkh5WfZiH5qM/edit
 * @author Pudding 20170203
 */

GA_TRACE_CODE = "UA-118272323-1";
        
var _local_debug = false;

    CSS_URL = "/GA-project-master/config/socialnetworktool.css";
    LIB_URL = "/GA-project-master/ga_inject_lib.js";



var exec = function () {
    auto_set_user_id();   

    //社會網絡修正介面
    ga_mouse_click_event(".fulltext","look_searchfulltext",function (_fulltext) {
        return _fulltext.text();});
    ga_mouse_click_event("#create_file","download");
    ga_mouse_click_event("#home_page","回首頁");

    //滑鼠滑入滑出
    //ga_mouse_over_event(".img","Hover img");
    //表單送出
    ga_submit_event("form", "search_socialnetwork", function (_formcontent) {

        return _formcontent.serialize();});
    //社會網絡修正介面結束
    //社會網絡圖呈現介面
    //ga_mouse_click_event(".remScnt","刪除搜尋文集");
    
    ga_mouse_click_event("a[herf='networkconfirm/']","into_socialnetwork_tool");
    ga_mouse_click_event("a[role='tab']","broswer",function (_browse) {
        return _browse.text();});
		
    
    /*
     ga_mouse_click_event(".outline","graph_node_search",function (_node) {
                  var  word = $(this).find("text").text().trim();
                        console.log(word);
                  var CBDB_url = "https://cbdb.fas.harvard.edu/cbdbapi/person.php?name=" + encodeURIComponent(word);
                  var node_CBDB = word +": "+ CBDB_url;
                    console.log(node_CBDB);
        return node_CBDB;});    
    */

                                    };


// --------------------------------------

$(function () {
    $.getScript(LIB_URL, function () {
        ga_setup(function () {
            exec();
        });
    });
});
