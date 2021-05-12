#!/bin/bash

#arg 1 = VersionName


#Part1: Run PHP Script to Write Entry to SQL
php WriteFromQA.php $1 ;

#Part2: Using SSH, Install New Version on PROD Machine
sshpass -p 'Steelers1243' scp -r /Versions/$1.zip michael@25.92.30.52:/home/michael/Versions/$1.zip;
sshpass -p 'Steelers1243' ssh -o strictHostKeyChecking=no michael@25.92.30.52 'bash -s' < RecieveVersion.sh $1 ;
