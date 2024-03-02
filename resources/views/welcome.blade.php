<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- head内容，如meta标签，标题，CSS链接等 -->
</head>
<body>
    <div id="app">
        <router-view></router-view>
    </div>

    <!-- 在body结束标签之前，引入编译后的JavaScript文件 -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>