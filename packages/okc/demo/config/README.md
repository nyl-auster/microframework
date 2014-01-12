Config directory contains special settings files used by the framework.
These are simple php files that MUST return an array.
- settings : used to hold your packages configuration. Will be merged then with
  all other settings, so namespace variables to avoid conflicts.
- routes : declare which url will be map to resources
- translations 
