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
        return $this->getParamsValuesArray($params)[2];
    }

    /**
     * @param $params
     *
     * @return string
     */
    public function fetchField($params): string
    {
        return $this->getParamsValuesArray($params)[4];
    }

    /**
     * @param $params
     *
     * @return array
     */
    private function getParamsValuesArray($params): array
    {
        $params = explode('|', $params);
        return explode('-', $params[4]);
    }
}
