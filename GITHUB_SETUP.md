# GitHub Setup Guide for Jeki Bakers Website

## Prerequisites
You need to have Git installed. Download from: https://git-scm.com/download/win

After installing Git, restart your terminal.

## Step 1: Initialize Local Git Repository

```powershell
cd C:\jeki-bakers-website
git init
git config user.name "Your Name"
git config user.email "your-email@jekibakers.co.ke"
```

## Step 2: Create .gitignore (Already Done ✅)
The `.gitignore` file is already in your project to exclude sensitive files.

## Step 3: Add All Files to Git

```powershell
git add .
git status
```

## Step 4: Create Initial Commit

```powershell
git commit -m "Initial commit: Complete Jeki Bakers website with PHP backend, MySQL database, and professional frontend"
```

## Step 5: Create Repository on GitHub

1. Go to https://github.com/new
2. **Repository name**: `jeki` (as you requested)
3. **Description**: Professional e-commerce bakery website for Jeki Bakers Kenya
4. **Public** or **Private**: Choose based on your preference
5. **Initialize with**: Leave unchecked (we already have files)
6. Click "Create repository"

## Step 6: Add Remote and Push

After creating the repository on GitHub, you'll see commands like:

```powershell
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/jeki.git
git push -u origin main
```

Replace `YOUR_USERNAME` with your actual GitHub username.

## Step 7: Verify on GitHub

Visit: https://github.com/YOUR_USERNAME/jeki

You should see all your files uploaded!

---

## Complete Commands (Copy & Paste)

After installing Git, run these commands in PowerShell:

```powershell
# Navigate to project
cd C:\jeki-bakers-website

# Initialize git
git init
git config user.name "Your Name"
git config user.email "your@email.com"

# Add all files
git add .

# Create first commit
git commit -m "Initial commit: Jeki Bakers website - PHP, MySQL, Modern Frontend"

# Add GitHub remote (replace YOUR_USERNAME)
git remote add origin https://github.com/YOUR_USERNAME/jeki.git

# Push to GitHub
git branch -M main
git push -u origin main
```

---

## Verify It Worked

After pushing, verify by:
1. Going to https://github.com/YOUR_USERNAME/jeki
2. You should see all your files there
3. The repository description should show

---

## GitHub README

Your repository will automatically display `README.md` as the homepage. 
Our comprehensive README.md is already in place and will look great on GitHub! ✅

---

## Next Steps After Uploading

1. ✅ Update repository description on GitHub
2. ✅ Add topics: `php`, `bakery`, `ecommerce`, `website`
3. ✅ Enable GitHub Pages (optional, for demo site)
4. ✅ Add collaborators if needed
5. ✅ Set up deployment webhooks (optional)

---

## Important Notes

- **Git must be installed first**: https://git-scm.com/download/win
- **Create GitHub account**: https://github.com/signup (if you don't have one)
- **SSH vs HTTPS**: Use HTTPS for easier authentication initially
- **All sensitive files ignored**: `.env`, `config/database.php` are in `.gitignore` ✅

---

This guide will help you get everything on GitHub in about 5 minutes!
