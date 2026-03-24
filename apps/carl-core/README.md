# Carl Core 1.0
## Architecture for OIX and be.imported.to

Currently managing the core architecture for developer managed CMS to back-end all open tool projects intended for the OIX application for Mira/AIDM. 

### Intentions for OIX
- Solid and consistent tree structure across applications
- Shared visual architecture while allowing identity and color palette choices
- Flexible shell structure to house a myriad of content types

#### Pending Next Actions
1. Finish enhancing [[iox-css.css]] to properly split between CORE, VAR, and STORE theming, to ensure required aspects cannot be damaged by design edits on the STORE level.
2. Fix [[oix-mast.php]] and [[JXCC-footer.php]] calls to ensure that they can be globally used. 
   ***Honestly what is up with those filenames?***
3. Clean up the [[iox-shell.php]] to ensure it does not have any functions. Functions belong in [[oix-common.php]]