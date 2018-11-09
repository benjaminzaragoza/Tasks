#!/bin/bash
cd /home/benjamin/Code/benjaminzaragoza/tasks/
git checkout production
git checkout .
git merge master
git checkout master
ssh tasks2DAM
