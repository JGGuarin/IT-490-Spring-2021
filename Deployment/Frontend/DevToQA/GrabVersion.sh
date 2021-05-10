#!/bin/bash

#arg 1 = VersionName
#arg 2 = SourceFolder
#arg 3 = DestinationFolder
#arg 4 = DevIPaddr
#arg 5 = QAIPaddr

#Part1: Using SSH, Send zip file to Deployment Server from Dev Server
sshpass -p 'ragingrabbits490' ssh michelle@25.57.130.112$4 'bash -s' < CreateVersion.sh $1 $2 ;
scp -r michelle@25.57.130.112$4:/home/michelle/Versions/$1.zip /git/Versions

#Part2: Run PHP Script to Write Entry to SQL
php WriteFromDev.php $1 ;

#Part3: Using SSH, Install New Version on QA Machine
scp -r /git/Versions/$1.zip michelle@25.57.130.112$5:/home/michaeldemusso/Versions/$1.zip ;
sshpass -p 'ragingrabbits490' ssh michaeldemusso@25.57.130.112$5 'bash -s' < RecieveVersion.sh $1 $3 ;
