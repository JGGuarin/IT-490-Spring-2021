#!/bin/bash

#arg 1 = VersionName

#Part1: Using SSH, Send zip file to Deployment Server from Dev Server
sshpass -p 'ragingrabbits490' ssh -o StrictHostKeyChecking=no michelle@25.59.41.205 'bash -s' < CreateVersion.sh $1;
sshpass -p 'ragingrabbits490' scp -r michelle@25.59.41.205:/home/michelle/Versions/$1.zip /Versions

#Part2: Run PHP Script to Write Entry to SQL
php WriteFromDev.php $1 ;

#Part3: Using SSH, Install New Version on QA Machine
sshpass -p 'ragingrabbits490' scp -r /Versions/$1.zip michelleqa@25.0.39.143:/home/michelleqa/Versions/$1.zip;
sshpass -p 'ragingrabbits490' ssh -o strictHostKeyChecking=no michelleqa@25.0.39.143 'bash -s' < RecieveVersion.sh $1 ;
