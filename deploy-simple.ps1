# Simple Git-based Deploy Script
# Render akan otomatis deploy ketika ada push ke branch render-deployment

Write-Host "🚀 Deploying to Render via Git..." -ForegroundColor Green

# Check current branch
$currentBranch = git branch --show-current
Write-Host "Current branch: $currentBranch" -ForegroundColor Cyan

if ($currentBranch -ne "render-deployment") {
    Write-Host "🔄 Switching to render-deployment branch..." -ForegroundColor Yellow
    git checkout render-deployment
    
    # Merge dari branch sebelumnya jika diperlukan
    $mergeFromBranch = Read-Host "Merge from which branch? (press Enter to skip or type branch name)"
    if (![string]::IsNullOrEmpty($mergeFromBranch)) {
        Write-Host "🔀 Merging from $mergeFromBranch..." -ForegroundColor Blue
        git merge $mergeFromBranch
    }
}

# Check for changes
$gitStatus = git status --porcelain
if ($gitStatus) {
    Write-Host "📝 Found changes to commit..." -ForegroundColor Yellow
    git add .
    
    $commitMsg = Read-Host "Enter commit message (or press Enter for default)"
    if ([string]::IsNullOrEmpty($commitMsg)) {
        $commitMsg = "Deploy to Render - $(Get-Date -Format 'yyyy-MM-dd HH:mm')"
    }
    
    git commit -m $commitMsg
    Write-Host "✅ Changes committed" -ForegroundColor Green
} else {
    Write-Host "ℹ️  No changes to commit" -ForegroundColor Blue
}

# Push to trigger deployment
Write-Host "📤 Pushing to GitHub (will trigger Render deployment)..." -ForegroundColor Blue
git push origin render-deployment

Write-Host "🎉 Push completed! Render will automatically start deployment." -ForegroundColor Green
Write-Host "Check your Render dashboard for deployment progress." -ForegroundColor Cyan
Write-Host "Dashboard: https://dashboard.render.com/" -ForegroundColor Blue
