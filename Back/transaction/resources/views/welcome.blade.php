<!DOCTYPE html>
<html>
<head>
    <title>Transfert</title>
</head>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<body>
    <h1>Page de transfert</h1>
    <p>Cliquez sur les liens ci-dessous pour accéder aux différents services de transfert :</p>
    <ul>
        <li><a href="{{ url('/transfert/orange-money') }}">Orange Money</a></li>
        <li><a href="{{ url('/transfert/wave') }}">Wave</a></li>
        <li><a href="{{ url('/transfert/wari') }}">Wari</a></li>
        <li><a href="{{ url('/transfert/cb') }}">Carte Bancaire</a></li>
    </ul>
</body>
</html>
