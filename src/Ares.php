<?php

namespace Ares;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Ares\Collection\EconomicallySubjectCollection;
use Ares\Collection\IcoCollection;
use Ares\Collection\OrderEnumCollection;
use Ares\Data\EconomicallySubject;
use Ares\ValidationObject\EconomicallySubjectName;
use Ares\ValidationObject\Ico;
use Ares\ValidationObject\SubjectsPerPage;

readonly class Ares
{
    private const API_URL = 'https://ares.gov.cz/ekonomicke-subjekty-v-be/rest/ekonomicke-subjekty/vyhledat';

    public function __construct(
        private ClientInterface         $httpClient,
        private RequestFactoryInterface $requestFactory,
        private StreamFactoryInterface  $streamFactory,
    )
    {}

    public function getEconomicallySubjectCollectionBySubjectName(
        EconomicallySubjectName $economicallySubjectName,
        SubjectsPerPage         $subjectsPerPage = null,
        OrderEnumCollection     $orderCollection = null,
    ): EconomicallySubjectCollection
    {
        $requestData = $this->getRequestData();

        $requestData['obchodniJmeno'] = $economicallySubjectName->economicallySubjectName;
        $requestData['pocet'] = $subjectsPerPage?->subjectsPerPage;
        $requestData['razeni'] = $orderCollection?->getOrderEnumValues();

        $response = $this->getResponseData($requestData);

        return $this->createEconomicallySubjectCollection($response['ekonomickeSubjekty']);
    }

    public function getEconomicallySubjectByIcoCollection(
        IcoCollection       $icoCollection,
        SubjectsPerPage     $subjectsPerPage = null,
        OrderEnumCollection $orderCollection = null,
    ): EconomicallySubject
    {
        $requestData = $this->getRequestData();

        $requestData['ico'] = $icoCollection->getIcoValues();
        $requestData['pocet'] = $subjectsPerPage?->subjectsPerPage;
        $requestData['razeni'] = $orderCollection?->getOrderEnumValues();

        $response = $this->getResponseData($requestData);

        return $this->createEconomicallySubject($response['ekonomickeSubjekty'][0]);
    }

    public function getEconomicallySubjectByIco(
        Ico                 $ico,
        SubjectsPerPage     $subjectsPerPage = null,
        OrderEnumCollection $orderEnumCollection = null,
    ): EconomicallySubject
    {
        return $this->getEconomicallySubjectByIcoCollection(
            icoCollection: (new IcoCollection())->add($ico),
            subjectsPerPage: $subjectsPerPage,
            orderCollection: $orderEnumCollection,
        );
    }

    /**
     * @return array{
     *     start: int, pocet: int,
     *     razeni: array<int,string>,
     *     ico: array<int,string>,
     *     obchodniJmeno: string,
     *     sidlo: array{
     *          kodCastiObce: int,
     *          kodSpravnihoObvodu: int,
     *          kodMestskeCastiObvodu: int,
     *          kodUlice: int,
     *          cisloDomovni: int,
     *          kodObce: int,
     *          cisloOrientacni: int,
     *          cisloOrientacniPismeno: string,
     *          textovaAdresa: string
     *      },
     *     pravniForma: array<int,string>,
     *     financniUrad: array<int,string>,
     *     czNace: array<int,string>
     *  }
     */
    private function getRequestData(): array
    {
        return [];
    }

    private function decode(ResponseInterface $response): array
    {
        $contents = $response->getBody()->getContents();

        return json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
    }

    private function createEconomicallySubjectCollection(array $economicalSubjects): EconomicallySubjectCollection
    {
        $economicallySubjectCollection = new EconomicallySubjectCollection();

        foreach ($economicalSubjects as $economicallySubject) {
            $economicallySubjectCollection->add($this->createEconomicallySubject($economicallySubject));
        }

        return $economicallySubjectCollection;
    }

    private function createEconomicallySubject(array $economicallySubject): EconomicallySubject
    {
        return new EconomicallySubject(
            ico: $economicallySubject['ico'],
            businessName: $economicallySubject['obchodniJmeno'],
            countryCode: $economicallySubject['sidlo']['kodStatu'],
            addressCity: $economicallySubject['sidlo']['nazevObce'],
            addressPostcode: $economicallySubject['sidlo']['psc'],
            addressStreet: $economicallySubject['sidlo']['nazevUlice'] ?? '',
            legalForm: $economicallySubject['pravniForma'],
        );
    }

    private function getResponseData(array $requestData): array
    {
        $request = $this->requestFactory->createRequest('POST', self::API_URL)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(json_encode($requestData, JSON_THROW_ON_ERROR)));

        $response = $this->httpClient->sendRequest($request);

        return $this->decode($response);
    }
}