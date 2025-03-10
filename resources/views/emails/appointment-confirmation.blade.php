<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bevestiging van uw afspraak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .content {
            padding: 30px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
        }
        .appointment-details {
            margin-top: 25px;
            padding: 20px;
            background-color: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .detail-row {
            margin-bottom: 15px;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: bold;
            color: #374151;
            display: inline-block;
            min-width: 120px;
        }
        .detail-value {
            color: #1f2937;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #6b7280;
            background-color: #f1f5f9;
            border-radius: 0 0 10px 10px;
        }
        .success-badge {
            background-color: #10b981;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            margin: 20px 0;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>NovaPlanner</h1>
        </div>
        
        <div class="content">
            <h2 style="color: #1f2937; margin-top: 0;">🎉 Uw afspraak is bevestigd!</h2>
            <p>Beste {{ $appointment->name }},</p>
            <p>Hartelijk dank voor het vertrouwen in NovaPlanner. Uw afspraak is succesvol geboekt en bevestigd.</p>
            
            <div class="success-badge">
                ✅ Afspraak Bevestigd
            </div>
            
            <div class="appointment-details">
                <h3 style="color: #374151; margin-top: 0; margin-bottom: 20px; font-size: 18px;">📋 Afspraak Details</h3>
                
                <div class="detail-row">
                    <span class="detail-label">👤 Naam:</span> 
                    <span class="detail-value">{{ $appointment->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">📧 E-mail:</span> 
                    <span class="detail-value">{{ $appointment->email }}</span>
                </div>
                @if($appointment->phone)
                <div class="detail-row">
                    <span class="detail-label">📞 Telefoon:</span> 
                    <span class="detail-value">{{ $appointment->phone }}</span>
                </div>
                @endif
                <div class="detail-row">
                    <span class="detail-label">📅 Datum:</span> 
                    <span class="detail-value">{{ $appointment->date->format('l, d F Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">🕐 Tijd:</span> 
                    <span class="detail-value">{{ $appointment->time }} (Nederlandse tijd)</span>
                </div>
                @if($appointment->notes)
                <div class="detail-row">
                    <span class="detail-label">📝 Opmerkingen:</span> 
                    <span class="detail-value">{{ $appointment->notes }}</span>
                </div>
                @endif
            </div>
            
            <div style="background-color: #e0f2fe; padding: 20px; border-radius: 8px; margin: 25px 0; border-left: 4px solid #0ea5e9;">
                <h4 style="color: #0c4a6e; margin: 0 0 10px 0;">ℹ️ Belangrijk om te weten:</h4>
                <ul style="color: #0c4a6e; margin: 0; padding-left: 20px;">
                    <li>Zorg ervoor dat u 5-10 minuten voor uw afspraak aanwezig bent</li>
                    <li>Bij wijzigingen, neem minimaal 24 uur van tevoren contact op</li>
                    <li>Neem eventuele benodigde documenten mee</li>
                </ul>
            </div>
            
            <p>Heeft u vragen of wilt u uw afspraak wijzigen? Neem gerust contact met ons op via <a href="mailto:info@novaplanner.nl" style="color: #3b82f6; text-decoration: none;">info@novaplanner.nl</a>.</p>
            
            <p style="margin-bottom: 0;"><strong>Met vriendelijke groet,</strong><br>
            <span style="color: #3b82f6; font-weight: bold;">Het NovaPlanner Team</span></p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} NovaPlanner. Alle rechten voorbehouden.</p>
        </div>
    </div>
</body>
</html> 