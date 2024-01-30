# Ares
Knihovna pro naseptavani dat z Aresu

    ```php
    <?php

    use YourNamespace\Ares;
    use YourNamespace\Collection\IcoCollection;
    use YourNamespace\ValidationObject\EconomicallySubjectName;
    use YourNamespace\ValidationObject\Ico;

    require 'vendor/autoload.php';

    $ares = new Ares(new Http\Adapter\Guzzle7\Client(new GuzzleHttp\Client()), new GuzzleHttp\Psr7\HttpFactory(), new GuzzleHttp\Psr7\HttpFactory());

    $ico = new Ico(ico: '06580484');
    $icoCollection = (new IcoCollection())->add($ico);
    $economicallySubjectName = new EconomicallySubjectName('Petr Pliska');

    echo 'Ziskam ekonomicky subjekt dle ICO';
    var_dump($ares->getEconomicallySubjectByIco($ico));
    echo 'Ziskam ekonomicky subjekt dle kolekce IC';
    var_dump($ares->getEconomicallySubjectByIcoCollection($icoCollection));
    echo 'Ziskam ekonomicky subjekt dle nazvu(jmena) subjektu';
    var_dump($ares->getEconomicallySubjectCollectionBySubjectName($economicallySubjectName));

    ```

