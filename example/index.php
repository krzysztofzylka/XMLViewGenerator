<?php

include('../vendor/autoload.php');

$xml = new \Krzysztofzylka\XmlViewGenerator\XmlViewGenerator();
$xml->loadXmlData('
<Data xmlns="http://test.pl/">
  <Naglowek>
    <Kod wersjaSchemy="1">Test</Kod>
    <WariantFormularza>1</WariantFormularza>
    <DataWytworzenia>2023-08-22T14:29:03</DataWytworzenia> 
  </Naglowek>
  <Dane>
    <A1>Test</A1>
  </Dane>
</Data>
');
$xml->setNodeDescriptions([
    'A1' => 'Testowy komentarz'
]);

echo $xml->render();