{{-- 기본셋팅 1204 최정훈 --}}
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="stylesheet" href="/css/common.css">
    <title>이의이승</title>
</head>
<body>
    <div id="app">
        <Open-Component></Open-Component>
    </div>
</body>
</html>