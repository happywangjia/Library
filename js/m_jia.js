/**
 * Created by hijj on 15-12-10.
 */

var httpRequest;
function addShu(e) {
    e.preventDefault();
    var shuNum = document.getElementById("shuNum");
    var shuName = document.getElementById("shuName");
    var shuJie = document.getElementById("shuJie");
    var ww = "wangjia";
    if (shuNum.value.trim() == "" || shuName.value.trim() == "") {
        alert("请填入书号和书名！");
        return;
    }
    if (shuJie.value == "介绍，限150字")
        shuJie.value = "";
    var form = document.getElementById("form");
    var formData = "";
    formData += shuNum.name + "=" + shuNum.value + "&";
    formData += shuName.name + "=" + shuName.value + "&";
    formData += shuJie.name + "=" + shuJie.value;
    httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = handleResponse;
    httpRequest.open("GET", form.action + "?" + formData);
    httpRequest.setRequestHeader("Content-Type", "application/x-www-urlencoded");
    httpRequest.send();
}
function handleResponse() {
    if (httpRequest.readyState == 4 && httpRequest.status == 200) {
        var res = httpRequest.responseText;
        var response = eval("(" + res + ")");
        var num = parseInt(response.Num);
        switch (num) {
            case 0:
                alert("输入有误！");
                break;
            case 1:
                alert("该书号已存在！");
                break;
            case 2:
                alert("添加成功！");
                var shuNum = document.getElementById("shuNum").value="";
                var shuName = document.getElementById("shuName").value="";
                var shuJie = document.getElementById("shuJie").value="";
                break;
            default:
                alert("输入有误！");
        }
    }
}