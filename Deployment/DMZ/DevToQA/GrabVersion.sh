#!/bin/bash

#arg 1 = VersionName

#Part1: Using SSH, Send zip file to Deployment Server from Dev Server
sshpass -p 'Steelers1243' ssh -o StrictHostKeyChecking=no michaeldemusso@25.58.26.210 'bash -s' < CreateVersion.sh $1;
sshpass -p 'Steelers1243' scp -r michaeldemusso@25.58.26.210:/home/michaeldemusso/Versions/$1.zip /Versions

#Part2: Run PHP Script to Write Entry to SQL
php WriteFromDev.php $1 ;

#Part3: Using SSH, Install New Version on QA Machine
sshpass -p 'Steelers1243' scp -r /Versions/$1.zip michael@25.88.2.255:/home/michael/Versions/$1.zip;
sshpass -p 'Steelers1243' ssh -o strictHostKeyChecking=no michael@25.88.2.255 'bash -s' < RecieveVersion.sh $1 ;
