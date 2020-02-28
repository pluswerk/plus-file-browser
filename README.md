# plus_file_browser

## What does it do

It provides an additional file browser for TYPO3 TCA media fields, which has the possibility to filter the shown folders.

## Usage

### TCA

**Example:**

Register the file browser for a image field.

```php
<?php

$GLOBALS['TCA']['tx_yourextension_some_table']['columns']['image'] = [
    'config' => [
        'overrideChildTca' => [
            'columns' => [
                'uid_local' => [
                    'config' => [
                        'appearance' => [
                            // This causes the usage of the PlusFileBrowser
                            'elementBrowserType' => 'plusFileBrowser'
                        ]
                    ]
                ]
            ]
        ]
    ]
];
```

### TypoScript

For each field a comma separated list of storage path combination can be configured.

**Schema:** <storageUid>:<path>

**Example:**

The following example configures the folder /some_images/ in storage with uid=1 and folder /some_other/images/folder/ in storage with uid=2 to be shown in file browser.
```typo3_typoscript
config.tx_kueibase {
  tca {
    elementBrowser {
      allowedPaths {
        tx_yourextension_some_table {
          # cat=KUEI base package: allowedPersonImagePaths; type=string; label=LLL:EXT:kuei_base/Resources/Private/Language/locallang_db.person.xlf:extConf.allowedPersonImagePaths
          image = 1:/some_images/,2:/some_other/images/folder/
        }
      }
    }
  }
}
```
