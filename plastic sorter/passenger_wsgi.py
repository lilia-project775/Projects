import sys, os

# Virtual Environment ki sahi path link karna lazmi hai
INTERP = "/home/bssstageserver3/virtualenv/trash-detection.xyz/3.11/bin/python"
if sys.executable != INTERP:
    os.execl(INTERP, INTERP, *sys.argv)

sys.path.append(os.getcwd())

# Flask app ko import karein
from app import app as application