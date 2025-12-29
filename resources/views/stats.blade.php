<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vagrant Cloud Download Tracker</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-family: 'Inter', system-ui, sans-serif; line-height: 1.5; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            color: #e2e8f0;
            padding: 2rem 1rem;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        header {
            text-align: center;
            margin-bottom: 3rem;
        }
        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }
        .subtitle {
            color: #94a3b8;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }
        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .card-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .card-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-icon svg {
            width: 24px;
            height: 24px;
            fill: white;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #f1f5f9;
        }
        .card-subtitle {
            font-size: 0.875rem;
            color: #64748b;
        }
        .box-link {
            color: #818cf8;
            text-decoration: none;
            transition: color 0.2s;
        }
        .box-link:hover {
            color: #a5b4fc;
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 0.875rem 1rem;
            text-align: left;
        }
        th {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            background: rgba(0, 0, 0, 0.2);
        }
        th:first-child { border-radius: 0.5rem 0 0 0.5rem; }
        th:last-child { border-radius: 0 0.5rem 0.5rem 0; text-align: right; }
        td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        td:last-child {
            text-align: right;
            font-variant-numeric: tabular-nums;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }
        .downloads {
            font-weight: 600;
            color: #22c55e;
        }
        .total-row td {
            background: rgba(34, 197, 94, 0.1);
            font-weight: 600;
            border-top: 2px solid rgba(34, 197, 94, 0.3);
        }
        .total-row td:last-child {
            color: #4ade80;
            font-size: 1.1rem;
        }
        footer {
            text-align: center;
            padding-top: 2rem;
            color: #64748b;
            font-size: 0.875rem;
        }
        footer a {
            color: #818cf8;
            text-decoration: none;
        }
        footer a:hover {
            text-decoration: underline;
        }
        .info-box {
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 0.5rem;
            padding: 1rem 1.25rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }
        .info-box svg {
            width: 20px;
            height: 20px;
            fill: #818cf8;
            flex-shrink: 0;
            margin-top: 2px;
        }
        .info-box p {
            color: #c7d2fe;
            font-size: 0.9rem;
            line-height: 1.6;
        }
        @media (max-width: 640px) {
            h1 { font-size: 1.75rem; }
            .subtitle { font-size: 1rem; }
            th, td { padding: 0.625rem 0.5rem; font-size: 0.875rem; }
            .card { padding: 1rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Vagrant Cloud Download Tracker</h1>
            <p class="subtitle">
                Tracking download statistics for Vagrant boxes hosted on HashiCorp's Vagrant Cloud
            </p>
        </header>

        <div class="info-box">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
            </svg>
            <p>
                This dashboard displays estimated yearly download counts for tracked Vagrant boxes.
                Downloads are calculated as the difference between the first and last recorded
                counts for each year. <strong>Note:</strong> This is not an official record. Due to
                gaps in our timeseries data, these numbers should be treated as estimates only.
            </p>
        </div>

        @foreach($boxes as $box)
        <div class="card">
            <div class="card-header">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M21 16.5c0 .38-.21.71-.53.88l-7.9 4.44c-.16.12-.36.18-.57.18-.21 0-.41-.06-.57-.18l-7.9-4.44A.991.991 0 013 16.5v-9c0-.38.21-.71.53-.88l7.9-4.44c.16-.12.36-.18.57-.18.21 0 .41.06.57.18l7.9 4.44c.32.17.53.5.53.88v9z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="card-title">{{ $box['name'] }}</h2>
                    <a href="https://app.vagrantup.com/{{ $box['username'] }}/boxes/{{ $box['boxname'] }}" target="_blank" class="box-link card-subtitle">
                        {{ $box['username'] }}/{{ $box['boxname'] }}
                    </a>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Year</th>
                        <th>Downloads</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($box['stats'] as $stat)
                    @php $total += $stat['downloads']; @endphp
                    <tr>
                        <td>{{ $stat['year'] }}</td>
                        <td class="downloads">{{ number_format($stat['downloads']) }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td>Total</td>
                        <td>{{ number_format($total) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endforeach

        <footer>
            <p>
                Built with Laravel v{{ Illuminate\Foundation\Application::VERSION }} &middot;
                <a href="https://github.com/svpernova09/vcdt" target="_blank">View on GitHub</a>
            </p>
        </footer>
    </div>
</body>
</html>
