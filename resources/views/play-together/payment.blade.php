<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - {{ $playTogether->title }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .back-nav {
            margin-bottom: 20px;
        }

        .back-nav a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 10px 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .back-nav a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .payment-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .payment-header h1 {
            color: #2c3e50;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .event-info {
            color: #6b7280;
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .payment-amount {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 12px 20px;
            border-radius: 15px;
            font-size: 1.3rem;
            font-weight: 700;
        }

        .payment-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .payment-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 1.4rem;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .payment-info {
            background: rgba(243, 244, 246, 0.8);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #374151;
        }

        .info-value {
            color: #6b7280;
            font-weight: 500;
        }

        .payment-method {
            background: rgba(59, 130, 246, 0.1);
            border: 2px solid rgba(59, 130, 246, 0.2);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .method-title {
            font-weight: 600;
            color: #1d4ed8;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .method-details {
            color: #374151;
            line-height: 1.6;
        }

        .upload-section {
            margin-top: 20px;
        }

        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
            margin-bottom: 15px;
        }

        .file-upload input[type=file] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 20px;
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            background: rgba(249, 250, 251, 0.8);
            color: #6b7280;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-upload-label:hover {
            border-color: #6366f1;
            background: rgba(99, 102, 241, 0.05);
            color: #6366f1;
        }

        .file-upload.has-file .file-upload-label {
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .payment-status {
            margin-bottom: 20px;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-pending { background: #fef3c7; color: #92400e; }
        .status-paid { background: #dcfce7; color: #166534; }
        .status-verified { background: #dbeafe; color: #1d4ed8; }
        .status-rejected { background: #fef2f2; color: #dc2626; }

        .payment-history {
            margin-top: 20px;
        }

        .history-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: rgba(249, 250, 251, 0.8);
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .history-icon {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        .history-icon.upload { background: #dbeafe; color: #1d4ed8; }
        .history-icon.verify { background: #dcfce7; color: #166534; }
        .history-icon.reject { background: #fef2f2; color: #dc2626; }

        .history-content {
            flex: 1;
        }

        .history-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 2px;
        }

        .history-time {
            font-size: 0.85rem;
            color: #9ca3af;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
            width: 100%;
            justify-content: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .alert-info {
            background: #dbeafe;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        @media (max-width: 768px) {
            body { padding: 10px; }
            .payment-content { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="back-nav">
            <a href="{{ route('play-together.show', $playTogether) }}">
                <i class="fas fa-arrow-left"></i> Kembali ke Event
            </a>
        </div>

        <div class="payment-header">
            <h1><i class="fas fa-credit-card"></i> Payment</h1>
            <div class="event-info">
                <strong>{{ $playTogether->title }}</strong><br>
                {{ \Carbon\Carbon::parse($playTogether->scheduled_date)->format('d M Y') }} - 
                {{ \Carbon\Carbon::parse($playTogether->scheduled_time)->format('H:i') }} WIB
            </div>
            <div class="payment-amount">
                <i class="fas fa-money-bill-wave"></i>
                Rp {{ number_format((float)($paymentAmount ?? 0), 0, ',', '.') }}
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="payment-content">
            <!-- Payment Information -->
            <div class="payment-section">
                <h2 class="section-title">
                    <i class="fas fa-info-circle"></i> Payment Information
                </h2>

                <div class="payment-info">
                    <div class="info-item">
                        <span class="info-label">Event Price</span>
                        <span class="info-value">Rp {{ number_format((float)($playTogether->price_per_person ?? 0), 0, ',', '.') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Payment Method</span>
                        <span class="info-value">{{ ucfirst(str_replace('_', ' ', $playTogether->payment_method ?? 'per_person')) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Your Amount</span>
                        <span class="info-value">Rp {{ number_format((float)($paymentAmount ?? 0), 0, ',', '.') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status</span>
                        <span class="info-value">
                            @if($userPayment)
                                <span class="status-badge status-{{ $userPayment->status }}">
                                    <i class="fas fa-{{ $userPayment->status == 'paid' ? 'check' : ($userPayment->status == 'verified' ? 'shield-alt' : ($userPayment->status == 'rejected' ? 'times' : 'clock')) }}"></i>
                                    {{ ucfirst($userPayment->status) }}
                                </span>
                            @else
                                <span class="status-badge status-pending">
                                    <i class="fas fa-clock"></i>
                                    Not Paid
                                </span>
                            @endif
                        </span>
                    </div>
                </div>

                <div class="payment-method">
                    <div class="method-title">
                        <i class="fas fa-university"></i>
                        Transfer Bank
                    </div>
                    <div class="method-details">
                        <strong>Bank BCA</strong><br>
                        No. Rekening: <strong>1234567890</strong><br>
                        A.n: <strong>{{ $playTogether->organizer->name ?? 'Event Organizer' }}</strong><br><br>
                        <small><i class="fas fa-info-circle"></i> Transfer sesuai nominal dan upload bukti pembayaran</small>
                    </div>
                </div>

                @if($userPayment && $userPayment->status == 'rejected')
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Payment Rejected</strong><br>
                            {{ $userPayment->admin_notes ?? 'Bukti pembayaran tidak valid. Silakan upload ulang.' }}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Upload Section -->
            <div class="payment-section">
                <h2 class="section-title">
                    <i class="fas fa-upload"></i> Upload Proof
                </h2>

                @if(!$userPayment || $userPayment->status == 'rejected')
                    <form action="{{ route('play-together.payment.upload', $playTogether) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="upload-section">
                            <div class="file-upload" id="fileUpload">
                                <input type="file" name="payment_proof" id="paymentProof" accept="image/*" required>
                                <label for="paymentProof" class="file-upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span id="uploadText">Choose payment proof image</span>
                                </label>
                            </div>
                            
                            <div style="margin-bottom: 15px;">
                                <textarea name="notes" placeholder="Additional notes (optional)" 
                                          style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; resize: vertical; min-height: 80px;"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i>
                                Upload Payment Proof
                            </button>
                        </div>
                    </form>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-check-circle"></i>
                        Payment proof has been uploaded and is being processed.
                    </div>
                    
                    @if($userPayment->proof_image)
                        <div style="text-align: center; margin: 20px 0;">
                            <img src="{{ Storage::url($userPayment->proof_image) }}" 
                                 alt="Payment Proof" 
                                 style="max-width: 100%; max-height: 300px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                        </div>
                    @endif
                @endif

                <!-- Payment History -->
                @if($userPayment)
                    <div class="payment-history">
                        <h3 style="color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem;">
                            <i class="fas fa-history"></i> Payment History
                        </h3>
                        
                        <div class="history-item">
                            <div class="history-icon upload">
                                <i class="fas fa-upload"></i>
                            </div>
                            <div class="history-content">
                                <div class="history-title">Payment proof uploaded</div>
                                <div class="history-time">{{ $userPayment->created_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>
                        
                        @if($userPayment->verified_at)
                            <div class="history-item">
                                <div class="history-icon verify">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="history-content">
                                    <div class="history-title">Payment verified</div>
                                    <div class="history-time">{{ $userPayment->verified_at->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                        @endif
                        
                        @if($userPayment->rejected_at)
                            <div class="history-item">
                                <div class="history-icon reject">
                                    <i class="fas fa-times"></i>
                                </div>
                                <div class="history-content">
                                    <div class="history-title">Payment rejected</div>
                                    <div class="history-time">{{ $userPayment->rejected_at->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // File upload preview
        document.getElementById('paymentProof').addEventListener('change', function() {
            const fileUpload = document.getElementById('fileUpload');
            const uploadText = document.getElementById('uploadText');
            
            if (this.files && this.files[0]) {
                fileUpload.classList.add('has-file');
                uploadText.textContent = this.files[0].name;
            } else {
                fileUpload.classList.remove('has-file');
                uploadText.textContent = 'Choose payment proof image';
            }
        });
    </script>
</body>
</html>