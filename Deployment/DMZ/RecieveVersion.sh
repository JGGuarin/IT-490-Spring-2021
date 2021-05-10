#!/bin/bash
#arg 1 = Version to grab
#arg 2 = Directory to Unzip Version

#part 2: Unzip new version to correct directory
unzip $2/$1 -d $2/$1;
