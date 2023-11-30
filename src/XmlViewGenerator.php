<?php

namespace Krzysztofzylka\XmlViewGenerator;

class XmlViewGenerator
{

    /**
     * XML data
     * @var string
     */
    private string $xml = '';

    /**
     * Node descriptions
     * @var array
     */
    private array $nodeDescriptions = [];

    /**
     * Load XML data from file
     * @param string $path
     * @return bool
     */
    public function loadXmlFile(string $path): bool
    {
        $readXml = file_get_contents($path);

        if (!$readXml) {
            return false;
        }

        $this->loadXmlData($readXml);

        return true;
    }

    /**
     * Load XML data from text
     * @param string $xml
     * @return void
     */
    public function loadXmlData(string $xml): void
    {
        $this->xml = $xml;
    }

    /**
     * Set node descriptions
     * @param array $nodeDescriptions
     */
    public function setNodeDescriptions(array $nodeDescriptions): void
    {
        $this->nodeDescriptions = $nodeDescriptions;
    }

    /**
     * Render xml view
     * @return string
     */
    public function render(): string
    {
        $data = $this->xml;

        if (!empty($this->nodeDescriptions)) {
            foreach ($this->nodeDescriptions as $nodeDescriptionKey => $nodeDescription) {
                $data = str_replace('</' . $nodeDescriptionKey . '>', '</' . $nodeDescriptionKey . '> # ' . $nodeDescription, $data);
            }
        }

        $data = $this->xmlBeautifully($data);

        if (!empty($this->nodeDescriptions)) {
            $data = preg_replace(
                '/(# (.*))/',
                '<font color="silver" style="user-select: none; font-weight: bold;">$1</font>',
                $data
            );
        }

        return '<pre>' . $data . '</pre>';
    }

    /**
     * Beautifully XML
     * @param string $xml
     * @return string
     */
    private function xmlBeautifully(string $xml) : string {
        return preg_replace(
            '/(<)(\/)?([0-9A-Za-z_]*)([ a-z=":\/.A-Z0-9\(\) -]*)?(>)/',
            '<font color="blue">&lt;$2</font><font style="color: rgb(176, 14, 0)">$3</font><font color="orange">$4</font><font color="blue">$5</font>',
            $xml
        );
    }

}