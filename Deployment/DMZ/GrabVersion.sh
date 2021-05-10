#!/bin/bash

#arg 1 = VersionName
#arg 2 = SourceFolder
#arg 3 = DestinationFolder
#arg 4 = DevIPaddr
#arg 5 = QAIPaddr

#Part1: Using SSH, Send zip file to Deployment Server from Dev Server
ssh -o StrictHostKeyChecking=no michelle@$4 'bash -s' < CreateVersion.sh $1 $2 ;
scp -r michelle@$4:/home/michelle/Versions/$1.zip /git/Versions

#Part2: Run PHP Script to Write Entry to SQL
php WriteFromDev.php $1 ;

#Part3: Using SSH, Install New Version on QA Machine
scp -r /git/Versions/$1.zip michaeldemusso@$5:/home/michaeldemusso/Versions/$1.zip ;
ssh -o strictHostKeyChecking=no michaeldemusso@$5 'bash -s' < RecieveVersion.sh $1 $3 ;
