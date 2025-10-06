<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reunión: {{ $reunion->titulo }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            background: white;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Header */
        .header {
            text-align: center;
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #1e40af;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .header p {
            color: #6b7280;
            font-size: 14px;
        }
        
        /* Main Info */
        .main-info {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }
        
        .main-info h2 {
            color: #1f2937;
            font-size: 18px;
            margin-bottom: 15px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 8px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            font-weight: bold;
            color: #374151;
            padding: 8px 15px 8px 0;
            width: 30%;
            vertical-align: top;
        }
        
        .info-value {
            display: table-cell;
            color: #1f2937;
            padding: 8px 0;
            vertical-align: top;
        }
        
        /* Description */
        .description {
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }
        
        .description h3 {
            color: #7c3aed;
            font-size: 16px;
            margin-bottom: 12px;
        }
        
        .description p {
            text-align: justify;
            line-height: 1.7;
        }
        
        /* Participants */
        .participants {
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }
        
        .participants h3 {
            color: #059669;
            font-size: 16px;
            margin-bottom: 15px;
        }
        
        .participant-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .participant-item:last-child {
            border-bottom: none;
        }
        
        .participant-info {
            flex: 1;
        }
        
        .participant-name {
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 2px;
        }
        
        .participant-cedula {
            color: #6b7280;
            font-size: 11px;
        }
        
        .participant-role {
            background: #dbeafe;
            color: #1e40af;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .participant-role.concejal {
            background: #fef3c7;
            color: #d97706;
        }
        
        /* Related Info */
        .related-info {
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }
        
        .related-info h3 {
            color: #dc2626;
            font-size: 16px;
            margin-bottom: 15px;
        }
        
        /* Status */
        .status-badge {
            display: inline-block;
            background: #e5e7eb;
            color: #374151;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            margin-top: 10px;
        }
        
        .status-badge.today {
            background: #fee2e2;
            color: #dc2626;
        }
        
        .status-badge.future {
            background: #dbeafe;
            color: #2563eb;
        }
        
        .status-badge.past {
            background: #dcfce7;
            color: #16a34a;
        }
        
        /* Footer */
        .footer {
            border-top: 2px solid #e5e7eb;
            padding-top: 15px;
            text-align: center;
            color: #6b7280;
            font-size: 11px;
            margin-top: 30px;
        }
        
        /* Print specific */
        @media print {
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
            
            .container {
                padding: 10px;
            }
        }
        
        /* Page break */
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>REPORTE DE REUNIÓN</h1>
            <p>Sistema Municipal CMBEY - {{ date('d/m/Y H:i') }}</p>
        </div>

        <!-- Main Information -->
        <div class="main-info">
            <h2>Información Principal</h2>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Título:</div>
                    <div class="info-value">{{ $reunion->titulo }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Fecha:</div>
                    <div class="info-value">{{ $reunion->fecha_reunion->format('d/m/Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Hora:</div>
                    <div class="info-value">{{ $reunion->fecha_reunion->format('H:i') }}</div>
                </div>
                @if($reunion->ubicacion)
                <div class="info-row">
                    <div class="info-label">Ubicación:</div>
                    <div class="info-value">{{ $reunion->ubicacion }}</div>
                </div>
                @endif
                <div class="info-row">
                    <div class="info-label">Estado:</div>
                    <div class="info-value">
                        @if($reunion->fecha_reunion->isToday())
                            <span class="status-badge today">HOY</span>
                        @elseif($reunion->fecha_reunion->isFuture())
                            <span class="status-badge future">PROGRAMADA</span>
                        @else
                            <span class="status-badge past">FINALIZADA</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        @if($reunion->descripcion)
        <div class="description">
            <h3>Descripción y Objetivos</h3>
            <p>{{ $reunion->descripcion }}</p>
        </div>
        @endif

        <!-- Related Information -->
        <div class="related-info">
            <h3>Información Relacionada</h3>
            <div class="info-grid">
                @if($reunion->solicitud)
                <div class="info-row">
                    <div class="info-label">Solicitud:</div>
                    <div class="info-value">
                        {{ $reunion->solicitud->titulo }}<br>
                        <small style="color: #6b7280;">ID: {{ $reunion->solicitud->solicitud_id }}</small>
                    </div>
                </div>
                @endif
                @if($reunion->institucion)
                <div class="info-row">
                    <div class="info-label">Institución:</div>
                    <div class="info-value">{{ $reunion->institucion->titulo }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Participants -->
        <div class="participants">
            <h3>Participantes ({{ $reunion->asistentes->count() }})</h3>
            @if($reunion->asistentes->count() > 0)
                @foreach($reunion->asistentes as $asistente)
                <div class="participant-item">
                    <div class="participant-info">
                        <div class="participant-name">{{ $asistente->nombre }} {{ $asistente->apellido }}</div>
                        <div class="participant-cedula">C.I: {{ number_format($asistente->cedula, 0, '.', '.') }}</div>
                    </div>
                    <div class="participant-role {{ $asistente->pivot->es_concejal ? 'concejal' : '' }}">
                        {{ $asistente->pivot->es_concejal ? 'Concejal Responsable' : 'Participante' }}
                    </div>
                </div>
                @endforeach
            @else
                <p style="color: #6b7280; font-style: italic;">No hay participantes registrados.</p>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                Documento generado automáticamente por el Sistema Municipal CMBEY<br>
                Generado el {{ date('d/m/Y') }} a las {{ date('H:i') }} hrs.
            </p>
        </div>
    </div>
</body>
</html>