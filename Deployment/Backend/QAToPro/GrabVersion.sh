#!/bin/bash

#arg 1 = VersionName


#Part1: Run PHP Script to Write Entry to SQL
php WriteFromQA.php $1 ;

#Part2: Using SSH, Install New Version on PROD Machine
sshpass -p 'fuck!!!' scp -r /Versions/$1.zip jayguarzprod@25.92.111.80:/home/jayguarzprod/Versions/$1.zip;
sshpass -p 'fuck!!!' ssh -o strictHostKeyChecking=no jayguarzprod@25.92.111.80 'bash -s' < RecieveVersion.sh $1 ;
