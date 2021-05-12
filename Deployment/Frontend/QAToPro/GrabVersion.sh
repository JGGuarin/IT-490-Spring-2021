#!/bin/bash

#arg 1 = VersionName


#Part1: Run PHP Script to Write Entry to SQL
php WriteFromQA.php $1 ;

#Part2: Using SSH, Install New Version on PROD Machine
sshpass -p 'ragingrabbits490' scp -r /Versions/$1.zip michelleproduction@25.1.211.206:/home/michelleproduction/Versions/$1.zip;
sshpass -p 'ragingrabbits490' ssh -o strictHostKeyChecking=no michelleproduction@25.1.211.206 'bash -s' < RecieveVersion.sh $1 ;
