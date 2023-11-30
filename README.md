# Instalacja pakietu
```bash
composer require krzysztofzylka/xml-view-generator
```

# Wyświetlenie ładnego XML'a
```php
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
```
## Przykładowy podgląd:
![alt text](resources/screen.png)
# Metody
## Wgranie XML'a z tekstu
```php
$xml->loadXmlData('string');
```
## Wgranie XML'a z pliku
```php
$xml->loadXmlFile('file_path');
```
## Opisy dla nodów
```php
$xml->setNodeDescriptions(['node_name' => 'description', ...]);
```
## Pobranie opisów dla nodów z pliku XSD
```php
$xml->loadNodeDescriptionsFromXSD('file_path');
```
## Renderowanie tekstu
```php
echo $xml->render();
```