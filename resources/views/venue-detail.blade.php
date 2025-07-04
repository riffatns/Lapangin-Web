<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $venue->name }} - Detail Venue</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    html {
      scroll-behavior: smooth;
    }
    
    body {
      font-family: 'Inter', sans-serif;
      background-color: #0f0f0f;
      color: white;
      line-height: 1.6;
      overflow-x: hidden;
    }
    
    /* Navigation */
    .navbar {
      background: rgba(28, 28, 30, 0.95);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid #333;
      padding: 1rem 0;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
    }
    
    .nav-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 2rem;
    }
    
    .nav-brand {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 1.5rem;
      font-weight: 700;
      color: #f59e0b;
      text-decoration: none;
    }
    
    .nav-links {
      display: flex;
      gap: 2rem;
      align-items: center;
    }
    
    .nav-link {
      color: #ccc;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s ease;
    }
    
    .nav-link:hover {
      color: #f59e0b;
    }
    
    .btn-back {
      background: linear-gradient(135deg, #374151, #4b5563);
      color: white;
      padding: 0.75rem 1.5rem;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    
    .btn-back:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    
    /* Main Content */
    .main-content {
      margin-top: 80px;
      min-height: calc(100vh - 80px);
    }
    
    /* Hero Section */
    .hero-section {
      position: relative;
      min-height: 80vh;
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
      display: flex;
      align-items: center;
      overflow: hidden;
      padding: 2rem 0;
    }
    
    .hero-bg {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: 
        radial-gradient(circle at 20% 80%, rgba(245, 158, 11, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(59, 130, 246, 0.15) 0%, transparent 50%),
        linear-gradient(135deg, rgba(15, 23, 42, 0.8), rgba(30, 41, 59, 0.9));
      z-index: 0;
    }
    
    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 1400px;
      margin: 0 auto;
      padding: 3rem 2rem;
      display: grid;
      grid-template-columns: 1fr 600px;
      gap: 4rem;
      align-items: center;
      min-height: 600px;
    }
    
    .hero-info {
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }
    
    .venue-badge {
      display: inline-block;
      background: linear-gradient(135deg, #f59e0b, #d97706);
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 20px;
      font-size: 0.9rem;
      font-weight: 600;
      width: fit-content;
    }
    
    .venue-title {
      font-size: 3rem;
      font-weight: 800;
      background: linear-gradient(135deg, #f59e0b, #fbbf24);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      line-height: 1.1;
    }
    
    .venue-subtitle {
      font-size: 1.2rem;
      color: #9ca3af;
      margin-bottom: 1rem;
    }
    
    .venue-stats {
      display: flex;
      gap: 2rem;
      margin-bottom: 2rem;
    }
    
    .stat-item {
      text-align: center;
    }
    
    .stat-number {
      font-size: 1.8rem;
      font-weight: 700;
      color: #f59e0b;
    }
    
    .stat-label {
      font-size: 0.9rem;
      color: #9ca3af;
    }
    
    .hero-actions {
      display: flex;
      gap: 1rem;
    }
    
    /* Venue Gallery */
    .venue-gallery {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 1.5rem;
      height: 100%;
      max-height: 450px;
    }
    
    .main-image {
      background: linear-gradient(135deg, #374151, #4b5563);
      border-radius: 20px;
      position: relative;
      overflow: hidden;
      min-height: 350px;
      border: 3px solid rgba(255, 255, 255, 0.15);
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
      transition: all 0.3s ease;
    }
    
    .main-image:hover {
      transform: translateY(-5px);
      box-shadow: 0 25px 80px rgba(0, 0, 0, 0.5);
    }
    
    .main-image img {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 17px;
      transition: transform 0.3s ease;
    }
    
    .main-image:hover img {
      transform: scale(1.05);
    }
    
    .main-image::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(
        45deg, 
        rgba(0, 0, 0, 0.1), 
        rgba(0, 0, 0, 0.05),
        rgba(245, 158, 11, 0.05)
      );
      border-radius: 17px;
      z-index: 1;
    }
    
    .main-image .image-placeholder {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 5rem;
      color: white;
      text-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
      z-index: 2;
    }
    
    .gallery-thumbs {
      display: grid;
      grid-template-rows: repeat(3, 1fr);
      gap: 1rem;
    }
    
    .thumb-image {
      background: linear-gradient(135deg, #374151, #4b5563);
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
      color: #9ca3af;
      transition: all 0.3s ease;
      cursor: pointer;
      min-height: 100px;
      border: 2px solid rgba(255, 255, 255, 0.1);
      overflow: hidden;
      position: relative;
    }
    
    .thumb-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 14px;
      transition: transform 0.3s ease;
    }
    
    .thumb-image:hover {
      transform: translateY(-3px);
      border-color: #f59e0b;
      box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
    }
    
    .thumb-image:hover img {
      transform: scale(1.1);
    }
    
    .thumb-image span {
      font-weight: 700;
      font-size: 1.1rem;
    }
      min-height: 400px;
      background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
      overflow: hidden;
    }
    
    .hero-bg {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><rect width="1000" height="1000" fill="%23111827"/><polygon fill="%23374151" points="0,1000 1000,800 1000,1000"/><polygon fill="%23f59e0b" opacity="0.1" points="0,600 500,400 1000,600 1000,800 0,1000"/></svg>') center/cover;
    }
    
    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 1200px;
      margin: 0 auto;
      padding: 3rem 2rem;
      height: 100%;
      display: flex;
      align-items: flex-start;
      padding-top: 0;
    }
    
    .hero-info {
      flex: 1;
      max-width: 600px;
    }
    
    .venue-badge {
      background: linear-gradient(135deg, #f59e0b, #d97706);
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 20px;
      font-size: 0.9rem;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      margin-bottom: 1rem;
    }
    
    .venue-title {
      font-size: 3rem;
      font-weight: 800;
      margin-bottom: 1rem;
      background: linear-gradient(135deg, #fff, #ccc);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    .venue-subtitle {
      font-size: 1.2rem;
      color: #9ca3af;
      margin-bottom: 2rem;
    }
    
    .venue-stats {
      display: flex;
      gap: 2rem;
      margin-bottom: 2rem;
    }
    
    .stat-item {
      text-align: center;
    }
    
    .stat-number {
      font-size: 1.8rem;
      font-weight: 700;
      color: #f59e0b;
    }
    
    .stat-label {
      font-size: 0.9rem;
      color: #9ca3af;
    }
    
    .hero-actions {
      display: flex;
      gap: 1rem;
    }
    
    .btn-primary {
      background: linear-gradient(135deg, #f59e0b, #d97706);
      color: white;
      padding: 1rem 2rem;
      border: none;
      border-radius: 12px;
      font-weight: 700;
      font-size: 1.1rem;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    
    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 30px rgba(245, 158, 11, 0.4);
    }
    
    .btn-secondary {
      background: rgba(255, 255, 255, 0.1);
      color: white;
      padding: 1rem 2rem;
      border: 2px solid rgba(255, 255, 255, 0.2);
      border-radius: 12px;
      font-weight: 600;
      font-size: 1.1rem;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      backdrop-filter: blur(10px);
    }
    
    .btn-secondary:hover {
      background: rgba(255, 255, 255, 0.2);
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(255, 255, 255, 0.1);
    }
      box-shadow: 0 10px 30px rgba(245, 158, 11, 0.4);
    }
    
    .btn-secondary {
      background: rgba(255, 255, 255, 0.1);
      color: white;
      padding: 1rem 2rem;
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 12px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    
    .btn-secondary:hover {
      background: rgba(255, 255, 255, 0.2);
      transform: translateY(-2px);
    }
    
    /* Image Gallery */
    .gallery-section {
      position: absolute;
      right: 2rem;
      top: 50%;
      transform: translateY(-50%);
      width: 400px;
      height: 300px;
    }
    
    .gallery-grid {
      display: grid;
      grid-template-columns: 2fr 1fr;
      grid-template-rows: 1fr 1fr;
      gap: 0.5rem;
      height: 100%;
      border-radius: 16px;
      overflow: hidden;
    }
    
    .gallery-main {
      grid-row: 1 / -1;
      background: linear-gradient(45deg, #374151, #4b5563);
      border-radius: 12px;
      overflow: hidden;
      position: relative;
    }
    
    .gallery-thumb {
      background: linear-gradient(45deg, #6b7280, #9ca3af);
      border-radius: 8px;
      position: relative;
      overflow: hidden;
    }
    
    .gallery-overlay {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background: linear-gradient(transparent, rgba(0,0,0,0.8));
      padding: 1rem;
      color: white;
    }
    
    .gallery-more {
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0.6);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 700;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    
    .gallery-more:hover {
      background: rgba(0,0,0,0.4);
    }
    
    /* Content Sections */
    .content-wrapper {
      max-width: 1400px;
      margin: 0 auto;
      padding: 4rem 2rem;
    }
    
    .content-grid {
      display: grid;
      grid-template-columns: 1.8fr 1.2fr;
      gap: 4rem;
    }
    
    .main-content-area {
      display: flex;
      flex-direction: column;
      gap: 3rem;
    }
    
    .sidebar {
      position: sticky;
      top: 120px;
      height: fit-content;
    }
    
    /* Section Styles */
    .section {
      background: rgba(28, 28, 30, 0.8);
      border-radius: 20px;
      padding: 2rem;
      border: 1px solid #333;
    }
    
    .section-title {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      color: #f59e0b;
    }
    
    .section-description {
      color: #d1d5db;
      line-height: 1.8;
      margin-bottom: 2rem;
    }
    
    /* Features */
    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 1rem;
    }
    
    .feature-item {
      background: rgba(245, 158, 11, 0.1);
      border: 1px solid rgba(245, 158, 11, 0.3);
      border-radius: 12px;
      padding: 1rem;
      text-align: center;
      transition: transform 0.3s ease;
    }
    
    .feature-item:hover {
      transform: translateY(-2px);
    }
    
    .feature-icon {
      font-size: 1.5rem;
      margin-bottom: 0.5rem;
    }
    
    .feature-text {
      font-size: 0.9rem;
      color: #d1d5db;
    }
    
    /* Policies */
    .policies-list {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    
    .policy-item {
      display: flex;
      align-items: flex-start;
      gap: 1rem;
      background: rgba(28, 28, 30, 0.6);
      border-radius: 12px;
      padding: 1.5rem;
      border: 1px solid #333;
    }
    
    .policy-icon {
      font-size: 1.5rem;
      min-width: 2rem;
      text-align: center;
    }
    
    .policy-text {
      flex: 1;
      color: #d1d5db;
      line-height: 1.6;
    }
    
    .policy-text strong {
      color: #f59e0b;
      font-weight: 600;
    }
    
    /* Reviews */
    .reviews-list {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    
    .review-item {
      background: rgba(15, 15, 15, 0.8);
      border-radius: 12px;
      padding: 1.5rem;
      border: 1px solid #2d2d2d;
    }
    
    .review-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
    }
    
    .review-user {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    
    .review-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: linear-gradient(135deg, #f59e0b, #d97706);
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      color: white;
    }
    
    .review-name {
      font-weight: 600;
    }
    
    .review-rating {
      display: flex;
      align-items: center;
      gap: 0.25rem;
      color: #f59e0b;
    }
    
    .review-text {
      color: #d1d5db;
      line-height: 1.6;
    }
    
    /* Booking Card */
    .booking-card {
      background: linear-gradient(135deg, #1f2937, #111827);
      border-radius: 20px;
      padding: 2rem;
      border: 1px solid #374151;
      position: sticky;
      top: 120px;
    }

    .booking-header {
      margin-bottom: 1.5rem;
    }

    .booking-form-content {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .form-group-full {
      grid-column: 1 / -1;
    }

    .time-selection-area {
      grid-column: 1 / -1;
      display: grid;
      grid-template-columns: 1.5fr 1fr;
      gap: 2rem;
      margin-top: 1rem;
    }

    .selected-slots-area {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }
    
    .booking-title {
      font-size: 1.3rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
      color: #f59e0b;
    }
    
    .booking-price {
      font-size: 2rem;
      font-weight: 800;
      color: white;
      margin-bottom: 1.5rem;
    }
    
    .booking-form {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    
    .form-group {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }
    
    .form-label {
      font-weight: 600;
      color: #d1d5db;
    }
    
    .form-input {
      background: rgba(0, 0, 0, 0.5);
      border: 1px solid #4b5563;
      border-radius: 10px;
      padding: 0.75rem;
      color: white;
      font-size: 1rem;
      transition: border-color 0.3s ease;
    }
    
    .form-input:focus {
      outline: none;
      border-color: #f59e0b;
    }
    
    .form-select {
      background: rgba(0, 0, 0, 0.5);
      border: 1px solid #4b5563;
      border-radius: 10px;
      padding: 0.75rem;
      color: white;
      font-size: 1rem;
      cursor: pointer;
    }
    
    .time-slots {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 0.5rem;
      /* Remove overflow and max-height to prevent double scrolling */
    }
    
    .time-slot {
      padding: 0.75rem;
      border: 1px solid #4b5563;
      border-radius: 8px;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s ease;
      background: rgba(0, 0, 0, 0.3);
      font-size: 0.9rem;
      position: relative;
    }
    
    .time-slot:hover {
      border-color: #f59e0b;
      background: rgba(245, 158, 11, 0.1);
    }
    
    .time-slot.selected {
      background: linear-gradient(135deg, #f59e0b, #d97706);
      border-color: #f59e0b;
      color: white;
    }

    .time-slot.past {
      background: rgba(107, 114, 128, 0.2);
      border-color: #6b7280;
      color: #9ca3af;
      cursor: not-allowed;
      position: relative;
    }
    
    .time-slot.past:hover {
      border-color: #6b7280;
      background: rgba(107, 114, 128, 0.2);
    }

    .time-slot.past::after {
      content: '⏰';
      position: absolute;
      top: 2px;
      right: 4px;
      font-size: 0.7rem;
      opacity: 0.7;
    }

    .time-slot.booked {
      background: rgba(239, 68, 68, 0.2);
      border-color: #ef4444;
      color: #fca5a5;
      cursor: not-allowed;
      position: relative;
    }
    
    .time-slot.booked:hover {
      border-color: #ef4444;
      background: rgba(239, 68, 68, 0.2);
    }

    .time-slot.booked::after {
      content: '🚫';
      position: absolute;
      top: 2px;
      right: 4px;
      font-size: 0.7rem;
      opacity: 0.7;
    }
    
    .time-slots-container {
      max-height: 200px;
      overflow-y: auto;
      border: 1px solid #4b5563;
      border-radius: 10px;
      padding: 1rem;
      background: rgba(0, 0, 0, 0.2);
      /* Custom scrollbar */
      scrollbar-width: thin;
      scrollbar-color: #f59e0b rgba(0, 0, 0, 0.3);
      /* Smooth scrolling */
      scroll-behavior: smooth;
    }
    
    .time-slots-container::-webkit-scrollbar {
      width: 8px;
    }
    
    .time-slots-container::-webkit-scrollbar-track {
      background: rgba(0, 0, 0, 0.3);
      border-radius: 4px;
      margin: 2px;
    }
    
    .time-slots-container::-webkit-scrollbar-thumb {
      background: linear-gradient(135deg, #f59e0b, #d97706);
      border-radius: 4px;
      border: 1px solid rgba(0, 0, 0, 0.2);
      box-shadow: inset 0 1px 2px rgba(255, 255, 255, 0.2);
    }

    .time-slots-container::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(135deg, #d97706, #b45309);
      box-shadow: inset 0 1px 2px rgba(255, 255, 255, 0.3);
    }

    .time-slots-container::-webkit-scrollbar-thumb:active {
      background: linear-gradient(135deg, #b45309, #92400e);
    }

    .selected-slots-display {
      background: rgba(0, 0, 0, 0.3);
      border: 1px solid #4b5563;
      border-radius: 10px;
      padding: 1rem;
      min-height: 100px;
      max-height: 250px;
      overflow-y: auto;
    }

    .selected-slot-item {
      background: linear-gradient(135deg, #f59e0b, #d97706);
      color: white;
      padding: 0.5rem 0.75rem;
      border-radius: 8px;
      margin: 0.25rem;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.9rem;
      font-weight: 500;
    }

    .remove-slot {
      background: rgba(255, 255, 255, 0.2);
      border: none;
      border-radius: 50%;
      width: 20px;
      height: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 0.7rem;
    }

    .remove-slot:hover {
      background: rgba(255, 255, 255, 0.3);
    }

    .text-muted {
      color: #9ca3af;
      font-style: italic;
    }
    
    .booking-summary {
      background: rgba(0, 0, 0, 0.3);
      border-radius: 10px;
      padding: 1rem;
      margin: 1rem 0;
    }
    
    .summary-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 0.5rem;
    }
    
    .summary-total {
      font-weight: 700;
      font-size: 1.1rem;
      border-top: 1px solid #4b5563;
      padding-top: 0.5rem;
      margin-top: 0.5rem;
    }
    
    /* Similar Venues */
    .similar-venues {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
    }
    
    .venue-card {
      background: rgba(28, 28, 30, 0.8);
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid #333;
      transition: transform 0.3s ease;
      cursor: pointer;
    }
    
    .venue-card:hover {
      transform: translateY(-5px);
    }
    
    .venue-image {
      height: 150px;
      background: linear-gradient(45deg, #374151, #6b7280);
      position: relative;
    }
    
    .venue-info {
      padding: 1.5rem;
    }
    
    .venue-name {
      font-weight: 700;
      margin-bottom: 0.5rem;
    }
    
    .venue-location {
      color: #9ca3af;
      font-size: 0.9rem;
      margin-bottom: 1rem;
    }
    
    .venue-price-tag {
      background: linear-gradient(135deg, #f59e0b, #d97706);
      color: white;
      padding: 0.25rem 0.75rem;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
      .hero-content {
        grid-template-columns: 1fr;
        gap: 3rem;
        text-align: center;
        min-height: auto;
        padding: 2rem 1rem;
      }
      
      .venue-gallery {
        grid-template-columns: 1fr;
        grid-template-rows: 350px auto;
        gap: 1.5rem;
        max-height: none;
      }
      
      .gallery-thumbs {
        grid-template-columns: repeat(3, 1fr);
        grid-template-rows: 1fr;
        max-height: 120px;
      }
      
      .content-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
      }
      
      .venue-title {
        font-size: 2.5rem;
      }

      .booking-form-content {
        grid-template-columns: 1fr;
        gap: 1rem;
      }

      .time-selection-area {
        grid-template-columns: 1fr;
        gap: 1rem;
      }
    }
    
    @media (max-width: 768px) {
      .nav-container {
        padding: 0 1rem;
      }
      
      .hero-content {
        padding: 2rem 1rem;
        gap: 2rem;
      }
      
      .hero-section {
        min-height: 70vh;
      }
      
      .venue-title {
        font-size: 2rem;
      }
      
      .venue-stats {
        flex-direction: row;
        gap: 2rem;
        justify-content: center;
      }
      
      .hero-actions {
        flex-direction: column;
        align-items: center;
        gap: 1rem;
      }
      
      .btn-primary,
      .btn-secondary {
        width: 100%;
        justify-content: center;
      }
      
      .content-wrapper {
        padding: 2rem 1rem;
      }
      
      .time-slots {
        grid-template-columns: 1fr;
      }
      
      .venue-gallery {
        grid-template-rows: 280px auto;
      }
      
      .gallery-thumbs {
        grid-template-columns: repeat(3, 1fr);
        max-height: 100px;
      }
      
      .thumb-image {
        min-height: 80px;
        font-size: 1rem;
      }
      
      .main-image {
        min-height: 250px;
      }

      /* Mobile Booking Card Optimization */
      .booking-card {
        position: relative;
        top: auto;
        margin-bottom: 2rem;
      }

      .sidebar {
        position: relative;
        top: auto;
      }

      .booking-form-content {
        grid-template-columns: 1fr;
      }

      .time-selection-area {
        grid-template-columns: 1fr;
      }

      .time-slots {
        grid-template-columns: 1fr;
      }

      .time-slots-container {
        max-height: 200px;
      }

      .selected-slots-display {
        max-height: 150px;
      }
    }
  </style>
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar">
    <div class="nav-container">
      <a href="{{ route('dashboard') }}" class="nav-brand">
        <img src="{{ asset('img/Lapangin-White.png') }}" alt="Lapangin" style="height: 32px; width: auto;">
      </a>
      <div class="nav-links">
        <a href="{{ route('dashboard') }}" class="btn-back">
          ← Kembali ke Dashboard
        </a>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="main-content">
    <!-- Hero Section -->
    <section class="hero-section">
      <div class="hero-bg"></div>
      <div class="hero-content">
        <div class="hero-info">
          <div class="venue-badge">
            @switch($venue->sport->name)
              @case('Badminton')
                🏸 {{ $venue->sport->name }}
                @break
              @case('Futsal')
                ⚽ {{ $venue->sport->name }}
                @break
              @case('Tennis')
                🎾 {{ $venue->sport->name }}
                @break
              @case('Basketball')
                🏀 {{ $venue->sport->name }}
                @break
              @default
                🏅 {{ $venue->sport->name }}
            @endswitch
          </div>
          <h1 class="venue-title">{{ $venue->name }}</h1>
          <p class="venue-subtitle">{{ $venue->address }}, {{ $venue->city }}</p>
          
          <div class="venue-stats">
            <div class="stat-item">
              <div class="stat-number">{{ number_format($averageRating, 1) }}</div>
              <div class="stat-label">Rating</div>
            </div>
            <div class="stat-item">
              <div class="stat-number">{{ $reviews->count() }}</div>
              <div class="stat-label">Reviews</div>
            </div>
            <div class="stat-item">
              <div class="stat-number">{{ $venue->capacity ?? 10 }}</div>
              <div class="stat-label">Kapasitas</div>
            </div>
          </div>
          
          <div class="hero-actions">
            <button class="btn-primary" onclick="scrollToBooking()">
              📅 Book Sekarang
            </button>
            <button class="btn-secondary" onclick="shareVenue()">
              🔗 Share
            </button>
          </div>
        </div>
        
        <!-- Venue Gallery -->
        <div class="venue-gallery">
          <div class="main-image">
            @if($venue->main_image)
              <img src="{{ asset('img/venues/' . $venue->main_image) }}" 
                   alt="{{ $venue->name }}">
            @else
              <div class="image-placeholder">
                @switch($venue->sport->name)
                  @case('Badminton')
                    🏸
                    @break
                  @case('Futsal')
                    ⚽
                    @break
                  @case('Tennis')
                    🎾
                    @break
                  @case('Basketball')
                    🏀
                    @break
                  @default
                    🏅
                @endswitch
              </div>
            @endif
          </div>
          <div class="gallery-thumbs">
            @if($venue->gallery_images && count($venue->gallery_images) > 0)
              @foreach($venue->gallery_images as $index => $image)
                @if($index < 2)
                  <div class="thumb-image">
                    <img src="{{ asset('img/venues/' . $image) }}" 
                         alt="Gallery {{ $index + 1 }}">
                  </div>
                @endif
              @endforeach
              @if(count($venue->gallery_images) > 2)
                <div class="thumb-image">
                  <span>+{{ count($venue->gallery_images) - 2 }} more</span>
                </div>
              @elseif(count($venue->gallery_images) < 3)
                @for($i = count($venue->gallery_images); $i < 3; $i++)
                  <div class="thumb-image">📸</div>
                @endfor
              @endif
            @else
              <div class="thumb-image">📸</div>
              <div class="thumb-image">📸</div>
              <div class="thumb-image"><span>View All</span></div>
            @endif
          </div>
        </div>
      </div>
    </section>

    <!-- Content -->
    <div class="content-wrapper">
      <div class="content-grid">
        <!-- Main Content -->
        <div class="main-content-area">
          <!-- Deskripsi -->
          <section class="section">
            <h2 class="section-title">
              📝 Deskripsi Venue
            </h2>
            <p class="section-description">
              {{ $venue->description ?? 'Venue olahraga berkualitas tinggi dengan fasilitas lengkap dan modern. Cocok untuk berbagai aktivitas olahraga dan rekreasi.' }}
            </p>
          </section>

          <!-- Fasilitas -->
          <section class="section">
            <h2 class="section-title">
              ⚡ Fasilitas
            </h2>
            <div class="features-grid">
              @if($venue->facilities)
                @php
                  $facilities = is_array($venue->facilities) ? $venue->facilities : explode(',', $venue->facilities);
                @endphp
                @foreach($facilities as $facility)
                  <div class="feature-item">
                    <div class="feature-icon">
                      @switch(trim($facility))
                        @case('Shower')
                          🚿
                          @break
                        @case('Toilet')
                          🚻
                          @break
                        @case('Parking')
                          🅿️
                          @break
                        @case('Wi-Fi')
                          📶
                          @break
                        @case('AC')
                          ❄️
                          @break
                        @case('Locker')
                          🗄️
                          @break
                        @default
                          ✨
                      @endswitch
                    </div>
                    <div class="feature-text">{{ trim($facility) }}</div>
                  </div>
                @endforeach
              @else
                <div class="feature-item">
                  <div class="feature-icon">🚿</div>
                  <div class="feature-text">Shower</div>
                </div>
                <div class="feature-item">
                  <div class="feature-icon">🚻</div>
                  <div class="feature-text">Toilet</div>
                </div>
                <div class="feature-item">
                  <div class="feature-icon">🅿️</div>
                  <div class="feature-text">Parking</div>
                </div>
                <div class="feature-item">
                  <div class="feature-icon">📶</div>
                  <div class="feature-text">Wi-Fi</div>
                </div>
              @endif
            </div>
          </section>

          <!-- Venue Policies -->
          <section class="section">
            <h2 class="section-title">
              📋 Kebijakan Venue
            </h2>
            <div class="policies-list">
              <div class="policy-item">
                <div class="policy-icon">🕐</div>
                <div class="policy-text">
                  <strong>Jam Operasional:</strong> 06:00 - 22:00 WIB
                </div>
              </div>
              <div class="policy-item">
                <div class="policy-icon">❌</div>
                <div class="policy-text">
                  <strong>Pembatalan:</strong> Booking tidak dapat dibatalkan dan bersifat non-refundable
                </div>
              </div>
              <div class="policy-item">
                <div class="policy-icon">⚠️</div>
                <div class="policy-text">
                  <strong>Keterlambatan:</strong> Toleransi keterlambatan maksimal 15 menit
                </div>
              </div>
              <div class="policy-item">
                <div class="policy-icon">🚫</div>
                <div class="policy-text">
                  <strong>Larangan:</strong> Dilarang merokok, membawa makanan dari luar, dan minuman beralkohol
                </div>
              </div>
              <div class="policy-item">
                <div class="policy-icon">💳</div>
                <div class="policy-text">
                  <strong>Pembayaran:</strong> Pembayaran harus dilakukan sebelum bermain
                </div>
              </div>
            </div>
          </section>

          <!-- Reviews -->
          @if($reviews->count() > 0)
          <section class="section">
            <h2 class="section-title">
              ⭐ Reviews ({{ $reviews->count() }})
            </h2>
            <div class="reviews-list">
              @foreach($reviews->take(5) as $review)
              <div class="review-item">
                <div class="review-header">
                  <div class="review-user">
                    <div class="review-avatar">
                      {{ strtoupper(substr($review->user->name, 0, 1)) }}
                    </div>
                    <div>
                      <div class="review-name">{{ $review->user->name }}</div>
                      <div class="review-rating">
                        @for($i = 1; $i <= 5; $i++)
                          {{ $i <= $review->rating ? '⭐' : '☆' }}
                        @endfor
                      </div>
                    </div>
                  </div>
                </div>
                <p class="review-text">{{ $review->review }}</p>
              </div>
              @endforeach
            </div>
          </section>
          @endif

          <!-- Similar Venues -->
          @if($similarVenues->count() > 0)
          <section class="section">
            <h2 class="section-title">
              🏟️ Venue Serupa
            </h2>
            <div class="similar-venues">
              @foreach($similarVenues as $similar)
              <div class="venue-card" onclick="location.href='{{ route('venue.show', $similar) }}'">
                <div class="venue-image"></div>
                <div class="venue-info">
                  <h3 class="venue-name">{{ $similar->name }}</h3>
                  <p class="venue-location">{{ $similar->address }}</p>
                  <span class="venue-price-tag">Rp {{ number_format($similar->price_per_hour) }}/jam</span>
                </div>
              </div>
              @endforeach
            </div>
          </section>
          @endif
        </div>

        <!-- Sidebar - Booking Card -->
        <div class="sidebar">
          <div class="booking-card" id="booking-section">
            <!-- Booking Header -->
            <div class="booking-header">
              <h3 class="booking-title">💰 Book Venue</h3>
              <div class="booking-price">
                Rp {{ number_format($venue->price_per_hour) }}
                <span style="font-size: 0.6em; color: #9ca3af;">/ jam</span>
              </div>
            </div>

            <form action="{{ route('venue.book', $venue) }}" method="POST" class="booking-form">
              @csrf
              
              <!-- Booking Form Content -->
              <div class="booking-form-content">
                <!-- Date Selection -->
                <div class="form-group">
                  <label class="form-label">📅 Pilih Tanggal</label>
                  <input type="date" name="booking_date" class="form-input" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required>
                  <small style="color: #9ca3af; font-size: 0.8rem; margin-top: 0.5rem; display: block;">
                    Waktu sekarang: {{ date('H:i') }} WIB
                  </small>
                </div>

                <!-- Summary Section -->
                <div class="form-group">
                  <label class="form-label">💰 Ringkasan</label>
                  <div class="booking-summary">
                    <div class="summary-row">
                      <span>Harga/jam:</span>
                      <span>Rp {{ number_format($venue->price_per_hour) }}</span>
                    </div>
                    <div class="summary-row">
                      <span>Durasi:</span>
                      <span id="duration-display">0 jam</span>
                    </div>
                    <div class="summary-row summary-total">
                      <span>Total:</span>
                      <span id="total-price">Rp 0</span>
                    </div>
                  </div>
                </div>

                <!-- Time Selection Area -->
                <div class="time-selection-area">
                  <!-- Time Slots -->
                  <div class="form-group">
                    <label class="form-label">⏰ Pilih Waktu</label>
                    
                    <!-- Compact Legend -->
                    <div style="display: flex; gap: 0.75rem; margin-bottom: 0.75rem; font-size: 0.75rem; color: #9ca3af; flex-wrap: wrap;">
                      <div style="display: flex; align-items: center; gap: 0.25rem;">
                        <div style="width: 8px; height: 8px; background: rgba(0, 0, 0, 0.3); border: 1px solid #4b5563; border-radius: 2px;"></div>
                        <span>Tersedia</span>
                      </div>
                      <div style="display: flex; align-items: center; gap: 0.25rem;">
                        <div style="width: 8px; height: 8px; background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; border-radius: 2px;"></div>
                        <span>Booked</span>
                      </div>
                      <div style="display: flex; align-items: center; gap: 0.25rem;">
                        <div style="width: 8px; height: 8px; background: rgba(107, 114, 128, 0.2); border: 1px solid #6b7280; border-radius: 2px;"></div>
                        <span>Lewat</span>
                      </div>
                    </div>
                    
                    <div class="time-slots-container">
                      <div class="time-slots">
                        @foreach($timeSlots as $time => $label)
                          @php
                            $isBooked = in_array($time, $bookedSlots);
                            $isPast = in_array($time, $pastSlots ?? []);
                            $cssClass = '';
                            if ($isBooked) {
                              $cssClass = 'booked';
                            } elseif ($isPast) {
                              $cssClass = 'past';
                            }
                          @endphp
                          <div class="time-slot {{ $cssClass }}" 
                               data-time="{{ $time }}" 
                               onclick="toggleTimeSlot(this, '{{ $time }}')">
                            {{ $label }}
                          </div>
                        @endforeach
                      </div>
                    </div>
                    <input type="hidden" name="selected_slots" id="selected_slots" required>
                    <input type="hidden" name="duration" id="total_duration" required>
                  </div>

                  <!-- Selected Slots -->
                  <div class="selected-slots-area">
                    <label class="form-label">📋 Slot Dipilih</label>
                    <div id="selected-slots-display" class="selected-slots-display">
                      <p class="text-muted">Belum ada slot yang dipilih</p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Book Button -->
              <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; margin-top: 1rem;">
                🏃‍♂️ Book Sekarang
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
    let selectedTimeSlots = [];
    const pricePerHour = {{ $venue->price_per_hour }};
    const timeLabels = {
      @foreach($timeSlots as $time => $label)
        '{{ $time }}': '{{ $label }}',
      @endforeach
    };

    function toggleTimeSlot(element, time) {
      if (element.classList.contains('booked')) {
        Swal.fire({
          title: 'Slot Tidak Tersedia',
          text: 'Waktu ini sudah dibooking oleh orang lain',
          icon: 'warning',
          background: '#1f2937',
          color: '#fff',
          confirmButtonColor: '#f59e0b'
        });
        return;
      }

      if (element.classList.contains('past')) {
        Swal.fire({
          title: 'Waktu Sudah Lewat',
          text: 'Tidak dapat booking untuk waktu yang sudah terlewat',
          icon: 'info',
          background: '#1f2937',
          color: '#fff',
          confirmButtonColor: '#f59e0b'
        });
        return;
      }

      // Check if slot is already selected
      const slotIndex = selectedTimeSlots.indexOf(time);
      
      if (slotIndex > -1) {
        // Remove slot
        selectedTimeSlots.splice(slotIndex, 1);
        element.classList.remove('selected');
      } else {
        // Add slot
        selectedTimeSlots.push(time);
        element.classList.add('selected');
      }

      // Sort slots chronologically
      selectedTimeSlots.sort();
      
      updateSelectedSlotsDisplay();
      updateTotal();
      updateHiddenInputs();
    }

    function removeSlot(time) {
      const slotIndex = selectedTimeSlots.indexOf(time);
      if (slotIndex > -1) {
        selectedTimeSlots.splice(slotIndex, 1);
        
        // Remove visual selection
        const slotElement = document.querySelector(`[data-time="${time}"]`);
        if (slotElement) {
          slotElement.classList.remove('selected');
        }
        
        updateSelectedSlotsDisplay();
        updateTotal();
        updateHiddenInputs();
      }
    }

    function updateSelectedSlotsDisplay() {
      const displayContainer = document.getElementById('selected-slots-display');
      
      if (selectedTimeSlots.length === 0) {
        displayContainer.innerHTML = '<p class="text-muted">Belum ada slot yang dipilih</p>';
        return;
      }

      let html = '';
      selectedTimeSlots.forEach(time => {
        html += `
          <div class="selected-slot-item">
            <span>${timeLabels[time]}</span>
            <button type="button" class="remove-slot" onclick="removeSlot('${time}')">
              ×
            </button>
          </div>
        `;
      });
      
      displayContainer.innerHTML = html;
    }

    function updateTotal() {
      const duration = selectedTimeSlots.length;
      const total = pricePerHour * duration;
      
      if (duration === 0) {
        document.getElementById('duration-display').textContent = '0 jam';
        document.getElementById('total-price').textContent = 'Rp 0';
      } else {
        document.getElementById('duration-display').textContent = duration + ' jam';
        document.getElementById('total-price').textContent = 'Rp ' + total.toLocaleString('id-ID');
      }
    }

    function updateHiddenInputs() {
      document.getElementById('selected_slots').value = JSON.stringify(selectedTimeSlots);
      document.getElementById('total_duration').value = selectedTimeSlots.length;
    }

    function scrollToBooking() {
      document.getElementById('booking-section').scrollIntoView({ 
        behavior: 'smooth' 
      });
    }

    function shareVenue() {
      const url = window.location.href;
      const title = '{{ $venue->name }} - Lapangin';
      
      if (navigator.share) {
        navigator.share({
          title: title,
          url: url
        });
      } else {
        navigator.clipboard.writeText(url).then(() => {
          Swal.fire({
            title: 'Link Copied!',
            text: 'Link venue berhasil disalin ke clipboard',
            icon: 'success',
            background: '#1f2937',
            color: '#fff',
            confirmButtonColor: '#f59e0b'
          });
        });
      }
    }

    // Success/Error Messages
    @if(session('success'))
      Swal.fire({
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        icon: 'success',
        background: '#1f2937',
        color: '#fff',
        confirmButtonColor: '#f59e0b'
      });
    @endif

    @if(session('error'))
      Swal.fire({
        title: 'Error!',
        text: '{{ session('error') }}',
        icon: 'error',
        background: '#1f2937',
        color: '#fff',
        confirmButtonColor: '#f59e0b'
      });
    @endif

    // Form validation
    document.querySelector('.booking-form').addEventListener('submit', function(e) {
      if (selectedTimeSlots.length === 0) {
        e.preventDefault();
        Swal.fire({
          title: 'Pilih Waktu',
          text: 'Silakan pilih minimal satu slot waktu',
          icon: 'warning',
          background: '#1f2937',
          color: '#fff',
          confirmButtonColor: '#f59e0b'
        });
      }
    });

    // Update slot status when date changes
    document.querySelector('input[name="booking_date"]').addEventListener('change', function(e) {
      const selectedDate = e.target.value;
      
      // Clear selected slots when date changes
      selectedTimeSlots = [];
      updateSelectedSlotsDisplay();
      updateTotal();
      updateHiddenInputs();
      
      // Show loading state
      document.querySelectorAll('.time-slot').forEach(slot => {
        slot.style.opacity = '0.5';
        slot.style.pointerEvents = 'none';
      });
      
      // Fetch updated booking data from server
      fetch(`{{ route('venue.booking-data', $venue->id) }}?date=${selectedDate}`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
      })
      .then(response => response.json())
      .then(data => {
        // Update slot status based on server response
        document.querySelectorAll('.time-slot').forEach(slot => {
          const slotTime = slot.getAttribute('data-time');
          
          // Remove all status classes first
          slot.classList.remove('selected', 'past', 'booked');
          slot.style.opacity = '1';
          slot.style.pointerEvents = 'auto';
          
          // Check if slot is past current time (only for today)
          if (data.pastSlots.includes(slotTime)) {
            slot.classList.add('past');
            slot.style.pointerEvents = 'none';
            slot.title = 'Waktu sudah berlalu';
          }
          // Check if slot is booked
          else if (data.bookedSlots.includes(slotTime)) {
            slot.classList.add('booked');
            slot.style.pointerEvents = 'none';
            slot.title = 'Slot sudah dibooking';
          }
          // Slot is available
          else {
            slot.style.pointerEvents = 'auto';
            slot.title = 'Klik untuk memilih slot ini';
          }
        });
      })
      .catch(error => {
        console.error('Error fetching booking data:', error);
        
        // Reset slots to available state on error
        document.querySelectorAll('.time-slot').forEach(slot => {
          slot.classList.remove('selected', 'past', 'booked');
          slot.style.opacity = '1';
          slot.style.pointerEvents = 'auto';
          slot.title = 'Klik untuk memilih slot ini';
        });
        
        // Show error message
        Swal.fire({
          title: 'Error',
          text: 'Gagal memuat data booking. Silakan refresh halaman.',
          icon: 'error',
          background: '#1f2937',
          color: '#fff',
          confirmButtonColor: '#f59e0b'
        });
      });
    });
  </script>
</body>
</html>
