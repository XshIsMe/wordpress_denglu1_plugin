<h2>日志</h2>
<table class="wp-list-table widefat plugins">
    <thead>
        <tr>
            <th>ID</th>
            <th>用户名</th>
            <th>IP地址</th>
            <th>经度</th>
            <th>纬度</th>
            <th>动作</th>
            <th>结果</th>
            <th>时间</th>
        </tr>
    </thead>
    <tbody id="denglu1-log"></tbody>
</table>
<p>
    <span>第</span>
    <input id="denglu1-page" type="text" value="1" style="width:2rem" />
    <span>页</span>
    <button id="denglu1-jump" class="button button-primary" onclick="denglu1Jump()">跳转</button>
</p>
<hr>
<h2>导入导出日志</h2>
<form action="<?php echo esc_html(home_url('/Denglu1ImportLog')) ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="denglu1-log-file">
    <input class="button button-primary" type="submit" value="导入日志">
    <a class="button button-primary" href="<?php echo esc_html(home_url('/Denglu1ExportLog')) ?>">导出日志</a>
</form>
</p>
<script>
    function denglu1FormatTime(timestamp) {
        var date = new Date(timestamp * 1000);
        var year = date.getFullYear();
        var month = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1);
        var day = (date.getDate() < 10 ? '0' + date.getDate() : date.getDate());
        var hour = (date.getHours() < 10 ? '0' + date.getHours() : date.getHours());
        var minute = (date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes());
        var second = date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds();
        return year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;
    }

    function denglu1LoadXMLDoc(page, func) {
        var xmlhttp;
        if (window.XMLHttpRequest) {
            //  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
            xmlhttp = new XMLHttpRequest();
        } else {
            // IE6, IE5 浏览器执行代码
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                func(xmlhttp.responseText);
            }
        }
        xmlhttp.open("GET", "<?php echo esc_html(home_url('/Denglu1Log?page=')) ?>" + page, true);
        xmlhttp.send();
    }

    function denglu1Jump() {
        // 获取页码
        var denglu1Page = document.getElementById("denglu1-page").value;
        // 发送异步请求
        denglu1LoadXMLDoc(denglu1Page, function(result) {
            // 获取表格
            var denglu1Log = document.getElementById("denglu1-log");
            // 清空表格
            denglu1Log.innerHTML = "";
            // 获取数据
            var data = JSON.parse(result);
            // 处理数据
            for (let i = 0; i < data.length; i++) {
                // 创建tr元素
                var tr = document.createElement('tr');
                // 创建td元素
                var tdID = document.createElement('td');
                var tdUsername = document.createElement('td');
                var tdIp = document.createElement('td');
                var tdLongtitude = document.createElement('td');
                var tdLatitude = document.createElement('td');
                var tdTime = document.createElement('td');
                var tdAction = document.createElement('td');
                var tdResult = document.createElement('td');
                // 填充元素
                tdID.innerText = data[i]['id'];
                tdUsername.innerText = data[i]['username'];
                tdIp.innerText = data[i]['ip'];
                tdLongtitude.innerText = data[i]['longitude'];
                tdLatitude.innerText = data[i]['latitude'];
                tdAction.innerText = data[i]['action'];
                tdResult.innerText = (data[i]['result'] ? '成功' : '失败');
                tdTime.innerText = denglu1FormatTime(data[i]['time']);
                // 将td元素插入tr元素
                tr.appendChild(tdID);
                tr.appendChild(tdUsername);
                tr.appendChild(tdIp);
                tr.appendChild(tdLongtitude);
                tr.appendChild(tdLatitude);
                tr.appendChild(tdAction);
                tr.appendChild(tdResult);
                tr.appendChild(tdTime);
                // 将tr元素插入表格
                denglu1Log.appendChild(tr)
            }
        })
    }

    // 第一次访问时加载日志
    denglu1Jump();
</script>