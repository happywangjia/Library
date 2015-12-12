/**
 * Created by hijj on 15-12-11.
 */

var httpRequest;
var password;
var email;
var telephone;
$(document).ready(function () {
    httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = handler1;
    httpRequest.open("GET", "../php/uXin.php?content=1");
    httpRequest.send();
})
function handler1() {
    if (httpRequest.readyState == 4 && httpRequest.status == 200) {
        var response = httpRequest.responseText;
        var res = eval("(" + response + ")");
        var num = parseInt(res.Num);
        switch (num) {
            case 1:
                addInfo(res);
                break;
            default:
                break;
        }
    }
}
function addInfo(res) {
    var learn_num = res.learn_num;
    var name = res.name;
    var grade = res.class;
    password = res.password;
    email = res.email;
    telephone = res.telephone;
    document.getElementById("learn_num").innerHTML = learn_num;
    document.getElementById("name").innerHTML = name;
    document.getElementById("grade").innerHTML = grade;
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
    } else if (obj.id == "telephone") {
        obj.hidden = true;
        obj.nextElementSibling.hidden = false;
        obj.nextElementSibling.focus();
    } else {
        obj.hidden = true;
        obj.nextElementSibling.hidden = false;
        obj.nextElementSibling.focus();
    }
}
function xiao() {
    var li = document.getElementById("li");
    li.hidden = true;
    var obj1 = document.getElementById("email");
    var obj2 = document.getElementById("telephone");
    var obj3 = document.getElementById("password");
    obj1.hidden = false;
    obj1.nextElementSibling.value = "";
    obj1.nextElementSibling.hidden = true;
    obj2.nextElementSibling.value = "";
    obj2.hidden = false;
    obj2.nextElementSibling.hidden = true;
    obj3.nextElementSibling.value = "";
    obj3.hidden = false;
    obj3.nextElementSibling.hidden = true;
}

function jiao() {
    var eee = document.getElementById("inputEmail");
    var ttt = document.getElementById("inputTel");
    var ppp = document.getElementById("inputPass");
    var e1 = "***";
    var t1 = "***";
    var psw = password;
    if (eee.hidden == false) {
        e1 = eee.value;
    }
    if (ttt.hidden == false) {
        t1 = ttt.value;
    }
    if (ppp.hidden == false) {
        psw = ppp.value;
    }
    var data = "";
    if (e1 != "***") {
        data += "email" + "=" + e1 + "&";
    } else {
        data += "email" + "=" + email + "&";
    }
    if (t1 != "***") {
        data += "telephone" + "=" + t1;
    } else {
        data += "telephone" + "=" + telephone + "&";
    }
    if (password != psw.trim() && psw.trim() != "") {
        data += "password" + "=" + psw;
    }

    jiao2(data);
}
var http2;
function jiao2(data) {
    http2 = new XMLHttpRequest();
    http2.onreadystatechange = handler2;
    http2.open("GET", "../php/uXin.php?content=2&" + data);
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
                var eee = document.getElementById("inputEmail");
                var ttt = document.getElementById("inputTel");
                var ppp = document.getElementById("inputPass");
                eee.value = "";
                ttt.value = "";
                ppp.value = "";
                location.reload();
                break;
        }
    }
}
