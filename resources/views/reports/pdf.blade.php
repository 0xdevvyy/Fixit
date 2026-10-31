<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket report - {{ $date }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            color: #172033;
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.45;
            margin: 0;
        }
        h1, h2, p { margin: 0; }
        h1 { font-size: 24px; margin: 5px 0; }
        h2 { font-size: 14px; margin: 20px 0 8px; }
        .muted { color: #64748b; }
        .header { border-bottom: 2px solid #dbe2ea; padding-bottom: 14px; }
        .eyebrow {
            color: #64748b;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .summary { display: flex; gap: 8px; margin-top: 16px; }
        .summary-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            flex: 1;
            padding: 9px;
        }
        .summary-card strong { display: block; font-size: 15px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border-bottom: 1px solid #e2e8f0; padding: 7px 6px; text-align: left; }
        th { background: #f1f5f9; font-size: 9px; text-transform: uppercase; }
        tr { page-break-inside: avoid; }
        .empty { border: 1px solid #e2e8f0; padding: 18px; text-align: center; }
    </style>
</head>
<body>
    <header class="header">
        <p class="eyebrow">Fixit maintenance report</p>
        <h1>{{ $period === 'monthly' ? 'Monthly' : 'Weekly' }} ticket report</h1>
        <p class="muted">
            {{ $start->format('M j, Y') }} – {{ $end->format('M j, Y') }}
            &nbsp; | &nbsp; Prepared for {{ $user->name }} ({{ $user->role->value }})
        </p>
    </header>

    <section class="summary">
        <div class="summary-card">
            <span class="muted">Total tickets</span>
            <strong>{{ $report['total'] }}</strong>
        </div>
        @foreach ($report['statuses'] as $status => $total)
            <div class="summary-card">
                <span class="muted">{{ str($status)->headline() }}</span>
                <strong>{{ $total }}</strong>
            </div>
        @endforeach
    </section>

    <section>
        <h2>Priority breakdown</h2>
        <table>
            <thead><tr><th>Priority</th><th>Tickets</th></tr></thead>
            <tbody>
                @foreach ($report['priorities'] as $priority => $total)
                    <tr><td>{{ str($priority)->headline() }}</td><td>{{ $total }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <section>
        <h2>Category breakdown</h2>
        <table>
            <thead><tr><th>Category</th><th>Tickets</th></tr></thead>
            <tbody>
                @foreach ($report['categories'] as $category => $total)
                    <tr><td>{{ str($category)->headline() }}</td><td>{{ $total }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <section>
        <h2>Tickets</h2>
        @if ($report['tickets']->isEmpty())
            <p class="empty">No tickets were reported during this period.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Ticket #</th>
                        <th>Title</th>
                        <th>Reporter</th>
                        <th>Assigned to</th>
                        <th>Building / Room</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Reported</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($report['tickets'] as $ticket)
                        <tr>
                            <td>{{ $ticket->ticket_number }}</td>
                            <td>{{ $ticket->title }}</td>
                            <td>{{ $ticket->reporter?->name ?? '—' }}</td>
                            <td>{{ $ticket->assignedTo?->name ?? 'Unassigned' }}</td>
                            <td>{{ $ticket->building?->name ?? '—' }}{{ $ticket->room ? ' / '.$ticket->room : '' }}</td>
                            <td>{{ str($ticket->status?->value ?? 'unknown')->headline() }}</td>
                            <td>{{ str($ticket->priority?->value ?? 'unknown')->headline() }}</td>
                            <td>{{ $ticket->created_at?->format('M j, Y') ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>
</body>
</html>
