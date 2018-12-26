#!/usr/bin/env python3

import yaml
import re

def main():
    with open("config.yml", 'r') as stream:
        try:
            data = str(yaml.load(stream))
            data = re.sub(r'\[\{', r'(\n', data)
            data = re.sub(r'\[', r'(\n', data)
            data = re.sub(r' ?\{', r'\n', data)
            data = re.sub(r'\]\}', r'\n)', data)
            data = re.sub(r', ', r',\n', data)
            data = re.sub(r'\}', r'', data)
            data = re.sub(r'\)\n\)', r'))', data)
            data = re.sub(r'^\n', r'', data)
            data = re.sub(r': \(', r' => array(', data)
            data = re.sub(r':', r' =>', data)
            data = re.sub(r'\.\.', r"' => '", data) + ');'
            data = re.sub(r'([^\;\,\(])\n', r"\1,\n", data)
            data = re.split(r'[\n]+', data)
            data[0] = re.sub(r' =>', r',', data[0])
            tabs = 0
            print("<?php\ndefine(", end='')
            for s in data:
                for c in s:
                    if c == ')':
                        tabs -= 1
                print(4*tabs*' '+s)
                for c in s:
                    if c == '(':
                        tabs += 1
        except yaml.YAMLError as exc:
            print(exc)

if __name__ == '__main__':
    main()
