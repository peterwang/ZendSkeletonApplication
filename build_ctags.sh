#!/bin/bash

cwd=`cd $(dirname $0);pwd`
cd $cwd;

listfile=$cwd/LIST
tagsfile=$cwd/TAGS

find $cwd -iname '*\.php' -type f|grep -v ZendTest > $listfile

/usr/local/bin/ctags -e -R \
    -L $listfile \
    -h ".php" \
    -f $tagsfile \
    --exclude=.git \
    --exclude=ZendTest \
    --totals=yes \
    --tag-relative=yes \
    --PHP-kinds=+cf-v \
    --regex-PHP='/abstract\s+class\s+([^ ]+)/\1/c/' \
    --regex-PHP='/interface\s+([^ ]+)/\1/c/' \
    --regex-PHP='/(public\s+|static\s+|abstract\s+|protected\s+|private\s+)function\s+\&?\s*([^ (]+)/\2/f/'
