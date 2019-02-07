#!/bin/bash
cd /home/benjamin/Code/benjaminzaragoza/tasks/
npm run dev
git checkout master
git status
git add .
git commit -a -m "Sync"
git pull origin master
git push origin master
git status
echo -n "Esperant correció status MASTER, vols continuar?(s/n): "
read TECLA
if [ "$TECLA" = "n" ]
then
exit
fi
git checkout production
git status
echo -n "Esperant correció status PRODUCTION, vols continuar?(s/n): "
read TECLA
if [ "$TECLA" = "n" ]
then
exit
fi
git merge master
git status
echo -n "Esperant correció status MERGE, vols continuar?(s/n): "
read TECLA
if [ "$TECLA" = "n" ]
then
exit
fi
git add .
git commit -a -m "Sync"
git pull origin master
git push origin master
git status
git checkout master
git push --all origin
ssh tasks2DAM << EOF
cd tasks.benjaminzaragoza.scool.cat/
git pull origin production
EOF
