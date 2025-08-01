# Backup original package.json
cp package.json package.json.bak

# Create minimal package.json to prevent Vite build
cat > package.json << 'EOF'
{
    "name": "lapangin-web-render",
    "private": true,
    "scripts": {
        "build": "echo 'No build required for Laravel backend'"
    }
}
EOF

echo "✅ Package.json updated for Render deployment"
