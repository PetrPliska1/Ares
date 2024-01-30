# Ares
-Knihovna pro naseptavani dat z Aresu

## Todo list - co by chtelo zlepsit
#### -Clean it up
#### -Osetreni chyb a vyjimek
#### -Dopsat testy
#### -Implementovat rate limiter(Ares ma maximalni povoleny pocet dotazu - 500/min.)
#### -Implementovat cachovani dotazu(Ares zakazuje ptat se opakovane na stejny dotaz)
#### -Separovat concerny z tridy Ares(abstrahovat metody do vice trid)
#### -Economical array z Ares classy prepsat na DTO

## Ukazka
    ```php
    <?php

    use Ares\Ares;
    use Ares\Collection\IcoCollection;
    use Ares\ValidationObject\EconomicallySubjectName;
    use Ares\ValidationObject\Ico;

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
