<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verification - {{ config('app.name') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 20px;
            min-height: 100vh;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #FF6B6B, #FF8E8E);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .header p {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .content {
            padding: 50px 30px;
            text-align: center;
        }
        
        .greeting {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .message {
            font-size: 16px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 40px;
        }
        
        .otp-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
        }
        
        .otp-label {
            color: white;
            font-size: 16px;
            margin-bottom: 15px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .otp-code {
            background: white;
            color: #333;
            font-size: 36px;
            font-weight: 700;
            padding: 20px 40px;
            border-radius: 10px;
            display: inline-block;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            border: 3px solid #f0f0f0;
        }
        
        .expiry-info {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 10px;
            padding: 20px;
            margin: 30px 0;
            color: #856404;
        }
        
        .expiry-info .icon {
            font-size: 20px;
            margin-bottom: 10px;
        }
        
        .warning {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            color: #721c24;
            font-size: 14px;
        }
        
        .footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        
        .footer p {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .brand {
            color: #FF6B6B;
            font-weight: 700;
            text-decoration: none;
        }
        
        .steps {
            text-align: left;
            margin: 30px 0;
        }
        
        .step {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        
        .step-number {
            background: #FF6B6B;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .step-text {
            color: #333;
            font-size: 14px;
            line-height: 1.5;
        }
        
        @media (max-width: 600px) {
            .container {
                margin: 0;
                border-radius: 0;
            }
            
            .header, .content, .footer {
                padding: 30px 20px;
            }
            
            .otp-code {
                font-size: 28px;
                padding: 15px 30px;
                letter-spacing: 5px;
            }
            
            .greeting {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🍕 {{ __('translate.favorite_food_app', ['name' => config('app.name', 'Foodigo')]) }}</h1>
            <p>{{ __('translate.favorite_food_app') }}</p>
        </div>
        @php 
            $user = $mail_message['user'];
            $otp = $mail_message['otp'];
            $expiryMinutes = $mail_message['expiryMinutes'];
        @endphp
        
        <div class="content">
            <div class="greeting">
                {{ __('translate.hello', ['name' => $user->name]) }} 👋
            </div>
            
            <div class="message">
                {!! __('translate.welcome_message', ['app_name' => config('app.name', 'Foodigo')]) !!}
            </div>
            
            <div class="otp-container">
                <div class="otp-label">{{ __('translate.verification_code') }}</div>
                <div class="otp-code">{{ $otp }}</div>
            </div>
            
            <div class="expiry-info">
                <div class="icon">⏰</div>
                {!! __('translate.expiry_notice', ['minutes' => $expiryMinutes]) !!}
            </div>
            
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-text">{{ __('translate.step_1', ['app_name' => config('app.name')]) }}</div>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-text">{{ __('translate.step_2') }}</div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-text">{{ __('translate.step_3') }}</div>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <div class="step-text">{{ __('translate.step_4') }}</div>
                </div>
            </div>
            
            <div class="warning">
                {!! __('translate.security_notice') !!}
            </div>
        </div>
        
        <div class="footer">
            <p>{!! __('translate.sent_by', ['app_name' => config('app.name', 'Foodigo')]) !!}</p>
            <p>{{ __('translate.copyright', ['year' => date('Y'), 'app_name' => config('app.name', 'Foodigo')]) }}</p>
            <p style="margin-top: 20px; font-size: 12px;">
                {{ __('translate.help_text') }}
            </p>
        </div>
    </div>
</body>
</html>
