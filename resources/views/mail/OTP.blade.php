<!DOCTYPE html>
<html>
<head>
    <title>OTP Email</title>
</head>
<body>
    <h1>One-Time Password (OTP)</h1>
    <p>Hola! {{ $user->name }},</p>
    <p>Tu código OTP es: <strong>{{ $otp }}</strong></p>
    <p>Utiliza este codigo para verificar tu ingreso.</p>
    <p>Gracias!</p>
</body>
</html>