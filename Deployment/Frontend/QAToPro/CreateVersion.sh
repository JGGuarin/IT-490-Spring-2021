#!/bin/bash


#arg 1 = VersionName
#part1: Zip Folder
cd /home/michelleqa/Versions ;
zip -r $1.zip /home/michelleqa/git ;
