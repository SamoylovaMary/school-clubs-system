<!DOCTYPE html>
<html>
<head>
    <title>Данные для входа в систему</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .credentials { background: #f5f5f5; padding: 15px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Добро пожаловать в систему школьных клубов!</h2>
        <p>Для вас была создана учетная запись тренера.</p>
        
        <div class="credentials">
            <p><strong>Логин:</strong> {{ \ }}</p>
            <p><strong>Пароль:</strong> {{ \ }}</p>
        </div>
        
        <p>Для входа перейдите по ссылке: <a href="{{ url('/login') }}">{{ url('/login') }}</a></p>
        <p>Рекомендуем сменить пароль после первого входа.</p>
    </div>
</body>
</html>
