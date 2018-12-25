#!/bin/bash
for i in $1/html/*; do
    ln -s $i `echo $i | cut -d "/" -f 4`;
done
