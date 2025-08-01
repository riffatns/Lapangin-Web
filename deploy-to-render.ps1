# PowerShell Script untuk Deploy ke Render
# Pastikan sudah ada API Key dan Service ID dari Render

param(
    [Parameter(Mandatory=$true)]
    [string]$ApiKey,
    
    [Parameter(Mandatory=$true)]
    [string]$ServiceId
)

Write-Host "🚀 Starting deployment to Render..." -ForegroundColor Green

# Check git status
$gitStatus = git status --porcelain
if ($gitStatus) {
    Write-Host "⚠️  There are uncommitted changes. Committing first..." -ForegroundColor Yellow
    git add .
    $commitMsg = Read-Host "Enter commit message (or press Enter for default)"
    if ([string]::IsNullOrEmpty($commitMsg)) {
        $commitMsg = "Deploy updates to Render - $(Get-Date -Format 'yyyy-MM-dd HH:mm')"
    }
    git commit -m $commitMsg
}

# Push to render-deployment branch
Write-Host "📤 Pushing to render-deployment branch..." -ForegroundColor Blue
git push origin render-deployment

# Trigger Render deployment via API
Write-Host "🔄 Triggering Render deployment..." -ForegroundColor Blue

$headers = @{
    "Authorization" = "Bearer $ApiKey"
    "Content-Type" = "application/json"
}

$uri = "https://api.render.com/v1/services/$ServiceId/deploys"

try {
    $response = Invoke-RestMethod -Uri $uri -Method POST -Headers $headers
    Write-Host "✅ Deployment triggered successfully!" -ForegroundColor Green
    Write-Host "Deploy ID: $($response.id)" -ForegroundColor Cyan
    Write-Host "Status: $($response.status)" -ForegroundColor Cyan
    
    # Monitor deployment status
    Write-Host "🔍 Monitoring deployment status..." -ForegroundColor Yellow
    
    do {
        Start-Sleep -Seconds 10
        $statusResponse = Invoke-RestMethod -Uri "https://api.render.com/v1/services/$ServiceId/deploys/$($response.id)" -Headers $headers
        Write-Host "Status: $($statusResponse.status)" -ForegroundColor Cyan
    } while ($statusResponse.status -eq "build_in_progress" -or $statusResponse.status -eq "update_in_progress")
    
    if ($statusResponse.status -eq "live") {
        Write-Host "🎉 Deployment completed successfully!" -ForegroundColor Green
        Write-Host "Your app is now live at: $($statusResponse.service.serviceDetails.url)" -ForegroundColor Green
    } else {
        Write-Host "❌ Deployment failed with status: $($statusResponse.status)" -ForegroundColor Red
    }
    
} catch {
    Write-Host "❌ Error triggering deployment: $($_.Exception.Message)" -ForegroundColor Red
    Write-Host "Make sure your API Key and Service ID are correct." -ForegroundColor Yellow
}
