<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket {{ $ticket->id }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            color: #172033;
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            margin: 0;
        }
        h1, h2, p { margin: 0; }
        .header {
            border-bottom: 2px solid #dbe2ea;
            margin-bottom: 24px;
            padding-bottom: 16px;
        }
        .eyebrow {
            color: #64748b;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        h1 { font-size: 24px; margin: 4px 0 10px; }
        .badges { display: flex; gap: 8px; }
        .badge {
            background: #f1f5f9;
            border-radius: 12px;
            color: #334155;
            display: inline-block;
            font-size: 10px;
            padding: 3px 9px;
        }
        h2 { font-size: 14px; margin-bottom: 12px; }
        .section { margin-bottom: 22px; }
        .details {
            display: grid;
            gap: 16px 24px;
            grid-template-columns: 1fr 1fr;
        }
        .label {
            color: #64748b;
            display: block;
            font-size: 10px;
            margin-bottom: 3px;
        }
        .value { font-weight: 600; }
        .description {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px;
            white-space: pre-wrap;
        }
        .timeline { border-left: 2px solid #e2e8f0; margin-left: 5px; padding-left: 16px; }
        .timeline-item { margin-bottom: 12px; }
        .timeline-item:last-child { margin-bottom: 0; }
        .photos { display: grid; gap: 16px; grid-template-columns: 1fr 1fr; }
        .photo { page-break-inside: avoid; }
        .photo img {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            display: block;
            height: 220px;
            object-fit: contain;
            width: 100%;
        }
        .photo .label { font-weight: 700; margin-bottom: 6px; }
    </style>
</head>
<body>
    <header class="header">
        <p class="eyebrow">Maintenance ticket #{{ $ticket->ticket_number }}</p>
        <h1>{{ $ticket->title }}</h1>
        <div class="badges">
            <span class="badge">{{ $ticket->priority->value }} priority</span>
            <span class="badge">{{ str($ticket->status->value)->headline() }}</span>
        </div>
    </header>

    <section class="section">
        <h2>Ticket details</h2>
        <div class="details">
            <div>
                <span class="label">Reported by</span>
                <span class="value">{{ $ticket->reporter?->name ?? '—' }}</span>
            </div>
            <div>
                <span class="label">Assigned to</span>
                <span class="value">{{ $ticket->assignedTo?->name ?? 'Unassigned' }}</span>
            </div>
            <div>
                <span class="label">Location</span>
                <span class="value">{{ $ticket->building?->name ?? '—' }}{{ $ticket->room ? ', '.$ticket->room : '' }}</span>
            </div>
            <div>
                <span class="label">Category</span>
                <span class="value">{{ str($ticket->category->value)->headline() }}</span>
            </div>
            <div>
                <span class="label">Date reported</span>
                <span class="value">{{ $ticket->created_at?->format('M d, Y') ?? '—' }}</span>
            </div>
        </div>
    </section>

    <section class="section">
        <h2>Description</h2>
        <div class="description">{{ $ticket->description }}</div>
    </section>

    <section class="section">
        <h2>Status progress</h2>
        <div class="timeline">
            @foreach ([
                ['Ticket created', $ticket->created_at],
                ['Assigned to technician', $ticket->assigned_at],
                ['Repair started', $ticket->accepted_at],
                ['Completed', $ticket->completed_at],
                ['Closed', $ticket->closed_at],
            ] as [$label, $date])
                <div class="timeline-item">
                    <span class="value">{{ $label }}</span>
                    <span class="label">{{ $date?->format('M d, Y') ?? 'Pending' }}</span>
                </div>
            @endforeach
        </div>
    </section>

    @if ($beforeImage || $afterImage)
        <section class="section">
            <h2>Maintenance photos</h2>
            <div class="photos">
                @if ($beforeImage)
                    <div class="photo">
                        <span class="label">Before</span>
                        <img src="{{ $beforeImage }}" alt="Before maintenance">
                    </div>
                @endif
                @if ($afterImage)
                    <div class="photo">
                        <span class="label">After</span>
                        <img src="{{ $afterImage }}" alt="After maintenance">
                    </div>
                @endif
            </div>
        </section>
    @endif
</body>
</html>
