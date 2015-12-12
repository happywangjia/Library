/**
 * Created by hijj on 15-12-9.
 */
var script=document.createElement("script");
script.type="text/javascript";
script.src="js/jquery.min.js";
document.getElementsByTagName('head')[0].appendChild(script);

function imgClick() {
    var tu = document.getElementsByTagName("img")[0];
    tu.src = tu.src + "?rand=" + Math.random();
}
function panErr(){
    imgClick();
    document.getElementById("ver").value="";
    document.getElementById("mi").value="";
}
var httpRequest;
function subClick(e) {
    e.preventDefault();
    var form = document.getElementById("form");
    var forData = "";
    var inputElements = document.getElementsByTagName("input");
    for (var i = 0; i < inputElements.length; i++) {
        if (inputElements[i].name == "role") {
            if (inputElements[i].checked) {
                forData += inputElements[i].name + "=" + inputElements[i].value + "&";

            }
        } else if (inputElements[i].name == "name" || inputElements[i].name == "pass" || inputElements[i].name == "checkcode") {
            forData += inputElements[i].name + "=" + inputElements[i].value + "&";
        }
    }
    httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = handleResponse;
    httpRequest.open("POST", form.action);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send(forData);
}
function handleResponse() {
    if (httpRequest.readyState == 4 && httpRequest.status == 200) {
        var respone = httpRequest.responseText;
        var res = eval("(" + respone + ")");
        var errNum = res.errNum;
        switch (parseInt(errNum)) {
            case 1:
                panErr();
                break;
            case 4:
                location.href = "html/u_zhuye.html";
                break;
            case 5:
                location.href = "html/m_zhuye.html";
                break;
            default:
                panErr();
                break;
        }
    }
}
$(document).ready(function(){
        document.getElementById("ver").value="";
    }
)