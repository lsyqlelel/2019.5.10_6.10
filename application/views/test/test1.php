<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <title>新闻栏目类型管理</title>
    <link rel="stylesheet" href="/style/css/base.css" /><!--引入css文件路径这样写就行，从根目录找-->
    <style type="text/css">
        html,body{
            background: #3399FF;
        }
        .add-box{
            width: 200px;
            position: absolute;
            top: 50%;
            height: 100px;
            left: 50%;
            margin-left: -100px;
            margin-top: -50px;
        }
        #menuName{
            width: 180px;
            font-size: 18px;
            color: #333333;
            padding: 12px 20px;
            border: none;
        }
        #ok-btn{
            margin: 20px;
            width: 100px;
            height: 30px;
            line-height: 30px;
            font-size: 18px;
            background: #FFFFFF;
            color: #000000;
            text-align: center;
            border: none;
        }
    </style>
</head>
<body>
<!--<div class="backbox" onclick="history.go(-1)">
    <img src="/style/img/back-btn.png" />
</div>-->
<div class="add-box">

    <form action="./addType" method="post">
        <input type="text" name="menuName" id="menuName" placeholder="请输入栏目名称"/>
        <input type="submit" value="确定" id="ok-btn"/>

    </form>
</div>
</body>
</html>
