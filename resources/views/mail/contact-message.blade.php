<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Nouveau message depuis le site JMC Services</title>
</head>
<body style="font-family: Arial, sans-serif; color: #0b1035; line-height: 1.6;">
    <h1 style="font-size: 20px; color: #101a79;">Nouveau message depuis le site JMC Services</h1>

    <p><strong>Nom :</strong> {{ $data['name'] }}</p>
    @if (! empty($data['company']))
        <p><strong>Entreprise :</strong> {{ $data['company'] }}</p>
    @endif
    <p><strong>E-mail :</strong> {{ $data['email'] }}</p>
    @if (! empty($data['phone']))
        <p><strong>Téléphone :</strong> {{ $data['phone'] }}</p>
    @endif
    <p><strong>Sujet :</strong> {{ $data['subject'] }}</p>

    <hr style="border: 0; border-top: 1px solid #dde2f1; margin: 24px 0;">

    <p style="white-space: pre-line;">{{ $data['message'] }}</p>
</body>
</html>
