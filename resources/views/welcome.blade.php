<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- head内容，如meta标签，标题，CSS链接等 -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

</head>
<body>
    <div id="app">
        <router-view></router-view>
    </div>

    <!-- 在body结束标签之前，引入编译后的JavaScript文件 -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>