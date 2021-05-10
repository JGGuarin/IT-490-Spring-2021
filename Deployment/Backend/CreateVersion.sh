#!/bin/bash


#arg 1 = VersionName
#arg 2 = SourceFolder

#part1: Zip Folder
cd /home/michelle/Versions ;
zip -r $1.zip $2 ;
