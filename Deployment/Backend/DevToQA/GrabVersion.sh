#!/bin/bash

#arg 1 = VersionName

#Part1: Using SSH, Send zip file to Deployment Server from Dev Server
sshpass -p 'fuck!!!' ssh -o StrictHostKeyChecking=no jayguarz@25.57.130.112 'bash -s' < CreateVersion.sh $1;
sshpass -p 'fuck!!!' scp -r jayguarz@25.57.130.112:/home/jayguarz/Versions/$1.zip /Versions

#Part2: Run PHP Script to Write Entry to SQL
php WriteFromDev.php $1 ;

#Part3: Using SSH, Install New Version on QA Machine
sshpass -p 'fuck!!!' scp -r /Versions/$1.zip jayquarzqa@25.69.254.182:/home/jayquarzqa/Versions/$1.zip;
sshpass -p 'fuck!!!' ssh -o strictHostKeyChecking=no jayquarzqa@25.69.254.182 'bash -s' < RecieveVersion.sh $1 ;
