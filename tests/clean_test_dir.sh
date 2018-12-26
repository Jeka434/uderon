#!/bin/bash
for i in $1/*; do
    ls -l $i | grep "^l" && rm $i;
done
