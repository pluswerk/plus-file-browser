<?php

defined('TYPO3_MODE') || die();

// Register additional file browser for TCA usage.
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ElementBrowsers'][Pluswerk\PlusFileBrowser\Configuration\Constants::FILE_BROWSER] = Pluswerk\PlusFileBrowser\Browser\FileBrowser::class;
