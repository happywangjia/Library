/**
 * Created by hijj on 15-12-10.
 */
var script = document.createElement("script");
script.type = "text/javascript";
script.src = "../js/jquery.min.js";
document.getElementsByTagName('head')[0].appendChild(script);

var httpRequest;
$(document).ready(function () {
    httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = handleResponse;
    httpRequest.open("GET", "../php/shman.php?getContent=1");
    httpRequest.send();
})
function handleResponse() {
    if (httpRequest.readyState == 4 && httpRequest.status == 200) {
        var response = httpRequest.responseText;
        var res = eval("(" + response + ")");
        var num = parseInt(res.Num);
        //alert(response);
        switch (num) {
            case 0:
                location.href = "../index.html"
                break;
            case 1:
                handler1(res);
                break;
            default:
                break;
        }

    }
}
function handler1(res) {
    var cnt = parseInt(res.cnt);
    var tab = document.getElementsByTagName("table")[0];
    for (var i = 1; i <= cnt; i++) {
        var ss = document.createElement("tr");
        ss.style.borderBottomcolor = "black";
        var name = res["" + i];
        ss.innerHTML = "<td style='border-bottom:1px solid black;width:20px'>" + i + "</td>" +
            "<td width='400px' style='padding-left: 30px;border-bottom: 1px solid black' dir='ltr'>" + name + "</td>" +
            "<td width='400px' style='border-bottom:1px solid black;padding-right:30px' dir='rtl'>" +
            "<a href='" + name + "' onclick='del(event)'>删除</a></td>";
        tab.appendChild(ss);
    }
}
var http3;
function add(e) {
    e.preventDefault();
    http3 = new XMLHttpRequest();
    var form = document.getElementById("add");
    var formData = new FormData(form);
    http3.onreadystatechange = handleAdd;
    http3.open("POST", "../php/addMan.php")
    http3.send(formData);
}
function handleAdd() {
    if (http3.readyState == 4 && http3.status == 200) {
        var res = http3.responseText;
 //       alert(res);
        var res2 = eval("(" + res + ")");
        var num = parseInt(res2.Num);
        switch (num) {
            case 0:
                alert("填写有误！");
                break;
            case 1:
                alert("该账户已存在！");
                break;
            case 2:
                alert("添加成功!");
                location.reload();
                break;
            default:
                alert("填写有误！");
                break;
        }
    }
}

var http2;
function del(e) {
    e.preventDefault();
    var str = e.currentTarget.toString();
    var i;
    for (i = str.length; i >= 0; i--) {
        if (str[i] == '/') {
            i++;
            break;
        }
    }
    var strs = "";
    for (i; i < str.length; i++) {
        strs += str[i];
    }
    // alert(strs);
    http2 = new XMLHttpRequest();
    http2.onreadystatechange = handleDel;
    http2.open("GET", "../php/delMan.php?name=" + strs);
    http2.send();
}
function handleDel(httpRequest) {
    if (http2.readyState == 4 && http2.status == 200) {
        if (http2.responseText == "ok") {
            alert("删除成功！")
            location.reload();
        }
    }
}