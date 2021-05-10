#!bin/bash

#Part1: get most recent working version
LOCATION=$(php RollbackToWorking.php);

#Part2: SCP the Version to the Respect
cd /Versions ;
sshpass -p 'fuck!!!' scp -r ${LOCATION}.zip jayguarzprod@25.92.111.80:/home/jayguarzprod/Versions/ ;

#Part3: Unzip the Rollbacked Version
cd /Deployment/Backend/Rollback
sshpass -p 'fuck!!!' ssh -o strictHostKeyChecking=no jayguarzprod@25.92.111.80 'bash -s' < RecieveVersion.sh ${LOCATION}.zip;
