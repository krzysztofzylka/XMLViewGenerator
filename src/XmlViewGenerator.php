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
     * Load node descriptions from XSD
     * @param string $path
     * @return void
     */
    public function loadNodeDescriptionsFromXSD(string $path): void
    {
        $xsd = simplexml_load_file($path);

        if (!$xsd) {
            return;
        }

        $mapping = [];

        foreach ($xsd->xpath('//xsd:element') as $element) {
            $doc = $element->xpath('xsd:annotation/xsd:documentation');

            if (isset($doc[0]) && !empty(trim((string)$doc[0]))) {
                $mapping[(string)$element['name']] = str_replace(['<br >', "\n", "\r"], ' ', (string)$doc[0]);
            }
        }

        $this->setNodeDescriptions($mapping);
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
                $data = preg_replace('/(<' . $nodeDescriptionKey . '*>)\s|(<' . $nodeDescriptionKey . '*>.*<\/' . $nodeDescriptionKey . '*>)\s/m', '$1$2 # ' . $nodeDescription . PHP_EOL, $data);
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