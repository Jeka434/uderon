#!/bin/bash
for i in ./*; do
    ls -l $i | grep "^l" && rm $i;
done
