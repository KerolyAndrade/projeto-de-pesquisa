<!-- resources/views/congregations/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database of Congregations</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <div class="container">
        <div class="search-form">
            <h2>Search</h2>
            <form action="{{ route('congregations.search') }}" method="GET">
                <!-- Search fields -->
                <div>
                    <label for="nome_congregacao">Congregation Name:</label>
                    <input type="text" name="nome_congregacao" id="nome_congregacao">
                </div>
                <!-- Other search fields -->
                <!-- ... -->
                <button type="submit">Search</button>
            </form>
        </div>
        <div class="results">
            <h2>Results</h2>
            <ul>
                @foreach($congregations as $congregation)
                    <li>
                        <strong>Name:</strong> {{ $congregation->nome_congregacao }}
                        <br>
                        <strong>Keyword:</strong> {{ $congregation->palavra_chave }}
                        <!-- Other result fields -->
                        <!-- ... -->
                    </li>
                @endforeach
            </ul>
            <div class="pagination">
                {{ $congregations->links() }}
            </div>
        </div>
    </div>
</body>
</html>