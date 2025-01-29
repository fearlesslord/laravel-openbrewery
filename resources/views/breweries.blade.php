<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Test Breweries</title>
    <!-- Collegamento al file CSS -->
    <link rel="stylesheet" href="{{ asset('css/breweries.css') }}">
</head>
<body>
<h1>Login</h1>
<form id="loginForm">
    <label for="username">Username:</label>
    <input type="text" id="username" value="root" />

    <label for="password">Password:</label>
    <input type="password" id="password" value="password" />

    <button type="submit">Login</button>
</form>

<hr>

<div id="statusMessage"></div>

<div id="breweriesSection" style="display: none;">
    <h2>Breweries List</h2>

    <label for="perPageSelector">Elementi per pagina:</label>
    <select id="perPageSelector">
        <option value="5" selected>5</option>
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="50">50</option>
    </select>

    <!-- Nuovo: selettore pagina -->
    <label for="pageSelector">Pagina:</label>
    <input type="number" id="pageSelector" value="1" min="1" />

    <div class="pagination-controls">
        <button id="prevPage">« Prev</button>
        <button id="nextPage">Next »</button>
    </div>

    <ul id="breweriesList"></ul>
</div>

<!-- Sezione dettaglio (come negli esempi precedenti) -->
<div id="breweryDetailSection" style="display: none;">
    <button id="closeDetail">Chiudi</button>
    <div id="breweryDetail"></div>
</div>

<!-- Collegamento al file JS -->
<script src="{{ asset('js/breweries.js') }}"></script>
</body>
</html>
