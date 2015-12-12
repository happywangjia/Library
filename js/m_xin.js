/**
 *
 * Created by hijj on 15-12-10.
 */

var httpRequest;
$(document).ready(function () {
    httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = handler1;
    httpRequest.open("GET", "../php/mXin.php?content=1");
    httpRequest.send();
})
function handler1() {
    if (httpRequest.readyState == 4 && httpRequest.status == 200) {
        var res2 = httpRequest.responseText;
        var response = eval("(" + res2 + ")");
        var Num = parseInt(response.Num);
        switch (Num) {
            case 0:
                break;
            case 1:
                addInfo(response);
                break;
        }
    }
}
var email;
var telephone;
function addInfo(response) {
    var name = response.name;
    var priority = parseInt(response.priority);
    email = response.email;
    telephone = response.telephone;
    document.getElementById("name").innerHTML = name;
    var pri = document.getElementById("priority");
    if (priority == 1) {
        pri.innerHTML = "超级管理员";
    } else {
        pri.innerHTML = "普通管理员";
    }
    if (email != null && email.trim() != "") {
        document.getElementById("email").innerHTML = email;
    } else {
        email = "";
        document.getElementById("email").innerHTML = "添加"
    }
    if (telephone != null && telephone.trim() != "") {
        document.getElementById("telephone").innerHTML = telephone;
    } else {
        telephone = "";
        document.getElementById("telephone").innerHTML = "添加";
    }
}
function gai(e, obj) {
    e.preventDefault();
    var li = document.getElementById("li");
    li.hidden = false;
    var submit = document.getElementById("submit");
    if (obj.id == "email") {
        obj.hidden = true;
        obj.nextElementSibling.hidden = false;
        obj.nextElementSibling.focus();
    } else {
        obj.hidden = true;
        obj.nextElementSibling.hidden = false;
        obj.nextElementSibling.focus();
    }
}
function jiao() {
    var eee = document.getElementById("inputEmail");
    var ttt = document.getElementById("inputTel");
    var e1 = "***";
    var t1 = "***";
    if (eee.hidden == false) {
        e1 = eee.value;
    }
    if (ttt.hidden == false) {
        t1 = ttt.value;
    }
    var data = "";
    if (e1 !== "***") {
        data += "email" + "=" + e1 + "&";
    } else {
        data += "email" + "=" + email + "&";
    }
    if (t1 !== "***") {
        data += "telephone" + "=" + t1;
    } else {
        data += "telephone" + "=" + telephone;
    }
    jiao2(data);
}
var http2;
function jiao2(data) {
    http2 = new XMLHttpRequest();
    http2.onreadystatechange = handler2;
    http2.open("GET", "../php/mXin.php?content=2&" + data);
    http2.send();
}
function handler2() {
    if (http2.readyState == 4 && http2.status == 200) {
        var res2 = http2.responseText;
        var res22 = eval("(" + res2 + ")");
        var num = parseInt(res22.Num);
        switch (num) {
            case 0:
                alert("操作错误！");
                break;
            case 2:
                alert("输入格式有误！");
                break;
            case 3:
                alert("修改成功！");
                location.reload();
                break;
        }
    }
}

function xiao() {
    var li = document.getElementById("li");
    li.hidden = true;
    var submit = document.getElementById("submit");
    var obj1 = document.getElementById("email");
    var obj2 = document.getElementById("telephone");
    obj1.hidden = false;
    obj1.nextElementSibling.value = "";
    obj1.nextElementSibling.hidden = true;
    obj2.nextElementSibling.value = "";
    obj2.hidden = false;
    obj2.nextElementSibling.hidden = true;
}