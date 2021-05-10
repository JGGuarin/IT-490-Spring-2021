#!/bin/bash

#arg 1 = VersionName

#Part1: Using SSH, Send zip file to Deployment Server from Dev Server
sshpass -p 'fuck!!!' ssh -o StrictHostKeyChecking=no jayquarzqa@25.69.254.182 'bash -s' < CreateVersion.sh $1;
sshpass -p 'fuck!!!' scp -r jayquarqaz@25.69.254.182:/home/jayquarzqa/Versions/$1.zip /Versions

#Part2: Run PHP Script to Write Entry to SQL
php WriteFromQA.php $1 ;

#Part3: Using SSH, Install New Version on QA Machine
sshpass -p 'fuck!!!' scp -r /Versions/$1.zip jayguarzprod@25.92.111.80:/home/jayguarzprod/Versions/$1.zip;
sshpass -p 'fuck!!!' ssh -o strictHostKeyChecking=no jayguarzprod@25.92.111.80 'bash -s' < RecieveVersion.sh $1 ;
