<?php

declare(strict_types=1);

namespace Pluswerk\PlusFileBrowser\Browser;

final class FileBrowserUtility
{
    /**
     * @param string $params
     *
     * @return string
     */
    public function fetchTable(string $params): string
    {
        $params = explode('|', $params);
        $paramsValues = explode('-', $params[4]);
        return $paramsValues[2];
    }

    /**
     * @param $params
     *
     * @return string
     */
    public function fetchField($params): string
    {
        $params = explode('|', $params);
        $paramsValues = explode('-', $params[4]);
        return $paramsValues[4];
    }
}
