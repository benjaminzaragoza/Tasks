#!/bin/bash
cd /home/benjamin/Code/benjaminzaragoza/tasks/
npm run dev
git checkout master
git status
git add .
git commit -a -m "sync"
git pull origin master
git push origin master
git status
git checkout production
git merge master
git status
git add .
git commit -a -m "sync"
git pull origin master
git push origin master
git status
git checkout master
git push --all origin
ssh tasks2DAM << EOF
cd tasks.benjaminzaragoza.scool.cat/
php artisan migrate:fresh --seed
composer install
git pull origin production
EOF
