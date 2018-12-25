#!/bin/bash
for i in ../uderon.com/html/*; do
    ln -s $i `echo $i | cut -d "/" -f 4`;
done
