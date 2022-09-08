#!/usr/bin/env python3
#
# slog.py -- Wadih Khairallah
# command line script for posting data to slog

import sys
import requests
import getopt
import select
from os.path import exists

argv = sys.argv[1:]
url = 'http://yourwebsite/slog/slog.php'
sbName = str() 
sbText = str()
filename = str()

def help():
    print("slog.py")
    print("-h\tThis help output.")
    print("-t\tTitle for the log.")
    print("-f\tFile to post to the log.")
    print("-u\tURL for slog to post to.")
    print()
    print("Note: Enclose any argument with spaces in quotes or escape them.")



try:
    opts, args = getopt.getopt(argv, "h:t:f:u:")

except:
    help()

for opt, arg in opts:
    if opt == '-h':
        help()
    elif opt == '-t':
        sbName = arg
    elif opt == '-f':
        filename = arg
    elif opt == '-u':
        url = arg

if 'sbName' not in locals():
    print("error: not title provided")
    exit()

if exists(filename):
    try:
        handle = open(filename, "r")
        sbText = handle.read()
    except:
        print("error: can not open" + filename + "for reading")
        exit()

elif select.select([sys.stdin, ], [], [], 0.0)[0]:
    for line in sys.stdin:
        sbText = sbText + line

else:
    print("error: no file or STDIN provided.")
    exit()

obj = {
        'sbName': sbName,
        'sbText': sbText,
        'submit': 'log' 
        }

response = requests.post(url, data = obj)

if response.status_code == 200:
    print("log posted")
else:
    print(f'error: unable to post response[{response.status_code}]')
