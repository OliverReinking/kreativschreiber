#!/bin/sh -l

npm install

git add .
git commit -m "npm install durchgeführt, nodes vorher komplett gelöscht."
git push
