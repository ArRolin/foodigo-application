<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Razorpay Payment</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .payment-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .payment_notify {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .payment_summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .payment_summary h3 {
            margin-top: 0;
            color: #495057;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 5px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .summary-item:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 18px;
        }
        .razorpay-payment-button {
            background: #007bff;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
        }
        .razorpay-payment-button:hover {
            background: #0056b3;
        }
        .error-message {
            color: #dc3545;
            text-align: center;
            padding: 10px;
            background: #f8d7da;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <h2 style="text-align: center; color: #333;">Razorpay Payment</h2>
        
        <p class="payment_notify">Please wait. Your payment is processing....</p>
        <p class="payment_notify">Do not press browser back or forward button while you are in payment page</p>

        @if(isset($payment_data) && $payment_data['success'])
            <div class="payment_summary">
                <h3>Order Summary</h3>
                <div class="summary-item">
                    <span>Items:</span>
                    <span>{{ $payment_data['data']['cart_summary']['item_count'] }}</span>
                </div>
                <div class="summary-item">
                    <span>Subtotal:</span>
                    <span>{{ number_format($payment_data['data']['cart_summary']['subtotal'], 2) }}</span>
                </div>
                <div class="summary-item">
                    <span>Delivery Charge:</span>
                    <span>{{ number_format($payment_data['data']['cart_summary']['delivery_charge'], 2) }}</span>
                </div>
                <div class="summary-item">
                    <span>VAT:</span>
                    <span>{{ number_format($payment_data['data']['cart_summary']['vat'], 2) }}</span>
                </div>
                @if($payment_data['data']['cart_summary']['discount_amount'] > 0)
                <div class="summary-item">
                    <span>Discount:</span>
                    <span>-{{ number_format($payment_data['data']['cart_summary']['discount_amount'], 2) }}</span>
                </div>
                @endif
                <div class="summary-item">
                    <span>Total Amount:</span>
                    <span>{{ number_format($payment_data['data']['cart_summary']['total_amount'], 2) }} {{ $payment_data['data']['currency'] }}</span>
                </div>
            </div>

            <button class="razorpay-payment-button" onclick="initiatePayment()">
                Pay {{ number_format($payment_data['data']['cart_summary']['total_amount'], 2) }} {{ $payment_data['data']['currency'] }}
            </button>
        @else
            <div class="error-message">
                Payment data not available. Please try again.
            </div>
        @endif
    </div>

    <script>
        function initiatePayment() {
            const paymentData = @json($payment_data ?? null);
            
            if (!paymentData || !paymentData.success) {
                alert('Payment data not available');
                return;
            }

            const options = {
                key: paymentData.data.razorpay_key,
                amount: paymentData.data.amount,
                currency: paymentData.data.currency,
                name: 'Foodigo',
                description: 'Food Order Payment',
                image: '{{ asset("favicon.ico") }}',
                handler: function (response) {
                    // Redirect to payment verification with payment token
                    const paymentToken = paymentData.data.payment_token;
                    const redirectUrl = `{{ route('payment-api.razorpay-webview-payment') }}?payment_token=${paymentToken}&razorpay_payment_id=${response.razorpay_payment_id}`;
                    window.location.href = redirectUrl;
                },
                prefill: {
                    name: '{{ Auth::user()->name ?? "" }}',
                    email: '{{ Auth::user()->email ?? "" }}',
                    contact: '{{ Auth::user()->phone ?? "" }}'
                },
                theme: {
                    color: '#007bff'
                }
            };

            const rzp = new Razorpay(options);
            rzp.open();
        }

        // Auto-initiate payment after page load
        $(document).ready(function() {
            setTimeout(function() {
                if ($('.razorpay-payment-button').length > 0) {
                    $('.razorpay-payment-button').click();
                }
            }, 2000);
        });
    </script>
</body>
</html>
